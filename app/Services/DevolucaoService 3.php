<?php

namespace App\Services;
use NFePHP\NFe\Make;
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;
use App\Venda;
use App\ConfigNota;
use App\Certificado;
use NFePHP\NFe\Complements;
use NFePHP\DA\NFe\Danfe;
use NFePHP\DA\Legacy\FilesFolders;
use NFePHP\Common\Soap\SoapCurl;
use App\Tributacao;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

class DevolucaoService{

	private $config; 
	private $tools;
	protected $empresa_id = null;

	public function __construct($config, $modelo){
		//$json = json_encode($config);
		$value = session('user_logged');
		$this->empresa_id = $value['empresa'];
		$certificado = Certificado::
		where('empresa_id', $this->empresa_id)
		->first();
		// print_r($certificado->arquivo);
		$this->config = $config;
		$this->tools = new Tools(json_encode($config), Certificate::readPfx($certificado->arquivo, $certificado->senha));
		$this->tools->model($modelo);
		
	}

	public function gerarDevolucao($devolucao){

		$config = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first(); // iniciando os dados do emitente NF

		$tributacao = Tributacao::
		where('empresa_id', $this->empresa_id)
		->first(); // iniciando tributos

		$nfe = new Make();
		$stdInNFe = new \stdClass();
		$stdInNFe->versao = '4.00'; 
		$stdInNFe->Id = null; 
		$stdInNFe->pk_nItem = ''; 

		$infNFe = $nfe->taginfNFe($stdInNFe);

		$vendaLast = Venda::lastNF();
		$lastNumero = $vendaLast > 0 ? $vendaLast : 0;
		
		$stdIde = new \stdClass();
		$stdIde->cUF = $config->cUF;
		$stdIde->cNF = rand(11111,99999);
		// $stdIde->natOp = $venda->natureza->natureza;
		$stdIde->natOp = $devolucao->natureza->natureza;

		// $stdIde->indPag = 1; //NÃO EXISTE MAIS NA VERSÃO 4.00 // forma de pagamento

		$stdIde->mod = 55;
		$stdIde->serie = $config->numero_serie_nfe;
		$stdIde->nNF = (int)$lastNumero+1;
		$stdIde->dhEmi = date("Y-m-d\TH:i:sP");
		$stdIde->dhSaiEnt = date("Y-m-d\TH:i:sP");
		$stdIde->tpNF = 1;
		$stdIde->idDest = $config->UF != $devolucao->fornecedor->cidade->uf ? 2 : 1;
		$stdIde->cMunFG = $config->codMun;
		$stdIde->tpImp = 1;
		$stdIde->tpEmis = 1;
		$stdIde->cDV = 0;
		$stdIde->tpAmb = $config->ambiente;
		$stdIde->finNFe = 4; // 4 - devolucao
		$stdIde->indFinal = 1;
		$stdIde->indPres = 1;
		$stdIde->procEmi = '0';
		$stdIde->verProc = '2.0';
		// $stdIde->dhCont = null;
		// $stdIde->xJust = null;


		//
		$tagide = $nfe->tagide($stdIde);

		$stdEmit = new \stdClass();
		$stdEmit->xNome = $config->razao_social;
		$stdEmit->xFant = $config->nome_fantasia;

		$ie = str_replace(".", "", $config->ie);
		$ie = str_replace("/", "", $ie);
		$ie = str_replace("-", "", $ie);
		$stdEmit->IE = $ie;
		$stdEmit->CRT = $tributacao->regime == 0 ? 1 : 3;

		$cnpj = str_replace(".", "", $config->cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);
		$stdEmit->CNPJ = $cnpj;

		$emit = $nfe->tagemit($stdEmit);

		// ENDERECO EMITENTE
		$stdEnderEmit = new \stdClass();
		$stdEnderEmit->xLgr = $config->logradouro;
		$stdEnderEmit->nro = $config->numero;
		$stdEnderEmit->xCpl = "";
		$stdEnderEmit->xBairro = $config->bairro;
		$stdEnderEmit->cMun = $config->codMun;
		$stdEnderEmit->xMun = $config->municipio;
		$stdEnderEmit->UF = $config->UF;

		$cep = str_replace("-", "", $config->cep);
		$cep = str_replace(".", "", $cep);
		$stdEnderEmit->CEP = $cep;
		$stdEnderEmit->cPais = $config->codPais;
		$stdEnderEmit->xPais = $config->pais;

		$enderEmit = $nfe->tagenderEmit($stdEnderEmit);

		// DESTINATARIO
		$stdDest = new \stdClass();
		$stdDest->xNome = $devolucao->fornecedor->razao_social;

		if($devolucao->fornecedor->ie_rg == 'ISENTO'){
			$stdDest->indIEDest = "2";
		}else{
			$stdDest->indIEDest = "1";
		}
		


		$cnpj_cpf = str_replace(".", "", $devolucao->fornecedor->cpf_cnpj);
		$cnpj_cpf = str_replace("/", "", $cnpj_cpf);
		$cnpj_cpf = str_replace("-", "", $cnpj_cpf);

		if(strlen($cnpj_cpf) == 14){
			$stdDest->CNPJ = $cnpj_cpf;
			$ie = str_replace(".", "", $devolucao->fornecedor->ie_rg);
			$ie = str_replace("/", "", $ie);
			$ie = str_replace("-", "", $ie);
			$stdDest->IE = $ie;
		}
		else{
			$stdDest->CPF = $cnpj_cpf;
		} 

		$dest = $nfe->tagdest($stdDest);

		$stdEnderDest = new \stdClass();
		$stdEnderDest->xLgr = $devolucao->fornecedor->rua;
		$stdEnderDest->nro = $devolucao->fornecedor->numero;
		$stdEnderDest->xCpl = "";
		$stdEnderDest->xBairro = $devolucao->fornecedor->bairro;
		$stdEnderDest->cMun = $devolucao->fornecedor->cidade->codigo;
		$stdEnderDest->xMun = strtoupper($devolucao->fornecedor->cidade->nome);
		$stdEnderDest->UF = $devolucao->fornecedor->cidade->uf;

		$cep = str_replace("-", "", $devolucao->fornecedor->cep);
		$cep = str_replace(".", "", $cep);
		$stdEnderDest->CEP = $cep;
		$stdEnderDest->cPais = "1058";
		$stdEnderDest->xPais = "BRASIL";

		$enderDest = $nfe->tagenderDest($stdEnderDest);

		$somaProdutos = 0;
		$somaICMS = 0;
		//PRODUTOS
		$itemCont = 0;

		$totalItens = count($devolucao->itens);
		$somaFrete = 0;


		$std = new \stdClass();
		$std->refNFe = $devolucao->chave_nf_entrada;

		$nfe->tagrefNFe($std);

		foreach($devolucao->itens as $i){
			$itemCont++;

			$stdProd = new \stdClass();
			$stdProd->item = $itemCont;
			$stdProd->cEAN = $i->codBarras;
			$stdProd->cEANTrib = $i->codBarras;
			$stdProd->cProd = $i->cod;
			$stdProd->xProd = $i->nome;
			$ncm = $i->ncm;
			$ncm = str_replace(".", "", $ncm);
			$stdProd->NCM = $ncm;
			$stdProd->CFOP = $config->UF != $devolucao->fornecedor->cidade->uf ?
			$devolucao->natureza->CFOP_saida_inter_estadual : $devolucao->natureza->CFOP_saida_estadual;
			$stdProd->uCom = $i->unidade_medida;
			$stdProd->qCom = $i->quantidade;
			$stdProd->vUnCom = $this->format($i->valor_unit);
			$stdProd->vProd = $this->format(($i->quantidade * $i->valor_unit));
			$stdProd->uTrib = $i->unidade_medida;
			$stdProd->qTrib = $i->quantidade;
			$stdProd->vUnTrib = $this->format($i->valor_unit);
			$stdProd->indTot = 1;
			$somaProdutos += ($i->quantidade * $i->valor_unit);

			// if($devolucao->vDesc > 0){
			// 	$stdProd->vDesc = $this->format($devolucao->vDesc/$totalItens);
			// }

			// if($venda->frete){
			// 	if($venda->frete->valor > 0){
			// 		$somaFrete += $vFt = $venda->frete->valor/$totalItens;
			// 		$stdProd->vFrete = $this->format($vFt);
			// 	}
			// }

			$prod = $nfe->tagprod($stdProd);

		//TAG IMPOSTO

			$stdImposto = new \stdClass();
			$stdImposto->item = $itemCont;

			$imposto = $nfe->tagimposto($stdImposto);

			// ICMS
			if($tributacao->regime == 1){ // regime normal

				//$venda->produto->CST  CST
				
				$stdICMS = new \stdClass();
				$stdICMS->item = $itemCont; 
				$stdICMS->orig = 0;
				$stdICMS->CST = $i->cst_csosn;
				$stdICMS->modBC = 0;
				$stdICMS->vBC = $stdProd->vProd;
				$stdICMS->pICMS = $this->format($i->perc_icms);
				$stdICMS->vICMS = $stdICMS->vBC * ($stdICMS->pICMS/100);

				// $somaICMS += 0;
				$ICMS = $nfe->tagICMS($stdICMS);
				$somaICMS += $stdICMS->vICMS;

			}else{ // regime simples

				//$venda->produto->CST CSOSN
				
				$stdICMS = new \stdClass();
				
				$stdICMS->item = $itemCont; 
				$stdICMS->orig = 0;
				$stdICMS->CSOSN = $i->cst_csosn;
				$stdICMS->pCredSN = $this->format($i->perc_icms);
				$stdICMS->vCredICMSSN = $this->format($i->perc_icms);
				$ICMS = $nfe->tagICMSSN($stdICMS);

				$somaICMS = 0;
			}

			
			$stdPIS = new \stdClass();//PIS
			$stdPIS->item = $itemCont; 
			$stdPIS->CST = $i->cst_pis;
			$stdPIS->vBC = $i->perc_pis > 0 ? $stdProd->vProd : 0.00;
			$stdPIS->pPIS = $this->format($i->perc_pis);
			$stdPIS->vPIS = $this->format(($stdProd->vProd) * 
				($i->perc_pis/100));
			$PIS = $nfe->tagPIS($stdPIS);


			$stdCOFINS = new \stdClass();//COFINS
			$stdCOFINS->item = $itemCont; 
			$stdCOFINS->CST = $i->cst_cofins;
			$stdCOFINS->vBC = $i->perc_cofins > 0 ? $stdProd->vProd : 0.00;
			$stdCOFINS->pCOFINS = $this->format($i->perc_cofins);
			$stdCOFINS->vCOFINS = $this->format(($stdProd->vProd) * 
				($i->perc_cofins/100));
			$COFINS = $nfe->tagCOFINS($stdCOFINS);

			

			// $std = new \stdClass();//IPI
			// $std->item = $itemCont; 
			// $std->clEnq = null;
			// $std->CNPJProd = null;
			// $std->cSelo = null;
			// $std->qSelo = null;
			// $std->cEnq = '999'; //999 – para tributação normal IPI
			// $std->CST = $i->produto->CST_IPI;
			// $std->vBC = 0.00;
			// $std->pIPI = 0.00;
			// $std->vIPI = 0.00;
			// $std->qUnid = null;
			// $std->vUnid = null;

			// $nfe->tagIPI($std);
		}



		$stdICMSTot = new \stdClass();
		$stdICMSTot->vBC = 0.00;
		$stdICMSTot->vICMS = $this->format($somaICMS);
		$stdICMSTot->vICMSDeson = 0.00;
		$stdICMSTot->vBCST = 0.00;
		$stdICMSTot->vST = 0.00;
		$stdICMSTot->vProd = $this->format($somaProdutos);

		$stdICMSTot->vFrete = 0.00;

		$stdICMSTot->vSeg = 0.00;
		$stdICMSTot->vDesc = 0.00;
		// $stdICMSTot->vDesc = $this->format($devolucao->vDesc);
		$stdICMSTot->vII = 0.00;
		$stdICMSTot->vIPI = 0.00;
		$stdICMSTot->vPIS = 0.00;
		$stdICMSTot->vCOFINS = 0.00;
		$stdICMSTot->vOutro = 0.00;

		if($devolucao->vFrete){
			$stdICMSTot->vNF = 
			$this->format(($somaProdutos));
		} 
		else $stdICMSTot->vNF = $this->format($somaProdutos-$devolucao->vDesc);

		$stdICMSTot->vTotTrib = 0.00;
		$ICMSTot = $nfe->tagICMSTot($stdICMSTot);


		$stdTransp = new \stdClass();
		$stdTransp->modFrete = '9';

		$transp = $nfe->tagtransp($stdTransp);


		// if($venda->frete != null){
		// 	$std = new \stdClass();
		// 	if($venda->transportadora){
		// 		$std->xNome = $venda->transportadora->razao_social;

		// 		$std->xEnder = $venda->transportadora->logradouro;
		// 		$std->xMun = $venda->transportadora->cidade->nome;
		// 		$std->UF = $venda->transportadora->cidade->uf;


		// 		$cnpj_cpf = $venda->transportadora->cnpj_cpf;
		// 		$cnpj_cpf = str_replace(".", "", $venda->transportadora->cnpj_cpf);
		// 		$cnpj_cpf = str_replace("/", "", $cnpj_cpf);
		// 		$cnpj_cpf = str_replace("-", "", $cnpj_cpf);

		// 		if(strlen($cnpj_cpf) == 14) $std->CNPJ = $cnpj_cpf;
		// 		else $std->CPF = $cnpj_cpf;

		// 		$nfe->tagtransporta($std);
		// 	}

		// 	$std = new \stdClass();


		// 	$placa = str_replace("-", "", $venda->frete->placa);
		// 	$std->placa = strtoupper($placa);
		// 	$std->UF = $venda->frete->uf;

		// 	$nfe->tagveicTransp($std);


		// 	if($venda->frete->qtdVolumes > 0 && $venda->frete->peso_liquido > 0
		// 		&& $venda->frete->peso_bruto > 0){
		// 		$stdVol = new \stdClass();
		// 		$stdVol->item = 1;
		// 		$stdVol->qVol = $venda->frete->qtdVolumes;
		// 		$stdVol->esp = $venda->frete->especie;

		// 		$stdVol->nVol = $venda->frete->numeracaoVolumes;
		// 		$stdVol->pesoL = $venda->frete->peso_liquido;
		// 		$stdVol->pesoB = $venda->frete->peso_bruto;
		// 		$vol = $nfe->tagvol($stdVol);
		// 	}
		// }



		$stdResp = new \stdClass();
		$stdResp->CNPJ = '08543628000145'; 
		$stdResp->xContato= 'Slym';
		$stdResp->email = 'marcos05111993@gmail.com'; 
		$stdResp->fone = '43996347016'; 

		$nfe->taginfRespTec($stdResp);


	//Fatura

		// $stdFat = new \stdClass();
		// $stdFat->nFat = (int)$lastNumero+1;
		// $stdFat->vOrig = $this->format($somaProdutos);
		// $stdFat->vDesc = $this->format($venda->desconto);
		// $stdFat->vLiq = $this->format($somaProdutos-$venda->desconto);

		// $fatura = $nfe->tagfat($stdFat);


	//Duplicata

		// if(count($venda->duplicatas) > 0){
		// 	$contFatura = 1;
		// 	foreach($venda->duplicatas as $ft){
		// 		$stdDup = new \stdClass();
		// 		$stdDup->nDup = "00".$contFatura;
		// 		$stdDup->dVenc = substr($ft->data_vencimento, 0, 10);
		// 		$stdDup->vDup = $this->format($ft->valor_integral);

		// 		$nfe->tagdup($stdDup);
		// 		$contFatura++;
		// 	}
		// }else{
		// 	$stdDup = new \stdClass();
		// 	$stdDup->nDup = '001';
		// 	$stdDup->dVenc = Date('Y-m-d');
		// 	$stdDup->vDup =  $this->format($somaProdutos-$venda->desconto);

		// 	$nfe->tagdup($stdDup);
		// }



		$stdPag = new \stdClass();
		$pag = $nfe->tagpag($stdPag);

		$stdDetPag = new \stdClass();


		$stdDetPag->tPag = '90';
		$stdDetPag->vPag = 0.00; 

		$stdDetPag->indPag = '0'; // sem pagamento 

		$detPag = $nfe->tagdetPag($stdDetPag);


		$stdInfoAdic = new \stdClass();
		$stdInfoAdic->infCpl = $devolucao->observacao;

		$infoAdic = $nfe->taginfAdic($stdInfoAdic);



		$std = new \stdClass();
		$std->CNPJ = getenv('RESP_CNPJ'); //CNPJ da pessoa jurídica responsável pelo sistema utilizado na emissão do documento fiscal eletrônico
		$std->xContato= getenv('RESP_NOME'); //Nome da pessoa a ser contatada
		$std->email = getenv('RESP_EMAIL'); //E-mail da pessoa jurídica a ser contatada
		$std->fone = getenv('RESP_FONE'); //Telefone da pessoa jurídica/física a ser contatada
		
		
		$nfe->taginfRespTec($std);

		if($nfe->montaNFe()){
			$arr = [
				'chave' => $nfe->getChave(),
				'xml' => $nfe->getXML(),
				'nNf' => $stdIde->nNF
			];
			return $arr;
		} else {
			throw new Exception("Erro ao gerar NFe");
		}

	}

	public function sign($xml){
		return $this->tools->signNFe($xml);
	}

	public function transmitir($signXml, $chave){
		try{
			$idLote = str_pad(100, 15, '0', STR_PAD_LEFT);
			$resp = $this->tools->sefazEnviaLote([$signXml], $idLote);

			$st = new Standardize();
			$std = $st->toStd($resp);
			sleep(2);

			if ($std->cStat != 103) {

				return "[$std->cStat] - $std->xMotivo";
			}
			sleep(3);

			$recibo = $std->infRec->nRec; 
			$protocolo = $this->tools->sefazConsultaRecibo($recibo);
			sleep(3);
			//return $protocolo;
			$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
			try {
				$xml = Complements::toAuthorize($signXml, $protocolo);
				header('Content-type: text/xml; charset=UTF-8');
				file_put_contents($public.'xml_devolucao/'.$chave.'.xml',$xml);
				return $recibo;
				// $this->printDanfe($xml);
			} catch (\Exception $e) {
				return "Erro: " . $st->toJson($protocolo);
			}

		} catch(\Exception $e){
			return "erro: ".$e->getMessage() ;
		}

	}	

	public function format($number, $dec = 2){
		return number_format((float) $number, $dec, ".", "");
	}

	public function cancelar($devolucao, $justificativa){
		try {

			$chave = $devolucao->chave_gerada;
			$response = $this->tools->sefazConsultaChave($chave);
			$stdCl = new Standardize($response);
			$arr = $stdCl->toArray();
			sleep(2);
				// return $arr;
			$xJust = $justificativa;
			
			$nProt = $arr['protNFe']['infProt']['nProt'];

			$response = $this->tools->sefazCancela($chave, $xJust, $nProt);
			sleep(3);
			$stdCl = new Standardize($response);
			$std = $stdCl->toStd();
			$arr = $stdCl->toArray();
			$json = $stdCl->toJson();

			if ($std->cStat != 128) {
        //TRATAR
			} else {
				$cStat = $std->retEvento->infEvento->cStat;
				$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
				if ($cStat == '101' || $cStat == '135' || $cStat == '155' ) {
            //SUCESSO PROTOCOLAR A SOLICITAÇÂO ANTES DE GUARDAR
					$xml = Complements::toAuthorize($this->tools->lastRequest, $response);
					file_put_contents($public.'xml_devolucao_cancelada/'.$chave.'.xml',$xml);

					return $json;
				} else {
            //houve alguma falha no evento 
            //TRATAR
					return $json;	
				}
			}    
		} catch (\Exception $e) {
			return $e->getMessage();
    //TRATAR
		}
	}

}