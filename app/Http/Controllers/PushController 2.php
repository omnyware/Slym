<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Push;
use App\TokenClienteDelivery;
use App\ClienteDelivery;
use App\TokenWeb;
use App\ProdutoDelivery;

class PushController extends Controller
{	
	public function __construct(){
		$this->middleware(function ($request, $next) {
			$value = session('user_logged');
			if(!$value){
				return redirect("/login");
			}else{
				if($value['acesso_produto'] == 0){
					return redirect("/sempermissao");
				}
			}
			return $next($request);
		});
	}

	public function index(){

		$pushes = Push::
		orderBy('id', 'desc')
		->get();
		return view('push/index')
		->with('pushes', $pushes)
		->with('title', 'Push');
	}

	public function new(){
		$clientes = ClienteDelivery::orderBy('nome')->get();
		return view('push/new')
		->with('pushJs', true)
		->with('clientes', $clientes)
		->with('title', 'Nova Push');
	}

	public function save(Request $request){
		$this->_validate($request);
		$cli = explode("-", $request->cli);
		$cli = $cli[0];

		$res = Push::create([
			'titulo' => $request->titulo,
			'texto' => $request->texto,
			'path_img' => $request->path_img ?? '',
			'cliente_id' => $request->todos ? NULL : $cli,
			'referencia_produto' => $request->referencia_produto ?? 0,
			'status' => false
		]);

		if($res){
			session()->flash('mensagem_sucesso', 'Push adicionado!');
		}else{
			session()->flash('mensagem_erro', 'Erro!');
		}
		return redirect('/push');
	}

	private function _validate(Request $request){

		$rules = [
			'cli' => ($request->id > 0) ? '' : ($request->todos ? '' : 'required'),
			'titulo' => 'required|max:50',
			'texto' => 'required|max:100'
		];

		$messages = [
			'titulo.required' => 'O campo titulo é obrigatório.',
			'titulo.max' => '50 caracteres maximos permitidos.',
			'texto.required' => 'O campo texto é obrigatório.',
			'texto.max' => '100 caracteres maximos permitidos.',
			'cli.required' => 'O campo cliente é obrigatório.'
		];
		$this->validate($request, $rules, $messages);
	}

	public function edit($id){
		$push = Push::
		where('id', $id)
		->first();

		return view('push/new')
		->with('pushJs', true)
		->with('push', $push)
		->with('title', 'Nova Push');
	}

	public function update(Request $request){
		$this->_validate($request);
		$push = Push::
		where('id', $request->id)
		->first();

		$push->titulo = $request->titulo;
		$push->texto = $request->texto;
		$push->path_img = $request->path_img;
		$push->referencia_produto = $request->referencia_produto;
		if($push->save()){
			session()->flash('mensagem_sucesso', 'Push editado!');
		}else{
			session()->flash('mensagem_erro', 'Erro!');
		}

		return redirect('/push');

	}

	public function send($id){
		$push = Push::
		where('id', $id)
		->first();

		$tkTemp = [];
		if($push->cliente){ 

			foreach($push->cliente->tokens as $t){

				if(!in_array($t->user_id, $tkTemp)){

					array_push($tkTemp, $t->user_id);
				}
			}

			$data = [
				'heading' => [
					"en" => $push->titulo
				],
				'content' => [
					"en" => $push->texto
				],
				'image' => $push->path_img,
				'referencia_produto' => $push->referencia_produto,
			];

			$this->sendMessageOneSignal($data, $tkTemp);
			session()->flash('mensagem_sucesso', 'Push enviado!');

			$push->status = true;
			$push->save();
			return redirect('/push');

		}else{

			$data = [
				'heading' => [
					"en" => $push->titulo
				],
				'content' => [
					"en" => $push->texto
				],
				'image' => $push->path_img,
				'referencia_produto' => $push->referencia_produto,
			];


			$res = $this->sendMessageOneSignal($data);

			
			$push->status = true;
			$push->save();

			session()->flash('mensagem_sucesso', 'Pushs enviados!');
			return redirect('/push');
		}
	}


	public function sendMessageOneSignal($data, $tokens = null){

		$fields = [
			'app_id' => getenv('ONE_SIGNAL_APP_ID'),
			'contents' => $data['content'],
			'headings' => $data['heading'],
			'large_icon' => getenv('PATH_URL').'/imgs/logo.png',
			'small_icon' => 'notification_icon'
		];

		if($data['image'] != '')
			$fields['big_picture'] = $data['image'];

		if($tokens == null){
			$fields['included_segments'] = array('All');
			if($data['image'] != '')
			$fields['chrome_web_image'] = $data['image'];
		}else{
			$fields['include_player_ids'] = $tokens;
		}


		if($data['referencia_produto'] > 0){
			$fields['web_url'] = getenv('PATH_URL') . "/cardapio/verProduto/" . $data['referencia_produto'];
			$produtoDelivery = ProdutoDelivery::find($data['referencia_produto']);
			if($produtoDelivery != null){
				$produtoDelivery->pizza;
				$produtoDelivery->galeria;
				$produtoDelivery->categoria;
				$produtoDelivery->produto;
				$fields['data'] = ["referencia" => $produtoDelivery];
			}
		}

		$fields = json_encode($fields);
		// print("\nJSON sent:\n");
		// print($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
			'Authorization: Basic '.getenv('ONE_SIGNAL_KEY')));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}
	

	public function delete($id){
		$res = Push::
		where('id', $id)
		->delete();

		if($res){

			session()->flash('mensagem_sucesso', 'Push removido!');
		}else{


			session()->flash('mensagem_erro', 'Erro!');
		}
		return redirect('/push');
	}

}
