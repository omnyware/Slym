<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EscritorioContabil;

class EscritorioController extends Controller
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
		$escritorio = EscritorioContabil::
		where('empresa_id', $this->empresa_id)
		->first();
		return view('escritorio/index')
		->with('escritorio', $escritorio)
		->with('title', 'Configurar Escritório');
	}


	public function save(Request $request){
		$this->_validate($request);
		if($request->id == 0){
			$result = EscritorioContabil::create([
				'razao_social' => strtoupper($this->sanitizeString($request->razao_social)),
				'nome_fantasia' => strtoupper($this->sanitizeString($request->nome_fantasia)),
				'cnpj' => $request->cnpj,
				'ie' => $request->ie,
				'fone' => $request->fone,
				'logradouro' => strtoupper($this->sanitizeString($request->logradouro)),
				'numero' => strtoupper($this->sanitizeString($request->numero)),
				'bairro' => strtoupper($this->sanitizeString($request->bairro)),
				'cep' => $request->cep,
				'email' => $request->email,
				'empresa_id' => $request->empresa_id
			]);
		}else{
			$config = EscritorioContabil::
			where('empresa_id', $this->empresa_id)
			->first();

			$config->razao_social = strtoupper($this->sanitizeString($request->razao_social));
			$config->nome_fantasia = strtoupper($this->sanitizeString($request->nome_fantasia));
			$config->cnpj = $request->cnpj;
			$config->ie = $request->ie;
			$config->fone = $request->fone;
			$config->logradouro = strtoupper($this->sanitizeString($request->logradouro));
			$config->numero = strtoupper($this->sanitizeString($request->numero));
			$config->bairro = strtoupper($this->sanitizeString($request->bairro));
			$config->cep = $request->cep;
			$config->email = strtoupper($request->email);
			$result = $config->save();
		}

		if($result){
			session()->flash("mensagem_sucesso", "Configurado com sucesso!");
		}else{
			session()->flash('mensagem_erro', 'Erro ao configurar!');
		}

		return redirect('/escritorio');
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
			'email' => 'required|email|max:80'
			
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
			'email.required' => 'O campo email é obrigatório.',
			'email.email' => 'Informe um email valido.',
			'email.max' => '80 caracteres maximos permitidos.'

		];
		$this->validate($request, $rules, $messages);
	}
}
