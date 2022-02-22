<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plano;
use App\PlanoEmpresa;
class PlanoController extends Controller
{
	public function __construct(){
		$this->middleware(function ($request, $next) {

			$value = session('user_logged');
			if(!$value){
				return redirect("/login");
			}

			if(!$value['super']){
				return redirect('/graficos');
			}
			return $next($request);
		});
	}

	public function index(){
		$planos = Plano::all();

		return view('planos/list')
		->with('planos', $planos)
		->with('title', 'Planos');
	}

	public function new(){

		return view('planos/register')
		->with('title', 'Novo Plano');
	}

	public function editar($id){
		$plano = Plano::find($id);
		return view('planos/register')
		->with('plano', $plano)
		->with('title', 'Editar Plano');
	}

	public function delete($id){
		$plano = Plano::find($id);

		$planoEmpresa = PlanoEmpresa::where('plano_id', $id)->first();

		if($planoEmpresa != null){
			session()->flash("mensagem_erro", "Não é possivel remover um plano atrelado com uma empresa.");
		}else{
			$plano->delete();
			session()->flash("mensagem_sucesso", "Plano removido com sucesso.");

		}
		return redirect('/planos');
	}

	public function save(Request $request){
		$this->_validate($request);

		Plano::create($request->all());
		session()->flash("mensagem_sucesso", "Plano cadastrado com sucesso.");
		return redirect('/planos');
	}

	public function update(Request $request){
		$this->_validate($request);

		$plano = Plano::find($request->id);

		$plano->nome = $request->nome;
		$plano->valor = $request->valor;
		$plano->maximo_clientes = $request->maximo_clientes;
		$plano->maximo_produtos = $request->maximo_produtos;
		$plano->maximo_fornecedores = $request->maximo_fornecedores;
		$plano->maximo_nfes = $request->maximo_nfes;
		$plano->maximo_nfces = $request->maximo_nfces;
		$plano->maximo_cte = $request->maximo_cte;
		$plano->maximo_mdfe = $request->maximo_mdfe;
		$plano->maximo_evento = $request->maximo_evento;
		$plano->save();
		session()->flash("mensagem_sucesso", "Plano atualizado com sucesso.");
		return redirect('/planos');
	}

	private function _validate(Request $request){
		$rules = [
			'nome' => 'required',
			'valor' => 'required',
			'maximo_clientes' => 'required',
			'maximo_produtos' => 'required',
			'maximo_fornecedores' => 'required',
			'maximo_nfes' => 'required',
			'maximo_nfces' => 'required',
			'maximo_cte' => 'required',
			'maximo_mdfe' => 'required',
		];

		$messages = [
			'nome.required' => 'O campo obrigatório.',
			'valor.required' => 'O campo obrigatório.',
			'maximo_clientes.required' => 'O campo obrigatório.',
			'maximo_produtos.required' => 'O campo obrigatório.',
			'maximo_fornecedores.required' => 'O campo obrigatório.',
			'maximo_nfes.required' => 'O campo obrigatório.',
			'maximo_nfces.required' => 'O campo obrigatório.',
			'maximo_cte.required' => 'O campo obrigatório.',
			'maximo_mdfe.required' => 'O campo obrigatório.',


		];
		$this->validate($request, $rules, $messages);
	}

}
