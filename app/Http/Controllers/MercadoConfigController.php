<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MercadoConfig;

class MercadoConfigController extends Controller
{
	public function __construct(){
		$this->middleware(function ($request, $next) {
			$value = session('user_logged');
			if(!$value){
				return redirect("/login");
			}
			return $next($request);
		});
	}

	public function index(){
		$config = MercadoConfig::
		first();
		return view('configMercado/index')
		->with('config', $config)
		->with('title', 'Configurar Parametros de Mercado');
	}


	public function save(Request $request){
		$this->_validate($request);
		$result = false;
		if($request->id == 0){
			$result = MercadoConfig::create([

				'email' => $request->email,
				'funcionamento' => $request->funcionamento,
				'descricao' => $request->descricao,
				'total_de_produtos' => $request->total_de_produtos,
				'total_de_clientes' => $request->total_de_clientes,
				'total_de_funcionarios' => $request->total_de_funcionarios
			]);
		}else{
			$config = MercadoConfig::
			first();

			$config->email = $request->email;
			$config->funcionamento = $request->funcionamento;
			$config->descricao = $request->descricao;
			$config->total_de_produtos = $request->total_de_produtos;
			$config->total_de_clientes = $request->total_de_clientes;
			$config->total_de_funcionarios = $request->total_de_funcionarios;
			

			$result = $config->save();
		}

		if($result){
			session()->flash('color', 'blue');
			session()->flash("message", "Configurado com sucesso!");
		}else{
			session()->flash('color', 'red');
			session()->flash('message', 'Erro ao configurar!');
		}

		return redirect('/configMercado');
	}


	private function _validate(Request $request){
		$rules = [
			
			'email' => 'required|max:50',
			'funcionamento' => 'required|max:100',
			'descricao' => 'required|max:200',
			'total_de_produtos' => 'required',
			'total_de_clientes' => 'required',
			'total_de_funcionarios' => 'required',
		];

		$messages = [

			'email.required' => 'O campo Email é obrigatório.',
			'email.max' => '50 caracteres maximos permitidos.',
			'funcionamento.required' => 'O campo funcionamento é obrigatório.',
			'funcionamento.max' => '100 caracteres maximos permitidos.',
			'descricao.required' => 'O campo descrição é obrigatório.',
			'descricao.max' => '200 caracteres maximos permitidos.',

			'total_de_produtos.required' => 'Campo obrigatório.',
			'total_de_clientes.required' => 'Campo obrigatório.',
			'total_de_funcionarios.required' => 'Campo obrigatório.',

		];
		$this->validate($request, $rules, $messages);
	}


}
