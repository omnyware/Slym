<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CTeService;
use App\Services\NFService;
use App\ConfigNota;
use App\Cte;
use App\Tributacao;
use NFePHP\DA\CTe\Dacte;
use NFePHP\DA\CTe\Daevento;
use Mail;

class EmiteCteController extends Controller
{
	protected $empresa_id = null;
	public function __construct(){
		$this->middleware(function ($request, $next) {
			$this->empresa_id = $request->empresa_id;
			$value = session('user_logged');
			if(!$value){
				return redirect("/login");
			}
			return $next($request);
		});
	}

	public function enviar(Request $request){

		$cteEmit = Cte::
		where('id', $request->id)
		->where('empresa_id', $this->empresa_id)
		->first();

		if(!$cteEmit){
			return response()->json('Não permitido', 403);
		}

		$tributacao = Tributacao::
        where('empresa_id', $this->empresa_id)
        ->get();

		$config = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();
		$cnpj = str_replace(".", "", $config->cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);
		$cnpj = str_replace(" ", "", $cnpj);

		$cte_service = new CTeService([
			"atualizacao" => date('Y-m-d h:i:s'),
			"tpAmb" => (int)$config->ambiente,
			"razaosocial" => $config->razao_social,
			"siglaUF" => $config->UF,
			"cnpj" => $cnpj,
			"schemes" => "PL_CTe_300",
			"versao" => '3.00',
			"proxyConf" => [
				"proxyIp" => "",
				"proxyPort" => "",
				"proxyUser" => "",
				"proxyPass" => ""
			]
		], '57');

		if($cteEmit->estado == 'REJEITADO' || $cteEmit->estado == 'DISPONIVEL'){
			header('Content-type: text/html; charset=UTF-8');
			$cte = $cte_service->gerarCTe($cteEmit);
			if(!isset($cte['erros_xml'])){
				$signed = $cte_service->sign($cte['xml']);

				$resultado = $cte_service->transmitir($signed, $cte['chave']);

				if(substr($resultado, 0, 4) != 'Erro'){
					$cteEmit->chave = $cte['chave'];
					$cteEmit->path_xml = $cte['chave'] . '.xml';
					$cteEmit->estado = 'APROVADO';

					$cteEmit->cte_numero = $cte['nCte'];
					$cteEmit->save();
				}else{
					$cteEmit->estado = 'REJEITADO';
					$cteEmit->save();
				}
				echo json_encode($resultado);
			}else{
				return response()->json($cte['erros_xml'], 401);
			}
		}else{
			echo json_encode("Apro");
		}
		
	}

	public function xmlTemp($id){
		$cteEmit = Cte::
		where('id', $id)
		->where('empresa_id', $this->empresa_id)
		->first();

		if(!$cteEmit){
			return redirect('/403');
		}

		$config = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();
		$cnpj = str_replace(".", "", $config->cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);
		$cnpj = str_replace(" ", "", $cnpj);

		$cte_service = new CTeService([
			"atualizacao" => date('Y-m-d h:i:s'),
			"tpAmb" => (int)$config->ambiente,
			"razaosocial" => $config->razao_social,
			"siglaUF" => $config->UF,
			"cnpj" => $cnpj,
			"schemes" => "PL_CTe_300",
			"versao" => '3.00',
			"proxyConf" => [
				"proxyIp" => "",
				"proxyPort" => "",
				"proxyUser" => "",
				"proxyPass" => ""
			]
		], '57');


		$cte = $cte_service->gerarCTe($cteEmit);
		if(!isset($cte['erros_xml'])){
			$xml = $cte['xml'];
			return response($xml)
			->header('Content-Type', 'application/xml');
		}else{
			foreach($cte['erros_xml'] as $err){
				echo $err;
			}
		}
	}

	public function consultaChave(Request $request){
		$config = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();

		$cnpj = str_replace(".", "", $config->cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);
		$cnpj = str_replace(" ", "", $cnpj);
		$nfe_service = new NFService([
			"atualizacao" => date('Y-m-d h:i:s'),
			"tpAmb" => (int)$config->ambiente, // ambiente de producao para consulta nfe
			"razaosocial" => $config->razao_social,
			"siglaUF" => $config->UF,
			"cnpj" => $cnpj,
			"schemes" => "PL_009_V4",
			"versao" => "4.00",
			"tokenIBPT" => "AAAAAAA",
			"CSC" => $config->csc,
			"CSCid" => $config->csc_id
		]);

		$consulta = $nfe_service->consultaChave($request['chave']);
		echo json_encode($consulta);
	}


	public function imprimir($id){
		$cte = Cte::
		where('id', $id)
		->first();
		if(valida_objeto($cte)){

			$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
			if(file_exists($public.'xml_cte/'.$cte->chave.'.xml')){
				$xml = file_get_contents($public.'xml_cte/'.$cte->chave.'.xml');
		// $docxml = FilesFolders::readFile($xml);

				try {

					$dacte = new Dacte($xml);
					$dacte->debugMode(true);
					//$dacte->creditsIntegratorFooter('WEBNFe Sistemas - http://www.webenf.com.br');
					$dacte->monta();
					$pdf = $dacte->render();
					header('Content-Type: application/pdf');
					return response($pdf)
					->header('Content-Type', 'application/pdf');
				} catch (InvalidArgumentException $e) {
					echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
				}  
			}else{
				echo "Arquivo não encontrado!";
			}
		}else{
			return redirect('/403');
		}
	}

	public function baixarXml($id){
		$venda = Cte::find($id);
		if(valida_objeto($venda)){
			$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
			if(file_exists($public.'xml_cte/'.$venda->chave.'.xml')){

				return response()->download($public.'xml_cte/'.$venda->chave.'.xml');
			}else{
				echo "Arquivo XML não encontrado!!";
			}
		}else{
			return redirect('/403');
		}

	}

	public function imprimirCCe($id){
		$cte = Cte::
		where('id', $id)
		->first();
		if(valida_objeto($cte)){
			$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
			if(file_exists($public.'xml_cte_correcao/'.$cte->chave.'.xml')){

				$xml = file_get_contents($public.'xml_cte_correcao/'.$cte->chave.'.xml');

				$config = ConfigNota::
				where('empresa_id', $this->empresa_id)
				->first();

				if($config->logo){
					$logo = 'data://text/plain;base64,'. base64_encode(file_get_contents($public.'logos/' . $config->logo));
				}else{
					$logo = null;
				}

				$dadosEmitente = $this->getEmitente();

				try {

					$daevento = new Daevento($xml, $dadosEmitente);
					$daevento->debugMode(true);
					$pdf = $daevento->render($logo);
					header('Content-Type: application/pdf');
					return response($pdf)
					->header('Content-Type', 'application/pdf');

				} catch (InvalidArgumentException $e) {
					echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
				}  
			}else{
				echo "Arquivo não encontrado!";
			}
		}else{
			return redirect('/403');
		}
	}

	public function imprimirCancela($id){
		$cte = Cte::
		where('id', $id)
		->first();
		if(valida_objeto($cte)){
			$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
			if(file_exists($public.'xml_cte_cancelada/'.$cte->chave.'.xml')){
				$xml = file_get_contents($public.'xml_cte_cancelada/'.$cte->chave.'.xml');
				$config = ConfigNota::
				where('empresa_id', $this->empresa_id)
				->first();

				if($config->logo){
					$logo = 'data://text/plain;base64,'. base64_encode(file_get_contents($public.'logos/' . $config->logo));
				}else{
					$logo = null;
				}

				$dadosEmitente = $this->getEmitente();

				try {

					$daevento = new Daevento($xml, $dadosEmitente);
					$daevento->debugMode(true);
					$pdf = $daevento->render($logo);
					header('Content-Type: application/pdf');
					return response($pdf)
					->header('Content-Type', 'application/pdf');

				} catch (InvalidArgumentException $e) {
					echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
				}  
			}else{
				echo "Arquivo não encontrado!";
			}
		}else{
			return redirect('/403');
		}
	}

	private function getEmitente(){
		$config = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();
		return [
			'razao' => $config->razao_social,
			'logradouro' => $config->logradouro,
			'numero' => $config->numero,
			'complemento' => '',
			'bairro' => $config->bairro,
			'CEP' => $config->cep,
			'municipio' => $config->municipio,
			'UF' => $config->UF,
			'telefone' => $config->telefone,
			'email' => ''
		];
	}


	public function cancelar(Request $request){

		$config = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();

		$cnpj = str_replace(".", "", $config->cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);
		$cnpj = str_replace(" ", "", $cnpj);

		$cte_service = new CTeService([
			"atualizacao" => date('Y-m-d h:i:s'),
			"tpAmb" => (int)$config->ambiente,
			"razaosocial" => $config->razao_social,
			"siglaUF" => $config->UF,
			"cnpj" => $cnpj,
			"schemes" => "PL_CTe_300",
			"versao" => '3.00',
			"proxyConf" => [
				"proxyIp" => "",
				"proxyPort" => "",
				"proxyUser" => "",
				"proxyPass" => ""
			]
		], '57');


		$cte = $cte_service->cancelar($request->id, $request->justificativa);

		$error = json_decode($cte)->infEvento;
		if($error->cStat == '101' || $error->cStat == '135' || $error->cStat == '155'){
			$c = Cte::
			where('id', $request->id)
			->first();
			$c->estado = 'CANCELADO';
			$c->save();

			//return response()->json($cte, 200);
		}
		
		echo json_encode($cte);
	}

	public function consultar(Request $request){
		$config = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();

		$cnpj = str_replace(".", "", $config->cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);
		$cnpj = str_replace(" ", "", $cnpj);

		$cte_service = new CTeService([
			"atualizacao" => date('Y-m-d h:i:s'),
			"tpAmb" => (int)$config->ambiente,
			"razaosocial" => $config->razao_social,
			"siglaUF" => $config->UF,
			"cnpj" => $cnpj,
			"schemes" => "PL_CTe_300",
			"versao" => '3.00',
			"proxyConf" => [
				"proxyIp" => "",
				"proxyPort" => "",
				"proxyUser" => "",
				"proxyPass" => ""
			]
		], '57');
		$c = $cte_service->consultar($request->id);
		echo json_encode($c);
	}

	public function inutilizar(Request $request){

		$config = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();

		$cnpj = str_replace(".", "", $config->cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);
		$cnpj = str_replace(" ", "", $cnpj);


		$cte_service = new CTeService([
			"atualizacao" => date('Y-m-d h:i:s'),
			"tpAmb" => (int)$config->ambiente,
			"razaosocial" => $config->razao_social,
			"siglaUF" => $config->UF,
			"cnpj" => $cnpj,
			"schemes" => "PL_CTe_300",
			"versao" => '3.00',
			"proxyConf" => [
				"proxyIp" => "",
				"proxyPort" => "",
				"proxyUser" => "",
				"proxyPass" => ""
			]
		], '57');

		// echo json_encode($request->justificativa);
		$result = $cte_service->inutilizar($request->nInicio, $request->nFinal, 
			$request->justificativa);

		echo json_encode($result);
	}

	public function cartaCorrecao(Request $request){

		$config = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();

		$cnpj = str_replace(".", "", $config->cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);
		$cnpj = str_replace(" ", "", $cnpj);

		$cte_service = new CTeService([
			"atualizacao" => date('Y-m-d h:i:s'),
			"tpAmb" => (int)$config->ambiente,
			"razaosocial" => $config->razao_social,
			"siglaUF" => $config->UF,
			"cnpj" => $cnpj,
			"schemes" => "PL_CTe_300",
			"versao" => '3.00',
			"proxyConf" => [
				"proxyIp" => "",
				"proxyPort" => "",
				"proxyUser" => "",
				"proxyPass" => ""
			]
		], '57');

		$cte = $cte_service->cartaCorrecao($request->id, $request->grupo, 
			$request->campo, $request->correcao);
		echo json_encode($cte);
	}

	public function enviarXml(Request $request){
		$email = $request->email;
		$id = $request->id;
		$cte = Cte::
		where('id', $id)
		->first();
		if(valida_objeto($cte)){
			$this->criarPdfParaEnvio($cte);
			$value = session('user_logged');
			Mail::send('mail.xml_send_cte', ['emissao' => $cte->data_registro, 'cte' => $cte->cte_numero, 'usuario' => $value['nome']], function($m) use ($cte, $email){
				$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
				$nomeEmpresa = getenv('SMS_NOME_EMPRESA');
				$nomeEmpresa = str_replace("_", " ",  $nomeEmpresa);
				$nomeEmpresa = str_replace("_", " ",  $nomeEmpresa);
				$emailEnvio = getenv('MAIL_USERNAME');

				$m->from($emailEnvio, $nomeEmpresa);
				$m->subject('Envio de XML CT-e ' . $cte->cte_numero);
				$m->attach($public.'xml_cte/'.$cte->path_xml);
				$m->attach($public.'pdf/CTe.pdf');
				$m->to($email);
			});
			return "ok";
		}else{
			return redirect('/403');
		}
	}

	private function criarPdfParaEnvio($cte){
		$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
		$xml = file_get_contents($public.'xml_cte/'.$cte->chave.'.xml');
		$logo = 'data://text/plain;base64,'. base64_encode(file_get_contents($public.'imgs/logo.jpg'));
		// $docxml = FilesFolders::readFile($xml);

		try {

			$dacte = new Dacte($xml);
			// $dacte->debugMode(true);
			//$dacte->creditsIntegratorFooter('WEBNFe Sistemas - http://www.webenf.com.br');
			$dacte->monta();
			$pdf = $dacte->render();
			header('Content-Type: application/pdf');
			file_put_contents($public.'pdf/CTe.pdf',$pdf);
		} catch (InvalidArgumentException $e) {
			echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
		}  
	}

	private function isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}
}
