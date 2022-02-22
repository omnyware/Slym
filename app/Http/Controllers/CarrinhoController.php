<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PedidoDelivery;
use App\ClienteDelivery;
use App\ItemPedidoDelivery;
use App\ItemPedidoComplementoDelivery;
use App\EnderecoDelivery;
use App\DeliveryConfig;
use App\ProdutoPizza;
use App\ItemPizzaPedido;
use App\CodigoDesconto;
use App\FuncionamentoDelivery;
use App\BairroDelivery;

class CarrinhoController extends Controller
{	
	protected $config = null;

	public function __construct(){
		$this->config = DeliveryConfig::first();
		$this->middleware(function ($request, $next) {
			$value = session('cliente_log');
			if(!$value){
				session()->flash("message_erro", "Voce precisa estar logado para comprar nossos produtos");
				return redirect('/autenticar'); 
			}
			return $next($request);
		});
	}

	public function carrinho(){

		$clienteLog = session('cliente_log');
		$pedido = PedidoDelivery::
		where('estado', 'nv')
		->where('valor_total', 0)
		->where('cliente_id', $clienteLog['id'])
		->first();

		return view('delivery/carrinho')
		->with('pedido', $pedido)
		->with('carrinho', true)
		->with('config', $this->config)
		->with('title', 'CARRINHO');
		
	}

	public function add(Request $request){
		$value = session('cliente_log');

		if($value){
			$adicionais = $request['adicionais'];
			$produto_id = $request['produto_id'];
			$quantidade = $request['quantidade'];
			$observacao = $request['observacao'];

			$clienteLog = session('cliente_log');
		//verifica se cliente nao possui pedido estado novo 'nv'

			$pedido = PedidoDelivery::where('estado', 'nv')
			->where('cliente_id', $clienteLog['id'])
			->first();
			if($pedido == null){ // cria um novo
				$pedido = PedidoDelivery::create([
					'cliente_id' => $clienteLog['id'],
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
			} // se nao usa o ja existe

			if($pedido->valor_total == 0){
				$item = ItemPedidoDelivery::create([
					'pedido_id' => $pedido->id,
					'produto_id' => $produto_id,
					'status' => false,
					'observacao' => $observacao ?? '',
					'quantidade' => $quantidade,
					'tamanho_id' => null
				]);

				if($adicionais){
					foreach($adicionais as $a){

						$itemAdd = ItemPedidoComplementoDelivery::create([
							'item_pedido_id' => $item->id,
							'complemento_id' => $a['id'],
							'quantidade' => 1,
						]);
					}
				}


				echo json_encode($pedido);
			}else{
				echo json_encode(false);
			}
		}else{
			session()->flash("message_erro", "Voce precisa estar logado, realize seu cadastro por gentileza");
			echo json_encode('401');
		}
	}

	public function addPizza(Request $request){
		$adicionais = $request['adicionais'];
		$sabores = $request['sabores'];
		$quantidade = $request['quantidade'];
		$observacao = $request['observacao'];
		$tamanho = $request['tamanho'];

		$clienteLog = session('cliente_log');
		//verifica se cliente nao possui pedido estado novo 'nv'

		$pedido = PedidoDelivery
		::where('estado', 'nv')
		->where('cliente_id', $clienteLog['id'])
		->first();
		if($pedido == null){ // cria um novo
			
			$pedido = PedidoDelivery::create([
				'cliente_id' => $clienteLog['id'],
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
		} // se nao usa o ja existe

		if($pedido->valor_total == 0){
			$identifica_produto_pizza = rand(1, 1000);
			
			$item = ItemPedidoDelivery::create([
				'pedido_id' => $pedido->id,
				'produto_id' => $sabores[0],
				'status' => false,
				'observacao' => $observacao ?? '',
				'quantidade' => $quantidade,
				'tamanho_id' => $tamanho
			]);

			if($sabores){
				foreach($sabores as $s){
					ItemPizzaPedido::create([
						'item_pedido' => $item->id,
						'sabor_id' => $s
					]);
				}
			}

			if($adicionais){
				foreach($adicionais as $a){
					$itemAdd = ItemPedidoComplementoDelivery::create([
						'item_pedido_id' => $item->id,
						'complemento_id' => $a['id'],
						'quantidade' => 1,
					]);
				}
			}


			echo json_encode($pedido);
		}else{
			echo json_encode(false);
		}
	}

	public function removeItem($id){
		$item = ItemPedidoDelivery::where('id', $id)->first();
		$item->delete();
		echo json_encode($item);
	}

	public function refreshItem($id, $quantidade){
		if($quantidade > 0){
			$item = ItemPedidoDelivery::where('id', $id)->first();
			$item->quantidade = $quantidade;

		//verifica os adicionais
			foreach($item->itensAdicionais as $a){
				$a->quantidade = $quantidade;
				$a->save();
			}
			$item->save();
			echo json_encode($item);
		}
	}

	public function forma_pagamento($cupom = 0){

		$funcionamento = $this->funcionamento();

		$pagseguroAtivo = getenv("PAGSEGURO_ATIVO");
		$pagseguroEmail = getenv("PAGSEGURO_EMAIL");
		$pagseguroToken = getenv("PAGSEGURO_TOKEN");

		$pagseguroAtivado = false;
		if($pagseguroAtivo == 1 && strlen($pagseguroEmail) > 10 && strlen($pagseguroToken) > 10){
			$pagseguroAtivado = true;
		}

		if($funcionamento['status']){
			$clienteLog = session('cliente_log');
			$pedido = PedidoDelivery::
			where('estado', 'nv')
			->where('valor_total', '==', 0)
			->where('cliente_id', $clienteLog['id'])
			->first();

			if($pedido){

				if(count($pedido->itens) > 0){

					$total = 0;
					foreach($pedido->itens as $i){
						$total += ($i->produto->valor * $i->quantidade);
						if(count($i->sabores) > 0){
							$maiorValor = 0;
							$somaValores = 0;
							foreach($i->sabores as $it){
								$v = $it->maiorValor($it->sabor_id, $i->tamanho_id);
								$somaValores += $v;
								if($v > $maiorValor) $maiorValor = $v;
							}
							if(getenv("DIVISAO_VALOR_PIZZA") == 1){
								$maiorValor = number_format(($somaValores/sizeof($i->sabores)),2);
							}
							$total += $i->quantidade * $maiorValor;
						}
						foreach($i->itensAdicionais as $a){
							$total += $i->quantidade * $a->adicional->valor;
						}
					}



					$cliente = ClienteDelivery::
					where('id', $clienteLog['id'])
					->first();

					$enderecos = $cliente->enderecos;


					if($clienteLog){

						$ultimoPedido = PedidoDelivery::
						where('cliente_id', $cliente->id)
						->where('valor_total', '>', 0)
						->orderBy('id', 'desc')
						->first();

						$cartoes = $this->getPedidosPagSeguro($cliente->id);
						$d = DeliveryConfig::first();

						$bairros = BairroDelivery::orderBy('nome')->get();

						return view('delivery/forma_pagamento')
						->with('pedido', $pedido)
						->with('ultimoPedido', $ultimoPedido)
						->with('cartoes', $cartoes)
						->with('cliente', $cliente)
						->with('enderecos', $enderecos)
						->with('forma_pagamento', true)
						->with('total', $total)
						->with('total', $total)
						->with('mapaJs', true)
						->with('bairros', $bairros)
						->with('usar_bairros', $d->usar_bairros)
						->with('maximo_km_entrega', $d->maximo_km_entrega)
						->with('cupom', $cupom)
						->with('pagseguroAtivado', $pagseguroAtivado)
						->with('config', $this->config)
						->with('title', 'FINALIZAR PEDIDO');
					}else{
						session()->flash("message_erro", "Voce precisa estar logado, realize seu cadastro por gentileza");
						return redirect('/autenticar/registro'); 
					}
				}else{
					session()->flash("message_erro", "Carrinho vazio!");
					return redirect('/'); 
				}
			}else{
				session()->flash("message_erro", "Carrinho vazio!");
				return redirect('/'); 
			}
		}else{
			if($funcionamento['funcionamento'] != null){
				session()->flash("message_erro", "Delivery das " .$funcionamento['funcionamento']->inicio_expediente. " às ".$funcionamento['funcionamento']->fim_expediente);

			}else{
				session()->flash("message_erro", "Não haverá delivery no dia de hoje!");
			}
			return redirect('/'); 
		}
	}

	private function getPedidosPagSeguro($clienteId){
		$pedidos = PedidoDelivery::where('cliente_id', $clienteId)
		->get();
		$arr = [];
		$cartaoInserido = [];
		foreach($pedidos as $p){
			if($p->forma_pagamento == 'pagseguro'){
				if(!in_array($p->pagseguro->numero_cartao, $cartaoInserido)){
					$p->pagseguro->src_bandeira = 'https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/'.
					$p->pagseguro->bandeira . '.png';
					array_push($arr, $p->pagseguro);
					array_push($cartaoInserido, $p->pagseguro->numero_cartao);
				}
			}
		}

		return $arr;
	}

	public function finalizarPedido(Request $request){
		$data = $request['data'];
		$pedido = PedidoDelivery::
		where('id', $data['pedido_id'])
		->where('estado', 'nv')
		->first();
		if($pedido){
			$total = 0;
			foreach($pedido->itens as $i){

				foreach($i->itensAdicionais as $a){
					$total += $a->adicional->valor * $i->quantidade;
				}
				
				if(count($i->sabores) > 0){
					$maiorValor = 0; 
					$somaValores = 0;
					foreach($i->sabores as $it){
						$v = $it->maiorValor($it->produto->id, $i->tamanho_id);
						$somaValores += $v;
						if($v > $maiorValor) $maiorValor = $v;
					}

					if(getenv("DIVISAO_VALOR_PIZZA") == 1){
						$maiorValor = number_format(($somaValores/sizeof($i->sabores)),2);
					}
					$total += ($maiorValor * $i->quantidade);
				}else{
					$total += ($i->produto->valor * $i->quantidade);
				}

			}

			if($data['desconto']){
				$total -= str_replace(",", ".", $data['desconto']);
			}

			if($data['endereco_id'] != 'balcao'){
				// $config = DeliveryConfig::first();
				$total += $data['valor_entrega'];
			}

			$pedido->forma_pagamento = $data['forma_pagamento'];
			$pedido->observacao = $data['observacao'] ? substr($data['observacao'], 0, 50) : '';
			$pedido->endereco_id = $data['endereco_id'] == 'balcao' ? null : $data['endereco_id'];
			$pedido->valor_total = $total;
			$pedido->telefone = $data['telefone'];
			$pedido->troco_para = $data['troco'] ? str_replace(",", ".", $data['troco']) : 0;
			$pedido->data_registro = date('Y-m-d H:i:s');
			$pedido->desconto = $data['desconto'] ? str_replace(",", ".", $data['desconto']) : 0;

			if($data['cupom'] != ''){
				$cupom = CodigoDesconto::
				where('codigo', $data['cupom'])
				->first();

				if($cupom->cliente_id != null){
					$cupom->ativo = false;
					$cupom->save();
				}

				$pedido->cupom_id= $cupom ? $cupom->id : NULL;
			}

			$pedido->save();
			echo json_encode($pedido);
		}else{
			echo json_encode(false);
		}
	}

	public function historico(){
		$clienteLog = session('cliente_log');
		$pedidos = PedidoDelivery::
		where('cliente_id', $clienteLog['id'])
		->orderBy('id', 'desc')
		->where('valor_total', '>', 0)
		->get();

		return view('delivery/historico')
		->with('pedidos', $pedidos)
		->with('historico', true)
		->with('config', $this->config)
		->with('title', 'Historico');
	}

	public function pedir_novamente($id){
		$clienteLog = session('cliente_log');

		$pedidoTemp = PedidoDelivery
		::where('estado', 'nv')
		->where('cliente_id', $clienteLog['id'])
		->first();

		if($pedidoTemp != null){ // delete pedido novo
			$pedidoTemp->delete();
		}

		$pedidoAnterior = PedidoDelivery::
		where('id', $id)
		->first();

		if($pedidoAnterior->estado != 'nv'){

			$clienteLog = session('cliente_log');

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
				'app' => false
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
			session()->flash("message_sucesso", "Itens do pedido adicionados ao seu carrinho!");
			return redirect('/carrinho');
		}else{
			session()->flash("message_erro", "Não foi possivel pedir novamente!");
			return redirect('/carrinho/historico');
		}
	}


	public function finalizado($id){
		$clienteLog = session('cliente_log');
		$pedido = PedidoDelivery::
		where('estado', 'nv')
		->where('valor_total', '!=', 0)
		->where('id', $id)
		->where('cliente_id', $clienteLog['id'])
		->first();

		if($pedido){
			return view('delivery/pedido_finalizado')
			->with('pedido', $pedido)
			->with('config', $this->config)
			->with('carrinho', true)
			->with('title', 'Pedido Finalizado');
		}else{
			session()->flash("message_erro", "Pedido inexistente");
			return redirect('/');
		}
	}

	public function configDelivery(){
		$d = DeliveryConfig::first();
		echo json_encode($d);
	}

	public function cupons(){
		$clienteLog = session('cliente_log');
		$cupons = CodigoDesconto::
		where('cliente_id', $clienteLog['id'])
		->orderBy('id', 'desc')
		->get();

		return view('delivery/cupons')
		->with('config', $this->config)
		->with('cupons', $cupons)
		->with('title', 'Cupons de Desconto');
	}

	public function cupom($codigo){
		$clienteLog = session('cliente_log');
		$cupom = CodigoDesconto::
		// where('cliente_id', $clienteLog['id'])
		where('codigo', $codigo)
		->where('ativo', true)
		->first();

		if($cupom != null){
			if($cupom->cliente_id != null){
				if($cupom->cliente_id != $clienteLog['id']){
					$cupom = null;
				}
			}else{
				if($this->validaClienteNaoUsouCupom($clienteLog['id'], $cupom))
					$cupom = null;
			}
		}

		echo json_encode($cupom);
	}

	private function validaClienteNaoUsouCupom($cliente, $cupom){

		$pedido = PedidoDelivery::
		where('cliente_id', $cliente)
		->where('cupom_id', $cupom->id)
		->first();

		return $pedido == null ? false : true;
	}

	private function funcionamento(){
		$atual = strtotime(date('H:i'));
		$dias = FuncionamentoDelivery::dias();
		$hoje = $dias[date('w')];
		$func = FuncionamentoDelivery::where('dia', $hoje)->first();

		if($func){
			if($atual >= strtotime($func->inicio_expediente) && $atual < strtotime($func->fim_expediente) && $func->ativo){
				return ['status' => true, 'funcionamento' => $func];
			}else{
				return ['status' => false, 'funcionamento' => $func];
			}
		}else{
			return ['status' => false, 'funcionamento' => null];
		}
	}

	public function getDadosCalculoEntrega(Request $request){
		try{
			$config = DeliveryConfig::first();
			if($config->usar_bairros == 0){
				$latitude_local = $config->latitude;
				$longitude_local = $config->longitude;

				$data = [ 
					'valor_km' => $config->valor_km,
					'entrega_gratis_ate' => $config->entrega_gratis_ate,
					'latitude_local' => $latitude_local,
					'longitude_local' => $longitude_local,
					'maximo_km_entrega' => $config->maximo_km_entrega
				];

				return response()->json($data, 200);
			}
		}catch(\Exception $e){
			return response()->json('', 401);

		}
	}


}
