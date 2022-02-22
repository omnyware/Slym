<?php

namespace App\Services;
use NFePHP\NFe\Make;
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

use App\ConfigNota;
use App\Certificado;
use App\Venda;
use NFePHP\NFe\Complements;
use NFePHP\DA\NFe\Danfe;
use NFePHP\DA\Legacy\FilesFolders;
use NFePHP\Common\Soap\SoapCurl;
use App\Tributacao;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

class NFeEntradaService {

	private $config; 
	private $tools;
	protected $empresa_id = null;

	public function __construct($config, $modelo){
		$value = session('user_logged');
		$this->empresa_id = $value['empresa'];
		$certificado = Certificado::
		where('empresa_id', $this->empresa_id)
		->first();
		$this->config = $config;
		$this->tools = new Tools(json_encode($config), Certificate::readPfx($certificado->arquivo, $certificado->senha));
		$this->tools->model($modelo);
		
	}

	public function gerarNFe($compra, $natureza, $tipoPagamento){
		

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
		$compraLast = $vendaLast;

		
		$stdIde = new \stdClass();
		$stdIde->cUF = $config->cUF;
		$stdIde->cNF = rand(11111,99999);
		// $stdIde->natOp = $venda->natureza->natureza;
		$stdIde->natOp = $natureza->natureza;

		// $stdIde->indPag = 1; //NÃO EXISTE MAIS NA VERSÃO 4.00 // forma de pagamento

		$stdIde->mod = 55;
		$stdIde->serie = 1;
		$stdIde->nNF = (int)$compraLast+1;
		$stdIde->dhEmi = date("Y-m-d\TH:i:sP");
		$stdIde->dhSaiEnt = date("Y-m-d\TH:i:sP");
		$stdIde->tpNF = 0; // 0 Entrada;
		$stdIde->idDest = $config->UF != $compra->fornecedor->cidade->uf ? 2 : 1;
		$stdIde->cMunFG = $config->codMun;
		$stdIde->tpImp = 1;
		$stdIde->tpEmis = 1;
		$stdIde->cDV = 0;
		$stdIde->tpAmb = $config->ambiente;
		$stdIde->finNFe = 1;
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
		$stdDest->xNome = $compra->fornecedor->razao_social;


		if($compra->fornecedor->ie_rg == 'ISENTO'){
			$stdDest->indIEDest = "2";
		}else{
			$stdDest->indIEDest = "1";
		}

		


		$cnpj_cpf = str_replace(".", "", $compra->fornecedor->cpf_cnpj);
		$cnpj_cpf = str_replace("/", "", $cnpj_cpf);
		$cnpj_cpf = str_replace("-", "", $cnpj_cpf);

		if(strlen($cnpj_cpf) == 14){
			$stdDest->CNPJ = $cnpj_cpf;
			$ie = str_replace(".", "", $compra->fornecedor->ie_rg);
			$ie = str_replace("/", "", $ie);
			$ie = str_replace("-", "", $ie);
			$stdDest->IE = $ie;
		}
		else{
			$stdDest->CPF = $cnpj_cpf;
		} 

		$dest = $nfe->tagdest($stdDest);

		$stdEnderDest = new \stdClass();
		$stdEnderDest->xLgr = $compra->fornecedor->rua;
		$stdEnderDest->nro = $compra->fornecedor->numero;
		$stdEnderDest->xCpl = "";
		$stdEnderDest->xBairro = $compra->fornecedor->bairro;
		$stdEnderDest->cMun = $compra->fornecedor->cidade->codigo;
		$stdEnderDest->xMun = strtoupper($compra->fornecedor->cidade->nome);
		$stdEnderDest->UF = $compra->fornecedor->cidade->uf;

		$cep = str_replace("-", "", $compra->fornecedor->cep);
		$cep = str_replace(".", "", $cep);
		$stdEnderDest->CEP = $cep;
		$stdEnderDest->cPais = "1058";
		$stdEnderDest->xPais = "BRASIL";

		$enderDest = $nfe->tagenderDest($stdEnderDest);

		$somaProdutos = 0;
		$somaICMS = 0;
		//PRODUTOS
		$itemCont = 0;

		$totalItens = count($compra->itens);
		$somaFrete = 0;

		foreach($compra->itens as $i){
			$itemCont++;

			$stdProd = new \stdClass();
			$stdProd->item = $itemCont;
			$stdProd->cEAN = $i->produto->codBarras;
			$stdProd->cEANTrib = $i->produto->codBarras;
			$stdProd->cProd = $i->produto->id;
			$stdProd->xProd = $i->produto->nome;
			$ncm = $i->produto->NCM;
			$ncm = str_replace(".", "", $ncm);
			$stdProd->NCM = $ncm;
			$stdProd->CFOP = $config->UF != $compra->fornecedor->cidade->uf ?
			$natureza->CFOP_entrada_inter_estadual : $natureza->CFOP_entrada_estadual;
			$stdProd->uCom = $i->produto->unidade_compra;
			$stdProd->qCom = $i->quantidade;
			$stdProd->vUnCom = $this->format($i->valor_unitario);
			$stdProd->vProd = $this->format(($i->quantidade * $i->valor_unitario));
			$stdProd->uTrib = $i->produto->unidade_compra;
			$stdProd->qTrib = $i->quantidade;
			$stdProd->vUnTrib = $this->format($i->valor_unitario);
			$stdProd->indTot = 1;
			$somaProdutos += ($i->quantidade * $i->valor_unitario);

			// if($venda->desconto > 0){
			// 	$stdProd->vDesc = $this->format($venda->desconto/$totalItens);
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
				$stdICMS->CST = $i->produto->CST_CSOSN;
				$stdICMS->modBC = 0;
				$stdICMS->vBC = $this->format($i->valor * $i->quantidade);
				$stdICMS->pICMS = $this->format($i->produto->perc_icms);
				$stdICMS->vICMS = $this->format(($i->valor_unitario * $i->quantidade) 
					* ($stdICMS->pICMS/100));

				$somaICMS += (($i->valor * $i->quantidade) 
					* ($stdICMS->pICMS/100));
				$ICMS = $nfe->tagICMS($stdICMS);

			}else{ // regime simples

				//$venda->produto->CST CSOSN
				
				$stdICMS = new \stdClass();
				
				$stdICMS->item = $itemCont; 
				$stdICMS->orig = 0;
				$stdICMS->CSOSN = $i->produto->CST_CSOSN;
				$stdICMS->pCredSN = $this->format($i->produto->perc_icms);
				$stdICMS->vCredICMSSN = $this->format($i->produto->perc_icms);
				$ICMS = $nfe->tagICMSSN($stdICMS);

				$somaICMS = 0;
			}

			
			$stdPIS = new \stdClass();//PIS
			$stdPIS->item = $itemCont; 
			$stdPIS->CST = $i->produto->CST_PIS;
			$stdPIS->vBC = $this->format($i->produto->perc_pis) > 0 ? $stdProd->vProd : 0.00;
			$stdPIS->pPIS = $this->format($i->produto->perc_pis);
			$stdPIS->vPIS = $this->format(($stdProd->vProd * $i->quantidade) * 
				($i->produto->perc_pis/100));
			$PIS = $nfe->tagPIS($stdPIS);


			$stdCOFINS = new \stdClass();//COFINS
			$stdCOFINS->item = $itemCont; 
			$stdCOFINS->CST = $i->produto->CST_COFINS;
			$stdCOFINS->vBC = $this->format($i->produto->perc_cofins) > 0 ? $stdProd->vProd : 0.00;
			$stdCOFINS->pCOFINS = $this->format($i->produto->perc_cofins);
			$stdCOFINS->vCOFINS = $this->format(($stdProd->vProd * $i->quantidade) * 
				($i->produto->perc_cofins/100));
			$COFINS = $nfe->tagCOFINS($stdCOFINS);

			

			$std = new \stdClass();//IPI
			$std->item = $itemCont; 
			$std->clEnq = null;
			$std->CNPJProd = null;
			$std->cSelo = null;
			$std->qSelo = null;
			$std->cEnq = '999'; //999 – para tributação normal IPI
			$std->CST = $i->produto->CST_IPI;
			$std->vBC = $this->format($i->produto->perc_ipi) > 0 ? $stdProd->vProd : 0.00;
			$std->pIPI = $this->format($i->produto->perc_ipi);
			$std->vIPI = $stdProd->vProd * $this->format(($i->produto->perc_ipi/100));
			$std->qUnid = null;
			$std->vUnid = null;

			$nfe->tagIPI($std);
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
		$stdICMSTot->vDesc = $this->format(0.00);
		$stdICMSTot->vII = 0.00;
		$stdICMSTot->vIPI = 0.00;
		$stdICMSTot->vPIS = 0.00;
		$stdICMSTot->vCOFINS = 0.00;
		$stdICMSTot->vOutro = 0.00;

		// if($venda->frete){
		// 	$stdICMSTot->vNF = 
		// 	$this->format(($somaProdutos+$venda->frete->valor)-$venda->desconto);
		// } 
		$stdICMSTot->vNF = $this->format($somaProdutos);

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


	//Fatura
		if($tipoPagamento != '90'){

			$stdFat = new \stdClass();
			$stdFat->nFat = $stdIde->nNF;
			$stdFat->vOrig = $this->format($compra->valor);
			$stdFat->vDesc = $this->format(0.00);
			$stdFat->vLiq = $this->format($compra->valor);

			$fatura = $nfe->tagfat($stdFat);
		}


	//Duplicata

		if($tipoPagamento != '90'){
			if(sizeof($compra->fatura) > 0){
				$contFatura = 1;
				foreach($compra->fatura as $ft){
					$stdDup = new \stdClass();
					$stdDup->nDup = "00".$contFatura;
					$stdDup->dVenc = substr($ft->data_vencimento, 0, 10);
					$stdDup->vDup = $this->format($ft->valor_integral);

					$nfe->tagdup($stdDup);
					$contFatura++;
				}
			}else{
				$stdDup = new \stdClass();
				$stdDup->nDup = '001';
				$stdDup->dVenc = Date('Y-m-d');
				$stdDup->vDup =  $this->format($compra->valor);

				$nfe->tagdup($stdDup);
			}
		}



		$stdPag = new \stdClass();
		$pag = $nfe->tagpag($stdPag);

		$stdDetPag = new \stdClass();


		$stdDetPag->tPag = $tipoPagamento;
		$stdDetPag->vPag = $tipoPagamento == '90' ? 0.00 : $this->format($stdProd->vProd); 
		$stdDetPag->indPag = '0'; 

		$detPag = $nfe->tagdetPag($stdDetPag);


		$stdInfoAdic = new \stdClass();
		$stdInfoAdic->infCpl = '';

		$infoAdic = $nfe->taginfAdic($stdInfoAdic);



		$std = new \stdClass();
		$std->CNPJ = getenv('RESP_CNPJ'); //CNPJ da pessoa jurídica responsável pelo sistema utilizado na emissão do documento fiscal eletrônico
		$std->xContato= getenv('RESP_NOME'); //Nome da pessoa a ser contatada
		$std->email = getenv('RESP_EMAIL'); //E-mail da pessoa jurídica a ser contatada
		$std->fone = getenv('RESP_FONE'); //Telefone da pessoa jurídica/física a ser contatada
		$nfe->taginfRespTec($std);
		
		if(getenv("AUTXML")){
			$std = new \stdClass();
			$std->CNPJ = getenv("AUTXML"); 
			$std->CPF = null;
			$nfe->tagautXML($std);
		}

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

	public function format($number, $dec = 2){
		return number_format((float) $number, $dec, ".", "");
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
			sleep(4);
			//return $protocolo;
			$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
			try {
				$xml = Complements::toAuthorize($signXml, $protocolo);
				header('Content-type: text/xml; charset=UTF-8');
				file_put_contents($public.'xml_entrada_emitida/'.$chave.'.xml',$xml);
				return $recibo;
				// $this->printDanfe($xml);
			} catch (\Exception $e) {
				return "Erro: " . $st->toJson($protocolo);
			}

		} catch(\Exception $e){
			return "Erro: ".$e->getMessage() ;
		}

	}	

	public function cancelar($compra, $justificativa){
		try {
			
			$chave = $compra->chave;
			$response = $this->tools->sefazConsultaChave($chave);
			$stdCl = new Standardize($response);
			$arr = $stdCl->toArray();
			sleep(1);
				// return $arr;
			$xJust = $justificativa;


			$nProt = $arr['protNFe']['infProt']['nProt'];

			$response = $this->tools->sefazCancela($chave, $xJust, $nProt);
			sleep(2);
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
					file_put_contents($public.'xml_nfe_entrada_cancelada/'.$chave.'.xml',$xml);

					return $json;
				} else {

					return $json;	
				}
			}    
		} catch (\Exception $e) {
			echo $e->getMessage();

		}
	}

	
	
}
