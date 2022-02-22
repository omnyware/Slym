<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriaConta;

class CategoriaContaController extends Controller {
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
        $categorias = CategoriaConta::
        where('empresa_id', $this->empresa_id)
        ->get();

        return view('categoriasConta/list')
        ->with('categorias', $categorias)
        ->with('title', 'Categoria de Contas');
    }

    public function new(){
        return view('categoriasConta/register')
        ->with('title', 'Cadastrar Categoria de Conta');
    }

    public function save(Request $request){
        $categoria = new CategoriaConta();
        $this->_validate($request);

        $result = $categoria->create($request->all());

        if($result){
            session()->flash("mensagem_sucesso", "Categoria cadastrada com sucesso.");
        }else{
            session()->flash('mensagem_erro', 'Erro ao cadastrar categoria.');
        }

        return redirect('/categoriasConta');
    }

    public function edit($id){
        $categoria = new CategoriaConta(); 

        $resp = $categoria
        ->where('id', $id)->first();  

        if(valida_objeto($resp)){

            return view('categoriasConta/register')
            ->with('categoria', $resp)
            ->with('title', 'Editar Categoria de Conta');
        }else{
            return redirect('/403');
        }

    }

    public function update(Request $request){
        $categoria = new CategoriaConta();

        $id = $request->input('id');
        $resp = $categoria
        ->where('id', $id)->first(); 

        $this->_validate($request);


        $resp->nome = $request->input('nome');

        $result = $resp->save();
        if($result){
            session()->flash('mensagem_sucesso', 'Categoria atualizada com sucesso!');
        }else{
            session()->flash('mensagem_erro', 'Erro ao atualizar categoria!');
        }

        return redirect('/categoriasConta'); 
    }

    public function delete($id){
        $resp = CategoriaConta
        ::where('id', $id)
        ->first();
        if(valida_objeto($resp)){

            if($resp->delete()){
                session()->flash('mensagem_sucesso', 'Registro removido!');
            }else{
                session()->flash('mensagem_erro', 'Erro!');
            }
            return redirect('/categoriasConta');
        }else{
            return redirect('/403');
        }
    }


    private function _validate(Request $request){
       $rules = [
          'nome' => 'required|max:50'
      ];

      $messages = [
          'nome.required' => 'O campo nome é obrigatório.',
          'nome.max' => '50 caracteres maximos permitidos.'
      ];
      $this->validate($request, $rules, $messages);
  }
}
