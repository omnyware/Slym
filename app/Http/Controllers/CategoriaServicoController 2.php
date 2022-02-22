<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriaServico;
class CategoriaServicoController extends Controller
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
        $categorias = CategoriaServico::
        where('empresa_id', $this->empresa_id)
        ->get();
        return view('categoriasServico/list')
        ->with('categorias', $categorias)
        ->with('title', 'Categorias');
    }

    public function new(){
        return view('categoriasServico/register')
        ->with('title', 'Cadastrar Categoria de Serviço');
    }

    public function save(Request $request){
        $category = new CategoriaServico();
        $this->_validate($request);

        $result = $category->create($request->all());

        if($result){
            session()->flash("mensagem_sucesso", "Categoria cadastrada com sucesso.");
        }else{
            session()->flash('mensagem_erro', 'Erro ao cadastrar categoria.');
        }
        
        return redirect('/categoriasServico');
    }

    public function edit($id){
        $categoria = new CategoriaServico(); //Model

        $resp = $categoria
        ->where('id', $id)->first();  
        if(valida_objeto($resp)){
            return view('categoriasServico/register')
            ->with('categoria', $resp)
            ->with('title', 'Editar Categoria de Serviço');
        }else{
            return redirect('/403');
        }

    }

    public function update(Request $request){
        $categoria = new CategoriaServico();

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
        
        return redirect('/categoriasServico'); 
    }

    public function delete($id){
        try{
            $resp = CategoriaServico
            ::where('id', $id)
            ->first();
            if(valida_objeto($resp)){
                if($resp->delete()){
                    session()->flash('mensagem_sucesso', 'Registro removido!');
                }else{
                    session()->flash('mensagem_erro', 'Erro!');
                }
                return redirect('/categoriasServico');
            }else{
                return redirect('/403');
            }
        }catch(\Exception $e){
            return view('errors.sql')
            ->with('title', 'Erro ao deletar categoria de serviço')
            ->with('motivo', 'Não é possivel remover categorias presentes em serviços!');
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
