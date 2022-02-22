<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConfigNota;
use App\Certificado;
use App\NaturezaOperacao;
use App\Services\NFService;
use NFePHP\Common\Certificate;
use Mail;

class ConfigNotaController extends Controller
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

	function sanitizeString($str){
		return preg_replace('{\W}', ' ', preg_replace('{ +}', ' ', strtr(
			utf8_decode(html_entity_decode($str)),
			utf8_decode('ÀÁÃÂÉÊÍÓÕÔÚÜÇÑàáãâéêíóõôúüçñ'),
			'AAAAEEIOOOUUCNaaaaeeiooouucn')));
	}

	public function index(){
		try{
			$naturezas = NaturezaOperacao::
			where('empresa_id', $this->empresa_id)
			->get();
			$tiposPagamento = ConfigNota::tiposPagamento();
			$tiposFrete = ConfigNota::tiposFrete();
			$listaCSTCSOSN = ConfigNota::listaCST();
			$listaCSTPISCOFINS = ConfigNota::listaCST_PIS_COFINS();
			$listaCSTIPI = ConfigNota::listaCST_IPI();

			$config = ConfigNota::
			where('empresa_id', $this->empresa_id)
			->first();
			$certificado = Certificado::
			where('empresa_id', $this->empresa_id)
			->first();

			$cUF = ConfigNota::estados();


			$infoCertificado = null;
			if($certificado != null){
				$infoCertificado = $this->getInfoCertificado($certificado);
			}

			$soapDesativado = !extension_loaded('soap');
			
			return view('configNota/index')
			->with('config', $config)
			->with('naturezas', $naturezas)
			->with('tiposPagamento', $tiposPagamento)
			->with('tiposFrete', $tiposFrete)
			->with('infoCertificado', $infoCertificado)
			->with('soapDesativado', $soapDesativado)
			->with('listaCSTCSOSN', $listaCSTCSOSN)
			->with('listaCSTPISCOFINS', $listaCSTPISCOFINS)
			->with('listaCSTIPI', $listaCSTIPI)
			->with('cUF', $cUF)
			->with('testeJs', true)

			->with('certificado', $certificado)
			->with('title', 'Configurar Emitente');
		}catch(\Exception $e){
			echo $e->getMessage();
			echo "<br><a href='/configNF/deleteCertificado'>Remover Certificado</a>";
		}
	}

	private function getInfoCertificado($certificado){

		$infoCertificado =  Certificate::readPfx($certificado->arquivo, $certificado->senha);

		$publicKey = $infoCertificado->publicKey;

		$inicio =  $publicKey->validFrom->format('Y-m-d H:i:s');
		$expiracao =  $publicKey->validTo->format('Y-m-d H:i:s');

		return [
			'serial' => $publicKey->serialNumber,
			'inicio' => \Carbon\Carbon::parse($inicio)->format('d-m-Y H:i'),
			'expiracao' => \Carbon\Carbon::parse($expiracao)->format('d-m-Y H:i'),
			'id' => $publicKey->commonName
		];

	}

	public function save(Request $request){
		$this->_validate($request);
		$uf = $request->uf;

		$nomeImagem = "";

		if($request->hasFile('file')){
			$file = $request->file('file');

			$extensao = $file->getClientOriginalExtension();
			$rand = rand(0, 999999);
			$nomeImagem = md5($file->getClientOriginalName()).$rand.".".$extensao;
			$upload = $file->move(public_path('logos'), $nomeImagem);
		}


		if($request->id == 0){
			$result = ConfigNota::create([
				'razao_social' => strtoupper($this->sanitizeString($request->razao_social)),
				'nome_fantasia' => strtoupper($this->sanitizeString($request->nome_fantasia)),
				'cnpj' => $request->cnpj,
				'ie' => $request->ie,
				'logradouro' => strtoupper($this->sanitizeString($request->logradouro)),
				'numero' => strtoupper($this->sanitizeString($request->numero)),
				'bairro' => strtoupper($this->sanitizeString($request->bairro)),
				'cep' => $request->cep,
				'municipio' => strtoupper($this->sanitizeString($request->municipio)),
				'codMun' => $request->codMun,
				'codPais' => $request->codPais,
				'UF' => ConfigNota::getUF($uf),
				'pais' => strtoupper($request->pais),
				'fone' => $this->sanitizeString($request->fone),
				'CST_CSOSN_padrao' => $request->CST_CSOSN_padrao, 
				'CST_COFINS_padrao' => $request->CST_COFINS_padrao, 
				'CST_PIS_padrao' => $request->CST_PIS_padrao, 
				'CST_IPI_padrao' => $request->CST_IPI_padrao, 
				'frete_padrao' => $request->frete_padrao, 
				'tipo_pagamento_padrao' => $request->tipo_pagamento_padrao, 
				'nat_op_padrao' => $request->nat_op_padrao ?? 0, 
				'ambiente' => $request->ambiente, 
				'cUF' => $uf,
				'ultimo_numero_nfe' => $request->ultimo_numero_nfe, 
				'ultimo_numero_nfce' => $request->ultimo_numero_nfce, 
				'ultimo_numero_cte' => $request->ultimo_numero_cte, 
				'ultimo_numero_mdfe' => $request->ultimo_numero_mdfe,
				'numero_serie_nfe' => $request->numero_serie_nfe,
				'numero_serie_nfce' => $request->numero_serie_nfce,
				'csc' => $request->csc,
				'csc_id' => $request->csc_id,
				'certificado_a3' => $request->certificado_a3 ? true: false,
				'empresa_id' => $request->empresa_id,
				'inscricao_municipal' => $request->inscricao_municipal ?? '',
				'aut_xml' => $request->aut_xml ?? '',
				'logo' => $nomeImagem
			]);
		}else{
			$config = ConfigNota::
			where('empresa_id', $this->empresa_id)
			->first();

			$config->razao_social = strtoupper($this->sanitizeString($request->razao_social));
			$config->nome_fantasia = strtoupper($this->sanitizeString($request->nome_fantasia));
			$config->cnpj = $this->sanitizeString($request->cnpj);
			$config->ie = $this->sanitizeString($request->ie);
			$config->logradouro = strtoupper($this->sanitizeString($request->logradouro));
			$config->numero = strtoupper($this->sanitizeString($request->numero));
			$config->bairro = strtoupper($this->sanitizeString($request->bairro));
			$config->cep = $request->cep;
			$config->municipio = strtoupper($this->sanitizeString($request->municipio));
			$config->codMun = $request->codMun;
			$config->codPais = $request->codPais;
			$config->UF = ConfigNota::getUF($uf);
			$config->pais = strtoupper($request->pais);
			$config->fone = $request->fone;

			$config->CST_CSOSN_padrao = $request->CST_CSOSN_padrao;
			$config->CST_COFINS_padrao = $request->CST_COFINS_padrao;
			$config->CST_PIS_padrao = $request->CST_PIS_padrao;
			$config->CST_IPI_padrao = $request->CST_IPI_padrao;
			
			$config->frete_padrao = $request->frete_padrao;
			$config->tipo_pagamento_padrao = $request->tipo_pagamento_padrao;
			$config->nat_op_padrao = $request->nat_op_padrao ?? 0;
			$config->ambiente = $request->ambiente;
			$config->cUF = $uf;
			$config->ultimo_numero_nfe = $request->ultimo_numero_nfe;
			$config->ultimo_numero_nfce = $request->ultimo_numero_nfce; 
			$config->ultimo_numero_cte = $request->ultimo_numero_cte;
			$config->ultimo_numero_mdfe = $request->ultimo_numero_mdfe;
			$config->numero_serie_nfe = $request->numero_serie_nfe;
			$config->numero_serie_nfce = $request->numero_serie_nfce;
			$config->csc = $request->csc;
			$config->csc_id = $request->csc_id;
			$config->certificado_a3 = $request->certificado_a3 ? true : false;

			$config->inscricao_municipal = $request->inscricao_municipal;
			$config->aut_xml = $request->aut_xml;
			$config->logo = $nomeImagem;


			$result = $config->save();
		}



		if($result){
			session()->flash("mensagem_sucesso", "Configurado com sucesso!");
		}else{
			session()->flash('mensagem_erro', 'Erro ao configurar!');
		}

		return redirect('/configNF');
	}


	private function _validate(Request $request){
		$rules = [
			'razao_social' => 'required|max:100',
			'nome_fantasia' => 'required|max:80',
			'cnpj' => 'required',
			'ie' => 'required',
			'logradouro' => 'required|max:80',
			'numero' => 'required|max:10',
			'bairro' => 'required|max:50',
			'fone' => 'required|max:20',
			'cep' => 'required',
			'municipio' => 'required',
			'pais' => 'required',
			'pais' => 'required',
			'codPais' => 'required',
			'codMun' => 'required',
			'uf' => 'required|max:2|min:2',
			'rntrc' => 'max:12',
			'ultimo_numero_nfe' => 'required',
			'ultimo_numero_nfce' => 'required',
			'ultimo_numero_cte' => 'required',
			'ultimo_numero_mdfe' => 'required',
			'numero_serie_nfe' => 'required|max:3',
			'numero_serie_nfce' => 'required|max:3',
			'csc' => 'required',
			'csc_id' => 'required',
			'file' => 'max:2000',
		];

		$messages = [
			'razao_social.required' => 'O Razão social nome é obrigatório.',
			'razao_social.max' => '100 caracteres maximos permitidos.',
			'nome_fantasia.required' => 'O campo Nome Fantasia é obrigatório.',
			'nome_fantasia.max' => '80 caracteres maximos permitidos.',
			'cnpj.required' => 'O campo CNPJ é obrigatório.',
			'logradouro.required' => 'O campo Logradouro é obrigatório.',
			'ie.required' => 'O campo Inscrição Estadual é obrigatório.',
			'logradouro.max' => '80 caracteres maximos permitidos.',
			'numero.required' => 'O campo Numero é obrigatório.',
			'cep.required' => 'O campo CEP é obrigatório.',
			'municipio.required' => 'O campo Municipio é obrigatório.',
			'numero.max' => '10 caracteres maximos permitidos.',
			'bairro.required' => 'O campo Bairro é obrigatório.',
			'bairro.max' => '50 caracteres maximos permitidos.',
			'fone.required' => 'O campo Telefone é obrigatório.',
			'fone.max' => '20 caracteres maximos permitidos.',

			'uf.required' => 'O campo UF é obrigatório.',
			'uf.max' => 'UF inválida.',
			'uf.min' => 'UF inválida.',

			'pais.required' => 'O campo Pais é obrigatório.',
			'codPais.required' => 'O campo Código do Pais é obrigatório.',
			'codMun.required' => 'O campo Código do Municipio é obrigatório.',
			'rntrc.max' => '12 caracteres maximos permitidos.',
			'ultimo_numero_nfe.required' => 'Campo obrigatório.',
			'ultimo_numero_nfe.required' => 'Campo obrigatório.',
			'ultimo_numero_nfce.required' => 'Campo obrigatório.',
			'ultimo_numero_cte.required' => 'Campo obrigatório.',
			'ultimo_numero_mdfe.required' => 'Campo obrigatório.',
			'numero_serie_nfe.required' => 'Campo obrigatório.',
			'numero_serie_nfe.max' => 'Maximo de 3 Digitos.',
			'numero_serie_nfce.required' => 'Campo obrigatório.',
			'numero_serie_nfce.max' => 'Maximo de 3 Digitos.',
			'csc.required' => 'O Razão CSC é obrigatório.',
			'csc_id.required' => 'O Razão CSCID é obrigatório.',
			'file.max' => 'Upload de até 2000KB.',

		];

		$this->validate($request, $rules, $messages);
	}

	public function certificado(){
		return view('configNota/upload')
		->with('title', 'Upload de Certificado');
	}

	public function download(){
		$certificado = Certificado::
		where('empresa_id', $this->empresa_id)
		->first();
		// echo "Senha: " . $certificado->senha;
		try{
			file_put_contents(public_path('cd.bin'), $certificado->arquivo);
			return response()->download(public_path('cd.bin'));
		}catch(\Exception $e){
			echo $e->getMessage();
		}

	}

	public function senha(){
		$certificado = Certificado::
		where('empresa_id', $this->empresa_id)
		->first();
		echo "Senha: " . $certificado->senha;

	}
	
	public function saveCertificado(Request $request){

		if($request->hasFile('file') && strlen($request->senha) > 0){
			$file = $request->file('file');
			$temp = file_get_contents($file);

			$res = Certificado::create([
				'senha' => $request->senha,
				'arquivo' => $temp,
				'empresa_id' => $request->empresa_id
			]);

			if($res){
				session()->flash("mensagem_sucesso", "Upload de certificado realizado!");
				return redirect('/configNF');
				
			}
		}else{
			session()->flash("mensagem_erro", "Envie o arquivo e senha por favor!");
			return redirect('/configNF/certificado');
		}
	}

	public function deleteCertificado(){
		Certificado::
		where('empresa_id', $this->empresa_id)
		->delete();
		session()->flash("mensagem_sucesso", "Certificado Removido!");
		return redirect('configNF');
	}

	public function teste(){
		try{
			$config = ConfigNota::
			where('empresa_id', $this->empresa_id)
			->first();

			$cnpj = str_replace(".", "", $config->cnpj);
			$cnpj = str_replace("/", "", $cnpj);
			$cnpj = str_replace("-", "", $cnpj);
			$cnpj = str_replace(" ", "", $cnpj);

			$nfe_service = new NFService([
				"atualizacao" => date('Y-m-d h:i:s'),
				"tpAmb" => (int)$config->ambiente,
				"razaosocial" => $config->razao_social,
				"siglaUF" => $config->UF,
				"cnpj" => $cnpj,
				"schemes" => "PL_009_V4",
				"versao" => "4.00",
				"tokenIBPT" => "AAAAAAA",
				"CSC" => $config->csc,
				"CSCid" => $config->csc_id
			]);

			$uf = $config->UF;
			$res = $nfe_service->consultaCadastro($cnpj, $uf);
			return response()->json($res, 200);
		}catch (\Exception $e) {
			return response()->json($e->getMessage(), 401);
		}

	}

	public function testeEmail(){

		$mailDriver = getenv("MAIL_HOST");
		$mailHost = getenv("MAIL_DRIVER");
		$mailPort = getenv("MAIL_PORT");
		$mailUsername = getenv("MAIL_USERNAME");
		$mailPass = getenv("MAIL_PASSWORD");
		$mailCpt = getenv("MAIL_ENCRYPTION");
		$mailName = getenv("MAIL_NAME");

		if($mailDriver == '') return response()->json("Configure no .env MAIL_HOST", 403);
		if($mailHost == '') return response()->json("Configure no .env MAIL_DRIVER", 403);
		if($mailPort == '') return response()->json("Configure no .env MAIL_PORT", 403);
		if($mailUsername == '') return response()->json("Configure no .env MAIL_USERNAME", 403);
		if($mailPass == '') return response()->json("Configure no .env MAIL_PASSWORD", 403);
		if($mailCpt == '') return response()->json("Configure no .env MAIL_ENCRYPTION", 403);
		if($mailName == '') return response()->json("Configure no .env MAIL_NAME", 403);

		try{
			Mail::send('mail.teste', [], function($m){
				$nomeEmail = getenv("MAIL_NAME");
				$mail = getenv("MAIL_USERNAME");
				$nomeEmail = str_replace("_", " ", $nomeEmail);
				$m->from(getenv('MAIL_USERNAME'), $nomeEmail);
				$m->subject('Teste de email');
				$m->to($mail);
			});
		}catch(\Exception $e){
			return response()->json($e->getMessage(), 403);
		}

	}

	
}
