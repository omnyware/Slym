<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use App\Produto;
use App\ProdutoDelivery;
use App\ItemPedido;
use App\ItemPizzaPedidoLocal;
use App\ItemPedidoComplementoLocal;
use App\ComplementoDelivery;
use App\Mesa;
class PedidoRestController extends Controller
{
    // APP

	private function duplicidadeComanda($comanda){
		$c = Pedido::
		where('comanda', $comanda)
		->where('desativado', false)
		->where('status', false)
		->first();
		return $c;
	}

	public function emAberto(){
		$pedidos = ItemPedido::where('status', false)
		->get();

        // echo json_encode(count($pedidos));
		return response()->json(count($pedidos), 200);
	}

	public function comandasAberta(){
		$pedidos = Pedido::
		where('status', false)
		->where('desativado', false)
		->get();

		return response()->json($this->somaTotal($pedidos), 200);
		// echo json_encode($this->somaTotal($pedidos));
	}

	private function somaTotal($pedidos){
		foreach($pedidos as $p){
			$p->mesa;
			$p['soma'] = $p->somaItems();
		}
		return $pedidos;
	}

	public function abrirComanda(Request $request){
		$duplcidade = $this->duplicidadeComanda($request->cod);
		if($duplcidade == null){
			$result = Pedido::create([
				'comanda' => $request->cod,
				'mesa_id' => $request->mesa > 0 ? $request->mesa : NULL,
				'status' => false,
				'observacao' => '',
				'desativado' => false,
				'rua' => '',
				'numero' => '',
				'bairro_id' => null,
				'referencia' => '',
				'telefone' => '', 
				'nome' => ''

			]);
			// echo json_encode($result);
			return response()->json($result, 200);

		}else{
			// echo json_encode(false);
			return response()->json(false, 200);

		}
	}

	public function deleteItem(Request $request){
		$item = ItemPedido
		::where('id', $request->id)
		->first();
		if($item->status == false){
			$result = $item->delete();
			return response()->json($item, 200);
		}else{
			return response()->json(false, 404);
		}
		
		// echo json_encode($item);
	}

	public function addProduto(Request $request){
		$saboresExtras = json_decode($request->saboresExtras);
		$adicionais = json_decode($request->adicionais);
		
		$result;
		$duplcidade = null;
		if($request->nova_comanda > 0){
			$duplcidade = $this->duplicidadeComanda($request->nova_comanda);
		}
		if($duplcidade == null){
			if($request->nova_comanda > 0){
				$result = Pedido::create([
					'comanda' => $request->nova_comanda,
					'status' => false,
					'observacao' => '',
					'desativado' => false,
					'rua' => '',
					'numero' => '',
					'bairro_id' => null,
					'mesa_id' => $request->novaMesa > 0 ? $request->novaMesa : NULL,
					'referencia' => '',
					'telefone' => '', 
					'nome' => ''
				]);
			}else{
				$result = Pedido::where('comanda', $request->comanda)
				->where('status', false)
				->where('desativado', false)
				->first();
			}

			$res = ItemPedido::create([
				'pedido_id' => $result->id,
				'produto_id' => $request->produto,
				'quantidade' => str_replace(",", ".", $request->quantidade),
				'status' => false,
				'observacao' => $request->obs ?? '',
				'tamanho_pizza_id' => $request->tamanho == 'null' ? NULL : $request->tamanho,
				'valor' => str_replace(",", ".", $request->valorFlex),
				'impresso' => false
			]);

			if($request->tamanho != 'null'){
				$produto = Produto::
				where('id', $request->produto)
				->first();
				if(count($saboresExtras) > 0){

					foreach($saboresExtras as $sab){
						$prod = ProdutoDelivery
						::where('id', $sab->produto_id)
						->first();

						$item = ItemPizzaPedidoLocal::create([
							'item_pedido' => $res->id,
							'sabor_id' => $prod->id,
						]);

					}

				}

				$item = ItemPizzaPedidoLocal::create([
					'item_pedido' => $res->id,
					'sabor_id' => $produto->delivery->id,
				]);
				
			}

			if(count($adicionais) > 0){
				foreach($adicionais as $ad){

					$adicional = ComplementoDelivery
					::where('id', $ad->id)
					->first();


					$item = ItemPedidoComplementoLocal::create([
						'item_pedido' => $res->id,
						'complemento_id' => $adicional->id,
						'quantidade' => str_replace(",", ".", $request->quantidade),
					]);
				}
			}

			// echo json_encode($res);
			return response()->json($res, 200);
		}else{
			// echo json_encode(false);
			return response()->json(false, 200);
		}
	}

	public function apk(){
		return response()->download("app.apk");
	}

	public function mesas(){
		$pedidos = Pedido::
		where('desativado', false)
		->where('mesa_id', '!=', NULL)
		->groupBy('mesa_id')
		->get();

		$mesas = [];

		foreach($pedidos as $p){
			// $p->mesa->pedidos;
			$this->somaTotal($p->mesa->pedidos);
			$p->mesa->soma = $p->mesa->somaItens();
			array_push($mesas, $p->mesa);
		}
		return response()->json($mesas, 200);
	}

	public function mesasTodas(){
		$mesas = Mesa::all();
		return response()->json($mesas, 200);
	}
}
