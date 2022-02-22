<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use App\Mesa;
use App\CategoriaProdutoDelivery;
use App\ProdutoDelivery;
use App\ItemPedidoDelivery;
use App\DeliveryConfig;
use App\TamanhoPizza;
use App\ItemPedido;
use App\ComplementoDelivery;
use App\ItemPedidoComplementoLocal;
use App\PedidoQrCodeCliente;

class PedidoQrCodeController extends Controller
{
	protected $config = null;

	public function __construct(){
		
		$this->config = DeliveryConfig::first();
		$delivery = getenv("DELIVERY");

	}

	public function index(){
		session()->forget('tamanho_pizza');
		session()->forget('sabores');

		$categorias = CategoriaProdutoDelivery::all();
		$destaques = ProdutoDelivery::
		where('destaque', true)
		->where('status', true)
		->get();

		$dataHoje = date('Y-m-d');

		foreach($destaques as $d){

			$itens = ItemPedidoDelivery::
			selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as data, quantidade')
			->where('produto_id', $d->id)
			->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") = "' . $dataHoje . '"')
			->get();

			$soma = 0;
			foreach($itens as $i){

				$soma += 2;
			}

			if($d->limite_diario <= $soma){
				$d->block = true;
			}
		}

		return view('delivery_pedido/index')
		->with('categorias', $categorias)
		->with('destaques', $destaques)
		->with('config', $this->config)
		->with('tokenJs', true)
		->with('title', 'INICIO');
	}

	public function open($id){
		$mesa = Mesa::find($id);

		if($mesa != null){

			$pedido = Pedido::where('mesa_id', $id)
			->where('status', false)
			->where('desativado', false)
			->first();

			$temp = true;

			if($pedido != null){

				$mesa_open = session('mesa_open');
				if(isset($mesa_open['pedido_id'])){
					if($mesa_open['pedido_id'] == $pedido->id){
						return redirect('/pedido');
					}else{
						session()->forget('mesa_open');
						return redirect('/pedido/open/'.$id);

					}
				}

				$ps = PedidoQrCodeCliente::where('pedido_id', $pedido->id)
				->get();

				$maximo = getenv("CLIENTES_MESA_QRCODE");
				if(sizeof($ps) >= $maximo){
					session()->flash("message_erro", "Maximo de $maximo clientes por mesas, para efetuar pedidos!!");
					return redirect('/pedido');
				}else{
					PedidoQrCodeCliente::create(
						[
							'pedido_id' => $pedido->id,
							'hash' => rand(0, 999999999)
						]
					);

					$session = [
						'mesa_id' => $id,
						'pedido_id' => $pedido->id,
						'abertura' => date('d-m-Y H:i')
					];

					session(['mesa_open' => $session]);
					session()->flash("message_sucesso_swal", "Mesa aberta com sucesso!!");
					session()->flash("message_sucesso", "Mesa aberta com sucesso!!");
					return redirect('/pedido');

				}
			}else{

				$p = Pedido::where('mesa_id', $id)
				->where('desativado', false)
				->where('status', false)
				->first();
				if($p == null){
					$result = Pedido::create([
						'comanda' => '',
						'mesa_id' => $id,
						'status' => false,
						'observacao' => '',
						'desativado' => false,
						'rua' => '',
						'numero' => '',
						'bairro_id' => null,
						'referencia' => '',
						'telefone' => '', 
						'nome' => '',
						'referencia_cliete' => md5(date('d-m-Y H:i') . $id),
						'mesa_ativa' => getenv("MESA_ATIVA_QRCODE")
					]);

					PedidoQrCodeCliente::create(
						[
							'pedido_id' => $result->id,
							'hash' => rand(0, 999999999)
						]
					);
					$session = [
						'mesa_id' => $id,
						'pedido_id' => $result->id,
						'abertura' => date('d-m-Y H:i')
					];

					session(['mesa_open' => $session]);
					session()->flash("message_sucesso", "Mesa aberta com sucesso!!");
					session()->flash("message_sucesso_swal", "Mesa aberta com sucesso!!");
					return redirect('/pedido');

				}else{
					session()->forget('tamanho_pizza');
					session()->flash("message_erro", "Mesa aberta com sucesso!!");
					return redirect('/pedido');

				}
			}

		}else{
			return redirect('/pedido/erro');
		}
	}

	public function cardapio($id){
		$categoria = CategoriaProdutoDelivery::find($id);

		if(strpos(strtolower($categoria->nome), 'izza') !== false){

			$tamanhos = TamanhoPizza::all();
			return view('delivery_pedido/tipoPizza')
			->with('tamanhos', $tamanhos)
			->with('config', $this->config)
			->with('categoria', $categoria)
			->with('title', 'TIPO DA PIZZA'); 

		}else{
			return view('delivery_pedido/produtos')
			->with('produtos', $categoria->produtos)
			->with('categoria', $categoria)
			->with('config', $this->config)
			->with('title', 'PRODUTOS'); 
		}
	}


	public function escolherSabores(Request $request){

		if($request->tipo){
			$tipo = $request->tipo;
			$tamanho = explode("-", $tipo)[0];
			$auxSabor = $sabores = explode("-", $tipo)[1];
			$categoria = $request->categoria;

			$session = [
				'tamanho' => $tamanho,
				'sabores' => $sabores
			];

			session(['tamanho_pizza' => $session]);

			$t = TamanhoPizza::
			where('nome', $tamanho)
			->first();
			$tamanho = session('tamanho_pizza');

			$sabores = session('sabores');

			if(empty($sabores) && $request->produto > 0){
				$session = [
					$request->produto,
				];
				session(['sabores' => $session]);
				$sabores = session('sabores');
				if($auxSabor == 1){
					return redirect('/pizza/adicionais');
				}
			}

			$saboresIncluidos = [];
			$valorPizza;
			$somaValores = 0;
			$valorPizza = 0;
			$maiorValor = 0;
			if($sabores){
				foreach($sabores as $s){
					$p = ProdutoDelivery::
					where('id', $s)
					->first();

					$p->produto;
					$p->galeria;


					foreach($p->pizza as $pz){
						if($tamanho['tamanho'] == $pz->tamanho->nome){
							$valor = $pz->valor;
						}
					}
					$somaValores += $p->valorPizza = $valor;
					if($valor > $maiorValor) $maiorValor = $valor;

					array_push($saboresIncluidos, $p);
				}
			}

			if(getenv("DIVISAO_VALOR_PIZZA") == 1 && sizeof($sabores) > 0){
				$valorPizza = $somaValores/sizeof($sabores);
			}else{
				$valorPizza = $maiorValor;
			}

			return view('delivery_pedido/pizzas')
			->with('pizzas', $t->produtoPizza)
			->with('config', $this->config)
			->with('pizzaJs', true)
			->with('categoria', $categoria)
			->with('valorPizza', $valorPizza)
			->with('saboresIncluidos', $saboresIncluidos)
			->with('title', 'PIZZAS'); 
		}else{
			session()->flash("message_erro", "Escolha um sabor");
			return back()->withInput();
		}
	}

	public function removeSabor($id){
		$sabores = session('sabores');
		$temp = [];
		if($sabores){
			foreach($sabores as $s){
				if($s != $id){
					array_push($temp, $s);
				}
			}
			session(['sabores' => $temp]);
		}
		return redirect()->back();
	}

	public function adicionaisPizza(){

		$sabores = session('sabores');
		$tamanho = session('tamanho_pizza');
		$saboresIncluidos = [];
		$tamanhoId = 0;

		$maiorValor = 0;
		$somaValores = 0;
		if($sabores){
			foreach($sabores as $s){
				$p = ProdutoDelivery::
				select('produto_deliveries.*')
				->join('produto_pizzas', 'produto_pizzas.produto_id', '=', 'produto_deliveries.id')
				->join('tamanho_pizzas', 'produto_pizzas.tamanho_id', '=', 'tamanho_pizzas.id')
				->where('produto_deliveries.id', $s)
				->where('tamanho_pizzas.nome', $tamanho['tamanho'])
				->first();

				$p->produto;
				$p->galeria;

				array_push($saboresIncluidos, $p);

				foreach($p->pizza as $t){
					if($t->tamanho->nome == $tamanho['tamanho']){
						$tamanhoId = $t->tamanho->id;
						$somaValores += $t->valor;
						if($t->valor > $maiorValor){
							$maiorValor = $t->valor;
						}
					}
				}
			}
			if(getenv("DIVISAO_VALOR_PIZZA") == 1){
				$maiorValor = number_format(($somaValores/sizeof($sabores)),2);
			}
		}


		$produto = $saboresIncluidos[0];

		$add = $produto->categoria->adicionais;
		$tamanho = substr($tamanho['tamanho'], 0, 1);

		$adicionais = [];

		foreach($add as $a){
			$nome = $a->complemento->nome;
			$ex = explode('>', $nome);

			if(sizeof($ex) > 1){
				if(strtolower($ex[0]) == strtolower($tamanho)){
					array_push($adicionais, $a);
				}
			}else{
				array_push($adicionais, $a);
			}

		}

		return view('delivery_pedido/adicionalPizza')
		->with('maiorValor', $maiorValor)
		->with('saboresIncluidos', $saboresIncluidos)
		->with('acompanhamentoPizza', true)
		->with('sabores', $sabores)
		->with('tamanho', $tamanhoId)
		->with('adicionais', $adicionais)
		->with('config', $this->config)
		->with('title', 'Adicionais para Pizza');

	}

	public function addPizza(Request $request){
		$adicionais = $request['adicionais'];
		$sabores = $request['sabores'];
		$quantidade = $request['quantidade'];
		$observacao = $request['observacao'];
		$tamanho = $request['tamanho'];
		$valor = $request['valor'];
		$mesa_open = session('mesa_open');
		if(isset($mesa_open['pedido_id'])){
			$pedido = Pedido::find($mesa_open['pedido_id']);
			if($pedido != null){
				$produto = ProdutoDelivery::find($sabores[0]);
				$res = ItemPedido::create([
					'pedido_id' => $pedido->id,
					'produto_id' => $produto->produto->id,
					'quantidade' => $quantidade,
					'status' => false,
					'observacao' => $observacao ?? '',
					'tamanho_pizza_id' => $tamanho == 'null' ? NULL : $tamanho,
					'valor' => str_replace(",", ".", $valor),
					'impresso' => false
				]);

				if(sizeof($adicionais) > 0){
					foreach($adicionais as $ad){

						$adicional = ComplementoDelivery
						::where('id', $ad['id'])
						->first();


						$item = ItemPedidoComplementoLocal::create([
							'item_pedido' => $res->id,
							'complemento_id' => $adicional->id,
							'quantidade' => str_replace(",", ".", $quantidade),
						]);
					}
				}
				// session()->flash("message_sucesso_swal", "Item Adicionado :)");
				return response()->json($pedido, 200);

			}else{
				session()->forget('tamanho_pizza');
				session()->flash("message_erro", "Realize a leitura do QrCode!!");
				return response()->json('Realize a leitura do QrCode, para abrir a mesa!!', 401);
			}
		}else{
			session()->forget('tamanho_pizza');
			session()->flash("message_erro", "Realize a leitura do QrCode!!");
			return response()->json('Realize a leitura do QrCode, para abrir a mesa!!', 401);
		}

	}

	public function addProd(Request $request){
		$adicionais = $request['adicionais'];
		$produto_id = $request['produto_id'];
		$quantidade = $request['quantidade'];
		$observacao = $request['observacao'];
		$valor = $request['valor'];
		$mesa_open = session('mesa_open');
		if(isset($mesa_open['pedido_id'])){

			$pedido = Pedido::find($mesa_open['pedido_id']);
			if($pedido != null){

				$produto = ProdutoDelivery::find($produto_id);
				$res = ItemPedido::create([
					'pedido_id' => $pedido->id,
					'produto_id' => $produto->produto->id,
					'quantidade' => $quantidade,
					'status' => false,
					'observacao' => $observacao ?? '',
					'tamanho_pizza_id' => NULL,
					'valor' => str_replace(",", ".", $valor),
					'impresso' => false
				]);

				if(sizeof($adicionais) > 0){
					foreach($adicionais as $ad){

						$adicional = ComplementoDelivery
						::where('id', $ad['id'])
						->first();


						$item = ItemPedidoComplementoLocal::create([
							'item_pedido' => $res->id,
							'complemento_id' => $adicional->id,
							'quantidade' => str_replace(",", ".", $quantidade),
						]);
					}
				}
				// session()->flash("message_sucesso_swal", "Item Adicionado :)");
				return response()->json($pedido, 200);

			}else{
				session()->forget('tamanho_pizza');
				session()->flash("message_erro", "Realize a leitura do QrCode!!");
				return response()->json('Realize a leitura do QrCode, para abrir a mesa!!', 401);
			}
		}else{
			session()->forget('tamanho_pizza');
			session()->flash("message_erro", "Realize a leitura do QrCode!!");
			return response()->json('Realize a leitura do QrCode, para abrir a mesa!!', 401);
		}
	}

	public function adicionarSabor(Request $request){
		$sabores = session('sabores');
		if($sabores){
			array_push($sabores, $request->pizza_id);

			session(['sabores' => $sabores]);
		}else{
			$session = [
				$request->pizza_id,
			];
			session(['sabores' => $session]);
		}
		$link = (string)$request->link;
		session()->flash("message_sucesso", "Sabor adicionado!!");
		if($link)
			return redirect($link);
		else
			return redirect()->back();

	}

	public function ver(){
		$mesa_open = session('mesa_open');
		if(isset($mesa_open['pedido_id'])){
			$pedido = Pedido::find($mesa_open['pedido_id']);

			return view('delivery_pedido/carrinho')
			->with('pedido', $pedido)
			->with('carrinho', true)
			->with('config', $this->config)
			->with('title', 'ITENS');
		}else{
			session()->flash("message_erro", "Realize a leitura do QrCode para continuar!!");
			return redirect('/pedido');
		}
	}

	public function adicionais($id){
		$produto = ProdutoDelivery::where('id', $id)
		->first();

		return view('delivery_pedido/acompanhamentos')
		->with('produto', $produto)
		->with('acompanhamento', true)
		->with('adicionais', $produto->categoria->adicionais)
		->with('config', $this->config)
		->with('title', 'ACOMPANHAMENTO');

	}

	public function removeItem($id){
		$item = ItemPedido::where('id', $id)->first();
		$item->delete();
		echo json_encode($item);
	}

	public function refreshItem($id, $quantidade){
		if($quantidade > 0){
			$item = ItemPedido::where('id', $id)->first();
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

	public function finalizar(){
		$mesa_open = session('mesa_open');
		if(isset($mesa_open['pedido_id'])){
			$pedido = Pedido::find($mesa_open['pedido_id']);
			$pedido->fechar_mesa = true;
			if($pedido->comanda == ''){
				$pedido->comanda = rand(111111, 999999);
			}
			$pedido->save();
			session()->forget('mesa_open');

			return view('delivery_pedido/pedido_finalizado')
			->with('title', 'Pedido Finalizado')
			->with('config', $this->config)

			->with('pedido', $pedido);
			
		}else{
			session()->flash("message_erro", "Nenhuma sessão ativa!");
			return redirect('/pedido');
		}
	}


	public function erro(){
		echo "Algo deu errado!";
	}
}
