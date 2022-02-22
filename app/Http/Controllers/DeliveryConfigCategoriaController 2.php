<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriaProdutoDelivery;
use App\ListaComplementoDelivery;
use App\ComplementoDelivery;
use App\TamanhoPizza;

class DeliveryConfigCategoriaController extends Controller
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
    $categorias = CategoriaProdutoDelivery::
    where('empresa_id', $this->empresa_id)
    ->get();
    $existeCategoriaPizza = $this->existeCategoriaPizza($categorias, $this->empresa_id);
    return view('categoriaDelivery/list')
    ->with('categorias', $categorias)
    ->with('existeCategoriaPizza', $existeCategoriaPizza)
    ->with('title', 'Categorias de Delivery');
  }

  private function existeCategoriaPizza($categorias, $empresa_id){
    $tamanhoFirst = sizeof(TamanhoPizza::
      where('empresa_id', $empresa_id)
      ->get()) > 0 ? true : false;
    
    foreach($categorias as $c){
      if(strpos(strtolower($c->nome), 'izza') !== false){
        if(!$tamanhoFirst) return true;
      }
    }
    return false;
  }

  public function new(){
    return view('categoriaDelivery/register')
    ->with('title', 'Cadastrar Categoria para Delivery');
  }

  public function save(Request $request){

    $category = new CategoriaProdutoDelivery();

    $this->_validate($request);

    $file = $request->file('file');

    $extensao = $file->getClientOriginalExtension();
    $nomeImagem = md5($file->getClientOriginalName()).".".$extensao;
    $request->merge([ 'path' => $nomeImagem ]);
    $request->merge([ 'empresa_id' => $this->empresa_id ]);

    $upload = $file->move(public_path('imagens_categorias'), $nomeImagem);

    if(!$upload){

      session()->flash('mensagem_erro', 'Erro ao realizar upload da imagem.');
    }else{

      $result = $category->create($request->all());
      if($result){

        session()->flash("mensagem_sucesso", "Categoria cadastrada com sucesso.");
      }else{

        session()->flash('mensagem_erro', 'Erro ao cadastrar categoria.');
      }
    }

    return redirect('/deliveryCategoria');
  }

  public function edit($id){
    $categoria = new CategoriaProdutoDelivery();
    $resp = $categoria
    ->where('id', $id)->first();  
    if(valida_objeto($resp)){
      return view('categoriaDelivery/register')
      ->with('categoria', $resp)
      ->with('title', 'Editar Categoria de Delivery');
    }else{
      return redirect('/403');
    }

  }

  public function additional($id){
    $categoria = new CategoriaProdutoDelivery(); //Model
    $adicionais = ComplementoDelivery::
    where('empresa_id', $this->empresa_id)
    ->orderBy('nome')->get();

    $resp = $categoria
    ->where('id', $id)->first();  
    if(valida_objeto($resp)){
      return view('categoriaDelivery/additional')
      ->with('categoria', $resp)
      ->with('adicionais', $adicionais)
      ->with('adicional', true)
      ->with('title', 'Adicionais da Categoria de Delivery');
    }else{
      return redirect('/403');
    }

  }

  public function update(Request $request){
    $categoria = new CategoriaProdutoDelivery();

    $id = $request->input('id');
    $resp = $categoria
    ->where('id', $id)->first(); 

    $anterior = CategoriaProdutoDelivery::where('id', $id)
    ->first();
    if($request->hasFile('file')){
    		//unlink anterior
      $public = getenv('SERVIDOR_WEB') ? 'public/' : '';
      if(file_exists($public . 'imagens_categorias/'.$anterior->path))
        unlink($public . 'imagens_categorias/'.$anterior->path);

      $file = $request->file('file');

      $extensao = $file->getClientOriginalExtension();
      $nomeImagem = md5($file->getClientOriginalName()).".".$extensao;

      $upload = $file->move(public_path('imagens_categorias'), $nomeImagem);
      $request->merge([ 'file' => $nomeImagem ]);
    }else{
      $request->merge([ 'file' => $anterior->path ]);
    }

    $this->_validate($request, false);

    $resp->nome = $request->input('nome');
    $resp->descricao = $request->input('descricao');
    $resp->path = $request->input('file');

    $result = $resp->save();
    if($result){

      session()->flash('mensagem_sucesso', 'Categoria editada com sucesso!');
    }else{

      session()->flash('mensagem_erro', 'Erro ao editar categoria!');
    }

    return redirect('/deliveryCategoria'); 
  }

  public function delete($id){
    $categoria = CategoriaProdutoDelivery
    ::where('id', $id)
    ->first();
    if(valida_objeto($categoria)){
      $public = getenv('SERVIDOR_WEB') ? 'public/' : '';
      if(file_exists($public . 'imagens_categorias/'.$categoria->path))
        unlink($public . 'imagens_categorias/'.$categoria->path);
      if($categoria->delete()){

        session()->flash('mensagem_sucesso', 'Registro removido!');
      }else{

        session()->flash('mensagem_erro', 'Erro!');
      }
      return redirect('/deliveryCategoria');
    }else{
      return redirect('/403');
    }
  }

  public function removeAditional($id){
    $additional = ListaComplementoDelivery
    ::where('id', $id)
    ->first();

    if($additional->delete()){

      session()->flash('mensagem_sucesso', 'Registro removido!');
    }else{

      session()->flash('mensagem_erro', 'Erro!');
    }
    return redirect('/deliveryCategoria/additional/'.$additional->categoria->id);
  }


  private function _validate(Request $request, $fileExist = true){
    $rules = [
      'nome' => 'required|max:30',
      'descricao' => 'required|max:120',
      'file' => $fileExist ? 'required' : ''
    ];

    $messages = [
      'nome.required' => 'O campo nome é obrigatório.',
      'nome.max' => '50 caracteres maximos permitidos.',
      'descricao.required' => 'O campo descricao é obrigatório.',
      'descricao.max' => '120 caracteres maximos permitidos.',
      'file.required' => 'O campo imagem é obrigatório.'
    ];
    $this->validate($request, $rules, $messages);
  }

  private function _validateAdd(Request $request){
    $rules = [
      'adicional' => 'required',
    ];

    $messages = [
      'adicional.required' => 'Erro, Campo obrigatório, inválido ou complemento já esta presente.'
    ];
    $this->validate($request, $rules, $messages);
  }

  public function saveAditional(Request $request){
    $adicional = $request->input('adicional');
    $request->merge([ 'adicional' => $adicional]);

    $tst = ComplementoDelivery::where('id', $adicional)
    ->first();

    if(!$tst) {
      $request->merge([ 'adicional' => '']);
    }

    $res = ListaComplementoDelivery::where('categoria_id', $request->categoria)
    ->where('complemento_id', $adicional)
    ->first();

    if($res){
      $request->merge([ 'adicional' => '']);
    }

    $this->_validateAdd($request);

    $result = ListaComplementoDelivery::create([
      'categoria_id' => $request->categoria,
      'complemento_id' => $adicional
    ]);

    session()->flash('mensagem_sucesso', 'Adicional atribuido!');

    return redirect('/deliveryCategoria/additional/' . $request->categoria);
  }

}
