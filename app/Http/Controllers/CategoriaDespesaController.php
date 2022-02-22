<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriaDespesaCte;
class CategoriaDespesaController extends Controller
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
		$categorias = CategoriaDespesaCte::all();
		return view('categoriaDespesa/list')
		->with('categorias', $categorias)
		->with('title', 'Categoria de Despesas Cte');
	}

	public function new(){
		return view('categoriaDespesa/register')
		->with('title', 'Cadastrar Categoria de Despesa CTE');
	}

	public function save(Request $request){
		$categoria = new CategoriaDespesaCte();
		$this->_validate($request);

		$result = $categoria->create($request->all());

		if($result){

			session()->flash("mensagem_sucesso", "Categoria cadastrada com sucesso.");
		}else{

			session()->flash('mensagem_erro', 'Erro ao cadastrar categoria.');
		}
		
		return redirect('/categoriaDespesa');
	}

	public function edit($id){
        $categoria = new CategoriaDespesaCte(); //Model

        $resp = $categoria
        ->where('id', $id)->first();  

        return view('categoriaDespesa/register')
        ->with('categoria', $resp)
        ->with('title', 'Editar Categoria de Despesa');

    }

    public function update(Request $request){
    	$categoria = new CategoriaDespesaCte();

    	$id = $request->input('id');
    	$resp = $categoria
    	->where('id', $id)->first(); 

    	$this->_validate($request);
    	

    	$resp->nome = $request->input('nome');

    	$result = $resp->save();
    	if($result){
    		session()->flash('mensagem_sucesso', 'Categoria editada com sucesso!');
    	}else{
    		session()->flash('mensagem_erro', 'Erro ao editar categoria!');
    	}
    	
    	return redirect('/categoriaDespesa'); 
    }

    public function delete($id){
        try{
        	$delete = CategoriaDespesaCte::
        	where('id', $id)
        	->delete();
        	if($delete){
        		session()->flash('mensagem_sucesso', 'Registro removido!');
        	}else{
        		session()->flash('mensagem_erro', 'Erro!');
        	}
        	return redirect('/categoriaDespesa');
        }catch(\Exception $e){
            return view('errors.sql')
            ->with('title', 'Erro ao deletar categoria de despesas')
            ->with('motivo', 'Não é possivel remover categorias presentes em contas!');
        }
    }


    private function _validate(Request $request){
    	$rules = [
    		'nome' => 'required|max:20'
    	];

    	$messages = [
    		'nome.required' => 'O campo nome é obrigatório.',
    		'nome.max' => '20 caracteres maximos permitidos.'
    	];
    	$this->validate($request, $rules, $messages);
    }
}
