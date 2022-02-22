<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BannerTopo;
use App\ProdutoDelivery;

class BannerTopoController extends Controller
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
		$banners = BannerTopo::all();

		return view('bannerTopo/list')
		->with('banners', $banners)
		->with('title', 'Banner Topo');
	}

	public function new(){
		return view('bannerTopo/register')
		->with('bannerJs', true)
		->with('title', 'Cadastrar Banner no Topo');
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

		$upload = $file->move(public_path('banner_topo'), $nomeImagem);

		if(!$upload){
			session()->flash('color', 'red');
			session()->flash('message', 'Erro ao realizar upload da imagem.');
		}else{

			$result = BannerTopo::create($request->all());
			if($result){
				session()->flash('color', 'green');
				session()->flash("message", "Banner cadastrada com sucesso.");
			}else{
				session()->flash('color', 'red');
				session()->flash('message', 'Erro ao cadastrar banner.');
			}
		}
		
		return redirect('/bannerTopo');
	}

	public function edit($id){

		$resp = BannerTopo::find($id);  

		return view('bannerTopo/register')
		->with('banner', $resp)
		->with('bannerJs', true)
		->with('title', 'Editar Banner de Topo');

	}

	public function delete($id){
		$banner = BannerTopo::find($id);
		$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
		if(file_exists($public . 'banner_topo/'.$banner->path))
			unlink($public . 'banner_topo/'.$banner->path);
		if($banner->delete()){
			session()->flash('color', 'blue');
			session()->flash('message', 'Registro removido!');
		}else{
			session()->flash('color', 'red');
			session()->flash('message', 'Erro!');
		}
		return redirect('/bannerTopo');
	}

	private function _validate(Request $request, $fileExist = true){
		$rules = [
			'titulo' => 'required|max:20',
			'descricao' => 'required|max:100',
			'file' => $fileExist ? 'required' : ''
		];

		$messages = [
			'titulo.required' => 'O campo titulo é obrigatório.',
			'titulo.max' => '20 caracteres maximos permitidos.',
			'descricao.required' => 'O campo descrição é obrigatório.',
			'descricao.max' => '100 caracteres maximos permitidos.',
			'file.required' => 'O campo imagem é obrigatório.'
		];
		$this->validate($request, $rules, $messages);
	}

	public function update(Request $request){

		$id = $request->input('id');
		$resp = BannerTopo::find($id); 

		$tempBanner = $resp;
		if($request->hasFile('file')){
    		//unlink anterior
			$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
			if(file_exists($public.'banner_topo/'.$tempBanner->path))
				unlink($public.'banner_topo/'.$tempBanner->path);

			$file = $request->file('file');

			$extensao = $file->getClientOriginalExtension();
			$nomeImagem = md5($file->getClientOriginalName()).".".$extensao;

			$upload = $file->move(public_path('banner_topo'), $nomeImagem);
			$request->merge([ 'path' => $nomeImagem ]);
		}else{
			$request->merge([ 'path' => $tempBanner->path ]);
		}

		$this->_validate($request, false);

		$resp->ativo = $request->status ? true : false ;
		$resp->titulo = $request->input('titulo');
		$resp->descricao = $request->input('descricao');

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

		return redirect('/bannerTopo'); 
	}

}
