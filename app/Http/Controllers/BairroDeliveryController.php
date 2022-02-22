<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BairroDelivery;
class BairroDeliveryController extends Controller
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
		$bairros = BairroDelivery::all();
		return view('bairros/list')
		->with('bairros', $bairros)
		->with('title', 'Bairros');
	}

	public function new(){
		return view('bairros/register')
		->with('title', 'Cadastrar Bairro');
	}

	public function save(Request $request){
		$bairro = new BairroDelivery();
		$this->_validate($request);

		$request->merge(['valor_entrega' => str_replace(",", ".", $request->valor_entrega)]);

		$result = $bairro->create($request->all());

		if($result){
			session()->flash('color', 'blue');
			session()->flash("message", "Bairro cadastrado com sucesso.");
		}else{
			session()->flash('color', 'red');
			session()->flash('message', 'Erro ao cadastrar bairro.');
		}

		return redirect('/bairrosDelivery');
	}

	public function edit($id){
		$bairro = new BairroDelivery(); 

		$resp = $bairro
		->where('id', $id)->first();  

		return view('bairros/register')
		->with('bairro', $resp)
		->with('title', 'Editar Bairro');

	}

	public function update(Request $request){
		$bairro = new BairroDelivery();
		$request->merge(['valor_entrega' => str_replace(",", ".", $request->valor_entrega)]);
		
		$id = $request->input('id');
		$resp = $bairro
		->where('id', $id)->first(); 

		$this->_validate($request);


		$resp->nome = $request->input('nome');
		$resp->valor_entrega = $request->input('valor_entrega');

		$result = $resp->save();
		if($result){
			session()->flash('color', 'green');
			session()->flash('message', 'Bairro editado com sucesso!');
		}else{
			session()->flash('color', 'red');
			session()->flash('message', 'Erro ao editar bairro!');
		}

		return redirect('/bairrosDelivery'); 
	}

	public function delete($id){

		$delete = BairroDelivery
		::where('id', $id)
		->delete();
		if($delete){
			session()->flash('color', 'blue');
			session()->flash('message', 'Registro removido!');
		}else{
			session()->flash('color', 'red');
			session()->flash('message', 'Erro!');
		}
		return redirect('/bairrosDelivery');

	}


	private function _validate(Request $request){
		$rules = [
			'nome' => 'required|max:50',
			'valor_entrega' => 'required'
		];

		$messages = [
			'nome.required' => 'O campo nome é obrigatório.',
			'nome.max' => '50 caracteres maximos permitidos.',
			'valor_entrega.required' => 'O campo valor de entrega é obrigatório.',

		];
		$this->validate($request, $rules, $messages);
	}
}
