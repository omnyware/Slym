<?php
namespace App\Services;

use NFePHP\NFe\Make;
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;
use App\VendaCaixa;
use App\ConfigNota;
use App\Certificado;
use NFePHP\NFe\Complements;
use NFePHP\DA\NFe\Danfe;
use NFePHP\DA\Legacy\FilesFolders;
use NFePHP\Common\Soap\SoapCurl;
use App\Tributacao;
use App\PedidoDelivery;

error_reporting(E_ALL);
ini_set('display_errors', 'On');


class NFCeService{

	private $config; 
	private $tools;
	protected $empresa_id = null;

	public function __construct($config, $empresa_id = null){
		if($empresa_id == null){
			$value = session('user_logged');
			$this->empresa_id = $value['empresa'];
		}else{
			$this->empresa_id = $empresa_id;
		}
		$certificado = Certificado::
		where('empresa_id', $this->empresa_id)
		->first();

		$this->config = $config;
		$this->tools = new Tools(json_encode($config), Certificate::readPfx($certificado->arquivo, $certificado->senha));
		$this->tools->model(65);
		
	}

	public function gerarNFCe($idVenda){
		$venda = VendaCaixa::
		where('id', $idVenda)
		->first();

		$config = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();

		$tributacao = Tributacao::
		where('empresa_id', $this->empresa_id)
		->first(); 

		$nfe = new Make();
		$stdInNFe = new \stdClass();
		$stdInNFe->versao = '4.00'; //versão do layout
		$stdInNFe->Id = null; //se o Id de 44 digitos não for passado será gerado automaticamente
		$stdInNFe->pk_nItem = ''; //deixe essa variavel sempre como NULL

		$infNFe = $nfe->taginfNFe($stdInNFe);

		//IDE
		$stdIde = new \stdClass();
		$stdIde->cUF = $config->cUF;
		$stdIde->cNF = rand(11111111, 99999999);
		$stdIde->natOp = $config->natureza->natureza;

		// $stdIde->indPag = 1; //NÃO EXISTE MAIS NA VERSÃO 4.00 // forma de pagamento

		$vendaLast = VendaCaixa::lastNFCe($this->empresa_id);
		$lastNumero = $vendaLast;

		$stdIde->mod = 65;
		$stdIde->serie = $config->numero_serie_nfce;
		$stdIde->nNF = (int)$lastNumero+1; 
		$stdIde->dhEmi = date("Y-m-d\TH:i:sP");
		$stdIde->dhSaiEnt = date("Y-m-d\TH:i:sP");
		$stdIde->tpNF = 1;
		$stdIde->idDest = 1;
		$stdIde->cMunFG = $config->codMun;
		$stdIde->tpImp = 4;
		$stdIde->tpEmis = 1;
		$stdIde->cDV = 0;
		$stdIde->tpAmb = $config->ambiente;
		$stdIde->finNFe = 1;
		$stdIde->indFinal = 1;
		$stdIde->indPres = 1;
		$stdIde->procEmi = '0';
		$stdIde->verProc = '2.0';
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
		$stdEnderEmit->CEP = $cep;
		$stdEnderEmit->cPais = $config->codPais;
		$stdEnderEmit->xPais = $config->pais;

		$fone = str_replace(" ", "", $config->fone);
		$fone = str_replace("-", "", $fone);
		$stdEnderEmit->fone = $fone;

		$enderEmit = $nfe->tagenderEmit($stdEnderEmit);

		// DESTINATARIO


		if($venda->cliente_id != null || $venda->cpf != null){
			$stdDest = new \stdClass();
			if($venda->cliente_id != null){
				$stdDest->xNome = $venda->cliente->razao_social;
				$stdDest->indIEDest = "1";

				$cnpj_cpf = str_replace(".", "", $venda->cliente->cpf_cnpj);
				$cnpj_cpf = str_replace("/", "", $cnpj_cpf);
				$cnpj_cpf = str_replace("-", "", $cnpj_cpf);

				if(strlen($cnpj_cpf) == 14) $stdDest->CNPJ = $cnpj_cpf;
				else $stdDest->CPF = $cnpj_cpf;

				$dest = $nfe->tagdest($stdDest);

				$stdEnderDest = new \stdClass();
				$stdEnderDest->xLgr = $venda->cliente->rua;
				$stdEnderDest->nro = $venda->cliente->numero;
				$stdEnderDest->xCpl = "";
				$stdEnderDest->xBairro = $venda->cliente->bairro;
				$stdEnderDest->cMun = $venda->cliente->cidade->codigo;
				$stdEnderDest->xMun = strtoupper($venda->cliente->cidade->nome);
				$stdEnderDest->UF = $venda->cliente->cidade->uf;

				$cep = str_replace("-", "", $venda->cliente->cep);
				$stdEnderDest->CEP = $cep;
				$stdEnderDest->cPais = "1058";
				$stdEnderDest->xPais = "BRASIL";
				$enderDest = $nfe->tagenderDest($stdEnderDest);

			}
			if($venda->cpf != null){

				$cpf = str_replace(".", "", $venda->cpf);
				$cpf = str_replace("/", "", $cpf);
				$cpf = str_replace("-", "", $cpf);
				$cpf = str_replace(" ", "", $cpf);

				if($venda->nome) $stdDest->xNome = $venda->nome;
				$stdDest->indIEDest = "9";
				$stdDest->CPF = $cpf;
				$dest = $nfe->tagdest($stdDest);
			}

		}


		$somaProdutos = 0;
		$somaICMS = 0;
		//PRODUTOS
		$itemCont = 0;
		$somaDesconto = 0;
		$totalItens = count($venda->itens);
		$somaAcrescimo = 0;
		$VBC = 0;

		foreach($venda->itens as $i){
			$itemCont++;

			$stdProd = new \stdClass();
			$stdProd->item = $itemCont;
			$stdProd->cEAN = $i->produto->codBarras;
			$stdProd->cEANTrib = $i->produto->codBarras;
			$stdProd->cProd = $i->produto->id;
			$stdProd->xProd = $i->produto->nome;
			if($i->produto->CST_CSOSN == '500' || $i->produto->CST_CSOSN == '60'){
				$stdProd->cBenef = 'SEM CBENEF';
			}

			$ncm = $i->produto->NCM;
			$ncm = str_replace(".", "", $ncm);
			$stdProd->NCM = $ncm;

			$stdProd->CFOP = $i->produto->CFOP_saida_estadual;
			$cest = $i->produto->CEST;
			$cest = str_replace(".", "", $cest);
			$stdProd->CEST = $cest;
			$stdProd->uCom = $i->produto->unidade_venda;
			$stdProd->qCom = $i->quantidade;
			$stdProd->vUnCom = $this->format($i->valor);
			$stdProd->vProd = $this->format($i->quantidade * $i->valor);
			$stdProd->uTrib = $i->produto->unidade_venda;
			$stdProd->qTrib = $i->quantidade;
			$stdProd->vUnTrib = $this->format($i->valor);
			$stdProd->indTot = 1;


			//calculo media prod

			if($venda->acrescimo > 0){
				if($itemCont < sizeof($venda->itens)){
					$totalVenda = $venda->valor_total;

					$media = (((($stdProd->vProd-$totalVenda)/$totalVenda))*100);
					$media = 100 - ($media * -1);

					$tempAcrescimo = ($venda->acrescimo*$media)/100;
					$somaAcrescimo+=$tempAcrescimo;

					$stdProd->vOutro = $this->format($tempAcrescimo);
				}else{
					$stdProd->vOutro = $this->format($venda->acrescimo - $somaAcrescimo);
				}
			}

			if($venda->pedido_delivery_id > 0){
				$pedido = PedidoDelivery::find($venda->pedido_delivery_id);
				$somaItens = $pedido->somaItensSemFrete();
				$totalVenda = $venda->valor_total;
				if($somaItens < $totalVenda){
					$vAcr = $totalVenda - $somaItens;

					if($itemCont < sizeof($venda->itens)){

						$media = (((($stdProd->vProd-$totalVenda)/$totalVenda))*100);
						$media = 100 - ($media * -1);

						$tempAcrescimo = ($vAcr*$media)/100;
						$somaAcrescimo+=$tempAcrescimo;

						$stdProd->vOutro = $this->format($tempAcrescimo);
					}else{
						$stdProd->vOutro = $this->format($vAcr - $somaAcrescimo);
					}

				}
			}
			// fim calculo
			

			// if($venda->desconto > 0){
			// 	$stdProd->vDesc = $this->format($venda->desconto/$totalItens);
			// }

			if($venda->desconto > 0){
				if($itemCont < sizeof($venda->itens)){
					$totalVenda = $venda->valor_total;

					$media = (((($stdProd->vProd - $totalVenda)/$totalVenda))*100);
					$media = 100 - ($media * -1);

					$tempDesc = ($venda->desconto*$media)/100;
					$somaDesconto += $tempDesc;

					$stdProd->vDesc = $this->format($tempDesc);
				}else{
					$stdProd->vDesc = $this->format($venda->desconto - $somaDesconto);
				}
			}

			$somaProdutos += $i->quantidade * $i->valor;


			$prod = $nfe->tagprod($stdProd);

			$tributacao = Tributacao::first();

			$stdImposto = new \stdClass();
			$stdImposto->item = $itemCont;

			$imposto = $nfe->tagimposto($stdImposto);

			if($tributacao->regime == 1){ // regime normal

				$stdICMS = new \stdClass();
				$stdICMS->item = $itemCont; 
				$stdICMS->orig = 0;
				$stdICMS->CST = $i->produto->CST_CSOSN;
				$stdICMS->modBC = 0;
				$stdICMS->vBC = $this->format($i->valor * $i->quantidade);
				$stdICMS->pICMS = $this->format($i->produto->perc_icms);
				$stdICMS->vICMS = $stdICMS->vBC * ($stdICMS->pICMS/100);

				if($i->produto->CST_CSOSN == '500' || $i->produto->CST_CSOSN == '60'){
					$stdICMS->pRedBCEfet = 0.00;
					$stdICMS->vBCEfet = 0.00;
					$stdICMS->pICMSEfet = 0.00;
					$stdICMS->vICMSEfet = 0.00;
				}else{
					$VBC += $stdProd->vProd;
				}

				$somaICMS += $stdICMS->vICMS;
				$ICMS = $nfe->tagICMS($stdICMS);

			}else{ // regime simples
				
				$stdICMS = new \stdClass();
				
				$stdICMS->item = $itemCont; 
				$stdICMS->orig = 0;
				$stdICMS->CSOSN = $i->produto->CST_CSOSN;
				$stdICMS->pCredSN = $this->format($i->produto->perc_icms);
				$stdICMS->vCredICMSSN = $this->format($i->produto->perc_icms);
				$ICMS = $nfe->tagICMSSN($stdICMS);

				$somaICMS = 0;
			}



			$stdPIS = new \stdClass();
			$stdPIS->item = $itemCont; 
			$stdPIS->CST = $i->produto->CST_PIS;
			$stdPIS->vBC = $this->format($i->produto->perc_pis) > 0 ? $stdProd->vProd : 0.00;
			$stdPIS->pPIS = $this->format($i->produto->perc_pis);
			$stdPIS->vPIS = $this->format(($stdProd->vProd) * ($i->produto->perc_pis/100));
			$PIS = $nfe->tagPIS($stdPIS);

		//COFINS
			$stdCOFINS = new \stdClass();
			$stdCOFINS->item = $itemCont; 
			$stdCOFINS->CST = $i->produto->CST_COFINS;
			$stdCOFINS->vBC = $this->format($i->produto->perc_cofins) > 0 ? $stdProd->vProd : 0.00;
			$stdCOFINS->pCOFINS = $this->format($i->produto->perc_cofins);
			$stdCOFINS->vCOFINS = $this->format(($stdProd->vProd) * 
				($i->produto->perc_cofins/100));
			$COFINS = $nfe->tagCOFINS($stdCOFINS);

			if(strlen($i->produto->descricao_anp) > 5){
				$stdComb = new \stdClass();
				$stdComb->item = 1; 
				$stdComb->cProdANP = $i->produto->codigo_anp;
				$stdComb->descANP = $i->produto->descricao_anp; 
				$stdComb->UFCons = $venda->cliente->cidade->uf;

				$nfe->tagcomb($stdComb);
			}

			$cest = $i->produto->CEST;
			$cest = str_replace(".", "", $cest);
			$stdProd->CEST = $cest;
			if(strlen($cest) > 0){
				$std = new \stdClass();
				$std->item = $itemCont; 
				$std->CEST = $cest;
				$nfe->tagCEST($std);
			}
		}

		//ICMS TOTAL
		$stdICMSTot = new \stdClass();
		$stdICMSTot->vBC = $this->format($VBC);
		$stdICMSTot->vICMS = $this->format($somaICMS);
		$stdICMSTot->vICMSDeson = 0.00;
		$stdICMSTot->vBCST = 0.00;
		$stdICMSTot->vST = 0.00;
		$stdICMSTot->vProd = $this->format($somaProdutos);
		
		$stdICMSTot->vFrete = 0.00;

		$stdICMSTot->vSeg = 0.00;
		$stdICMSTot->vDesc = $this->format($venda->desconto);
		$stdICMSTot->vII = 0.00;
		$stdICMSTot->vIPI = 0.00;
		$stdICMSTot->vPIS = 0.00;
		$stdICMSTot->vCOFINS = 0.00;
		$stdICMSTot->vOutro = 0.00;
		$stdICMSTot->vNF = $this->format($venda->valor_total);
		$stdICMSTot->vTotTrib = 0.00;
		$ICMSTot = $nfe->tagICMSTot($stdICMSTot);

		//TRANSPORTADORA

		$stdTransp = new \stdClass();
		$stdTransp->modFrete = 9;

		$transp = $nfe->tagtransp($stdTransp);

		
		$stdPag = new \stdClass();

		$stdPag->vTroco = $this->format($venda->troco); 


		$pag = $nfe->tagpag($stdPag);

		//Resp Tecnico
		$stdResp = new \stdClass();
		$stdResp->CNPJ = getenv('RESP_CNPJ'); 
		$stdResp->xContato= getenv('RESP_NOME');
		$stdResp->email = getenv('RESP_EMAIL'); 
		$stdResp->fone = getenv('RESP_FONE'); 

		$nfe->taginfRespTec($stdResp);

		//DETALHE PAGAMENTO

		$stdDetPag = new \stdClass();
		$stdDetPag->indPag = 0;

		$stdDetPag->tPag = $venda->tipo_pagamento; 
		$stdDetPag->vPag = $this->format($venda->dinheiro_recebido); //Obs: deve ser informado o valor pago pelo cliente

		if($venda->tipo_pagamento == '03' || $venda->tipo_pagamento == '04'){
			$stdDetPag->CNPJ = '12345678901234';
			$stdDetPag->tBand = '01';
			$stdDetPag->cAut = '3333333';
			$stdDetPag->tpIntegra = 1;
		}
		
		// $std->tpIntegra = 1; //incluso na NT 2015/002
		// $std->indPag = '0'; //0= Pagamento à Vista 1= Pagamento à Prazo

		$detPag = $nfe->tagdetPag($stdDetPag);

		//INFO ADICIONAL
		// $stdInfoAdic = new \stdClass();
		// $stdInfoAdic->infAdFisco = 'informacoes para o fisco';
		// $stdInfoAdic->infCpl = 'informacoes complementares';

		// $infoAdic = $nfe->taginfAdic($stdInfoAdic);
		// if($nfe->monta()){

		// 	$arr = [
		// 		'chave' => $nfe->getChave(),
		// 		'xml' => $nfe->getXML(),
		// 		'nNf' => $stdIde->nNF,
		// 		'modelo' => $nfe->getModelo()
		// 	];
		// 	return $arr;
		// } else {
		// 	throw new Exception("Erro ao gerar NFce");
		// }


		try{
			$nfe->monta();
			$arr = [
				'chave' => $nfe->getChave(),
				'xml' => $nfe->getXML(),
				'nNf' => $stdIde->nNF,
				'modelo' => $nfe->getModelo()
			];
			return $arr;
		}catch(\Exception $e){
			return [
				'erros_xml' => $nfe->getErrors()
			];
		}

	}

	public function sign($xml){
		return $this->tools->signNFe($xml);
	}

	public function transmitirNfce($signXml, $chave){
		try{
			$idLote = str_pad(100, 15, '0', STR_PAD_LEFT);
			$resp = $this->tools->sefazEnviaLote([$signXml], $idLote);
			sleep(2);
			$st = new Standardize();
			$std = $st->toStd($resp);

			if ($std->cStat != 103) {

				return "[$std->cStat] - $std->xMotivo";
			}
			sleep(1);
			$recibo = $std->infRec->nRec; 
			$protocolo = $this->tools->sefazConsultaRecibo($recibo);
			sleep(1);
			// return $protocolo;

			$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
			try {
				$xml = Complements::toAuthorize($signXml, $protocolo);
				header('Content-type: text/xml; charset=UTF-8');
				file_put_contents($public.'xml_nfce/'.$chave.'.xml',$xml);
				return $recibo;
				// $this->printDanfe($xml);
			} catch (\Exception $e) {
				return "Erro: " . $st->toJson($protocolo);
			}

		} catch(\Exception $e){
			return "Erro: ".$e->getMessage() ;
		}

	}	

	public function cancelarNFCe($vendaId, $justificativa){
		try {
			$venda = VendaCaixa::
			where('id', $vendaId)
			->first();
			if(valida_objeto($venda)){

				$chave = $venda->chave;
				$response = $this->tools->sefazConsultaChave($chave);
				sleep(1);
				$stdCl = new Standardize($response);
				$arr = $stdCl->toArray();
				// return $arr;
				$xJust = $justificativa;


				$nProt = $arr['protNFe']['infProt']['nProt'];
				sleep(1);

				$response = $this->tools->sefazCancela($chave, $xJust, $nProt);

				$stdCl = new Standardize($response);
				$std = $stdCl->toStd();
				$arr = $stdCl->toArray();
				$json = $stdCl->toJson();

				$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
				if ($std->cStat != 128) {

				} else {
					$cStat = $std->retEvento->infEvento->cStat;
					if ($cStat == '101' || $cStat == '135' || $cStat == '155' ) {
            //SUCESSO PROTOCOLAR A SOLICITAÇÂO ANTES DE GUARDAR
						$xml = Complements::toAuthorize($this->tools->lastRequest, $response);
						file_put_contents($public.'xml_nfce_cancelada/'.$chave.'.xml',$xml);

						return $arr;
					} else {
						return $arr;	
					}
				}   
			}else{
				return 
				[
					'mensagem' => '403',
					'erro' => true
				];
			} 
		} catch (\Exception $e) {
			return 
			[
				'mensagem' => $e->getMessage(),
				'erro' => true
			];
    //TRATAR
		}
	}

	public function format($number, $dec = 2){
		return number_format((float) $number, $dec, ".", "");
	}

	public function consultarNFCe($venda){
		try {
			
			$this->tools->model('65');

			$chave = $venda->chave;
			$response = $this->tools->sefazConsultaChave($chave);

			$stdCl = new Standardize($response);
			$arr = $stdCl->toArray();

			// $arr = json_decode($json);
			return json_encode($arr);

		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}

}