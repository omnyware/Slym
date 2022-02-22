<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProdutoDelivery;
use App\ClienteDelivery;
use App\DeliveryConfig;
use App\PedidoDelivery;
use App\ItemPedidoDelivery;
use App\CategoriaProdutoDelivery;
use App\MercadoConfig;

class MercadoProdutoController extends Controller
{	
	protected $imagensRandom = [];
	public function __construct(){
		$categorias = CategoriaProdutoDelivery::all();
		$temp = [];
		for($aux = 0; $aux < 4; $aux++){

			$n = rand(0, sizeof($categorias)-1);
			array_push($this->imagensRandom, $categorias[$n]->path);
		}
	}

	public function addProduto(Request $request){
		$produto = ProdutoDelivery::find($request->id);
		$cliente = session('cliente_log');
		$cliente = ClienteDelivery::find($cliente['id']);


		$pedido = PedidoDelivery::where('estado', 'nv')
		->where('cliente_id', $cliente->id)
		->first();

		if($pedido == null){ 
			$pedido = PedidoDelivery::create([
				'cliente_id' => $cliente->id,
				'valor_total' => 0,
				'telefone' => '',
				'observacao' => '',
				'forma_pagamento' => '',
				'estado'=> 'nv',
				'motivoEstado'=> '',
				'endereco_id' => NULL,
				'troco_para' => 0,
				'desconto' => 0,
				'cupom_id' => NULL,
				'app' => false
			]);
		} 

		if($pedido->valor_total == 0){
			$item = ItemPedidoDelivery::
			where('produto_id', $produto->id)
			->where('pedido_id', $pedido->id)
			->first();

			if($item == null){
				ItemPedidoDelivery::create([
					'pedido_id' => $pedido->id,
					'produto_id' => $produto->id,
					'status' => false,
					'observacao' => '',
					'quantidade' => $request->qtd,
					'tamanho_id' => null
				]);
			}else{
				if($item->produto->produto->unidade_venda == 'UNID'){
					$item->quantidade += 1;
				}else{
					$item->quantidade += 0.1;
				}
				$item->save();
			}
		}else{
			return response()->json(false, 403);
		}

		$pedido = PedidoDelivery::find($pedido->id);

		foreach($pedido->itens as $i){
			$i->produto->produto;
			if(sizeof($i->produto->galeria) > 0){
				$path = $i->produto->galeria[0]->path;
				$i->imagem = "/imagens_produtos/$path";
			}else{
				$i->imagem = "/imgs/no_image.png";
			}
			if($i->produto->produto->unidade_venda == 'UNID'){
				$i->quantidade = (int) $i->quantidade;
			}

		}
		$pedido->soma = $pedido->somaItens();
		return response()->json($pedido, 200);
	}

	public function downProduto(Request $request){
		$produto = ProdutoDelivery::find($request->id);
		$cliente = session('cliente_log');
		$cliente = ClienteDelivery::find($cliente['id']);


		$pedido = PedidoDelivery::where('estado', 'nv')
		->where('cliente_id', $cliente->id)
		->where('valor_total', '=', 0)
		->first();

		if($pedido != null){ 
			$item = ItemPedidoDelivery::
			where('produto_id', $produto->id)
			->where('pedido_id', $pedido->id)
			->first();

			if($item->quantidade == 1 || $item->quantidade == 0.1){
				$item->delete();
			}else{

				if($item->produto->produto->unidade_venda == 'UNID'){
					$item->quantidade -= 1;
				}else{
					$item->quantidade -= 0.1;
				}
				$item->save();
			}

			$pedido = PedidoDelivery::find($pedido->id);
			foreach($pedido->itens as $i){
				$i->produto->produto;
				if(sizeof($i->produto->galeria) > 0){
					$path = $i->produto->galeria[0]->path;
					$i->imagem = "/imagens_produtos/$path";
				}else{
					$i->imagem = "/imgs/no_image.png";
				}

				if($i->produto->produto->unidade_venda == 'UNID'){
					$i->quantidade = (int) $i->quantidade;
				}

			}
			$pedido->soma = $pedido->somaItens();
			return response()->json($pedido, 200);
		}else{
			return response()->json(false, 403);
		}

		
	}

	public function novoCliente(){
		$rota = 'login';
		$config = DeliveryConfig::first();
		$mercadoConfig = MercadoConfig::first();

		return view('delivery_mercado/login_first')
		->with('config', $config)
		->with('mercadoConfig', $mercadoConfig)
		->with('rota', $rota)
		->with('imagens', $this->imagensRandom)
		->with('title', 'Login');
	}

	public function carrinho(){
		$cliente = session('cliente_log');
		$cliente = ClienteDelivery::find($cliente['id']);

		if($cliente == null) return response()->json([], 402);

		$pedido = PedidoDelivery::where('estado', 'nv')
		->where('cliente_id', $cliente->id)
		->where('valor_total', '=', 0)
		->first();

		if($pedido == null) return response()->json([], 403);

		foreach($pedido->itens as $i){
			$i->produto->produto;
			if(sizeof($i->produto->galeria) > 0){
				$path = $i->produto->galeria[0]->path;
				$i->imagem = "/imagens_produtos/$path";
			}else{
				$i->imagem = "/imgs/no_image.png";
			}
			if($i->produto->produto->unidade_venda == 'UNID'){
				$i->quantidade = (int) $i->quantidade;
			}else{
				$i->quantidade = number_format($i->quantidade, 3);
			}
		}
		$pedido->soma = $pedido->somaItens();
		return response()->json($pedido, 200);
	}

	public function alterCart(Request $request){
		$item = ItemPedidoDelivery::find($request->item_id);
		if($item->pedido_id != $request->pedido_id){
			return response()->json(false, 401);
		}

		$item->quantidade = $request->qtd;
		$item = $item->save();
		$item = ItemPedidoDelivery::find($request->item_id);
		$pedido = $item->pedido;
		$pedido->soma = $pedido->somaItens();
		return response()->json($pedido, 200);

	}

	public function adicionarProduto($id){
		$produto = ProdutoDelivery::find($id);
		$cliente = session('cliente_log');
		$cliente = ClienteDelivery::find($cliente['id']);

		if($cliente == null){
			session()->flash("message_erro", "Faça o login para continuar!");
			return redirect('/delivery/login');
		}

		$pedido = PedidoDelivery::where('estado', 'nv')
		->where('cliente_id', $cliente->id)
		->where('valor_total', '=', 0)
		->first();

		if($pedido == null){ 
			$pedido = PedidoDelivery::create([
				'cliente_id' => $cliente->id,
				'valor_total' => 0,
				'telefone' => '',
				'observacao' => '',
				'forma_pagamento' => '',
				'estado'=> 'nv',
				'motivoEstado'=> '',
				'endereco_id' => NULL,
				'troco_para' => 0,
				'desconto' => 0,
				'cupom_id' => NULL,
				'app' => false
			]);
		} 

		if($pedido->valor_total == 0){
			$item = ItemPedidoDelivery::
			where('produto_id', $produto->id)
			->where('pedido_id', $pedido->id)
			->first();

			if($item == null){
				ItemPedidoDelivery::create([
					'pedido_id' => $pedido->id,
					'produto_id' => $produto->id,
					'status' => false,
					'observacao' => '',
					'quantidade' => 1,
					'tamanho_id' => null
				]);
			}else{
				if($item->produto->produto->unidade_venda == 'UNID'){
					$item->quantidade += 1;
				}else{
					$item->quantidade += 0.1;
				}
				$item->save();
			}
			session()->flash("message_sucesso", "Produto adicionado!");
			return redirect('/delivery/carrinho');
		}else{
			session()->flash("message_erro", "Você possui um pedido em aberto, aguarde por favor!");
			return redirect('/delivery');
		}
	}

}
