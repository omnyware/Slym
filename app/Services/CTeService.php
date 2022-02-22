<?php

namespace App\Services;
use NFePHP\CTe\Make;
use NFePHP\CTe\Tools;
use NFePHP\CTe\Complements;
use NFePHP\CTe\Common\Standardize;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapCurl;
use App\ConfigNota;
use App\Cte;
use App\Certificado;
use App\Tributacao;

error_reporting(E_ALL);
ini_set('display_errors', 'On');
class CTeService{

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
		$this->tools->model('57');
		
	}

	public function gerarCTe($cteEmit){

		$config = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();

		// $cteEmit = Cte::where('id', $id)
		// ->first();

		$tributacao = Tributacao::
		where('empresa_id', $this->empresa_id)
		->first(); // iniciando tributos

		$cte = new Make();
		$dhEmi = date("Y-m-d\TH:i:sP");
		$lastCte = Cte::lastCTe();
		$numeroCTE = $lastCte;
		$numeroCTE++;

		$cnpj = str_replace(".", "", $config->cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);
		$cnpj = str_replace(" ", "", $cnpj);

		$chave = $this->montaChave(
			$config->cUF, date('y', strtotime($dhEmi)), date('m', strtotime($dhEmi)), $cnpj, $this->tools->model(), '1', $numeroCTE, '1', '10'
		);
		$infCte = new \stdClass();
		$infCte->Id = "";
		$infCte->versao = "3.00";
		$cte->taginfCTe($infCte);


		$cDV = substr($chave, -1);      
		$ide = new \stdClass();

		$ide->cUF = $config->cUF; 
		$ide->cCT = rand(11111111, 99999999); 
		/*if($config->UF != $cteEmit->remetente->cidade->uf && $config->UF = $cteEmit->destinatario->cidade->uf){
			$ide->CFOP = $cteEmit->natureza->CFOP_saida_estadual;
		}else if($config->UF != $cteEmit->remetente->cidade->uf && $config->UF != $cteEmit->destinatario->cidade->uf){	
			$ide->CFOP = $cteEmit->natureza->CFOP_saida_inter_estadual; 
		}else if($config->UF = $cteEmit->remetente->cidade->uf){
			$ide->CFOP = $config->UF != $cteEmit->destinatario->cidade->uf ?
			$cteEmit->natureza->CFOP_saida_inter_estadual : $cteEmit->natureza->CFOP_saida_estadual;
		}*/
		$ide->CFOP = $config->UF != $cteEmit->remetente->cidade->uf ?
			$cteEmit->natureza->CFOP_saida_inter_estadual : $cteEmit->natureza->CFOP_saida_estadual;	
		$ide->natOp = $cteEmit->natureza->natureza;
		$ide->mod = '57'; 
		$ide->serie = '1'; 
		$nCte = $ide->nCT = $numeroCTE; 
		$ide->dhEmi = $dhEmi; 
		$ide->tpImp = '1'; 
		$ide->tpEmis = '1'; 
		$ide->cDV = $cDV; 
		$ide->tpAmb = (int)$config->ambiente; 
		$ide->tpCTe = '0'; 

		// 0- CT-e Normal; 1 - CT-e de Complemento de Valores;
// 2 -CT-e de Anulação; 3 - CT-e Substituto

		$ide->procEmi = '0'; 
		$ide->verProc = '3.0'; 
		$ide->indGlobalizado = $cteEmit->globalizado == 1 ? '1' : '';

		$ide->cMunEnv = $cteEmit->municipioEnvio->codigo; 
		$ide->xMunEnv = strtoupper($cteEmit->municipioEnvio->nome); 
		$ide->UFEnv = $cteEmit->municipioEnvio->uf; 
		$ide->modal = $cteEmit->modal; 
		$ide->tpServ = '0'; 

		$ide->cMunIni = $cteEmit->remetente->cidade->codigo; 
		$ide->xMunIni = strtoupper($cteEmit->remetente->cidade->nome); 
		$ide->UFIni = $cteEmit->remetente->cidade->uf; 
		$ide->cMunFim = $cteEmit->destinatario->cidade->codigo; 
		$ide->xMunFim = strtoupper($cteEmit->destinatario->cidade->nome); 
		$ide->UFFim = $cteEmit->destinatario->cidade->uf; 
		$ide->retira = $cteEmit->retira ? 0 : 1;
		$ide->xDetRetira = $cteEmit->detalhes_retira;

		if($cteEmit->tomador == 0){
			if($cteEmit->remetente->contribuinete){
				if($cteEmit->remetente->ie_rg == 'ISENTO'){
					$ide->indIEToma = '2';
				}else{
					$ide->indIEToma = '1';
				}
			}else{
				$ide->indIEToma = '9';
			}
		}else if($cteEmit->tomador == 3){
			if($cteEmit->destinatario->contribuinete){
				if($cteEmit->destinatario->ie_rg == 'ISENTO'){
					$ide->indIEToma = '2';
				}else{
					$ide->indIEToma = '1';
				}
			}else{
				$ide->indIEToma = '9';
			}
		}
		// $ide->indIEToma = $cteEmit->destinatario;
		$ide->dhCont = ''; 
		$ide->xJust = '';

		$cte->tagide($ide);
// Indica o "papel" do tomador: 0-Remetente; 1-Expedidor; 2-Recebedor; 3-Destinatário
		$toma3 = new \stdClass();
		$toma3->toma = $cteEmit->tomador;
		$cte->tagtoma3($toma3);

		$enderToma = new \stdClass();
		$enderToma->xLgr = $cteEmit->logradouro_tomador;
		$enderToma->nro = $cteEmit->numero_tomador; 
		$enderToma->xCpl = ''; 
		$enderToma->xBairro = $cteEmit->bairro_tomador; 
		$enderToma->cMun = $cteEmit->municipioTomador->codigo; 
		$enderToma->xMun = $cteEmit->municipioTomador->nome; 
		$enderToma->CEP = $cteEmit->cep_tomador; 
		$enderToma->UF = $cteEmit->municipioTomador->uf; 
		$enderToma->cPais = '1058'; 
		$enderToma->xPais = 'Brasil';                   
		$cte->tagenderToma($enderToma);   


		$emit = new \stdClass();
		
		$emit->CNPJ = $cnpj; 

		$ie = str_replace(".", "", $config->ie);
		$ie = str_replace("/", "", $ie);
		$ie = str_replace("-", "", $ie);
		$emit->IE = $ie; 
		$emit->IEST = "";
		$emit->xNome = $config->razao_social; 
		$emit->xFant = $config->nome_fantasia; 
		$cte->tagemit($emit); 


		$enderEmit = new \stdClass();
		$enderEmit->xLgr = $config->logradouro; 
		$enderEmit->nro = $config->numero; 
		$enderEmit->xCpl = '';
		$enderEmit->xBairro = $config->bairro; 
		$enderEmit->cMun = $config->codMun;
		$enderEmit->xMun = $config->municipio; 

		$cep = str_replace("-", "", $config->cep);
		$cep = str_replace(".", "", $cep);
		$enderEmit->CEP = $cep; 
		$enderEmit->UF = $config->UF; 

		$fone = str_replace(" ", "", $config->fone);
		$fone = str_replace("-", "", $fone);
		$enderEmit->fone = $fone; 
		$cte->tagenderEmit($enderEmit);

		$rem = new \stdClass();

		$cnpjRemente = str_replace(".", "", $cteEmit->remetente->cpf_cnpj);
		$cnpjRemente = str_replace("/", "", $cnpjRemente);
		$cnpjRemente = str_replace("-", "", $cnpjRemente);
		if(strlen($cnpjRemente) == 14){
			$rem->CNPJ = $cnpjRemente; 

			$ieRemetente = str_replace(".", "", $cteEmit->remetente->ie_rg);
			$ieRemetente = str_replace("/", "", $ieRemetente);
			$ieRemetente = str_replace("-", "", $ieRemetente);
			$rem->IE = $ieRemetente;
		}
		else{
			$rem->CPF = $cnpjRemente; 
		}

		$rem->xNome = $cteEmit->remetente->razao_social;
		if($cteEmit->remetente->nome_fantasia) $rem->xFant = $cteEmit->remetente->nome_fantasia; 
		$rem->fone = ''; 
		$rem->email = ''; 
		$cte->tagrem($rem);

		$enderReme = new \stdClass();
		$enderReme->xLgr = $cteEmit->remetente->rua; 
		$enderReme->nro = $cteEmit->remetente->numero; 
		$enderReme->xCpl = ''; 
		$enderReme->xBairro = $cteEmit->remetente->bairro; 
		$enderReme->cMun = $cteEmit->remetente->cidade->codigo; 
		$enderReme->xMun = strtoupper($cteEmit->remetente->cidade->nome); 
		$cepRemetente = str_replace("-", "", $cteEmit->remetente->cep);
		$enderReme->CEP = $cepRemetente; 
		$enderReme->UF = $cteEmit->remetente->cidade->uf; 
		$enderReme->cPais = '1058'; 
		$enderReme->xPais = 'Brasil'; 
		$cte->tagenderReme($enderReme);

		$dest = new \stdClass();
		$cnpjDestinatario = str_replace(".", "", $cteEmit->destinatario->cpf_cnpj);
		$cnpjDestinatario = str_replace("/", "", $cnpjDestinatario);
		$cnpjDestinatario = str_replace("-", "", $cnpjDestinatario);
		if(strlen($cnpjDestinatario) == 14){
			$dest->CNPJ = $cnpjDestinatario; 

			$ieDestinatario = str_replace(".", "", $cteEmit->destinatario->ie_rg);
			$ieDestinatario = str_replace("/", "", $ieDestinatario);
			$ieDestinatario = str_replace("-", "", $ieDestinatario);
			$dest->IE = $ieDestinatario;
		}
		else{
			$dest->CPF = $cnpjDestinatario; 
		}
		
		$dest->xNome = $cteEmit->destinatario->razao_social;
		$dest->fone = ''; 
		$dest->ISUF = ''; 
		$dest->email = ''; 
		$cte->tagdest($dest);

		$enderDest = new \stdClass();
		$enderDest->xLgr = $cteEmit->destinatario->rua; 
		$enderDest->nro = $cteEmit->destinatario->numero; 
		$enderDest->xCpl = ''; 
		$enderDest->xBairro = $cteEmit->destinatario->bairro; 
		$enderDest->cMun = $cteEmit->destinatario->cidade->codigo; 
		$enderDest->xMun = strtoupper($cteEmit->destinatario->cidade->nome); 

		$cepDest = str_replace("-", "", $cteEmit->destinatario->cep);
		$enderDest->CEP = $cepDest; 
		$enderDest->UF = $cteEmit->destinatario->cidade->uf; 
		$enderDest->cPais = '1058'; 
		$enderDest->xPais = 'Brasil'; 
		$cte->tagenderDest($enderDest);

		$vPrest = new \stdClass();
		$vPrest->vTPrest = $this->format($cteEmit->valor_transporte); 
		$vPrest->vRec = $this->format($cteEmit->valor_receber);      
		$cte->tagvPrest($vPrest);

		foreach($cteEmit->componentes as $c){
			$comp = new \stdClass();
			$comp->xNome = $c->nome; 
			$comp->vComp = $this->format($c->valor);  
			$cte->tagComp($comp);
		}


		$icms = new \stdClass();
		if($tributacao->regime == 1){ 
			$icms->cst = $cteEmit->CST;
		}else{
			$icms->cst = 'SN';
		}
		$icms->pRedBC = ''; 
		if($cteEmit->CST = '00'){
			$icms->vBC = $this->format($cteEmit->valor_receber); 
			$icms->pICMS = $this->format($tributacao->icms);
			$icms->vICMS = $this->format($icms->vBC * ($icms->pICMS/100));	
		}else{
			$icms->vBC = 0.00; 
			$icms->pICMS = 0.00; 
			$icms->vICMS = 0.00;
		} 
		$icms->vBCSTRet = 0.00; 
		$icms->vICMSSTRet = 0.00; 
		$icms->pICMSSTRet = 0.00; 
		$icms->vCred = 0.00; 
		$icms->vTotTrib = 0.00; 
		$icms->outraUF = false;    
		$icms->vICMSUFIni = 0;  
		$icms->vICMSUFFim = 0;
		$icms->infAdFisco = '';
		$cte->tagicms($icms);

		$cte->taginfCTeNorm();              // Grupo de informações do CT-e Normal e Substituto
		
		$infCarga = new \stdClass();
		$infCarga->vCarga = $this->format($cteEmit->valor_carga);
		$infCarga->proPred = $cteEmit->produto_predominante; 
		$infCarga->xOutCat = 0.00; 
		// $infCarga->vCargaAverb = 1.99;
		$cte->taginfCarga($infCarga);

		foreach($cteEmit->medidas as $m){
			$infQ = new \stdClass();
			$infQ->cUnid = $m->cod_unidade; 
// Código da Unidade de Medida: ( 00-M3; 01-KG; 02-TON; 03-UNIDADE; 04-LITROS; 05-MMBTU
			$infQ->tpMed = $m->tipo_medida; 
// Tipo de Medida
// ( PESO BRUTO; PESO DECLARADO; PESO CUBADO; PESO AFORADO; PESO AFERIDO; LITRAGEM; CAIXAS e etc)
			$infQ->qCarga = $m->quantidade_carga;  
// Quantidade (15 posições; sendo 11 inteiras e 4 decimais.)
			$cte->taginfQ($infQ);
		}

		if(strlen($cteEmit->chave_nfe) > 0){
			$chaves = explode(";", $cteEmit->chave_nfe);

			foreach($chaves as $chave){
				$infNFe = new \stdClass();
				$infNFe->chave = $chave; 
				$infNFe->PIN = ''; 
				$infNFe->dPrev = $cteEmit->data_previsata_entrega;                                       
				$cte->taginfNFe($infNFe);
			}
		}else{

			$infOut = new \stdClass();

			$infOut->tpDoc = $cteEmit->tpDoc;     
			$infOut->descOutros = $cteEmit->descOutros;     
			$infOut->nDoc = $cteEmit->nDoc;     
			$infOut->dEmi = date('Y-m-d');     
			$infOut->vDocFisc = $this->format($cteEmit->vDocFisc);     
			$infOut->dPrev = $cteEmit->data_previsata_entrega;     
			$cte->taginfOutros($infOut);

		}


		$infModal = new \stdClass();
		$infModal->versaoModal = '3.00';
		$cte->taginfModal($infModal);

		$rodo = new \stdClass();
		$rodo->RNTRC = $cteEmit->veiculo->rntrc;
		$cte->tagrodo($rodo);

		$aereo = new \stdClass();
		$aereo->nMinu = '123'; 
		$aereo->nOCA = '';
 // Número Operacional do Conhecimento Aéreo
		$aereo->dPrevAereo = date('Y-m-d');
		$aereo->natCarga_xDime = ''; 
		$aereo->natCarga_cInfManu = [  ]; 
		$aereo->tarifa_CL = 'G';
		$aereo->tarifa_cTar = ''; 
		$aereo->tarifa_vTar = 100.00; 
		$cte->tagaereo($aereo);

// 		$autXML = new \stdClass();
// 		// $cnpj = str_replace(".", "", $config->cnpj);
// 		// $cnpj = str_replace("/", "", $cnpj);
// 		// $cnpj = str_replace("-", "", $cnpj);
// 		// $cnpj = str_replace(" ", "", $cnpj);
// 		$autXML->CNPJ = '08543628000145'; 
// // CPF ou CNPJ dos autorizados para download do XML
// 		$cte->tagautXML($autXML);


		try{
			$cte->montaCTe();
			$chave = $cte->chCTe;
			$xml = $cte->getXML();
			$arr = [
				'chave' => $chave,
				'xml' => $xml,
				'nCte' => $nCte
			];
			return $arr;
		}catch(\Exception $e){
			return [
				'erros_xml' => $cte->getErrors()
			];
		}
	}

	public function sign($xml){
		return $this->tools->signCTe($xml);
	}

	public function transmitir($signXml, $chave){
		try{
			$idLote = substr(str_replace(',', '', number_format(microtime(true) * 1000000, 0)), 0, 15);
			$resp = $this->tools->sefazEnviaLote([$signXml], $idLote);
			sleep(1);
			$st = new Standardize($resp);
			sleep(2);

			$arr = $st->toArray();
			$std = $st->toStd();

			if ($std->cStat != 103) {
				// erro
				return "[$std->cStat] - $std->xMotivo";
			}

			$recibo = $std->infRec->nRec; 
			$protocolo = $this->tools->sefazConsultaRecibo($recibo);
			sleep(3);
			// return $protocolo;
			$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
			try {
				$xml = Complements::toAuthorize($signXml, $protocolo);
				header('Content-type: text/xml; charset=UTF-8');
				file_put_contents($public.'xml_cte/'.$chave.'.xml',$xml);
				return $recibo;
				// $this->printDanfe($xml);
			} catch (\Exception $e) {
				return "Erro: " . $st->toJson($protocolo);
			}

		} catch(\Exception $e){
			return "Erro: ".$e->getMessage() ;
		}

	}	

	private function format($number, $dec = 2){
		return number_format((float) $number, $dec, ".", "");
	}

	private function montaChave($cUF, $ano, $mes, $cnpj, $mod, $serie, 
		$numero, $tpEmis, $codigo = ''){
		if ($codigo == '') {
			$codigo = $numero;
		}
		$forma = "%02d%02d%02d%s%02d%03d%09d%01d%08d";
		$chave = sprintf(
			$forma, $cUF, $ano, $mes, $cnpj, $mod, $serie, $numero, $tpEmis, $codigo
		);
		return $chave . $this->calculaDV($chave);
	}

	private function calculaDV($chave43){
		$multiplicadores = array(2, 3, 4, 5, 6, 7, 8, 9);
		$iCount = 42;
		$somaPonderada = 0;
		while ($iCount >= 0) {
			for ($mCount = 0; $mCount < count($multiplicadores) && $iCount >= 0; $mCount++) {
				$num = (int) substr($chave43, $iCount, 1);
				$peso = (int) $multiplicadores[$mCount];
				$somaPonderada += $num * $peso;
				$iCount--;
			}
		}
		$resto = $somaPonderada % 11;
		if ($resto == '0' || $resto == '1') {
			$cDV = 0;
		} else {
			$cDV = 11 - $resto;
		}
		return (string) $cDV;
	}


	public function cancelar($cteId, $justificativa){

		try {
			$cte = Cte::
			where('id', $cteId)
			->first();
				// $this->tools->model('55');

			$chave = $cte->chave;
			$response = $this->tools->sefazConsultaChave($chave);
			$stdCl = new Standardize($response);
			$arr = $stdCl->toArray();
			$js = $stdCl->toJson();
			sleep(1);
			$xJust = $justificativa;

			$nProt = $arr['protCTe']['infProt']['nProt'];


			$response = $this->tools->sefazCancela($chave, $xJust, $nProt);

			$stdCl = new Standardize($response);
			$std = $stdCl->toStd();
			$arr = $stdCl->toArray();
			$json = $stdCl->toJson();
			// return $json;
			$cStat = $std->infEvento->cStat;

			$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
			if ($cStat == '101' || $cStat == '135' || $cStat == '155') {
				$xml = Complements::toAuthorize($this->tools->lastRequest, $response);
				// header('Content-type: text/xml; charset=UTF-8');
				file_put_contents($public.'xml_cte_cancelada/'.$chave.'.xml',$xml);
				return $json;
			}else{
				return $json;
			}

		} catch (\Exception $e) {
			echo $e->getMessage();
    //TRATAR
		}
	}

	public function consultar($id){
		try {
			$cte = Cte::
			where('id', $id)
			->first();

			$chave = $cte->chave;
			$response = $this->tools->sefazConsultaChave($chave);

			$stdCl = new Standardize($response);
			$arr = $stdCl->toArray();

			// $arr = json_decode($json);
			return json_encode($arr);

		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}

	public function inutilizar($nInicio, $nFinal, $justificativa){
		try{

			$nSerie = '1';
			$nIni = $nInicio;
			$nFin = $nFinal;
			$xJust = $justificativa;
			$tpAmb = 2;
			$response = $this->tools->sefazInutiliza($nSerie, $nIni, $nFin, $xJust, $tpAmb);

			$stdCl = new Standardize($response);

			$std = $stdCl->toStd();

			$arr = $stdCl->toArray();

			$json = $stdCl->toJson();

			return $arr;

		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}

	public function cartaCorrecao($id, $grupo, $campo, $valor){
		try {

			$cte = Cte::
			where('id', $id)
			->first();

			$chave = $cte->chave;

			$nSeqEvento = $cte->sequencia_cce+1;
			$infCorrecao[] = [
				'grupoAlterado' => $grupo,
				'campoAlterado' => $campo,
				'valorAlterado' => $valor,
				'nroItemAlterado' => '01'
			];
			$response = $this->tools->sefazCCe($chave, $infCorrecao, $nSeqEvento);
			sleep(2);

			$stdCl = new Standardize($response);
			$std = $stdCl->toStd();
			$arr = $stdCl->toArray();
			$json = $stdCl->toJson();
			$cStat = $std->infEvento->cStat;
			$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
			if ($cStat == '101' || $cStat == '135' || $cStat == '155') {
				$xml = Complements::toAuthorize($this->tools->lastRequest, $response);
				file_put_contents($public.'xml_cte_correcao/'.$chave.'.xml',$xml);
				$cte->sequencia_cce = $cte->sequencia_cce + 1;
				$cte->save();
				return $json;
			}else{
				 //houve alguma falha no evento 
				return $json;
			}

		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

}