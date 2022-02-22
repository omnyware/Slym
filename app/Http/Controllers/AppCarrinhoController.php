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
use App\DeliveryConfig;
use App\BairroDelivery;
use App\FuncionamentoDelivery;
use App\CodigoDesconto;
use App\ItemPizzaPedido;
use App\EnderecoDelivery;


class AppCarrinhoController extends Controller
{
	public function index(Request $request){

		$pedido = PedidoDelivery::
		where('estado', 'nv')
		->where('valor_total', 0)
		->where('cliente_id', $request->cliente)
		->first();
		if($pedido){
			$p = $this->defineCarrinho($pedido);
			return response()->json($p, 200);
		}
		else return response()->json(null, 204);
	}

	public function defineCarrinho($pedido){
		foreach($pedido->itens as $i){
			$i->produto;
			$i['nome'] = $i->produto->produto->nome;

			$i->produto->galeria;
			$i->tamanho;
			$i->sabores;

			$maiorValor = 0;
			if(count($i->sabores) > 0){
				$somaValores = 0;
				foreach($i->sabores as $s){
					$s->produto->produto;
					$v = $s->maiorValor($s->sabor_id, $i->tamanho_id);
					$somaValores += $v;
					if($v > $maiorValor) $maiorValor = $v;
				}
				if(getenv("DIVISAO_VALOR_PIZZA") == 1){
					$maiorValor = $somaValores/sizeof($i->sabores);
				}
				$i->valorPizza = $maiorValor;
				
				foreach($i->itensAdicionais as $a){
					$a->adicional;
				}
			}
			
			$i['temadicional'] = count($i->itensAdicionais) > 0 ? true: false;
		}
		return $pedido;

	}

	public function validaPedidoEmAberto(Request $request){

		$pedido = PedidoDelivery::
		where('cliente_id', $request->cliente)
		->where('estado', 'nv')
		->where('valor_total', '>', 0)
		->first();

		if($pedido == null){
			return response()->json(true, 200);

		}else{
			return response()->json(false, 401);
		}
	}

	private function validaDataCancelar($dataRegistro, $pedido){
		$atual = date("Y-m-d H:i:s");
		$config = DeliveryConfig::first();
		$tempoMaximo = 0;
		if($config != null){
			$tempoMaximo = $config->tempo_maximo_cancelamento;
			$t = explode(":", $tempoMaximo);
			$tempoMaximo = $t[1];
		}

		$dateStart = new \DateTime($dataRegistro);
		$dateNow = new \DateTime($atual);

		$dif = $dateStart->diff($dateNow);
		if($dif->y == 0 && $dif->m == 0 && $dif->d == 0 && $dif->h == 1 &&
			$dif->i < $tempoMaximo){
			if($pedido->estado == 'nv' || $pedido->estado == 'ap'){
				return true;
			}else{
				return false;
			}
		}
		return false;
	}

	public function removeItem(Request $request){
		$res = ItemPedidoDelivery::where('id', $request->id)
		->delete();
		return response()->json(true, 200);
	}

	public function finalizar(Request $request){
		$pedido = PedidoDelivery::
		where('id', $request->pedido)
		->where('estado', 'nv')
		->first();

		if($pedido){
			$rs = $this->validaPedidoNovo($pedido);
			if($rs){

				$total = 0;

				foreach($pedido->itens as $i){

					if(count($i->sabores) > 0){
						$maiorValor = 0; 
						$somaValores = 0;
						foreach($i->sabores as $it){
							$v = $it->maiorValor($it->produto->id, $i->tamanho_id);
							$somaValores += $v;
							if($v > $maiorValor) $maiorValor = $v;
						}
						if(getenv("DIVISAO_VALOR_PIZZA") == 1){
							$maiorValor = $somaValores/sizeof($i->sabores);
						}
						$total += $maiorValor * $i->quantidade;
					}else{
						$total += ($i->produto->valor * $i->quantidade);
					}

					foreach($i->itensAdicionais as $a){
						$total += $a->adicional->valor * $i->quantidade;
					}
				}

				if($request->desconto){
					$total -= str_replace(",", ".", $request->desconto);
				}

				if($request->forma_entrega != 'balcao'){
					// $config = DeliveryConfig::first();
					$total += $request->valor_entrega;
				}

				$cupom = null;
				if($request->cupom != 'null'){
					$c = CodigoDesconto::
					where('codigo', $request->cupom)
					->first();
					$cupom = $c->id;

					if($c->cliente_id != null){
						$c->ativo = false;
						$c->save();
					}
				}

				$pedido->forma_pagamento = $request->forma_pagamento;
				$pedido->observacao = $request->observacao ?? '';
				$pedido->endereco_id = $request->forma_entrega == 'balcao' ? null : $request->endereco_id;
				$pedido->valor_total = $total;
				$pedido->telefone = $request->telefone ?? '';
				$pedido->troco_para = $request->troco ?? 0;
				$pedido->data_registro = date('Y-m-d H:i:s');
				$pedido->cupom_id = $cupom;
				$pedido->desconto = $request->desconto;

				$pedido->save();
				return response()->json($pedido, 200);
			}else{
				return response()->json(false, 403);
			}
		}else{
			return response()->json(false, 404);
		}
	}

	private function validaPedidoNovo($pedido){
		$cliente = $pedido->cliente;
		if(count($cliente->pedidos) == 1) return true;
		$ultimoPedido = $cliente->pedidos[count($cliente->pedidos)-1];
		if(empty($ultimoPedido)) return true;
		if($ultimoPedido->valor_total > 0 && $ultimoPedido->estado == 'nv') return false;
		else return true;
	}

	public function historico(Request $request){
		$pedidos = PedidoDelivery::
		where('cliente_id', $request->cliente)
		->where('valor_total', '>', 0)
		->orderBy('id', 'desc')
		->get();
		if(count($pedidos) > 0) return response()->json($this->setaItens($pedidos), 200);
		else return response()->json(null, 204);
	}

	private function setaItens($pedidos){
		foreach($pedidos as $p){
			$p['cancelar'] = $this->validaDataCancelar($p->data_registro, $p);

			foreach($p->itens as $i){
				$i->produto;
				$i['nome'] = $i->produto->produto->nome;
				$sub = 0;
				$i->tamanho;
				if(count($i->sabores) > 0){
					$maiorValor = 0; 
					$somaValores = 0;
					foreach($i->sabores as $it){
						$v = $it->maiorValor($it->produto->id, $i->tamanho_id);
						$somaValores += $v;
						if($v > $maiorValor) $maiorValor = $v;

						$it->produto->produto;
					}
					if(getenv("DIVISAO_VALOR_PIZZA") == 1){
						$maiorValor = $somaValores/sizeof($i->sabores);
					}
					$sub += $maiorValor * $i->quantidade;
					$i->pPizza = true;
				}else{
					$sub += ($i->produto->valor * $i->quantidade);
				}


				foreach($i->itensAdicionais as $a){
					$sub+= $a->adicional->valor * $i->quantidade;

				}
				$i['sub'] = $sub;
			}
		}
		return $pedidos;
	}

	public function pedirNovamente(Request $request){
		$pedidoTemp = PedidoDelivery
		::where('estado', 'nv')
		->where('cliente_id', $request->cliente)
		->first();

		if($pedidoTemp != null){ // delete pedido novo
			$pedidoTemp->delete();
		}

		$pedidoAnterior = PedidoDelivery::
		where('id', $request->pedido)
		->first();

		if($pedidoAnterior->estado != 'nv'){

			$pedido = PedidoDelivery::create([
				'cliente_id' => $pedidoAnterior->cliente_id,
				'valor_total' => 0,
				'telefone' => '',
				'observacao' => '',
				'forma_pagamento' => '',
				'estado'=> 'nv',
				'motivoEstado'=> '',
				'endereco_id' => NULL,
				'troco_para' => 0,
				'cupom_id' => NULL,
				'desconto' => 0,
				'app' => true
			]);


			foreach($pedidoAnterior->itens as $i){

				$item = ItemPedidoDelivery::create([
					'pedido_id' => $pedido->id,
					'produto_id' => $i->produto_id,
					'status' => false,
					'observacao' => $i->observacao,
					'quantidade' => $i->quantidade,
					'tamanho_id' => $i->tamanho_id
				]);

				if($i->tamanho != null){
					
					foreach($i->sabores as $s){
						ItemPizzaPedido::create([
							'item_pedido' => $item->id,
							'sabor_id' => $s->sabor_id
						]);
					}
				}

				foreach($i->itensAdicionais as $a){

					$itemAdd = ItemPedidoComplementoDelivery::create([
						'item_pedido_id' => $item->id,
						'complemento_id' => $a->complemento_id,
						'quantidade' => 1,
					]);
				}
			}
		}
		if($pedidoAnterior->estado != 'nv') return response()->json(true, 200);
		else return response()->json(false, 204);
	}

	public function itensCarrinho(Request $request){
		$pedido = PedidoDelivery::
		where('estado', 'nv')
		->where('valor_total', 0)
		->where('cliente_id', $request->cliente)
		->first();
		if($pedido){
			$pedido = $this->defineCarrinho($pedido);
			return response()->json(count($pedido->itens), 200);
		}
		else return response()->json(0, 200);
	}

	public function valorEntrega(){
		$config = DeliveryConfig::first();
		return response()->json($config->valor_entrega, 200);
	}

	public function config(){
		$config = DeliveryConfig::first();
		return response()->json($config, 200);
	}

	public function cancelar(Request $request){
		$pedido = PedidoDelivery::
		where('id', $request->pedido)
		->first();
		$pedido->estado = 'rp';
		$pedido->motivoEstado = $request->motivo;
		$pedido->save();

		return response()->json(true, 200);
	}

	public function funcionamento(){
		$atual = strtotime(date('H:i'));
		$dias = FuncionamentoDelivery::dias();
		$hoje = $dias[date('w')];
		$func = FuncionamentoDelivery::where('dia', $hoje)->first();
		if($func == null) return response()->json("vazio", 403);
		// echo strtotime($func->fim_expediente)."<br>";
		if($atual >= strtotime($func->inicio_expediente) && $atual < strtotime($func->fim_expediente) && $func->ativo){
			return response()->json($func, 200);
		}else{
			return response()->json($func, 401);
		}
	}

	public function getBairros(){
		return response()->json(BairroDelivery::all(), 200);
	}

	public function getValorBairro($id){
		$endereco = EnderecoDelivery::find($id);
		if($endereco->bairro_id > 0){
			$bairro = BairroDelivery::find($endereco->bairro_id);
			if($bairro != null){
				return response()->json($bairro, 200);
			}else{
				return response()->json(null, 401);
			}
		}else{
			return response()->json(null, 401);
		}

	}

}
