<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TamanhoPizza;

class TamanhoPizzaController extends Controller
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
		$tamanhos = TamanhoPizza::paginate(20);
		return view('tamanhoPizza/list')
		->with('title', 'Tamanhos de Pizza')
		->with('tamanhos', $tamanhos);
	}

	public function new(){
		return view('tamanhoPizza/register')
		->with('title', 'Novo Tamanho de Pizza');
	}


	public function save(Request $request){
		$this->_validate($request);

		$res = TamanhoPizza::create($request->all());

		if($res){
			session()->flash('color', 'blue');
			session()->flash('message', 'Tamanho de pizza adicionado!');
		}else{
			session()->flash('color', 'red');
			session()->flash('message', 'Erro!');
		}
		return redirect('/tamanhosPizza');
	}

	public function edit($id){
		$tamanho = TamanhoPizza::
		where('id', $id)
		->first();

		return view('tamanhoPizza/register')
		->with('tamanho', $tamanho)
		->with('title', 'Editar Tamanho de Pizza');
	}

	public function update(Request $request){
		$this->_validate($request);
		$tamanho = TamanhoPizza::
		where('id', $request->id)
		->first();

		$tamanho->nome = $request->nome;
		$tamanho->pedacos = $request->pedacos;
		$tamanho->maximo_sabores = $request->maximo_sabores;

		if($tamanho->save()){
			session()->flash('color', 'green');
			session()->flash('message', 'Tamanho de pizza editado!');
		}else{
			session()->flash('color', 'red');
			session()->flash('message', 'Erro!');
		}

		return redirect('/tamanhosPizza');

	}


	private function _validate(Request $request){

		$rules = [
			'nome' => 'required|max:20',
			'pedacos' => 'required',
			'maximo_sabores' => 'required',
		];

		$messages = [
			'nome.required' => 'O campo nome é obrigatório.',
			'nome.max' => 'Maximo de 20 caracteres.',
			'pedacos.required' => 'O campo pedaços é obrigatório.',
			'maximo_sabores.required' => 'O campo maximo de sabores é obrigatório.',
		];
		$this->validate($request, $rules, $messages);
	}

	public function delete($id){
		$res = TamanhoPizza::
		where('id', $id)
		->delete();

		if($res){
			session()->flash('color', 'blue');
			session()->flash('message', 'Tamanho removido!');
		}else{

			session()->flash('color', 'red');
			session()->flash('message', 'Erro!');
		}
		return redirect('/tamanhosPizza');
	}
}
