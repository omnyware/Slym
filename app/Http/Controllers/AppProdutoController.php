<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriaProdutoDelivery;
use App\ProdutoDelivery;
use App\ClienteDelivery;
use App\PedidoDelivery;
use App\ProdutoFavoritoDelivery;
use App\ItemPedidoDelivery;
use App\ItemPedidoComplementoDelivery;

use App\TamanhoPizza;
use App\ProdutoPizza;
use App\ItemPizzaPedido;
class AppProdutoController extends Controller
{
	public function categorias($usuarioId = null){
		$categorias = $this->setProdutosCategoria(CategoriaProdutoDelivery::all(), $usuarioId);
		return response()->json($categorias, 200);
	}

	private function setProdutosCategoria($categorias, $usuarioId){
		foreach($categorias as $c){
			if($usuarioId > 0){
				$prTemp = $this->verificaFavoritos($c->produtos , $usuarioId);

				foreach($prTemp as $p){
					$p->categoria;
					$p->produto;
					$p->galeria;
					$p->pizza;
					if(count($p->pizza) > 0){
						foreach($p->pizza as $pz){
							$pz->tamanho;
						}
					}
				}
			}else{
				foreach($c->produtos as $f){
					$f->produto;
					$f->categoria;
					$f->galeria;
					$f->pizza;
					if(count($f->pizza) > 0){
						foreach($f->pizza as $pz){
							$pz->tamanho;
						}
					}

				}
			}

		}
		return $categorias;
	}

	public function destaques($usuarioId = 0){
		$produtos = ProdutoDelivery::where('destaque', true)->get();
		$produtos = $this->setGaleria($produtos);
		if($usuarioId > 0){
			$produtos = $this->verificaFavoritos($produtos, $usuarioId);
		}else{
			foreach($produtos as $p){
				$p['color'] = '#e57373';
				$p['icon'] = 'star-outline';
				$p->categoria;
				if(strpos(strtolower($p->categoria->nome), 'izza') !== false){
					foreach($p->pizza as $s) $s->tamanho;
				}
			}
		}

		return response()->json($produtos, 200);
	}

	private function setGaleria($produtos){
		foreach($produtos as $p){
			$p['galeria'] = $p->galeria;
			$p['nome'] = $p->produto->nome;
		}
		return $produtos;
	}

	private function verificaFavoritos($produtos, $usuarioId){
		$cliente = ClienteDelivery::
		where('id', $usuarioId)
		->first();

		foreach($produtos as $p){
			$p->categoria;
			$p['color'] = '#e57373';
			$p['icon'] = 'star-outline';
			foreach($cliente->favoritos as $pf){
				if($p->id == $pf->produto->id){
					$p['color'] = '#00796b';
					$p['icon'] = 'star';
				}
			}
			if(strpos(strtolower($p->categoria->nome), 'izza') !== false){
				foreach($p->pizza as $s) $s->tamanho;
			}
		}

		return $produtos;
	}

	public function tamanhosPizza(){
		$tamanhos = TamanhoPizza::all();
		return response()->json($tamanhos, 200);
	}

	public function pizzaValorPorTamanho(Request $request){

		$p = ProdutoPizza::
		where('produto_id', $request->produto)
		->where('tamanho_id', $request->tamanho)
		->first();

		if($p != null) return response()->json((float)$p->valor, 200);
		else return response()->json(0, 200);
	}

	public function saboresPorTamanho(Request $request){

		$tamanho = TamanhoPizza::
		where('id', $request->tamanho)
		->first();

		$sabores = $tamanho->produtoPizza;
		$temp = [];
		foreach($sabores as $s){
			$s->produto->produto->galeria;
			$s->produto->galeria;
			$s->maximo_sabores = $tamanho->maximo_sabores;
			if($request->saborPrincipal != $s->produto->id && $s->produto->status){
				array_push($temp, $s);
			}
		}

		return response()->json($temp, 200);

	}

	public function favorito(Request $request){
		$produtoExist = ProdutoFavoritoDelivery::where('cliente_id', $request->cliente)
		->where('produto_id', $request->produto)->first();
		if(!$produtoExist){
			$result = ProdutoFavoritoDelivery::create([
				'produto_id' => $request->produto,
				'cliente_id' => $request->cliente
			]);
			if($request) return response()->json(true, 200);
			else return response()->json(null, 400);
		}else{
			// ja existe
			$produtoExist->delete();
			if($request) return response()->json(false, 200);
		}

	}

	public function adicionais($produtoId){
		$produto = ProdutoDelivery::where('id', $produtoId)->first();
		return response()->json($this->setaDadosAdicionais($produto->categoria->adicionais), 200);
	}

	private function setaDadosAdicionais($adicionais){
		foreach($adicionais as $a){
			$a->complemento;
		}
		return $adicionais;
	}

	public function enviaProduto(Request $request){
		$adicionais = json_decode($request['adicionais']);
		$sabores = json_decode($request['sabores']);
		$produto = json_decode($request['produto']);
		$quantidade = $request->quantidade;
		$observacao = $request->observacao;
		$cliente = $request->cliente;
		$tamanho = $request->tamanho ?? null;


		//verifica se cliente nao possui pedido estado novo 'nv'

		$pedido = PedidoDelivery
		::where('estado', 'nv')
		->where('cliente_id', $cliente)
		->where('valor_total', 0)
		->first();
		if($pedido == null){ // cria um novo
			$pedido = PedidoDelivery::create([
				'cliente_id' => $cliente,
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
				'app' => true
			]);
		} // se nao usa o ja existe

		if($pedido->valor_total == 0){
			$item = ItemPedidoDelivery::create([
				'pedido_id' => $pedido->id,
				'produto_id' => $produto->id,
				'status' => false,
				'observacao' => $observacao ?? '',
				'quantidade' => $quantidade,
				'tamanho_id' => $tamanho == 'null' ? NULL : $tamanho
			]);

			if($tamanho != 'null'){
				ItemPizzaPedido::create([
					'item_pedido' => $item->id,
					'sabor_id' => $produto->id
				]);
				foreach($sabores as $s){
					ItemPizzaPedido::create([
						'item_pedido' => $item->id,
						'sabor_id' => $s->produto_id
					]);
				}
			}


			if(count($adicionais) > 0){
				foreach($adicionais as $a){

					$itemAdd = ItemPedidoComplementoDelivery::create([
						'item_pedido_id' => $item->id,
						'complemento_id' => $a->complemento_id,
						'quantidade' => 1,
					]);
				}
			}

			return response()->json(true, 200);
		}else{
			return response()->json(false, 204);
		}
	}

	public function pesquisaProduto(Request $request){
		$pesquisa = $request->pesquisa;
		$produtos = ProdutoDelivery::
		select('produto_deliveries.*')
		->join('produtos', 'produtos.id', '=', 'produto_deliveries.produto_id')
		->where('produtos.nome', 'LIKE', "%$pesquisa%")
		->where('produto_deliveries.status', true)
		->get();
		if($request->usuario_id > 0){
			$produtos = $this->verificaFavoritos($produtos, $request->usuario_id);
		}else{
			foreach($produtos as $p){
				$p['color'] = '#e57373';
				$p['icon'] = 'star-outline';
				$p->categoria;
				if(strpos(strtolower($p->categoria->nome), 'izza') !== false){
					foreach($p->pizza as $s) $s->tamanho;
				}
			}
		}
		return response()->json($produtos, 200);
	}

}
