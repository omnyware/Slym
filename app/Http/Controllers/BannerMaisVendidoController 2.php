<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BannerMaisVendido;
use App\ProdutoDelivery;

class BannerMaisVendidoController extends Controller
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
		$banners = BannerMaisVendido::all();

		return view('bannerMaisVendido/list')
		->with('banners', $banners)
		->with('title', 'Banner Topo');
	}

	public function new(){
		return view('bannerMaisVendido/register')
		->with('bannerJs', true)
		->with('title', 'Cadastrar Banner mais Vendido');
	}

	public function save(Request $request){
		

		$this->_validate($request);

		$file = $request->file('file');

		$extensao = $file->getClientOriginalExtension();
		$nomeImagem = md5($file->getClientOriginalName()).".".$extensao;
		$request->merge([ 'path' => $nomeImagem ]);
		$request->merge([ 'ativo' => $request->status ? true : false ]);

		$produto = $request->input('produto');
		$produto = explode("-", $produto);
		$produto = $produto[0];

		$produto = ProdutoDelivery::find($produto);
		if($produto != null){
			$request->merge([ 'produto_delivery_id' => $produto->id]);
		}

		$upload = $file->move(public_path('banner_mais_vendido'), $nomeImagem);

		if(!$upload){
			session()->flash('color', 'red');
			session()->flash('message', 'Erro ao realizar upload da imagem.');
		}else{

			$result = BannerMaisVendido::create($request->all());
			if($result){
				session()->flash('color', 'green');
				session()->flash("message", "Banner cadastrada com sucesso.");
			}else{
				session()->flash('color', 'red');
				session()->flash('message', 'Erro ao cadastrar banner.');
			}
		}
		
		return redirect('/bannerMaisVendido');
	}

	public function edit($id){

		$resp = BannerMaisVendido::find($id);  

		return view('bannerMaisVendido/register')
		->with('banner', $resp)
		->with('bannerJs', true)
		->with('title', 'Editar Banner de Topo');

	}

	public function delete($id){
		$banner = BannerMaisVendido::find($id);
		$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
		if(file_exists($public . 'banner_mais_vendido/'.$banner->path))
			unlink($public . 'banner_mais_vendido/'.$banner->path);
		if($banner->delete()){
			session()->flash('color', 'blue');
			session()->flash('message', 'Registro removido!');
		}else{
			session()->flash('color', 'red');
			session()->flash('message', 'Erro!');
		}
		return redirect('/bannerMaisVendido');
	}

	private function _validate(Request $request, $fileExist = true){
		$rules = [
			'texto_primario' => 'required|max:20',
			'texto_secundario' => 'required|max:30',
			'file' => $fileExist ? 'required' : ''
		];

		$messages = [
			'texto_primario.required' => 'O campo texto primário é obrigatório.',
			'texto_primario.max' => '20 caracteres maximos permitidos.',
			'texto_secundario.required' => 'O campo texto secundário é obrigatório.',
			'texto_secundario.max' => '30 caracteres maximos permitidos.',
			'file.required' => 'O campo imagem é obrigatório.'
		];
		$this->validate($request, $rules, $messages);
	}

	public function update(Request $request){

		$id = $request->input('id');
		$resp = BannerMaisVendido::find($id); 

		$tempBanner = $resp;
		if($request->hasFile('file')){
    		//unlink anterior
			$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
			if(file_exists($public.'banner_mais_vendido/'.$tempBanner->path))
				unlink($public.'banner_mais_vendido/'.$tempBanner->path);

			$file = $request->file('file');

			$extensao = $file->getClientOriginalExtension();
			$nomeImagem = md5($file->getClientOriginalName()).".".$extensao;

			$upload = $file->move(public_path('banner_mais_vendido'), $nomeImagem);
			$request->merge([ 'path' => $nomeImagem ]);
		}else{
			$request->merge([ 'path' => $tempBanner->path ]);
		}

		$this->_validate($request, false);

		$resp->ativo = $request->status ? true : false ;
		$resp->texto_primario = $request->input('texto_primario');
		$resp->texto_secundario = $request->input('texto_secundario');

		$produto = $request->input('produto');
		$produto = explode("-", $produto);
		$produto = $produto[0];

		$produto = ProdutoDelivery::find($produto);
		if($produto != null){
			$resp->produto_delivery_id = $produto->id;
		}

		$result = $resp->save();
		if($result){
			session()->flash('color', 'green');
			session()->flash('message', 'Banner editado com sucesso!');
		}else{
			session()->flash('color', 'red');
			session()->flash('message', 'Erro ao editar banner!');
		}

		return redirect('/bannerMaisVendido'); 
	}

}

