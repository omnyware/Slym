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
use App\PedidoPagSeguro;
use App\FuncionamentoDelivery;

class PagSeguroController extends Controller
{
	protected $url = '';
	public function __construct(){
		if(getenv('PAGSEGURO_SANDBOX')){
			$this->url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/';
		}else{
			$this->url = 'https://ws.pagseguro.uol.com.br/v2/';
		}
	} 

	public function getSessao(){

		$data['token'] = getenv('PAGSEGURO_TOKEN'); 
		$emailPagseguro = getenv('PAGSEGURO_EMAIL');

		$data = http_build_query($data);
		$url = $this->url . "sessions";

		$curl = curl_init();

		$headers = array(
			'Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1'
		);

		curl_setopt($curl, CURLOPT_URL, $url . "?email=" . $emailPagseguro);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt( $curl,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $curl,CURLOPT_RETURNTRANSFER, true );
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		//curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$xml = simplexml_load_string(curl_exec($curl));

		curl_close($curl);

		return response()->json($xml, 200);
	}

	public function getFuncionamento(){
		$pagseguroAtivo = getenv("PAGSEGURO_ATIVO");
		$pagseguroEmail = getenv("PAGSEGURO_EMAIL");
		$pagseguroToken = getenv("PAGSEGURO_TOKEN");

		if($pagseguroAtivo == 0 || strlen($pagseguroEmail) < 10 || strlen($pagseguroToken) < 10){
			return response()->json(null, 403);
		}else{
			return response()->json(true, 200);
		}
	}

	public function efetuaPagamento(Request $request){
		$json = $request->data;
		$rua = getenv("RUA_PADRAO");
		$numero = getenv("NUMERO_PADRAO");
		$bairro = getenv("BAIRRO_PADRAO");
		if($json['endereco_id'] != 'balcao'){
			$endereco = EnderecoDelivery::find($json['endereco_id']);
			$rua = $endereco->rua;
			$numero = $endereco->numero;
			$bairro = $endereco->bairro;
		}

		$referencia = $json['cpf'] . "-" . $json['nome_cartao'];

		$data = [
			'token' => getenv('PAGSEGURO_TOKEN'),
			'paymentMode' => 'default',
			'paymentMethod' => 'creditCard',
			'receiverEmail' => getenv('PAGSEGURO_EMAIL'),
			'currency' => 'BRL',
			'extraAmount' => '0.00',

			'itemId1' => '0001',
			'itemQuantity1' => '1',
			'itemDescription1' => $json['produto_nome'],
			'itemAmount1' => $json['total'],

			'notificationURL' => getenv('PAGSEGURO_NOTIFICATION'),
			'reference' => 'codigo0001',

			'senderName' => $json['nome_cartao'],
			'senderAreaCode' => substr($json['telefone'], 0, 2),
			'senderPhone' => substr($json['telefone'], 3, 12),
			'senderEmail' => $json['email'],
			'senderCPF' => $json['cpf'],
			'senderHash' => $json['hashCliente'],

			'shippingAddressStreet' => $rua,
			'shippingAddressNumber' => $numero,
			'shippingAddressDistrict' => $bairro,
			'shippingAddressPostalCode' => getenv("CEP_PADRAO"),
			'shippingAddressCity' => getenv("CIDADE_PADRAO"),
			'shippingAddressState' => getenv("UF_PADRAO"),
			'shippingAddressCountry' => 'BRA',
			'shippingType' => '1',
			'shippingCost' => '0.00',

			'creditCardToken' => $json['creditCardToken'],
			'installmentQuantity' => (int) $json['parcelas'],
			'installmentValue' => $json['valor'],
			'noInterestInstallmentQuantity' => '2',

			'creditCardHolderName' => $json['nome_cartao'],
			'creditCardHolderCPF' => $json['cpf'],
			'creditCardHolderBirthDate' => '27/10/1987',
			'creditCardHolderAreaCode' => substr($json['telefone'], 0, 2),
			'creditCardHolderPhone' => substr($json['telefone'], 3, 12),

			'reference' => $referencia,

			'billingAddressStreet' => $rua,
			'billingAddressNumber' => $numero,
			'billingAddressDistrict' => $bairro,
			'billingAddressPostalCode' => getenv("CEP_PADRAO"),
			'billingAddressCity' => getenv("CIDADE_PADRAO"),
			'billingAddressState' => getenv("UF_PADRAO"),
			'billingAddressCountry' => 'BRA',
			
		];

		// return response()->json($data, 200);

		$emailPagseguro = getenv('PAGSEGURO_EMAIL');
		$data = http_build_query($data);

		$url = $this->url . 'transactions';

		$curl = curl_init();

		$headers = array('Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1');

		curl_setopt($curl, CURLOPT_URL, $url . "?email=" . $emailPagseguro);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$xml = simplexml_load_string(curl_exec($curl));
		// return $xml;
		curl_close($curl);
		sleep(7);
		if($xml->code){
			$consulta = $this->consultaPagamento($xml->code);
			if($consulta->original->status == '3'){
				$pedido = $this->incluiPedidoCartao($json, $referencia, $xml->code, $consulta->original->status);
				$arr = [
					'consulta' => $consulta,
					'pedido_id' => $pedido->id
				];
				return response()->json($arr, 200);

			}else if($consulta->original->status == '1' || $consulta->original->status == '2'){
				// aguardando pagamento
				$pedido = $this->incluiPedidoCartao($json, $referencia, $xml->code, $consulta->original->status);

				return response()->json($consulta, 402);

			}else{
				return response()->json($consulta, 404);
			}
		}

		return response()->json($xml, 403);
	}

	private function incluiPedidoCartao($data, $referencia, $codigoTransacao, $status){

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
				
				if(sizeof($i->sabores) > 0){

					//INICIO DIVISAO_VALOR_PIZZA
					if(getenv("DIVISAO_VALOR_PIZZA") == 1){

						$somaValores = 0; 
						foreach($i->sabores as $it){
							$somaValores += $it->maiorValor($it->produto->id, $i->tamanho_id);
							// if($v > $maiorValor) $maiorValor = $v;
						}
						$total += $somaValores/sizeof($i->sabores);

					}else{
						$maiorValor = 0; 
						foreach($i->sabores as $it){
							$v = $it->maiorValor($it->produto->id, $i->tamanho_id);
							if($v > $maiorValor) $maiorValor = $v;
						}
						$total += ($maiorValor * $i->quantidade);
					}

					//FIM DIVISAO_VALOR_PIZZA
				}else{
					$total += ($i->produto->valor * $i->quantidade);
				}

			}

			if($data['desconto']){
				$total -= str_replace(",", ".", $data['desconto']);
			}

			if($data['endereco_id'] != 'balcao'){
				$config = DeliveryConfig::first();
				$total += $data['valor_entrega'];
			}

			$pedido->forma_pagamento = $data['forma_pagamento'];
			$pedido->observacao = $data['observacao'] ?? '';
			$pedido->endereco_id = $data['endereco_id'] == 'balcao' ? null : $data['endereco_id'];
			$pedido->valor_total = $total;
			$pedido->telefone = $data['telefone'];
			$pedido->troco_para = $data['troco'] ? str_replace(",", ".", $data['troco']) : 0;
			$pedido->data_registro = date('Y-m-d H:i:s');
			$pedido->desconto = $data['desconto'] ? str_replace(",", ".", $data['desconto']) : 0;
			$pedido->app = false;

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

			$pagseguro = PedidoPagSeguro::create(
				[
					'pedido_delivery_id' => $pedido->id,
					'numero_cartao' => $data['numero_cartao'],
					'cpf' => $data['cpf'],
					'nome_impresso' => $data['nome_cartao'],
					'codigo_transacao' => $codigoTransacao,
					'referencia' => $referencia,
					'parcelas' => $data['parcelas'],
					'bandeira' => $data['bandeira'],
					'status' => $status
				]
			);
			return $pedido;
		}else{
			return false;
		}
	}

	public function consultaPagamento($codigo){

		$token = getenv('PAGSEGURO_TOKEN'); 
		$emailPagseguro = getenv('PAGSEGURO_EMAIL');

		$url = $this->url . 'transactions/'.$codigo."?email=" . $emailPagseguro . "&token=" . $token;

		$curl = curl_init();

		$headers = array(
			'Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1'
		);

		curl_setopt($curl, CURLOPT_URL, $url);

		curl_setopt($curl,CURLOPT_HTTPHEADER, $headers );
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, true );
		$xml = simplexml_load_string(curl_exec($curl));

		curl_close($curl);

		return response()->json($xml);
	}

	public function consultaJS(Request $request){
		$consulta = $this->consultaPagamento($request->codigo);
		$arr = [
			'referencia' => $consulta->original->reference,
			'status' => $consulta->original->status,
			'total' => $consulta->original->grossAmount,
			'taxa' => $consulta->original->feeAmount
		];
		return response()->json($arr, 200);
	}

	public function efetuaPagamentoApp(Request $request){
		$json = $request;
		$pedido = PedidoDelivery::find($request->pedido);
		// return response()->json($json->endereco_id, 200);

		$rua = getenv("RUA_PADRAO");
		$numero = getenv("NUMERO_PADRAO");
		$bairro = getenv("BAIRRO_PADRAO");
		if($json->forma_entrega != 'balcao'){
			$endereco = EnderecoDelivery::find($json->endereco_id);
			$rua = $endereco->rua;
			$numero = $endereco->numero;
			$bairro = $endereco->bairro;
		}

		$referencia = $json->cpf . "-" . $json->nome_cartao;

		$data = [
			'token' => getenv('PAGSEGURO_TOKEN'),
			'paymentMode' => 'default',
			'paymentMethod' => 'creditCard',
			'receiverEmail' => getenv('PAGSEGURO_EMAIL'),
			'currency' => 'BRL',
			'extraAmount' => '0.00',

			'itemId1' => '0001',
			'itemQuantity1' => '1',
			'itemDescription1' => $json->produto_nome,
			'itemAmount1' => number_format($json->total, 2),

			'notificationURL' => getenv('PAGSEGURO_NOTIFICATION'),
			'reference' => 'codigo0001',

			'senderName' => $json->nome_cartao,
			'senderAreaCode' => substr($json->telefone, 0, 2),
			'senderPhone' => str_replace("-", "", substr($json->telefone, 3, 12)),
			'senderEmail' => $pedido->cliente->email,
			'senderCPF' => $json->cpf,
			'senderHash' => $json->hashCliente,

			'shippingAddressStreet' => $rua,
			'shippingAddressNumber' => $numero,
			'shippingAddressDistrict' => $bairro,
			'shippingAddressPostalCode' => getenv("CEP_PADRAO"),
			'shippingAddressCity' => getenv("CIDADE_PADRAO"),
			'shippingAddressState' => getenv("UF_PADRAO"),
			'shippingAddressCountry' => 'BRA',
			'shippingType' => '1',
			'shippingCost' => '0.00',

			'creditCardToken' => $json->creditCardToken,
			'installmentQuantity' => (int) $json->parcelas,
			'installmentValue' => number_format($json->valor, 2),
			'noInterestInstallmentQuantity' => '2',

			'creditCardHolderName' => $json->nome_cartao,
			'creditCardHolderCPF' => $json->cpf,
			'creditCardHolderBirthDate' => '27/10/1987',
			'creditCardHolderAreaCode' => substr($json->telefone, 0, 2),
			'creditCardHolderPhone' => str_replace("-", "", substr($json->telefone, 3, 12)),

			'reference' => $referencia,

			'billingAddressStreet' => $rua,
			'billingAddressNumber' => $numero,
			'billingAddressDistrict' => $bairro,
			'billingAddressPostalCode' => getenv("CEP_PADRAO"),
			'billingAddressCity' => getenv("CIDADE_PADRAO"),
			'billingAddressState' => getenv("UF_PADRAO"),
			'billingAddressCountry' => 'BRA',
			
		];

		// return response()->json($data, 200);

		$emailPagseguro = getenv('PAGSEGURO_EMAIL');
		$data = http_build_query($data);

		$url = $this->url . 'transactions';

		$curl = curl_init();

		$headers = array('Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1');

		curl_setopt($curl, CURLOPT_URL, $url . "?email=" . $emailPagseguro);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$xml = simplexml_load_string(curl_exec($curl));
		// return $xml;
		curl_close($curl);
		sleep(7);
		if($xml->code){
			$consulta = $this->consultaPagamento($xml->code);
			if($consulta->original->status == '3'){
				$pedido = $this->incluiPedidoCartaoApp($json, $referencia, $xml->code, $consulta->original->status);
				$arr = [
					'consulta' => $consulta,
					'pedido' => $pedido
				];
				return response()->json($arr, 200);

			}else if($consulta->original->status == '1' || $consulta->original->status == '2'){
				// aguardando pagamento
				$pedido = $this->incluiPedidoCartao($json, $referencia, $xml->code, $consulta->original->status);

				return response()->json($consulta, 402);

			}else{
				return response()->json($consulta, 404);
			}
		}

		return response()->json($xml, 403);
	}

	public function incluiPedidoCartaoApp($request, $referencia, $codigoTransacao, $status){
		$pedido = PedidoDelivery::
		where('id', $request->pedido)
		->where('estado', 'nv')
		->first();

		if($pedido){
			

			$total = 0;

			// foreach($pedido->itens as $i){

			// 	if(count($i->sabores) > 0){
			// 		$maiorValor = 0; 
			// 		foreach($i->sabores as $it){
			// 			$v = $it->maiorValor($it->produto->id, $i->tamanho_id);
			// 			if($v > $maiorValor) $maiorValor = $v;
			// 		}
			// 		$total += $maiorValor * $i->quantidade;
			// 	}else{
			// 		$total += ($i->produto->valor * $i->quantidade);
			// 	}

			// 	foreach($i->itensAdicionais as $a){
			// 		$total += $a->adicional->valor * $i->quantidade;
			// 	}
			// }

			// if($request->desconto){
			// 	$total -= str_replace(",", ".", $request->desconto);
			// }

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
			$pedido->valor_total = $request->total;
			$pedido->telefone = $request->telefone ?? '';
			$pedido->troco_para = $request->troco ?? 0;
			$pedido->data_registro = date('Y-m-d H:i:s');
			$pedido->cupom_id = $cupom;
			$pedido->desconto = $request->desconto;
			$pedido->app = true;

			$pedido->save();

			$pagseguro = PedidoPagSeguro::create(
				[
					'pedido_delivery_id' => $pedido->id,
					'numero_cartao' => $request->numero_cartao,
					'cpf' => $request->cpf,
					'nome_impresso' => $request->nome_cartao,
					'codigo_transacao' => $codigoTransacao,
					'referencia' => $referencia,
					'parcelas' => $request->parcelas,
					'bandeira' => $request->bandeira,
					'status' => $status
				]
			);
			$pedido->itens;
			return $pedido;
			
		}else{
			return response()->json(false, 404);
		}
	}

	public function cartoes(Request $request){

		$pedidos = PedidoDelivery::where('cliente_id', $request->cliente)
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
		if(sizeof($arr) > 0) return response()->json($arr, 200);
		else return response()->json(false, 401);

	}

}
