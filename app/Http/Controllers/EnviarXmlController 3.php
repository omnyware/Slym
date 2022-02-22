<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venda;
use App\VendaCaixa;
use App\Cte;
use App\Mdfe;
use App\ConfigNota;
use App\EscritorioContabil;
use Mail;

class EnviarXmlController extends Controller
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

	public function index(){
		return view('enviarXml/list')
		->with('title', 'Enviar XML');
	}

	public function filtro(Request $request){
		$xml = Venda::
		whereBetween('updated_at', [
			$this->parseDate($request->data_inicial), 
			$this->parseDate($request->data_final, true)])
		->where('estado', 'APROVADO')
		->where('empresa_id', $this->empresa_id)
		->get();

		$public = getenv('SERVIDOR_WEB') ? 'public/' : '';

		try{
			if(count($xml) > 0){

				$zip_file = $public.'zips/xml_'.$this->empresa_id.'.zip';
				$zip = new \ZipArchive();
				$zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

				foreach($xml as $x){
					if(file_exists($public.'xml_nfe/'.$x->chave. '.xml'))
						$zip->addFile($public.'xml_nfe/'.$x->chave. '.xml', $x->path_xml);
				}
				$zip->close();
			}
		}catch(\Exception $e){

		}

		try{
			$xmlCte = Cte::
			whereBetween('updated_at', [
				$this->parseDate($request->data_inicial), 
				$this->parseDate($request->data_final, true)])
			->where('estado', 'APROVADO')
			->where('empresa_id', $this->empresa_id)
			->get();

			if(count($xmlCte) > 0){


				// $zip_file = $public.'xmlcte.zip';
				$zip_file = $public.'zips/xmlcte_'.$this->empresa_id.'.zip';

				$zip = new \ZipArchive();
				$zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

				foreach($xmlCte as $x){
					if(file_exists($public.'xml_cte/'.$x->chave. '.xml'))
						$zip->addFile($public.'xml_cte/'.$x->chave. '.xml', $x->path_xml);
				}
				$zip->close();

			}
		}catch(\Exception $e){

		}

		try{
			$xmlNfce = VendaCaixa::
			whereBetween('updated_at', [
				$this->parseDate($request->data_inicial), 
				$this->parseDate($request->data_final, true)])
			->where('estado', 'APROVADO')
			->where('empresa_id', $this->empresa_id)
			->get();

			if(count($xmlNfce) > 0){

				// $zip_file = $public.'xmlnfce.zip';
				$zip_file = $public.'zips/xmlnfce_'.$this->empresa_id.'.zip';

				$zip = new \ZipArchive();
				$zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

				foreach($xmlNfce as $x){
					if(file_exists($public.'xml_nfce/'.$x->chave. '.xml'))
						$zip->addFile($public.'xml_nfce/'.$x->chave. '.xml', $x->chave. '.xml');
				}
				$zip->close();
			}
		}catch(\Exception $e){

		}

		$xmlMdfe = Mdfe::
		whereBetween('updated_at', [
			$this->parseDate($request->data_inicial), 
			$this->parseDate($request->data_final, true)])
		->where('estado', 'APROVADO')
		->where('empresa_id', $this->empresa_id)
		->get();

		if(count($xmlMdfe) > 0){
			try{

				// $zip_file = $public.'xmlmdfe.zip';
				$zip_file = $public.'zips/xmlmdfe_'.$this->empresa_id.'.zip';

				$zip = new \ZipArchive();
				$zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

				foreach($xmlMdfe as $x){
					if(file_exists($public.'xml_mdfe/'.$x->chave. '.xml')){
						$zip->addFile($public.'xml_mdfe/'.$x->chave. '.xml', $x->chave. '.xml');
					}
				}
				$zip->close();
			}catch(\Exception $e){
				// echo $e->getMessage();
			}

		}

		$dataInicial = str_replace("/", "-", $request->data_inicial);
		$dataFinal = str_replace("/", "-", $request->data_final);

		return view('enviarXml/list')
		->with('xml', $xml)
		->with('xmlNfce', $xmlNfce)
		->with('xmlCte', $xmlCte)
		->with('xmlMdfe', $xmlMdfe)
		->with('dataInicial', $dataInicial)
		->with('dataFinal', $dataFinal)
		->with('title', 'Enviar XML');
	}

	public function download(){
		$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
		$file = $public."zips/xml_".$this->empresa_id.".zip";
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="'.$file.'"');
		readfile($file);


		return redirect('/enviarXml');

	}

	public function downloadNfce(){
		$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
		// $file = $public."xmlnfce.zip";
		$file = $public."zips/xmlnfce_".$this->empresa_id.".zip";

		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="'.$file.'"');
		readfile($file);

		return redirect('/enviarXml');
	}

	public function downloadCte(){
		$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
		// $file = $public."xmlcte.zip";
		$file = $public."zips/xmlcte_".$this->empresa_id.".zip";

		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="'.$file.'"');
		readfile($file);

		return redirect('/enviarXml');
	}

	public function downloadMdfe(){
		$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
		// $file = $public."xmlmdfe.zip";
		$file = $public."zips/xmlmdfe_".$this->empresa_id.".zip";

		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="'.$file.'"');
		readfile($file);

		return redirect('/enviarXml');
	}

	private function parseDate($date, $plusDay = false){
		if($plusDay == false)
			return date('Y-m-d', strtotime(str_replace("/", "-", $date)));
		else
			return date('Y-m-d', strtotime("+1 day",strtotime(str_replace("/", "-", $date))));
	}

	public function email($dataInicial, $dataFinal){

		$empresa = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();
		Mail::send('mail.xml', ['data_inicial' => $dataInicial, 'data_final' => $dataFinal,
			'empresa' => $empresa->razao_social, 'cnpj' => $empresa->cnpj, 'tipo' => 'NFe'], function($m){
				$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
				$escritorio = EscritorioContabil::first();
				if($escritorio == null){
					echo "<h1>Configure o email do escritório <a target='_blank' href='/escritorio'>aqui</a></h1>";
					die();
				}
				$nomeEmail = getenv('MAIL_NAME');
				$nomeEmail = str_replace("_", " ", $nomeEmail);
				$m->from(getenv('MAIL_USERNAME'), $nomeEmail);
				$m->subject('Envio de XML');
				//$m->attach($public.'xml.zip');
				$m->attach($public.'zips/xml_'.$this->empresa_id.'.zip');
				$m->to($escritorio->email);
			});
		echo '<h1>Email enviado</h1>';
	}

	public function emailNfce($dataInicial, $dataFinal){

		$empresa = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();
		Mail::send('mail.xml', ['data_inicial' => $dataInicial, 'data_final' => $dataFinal,
			'empresa' => $empresa->razao_social, 'cnpj' => $empresa->cnpj, 'tipo' => 'NFCe'], function($m){
				$escritorio = EscritorioContabil::first();
				if($escritorio == null){
					echo "<h1>Configure o email do escritório <a target='_blank' href='/escritorio'>aqui</a></h1>";
					die();
				}
				$public = getenv('SERVIDOR_WEB') ? 'public/' : '';

				$nomeEmail = getenv('MAIL_NAME');
				$nomeEmail = str_replace("_", " ", $nomeEmail);
				$m->from(getenv('MAIL_USERNAME'), $nomeEmail);
				$m->subject('Envio de XML');
				//$m->attach($public.'xmlnfce.zip');
				$m->attach($public.'zips/xmlnfce_'.$this->empresa_id.'.zip');
				$m->to($escritorio->email);

			});
		echo '<h1>Email enviado</h1>';

	}

	public function emailCte($dataInicial, $dataFinal){
		
		$empresa = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();
		Mail::send('mail.xml', ['data_inicial' => $dataInicial, 'data_final' => $dataFinal,
			'empresa' => $empresa->razao_social, 'cnpj' => $empresa->cnpj, 'tipo' => 'CTe'], function($m){
				$escritorio = EscritorioContabil::first();
				if($escritorio == null){
					echo "<h1>Configure o email do escritório <a target='_blank' href='/escritorio'>aqui</a></h1>";
					die();
				}
				$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
				$nomeEmail = getenv('MAIL_NAME');
				$nomeEmail = str_replace("_", " ", $nomeEmail);
				$m->from(getenv('MAIL_USERNAME'), $nomeEmail);
				$m->subject('Envio de XML');
				//$m->attach($public.'xmlcte.zip');
				$m->attach($public.'zips/xmlcte_'.$this->empresa_id.'.zip');
				$m->to($escritorio->email);

			});
		echo '<h1>Email enviado</h1>';

	}

	public function emailMdfe($dataInicial, $dataFinal){
		
		$empresa = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();
		Mail::send('mail.xml', ['data_inicial' => $dataInicial, 'data_final' => $dataFinal,
			'empresa' => $empresa->razao_social, 'cnpj' => $empresa->cnpj, 'tipo' => 'MDFe'], function($m){
				$escritorio = EscritorioContabil::first();
				if($escritorio == null){
					echo "<h1>Configure o email do escritório <a target='_blank' href='/escritorio'>aqui</a></h1>";
					die();
				}
				$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
				$nomeEmail = getenv('MAIL_NAME');
				$nomeEmail = str_replace("_", " ", $nomeEmail);
				$m->from(getenv('MAIL_USERNAME'), $nomeEmail);
				$m->subject('Envio de XML');
				//$m->attach($public.'xmlmdfe.zip');
				$m->attach($public.'zips/xmlmdfe_'.$this->empresa_id.'.zip');
				$m->to($escritorio->email);

			});
		echo '<h1>Email enviado</h1>';

	}

	
	

}
