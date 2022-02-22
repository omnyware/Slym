<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\CategoriaProdutoDelivery;

class CategoryController extends Controller
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

    public function index(Request $request){

        $categorias = Categoria::
        where('empresa_id', $request->empresa_id)
        ->get();

        return view('categorias/list')
        ->with('categorias', $categorias)
        ->with('title', 'Categorias');
    }

    public function new(){
        return view('categorias/register')
        ->with('categoriaJs', true)
        ->with('title', 'Cadastrar Categoria');
    }

    public function save(Request $request){

        $category = new Categoria();
        $this->_validate($request);

        $result = $category->create($request->all());

        $atribuir_delivery = $request->atribuir_delivery;
        $msgSucesso = "Categoria cadastrada com sucesso";
        if($atribuir_delivery){
            $this->_validateDelivery($request);
            $file = $request->file('file');

            $extensao = $file->getClientOriginalExtension();
            $nomeImagem = md5($file->getClientOriginalName()).".".$extensao;
            $upload = $file->move(public_path('imagens_categorias'), $nomeImagem);

            if(!$upload){

                session()->flash('mensagem_sucesso', 'Erro ao realizar upload da imagem.');
            }else{

                $result = CategoriaProdutoDelivery::create(
                    [
                        'nome' => $request->nome,
                        'descricao' => $request->descricao,
                        'path' => $nomeImagem
                    ]
                );
                if($result){
                    $msgSucesso = "Categoria cadastrada e atribuida ao delivery com sucesso";
                }
            }

        }

        if($result){

            session()->flash("mensagem_sucesso", $msgSucesso);
        }else{
            session()->flash('mensagem_erro', 'Erro ao cadastrar categoria.');
        }

        return redirect('/categorias');
    }

    public function edit($id){
        $categoria = new Categoria(); 

        $resp = $categoria
        ->where('id', $id)->first();  

        if(valida_objeto($resp)){
            return view('categorias/register')
            ->with('categoria', $resp)
            ->with('title', 'Editar Categoria');
        }else{
            return redirect('/403');
        }

    }

    public function update(Request $request){
        $categoria = new Categoria();

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

        return redirect('/categorias'); 
    }

    public function delete($id){
        try{
            $categoria = Categoria
            ::where('id', $id)
            ->first();
            if(valida_objeto($categoria)){
                if($categoria->delete()){
                    session()->flash('mensagem_sucesso', 'Registro removido!');
                }else{

                    session()->flash('mensagem_erro', 'Erro!');
                }
                return redirect('/categorias');
            }else{
                return redirect('403');
            }
        }catch(\Exception $e){
            return view('errors.sql')
            ->with('title', 'Erro ao deletar categoria')
            ->with('motivo', $e->getMessage());
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


    private function _validateDelivery(Request $request){
        $rules = [
            'descricao' => 'required|max:120',
            'file' => 'required'
        ];

        $messages = [
            'descricao.required' => 'O campo descricao é obrigatório.',
            'descricao.max' => '120 caracteres maximos permitidos.',
            'file.required' => 'O campo imagem é obrigatório.'
        ];
        $this->validate($request, $rules, $messages);
    }
}
