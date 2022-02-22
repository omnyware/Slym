<?php

namespace App\Http\Controllers\AppFiscal;

use Illuminate\Http\Request;
use App\VendaCaixa;
use App\ItemVendaCaixa;
use App\Produto;
use App\Helpers\StockMove;
use App\ListaPreco;
use App\ContaReceber;
use App\Services\NFCeService;
use NFePHP\DA\NFe\Danfce;
use Dompdf\Dompdf;
use NFePHP\DA\NFe\Cupom;
use App\ConfigNota;

class VendaCaixaController extends Controller
{

	public function index(Request $request){
		$vendas = VendaCaixa::orderBy('id', 'desc')
		->where('empresa_id', $request->empresa_id)
		->limit(50)->get();
		foreach($vendas as $v){
			foreach($v->itens as $i){
				$i->produto;
			}
			$v->cliente;
			$v->natureza;
		}
		return response()->json($vendas, 200);
	}

	public function ambiente(Request $request){
		$config = ConfigNota::where('empresa_id', $request->empresa_id)->first();
		if($config != null){
			return response()->json($config->ambiente, 200);
		}else{
			return response()->json('erro', 401);
		}
	}

	public function filtroVendas(Request $request){
		$dataInicial = $request->data_inicio;
		$dataFinal = $request->data_final;
		$estado = $request->estado ? $request->estado : 'TODOS';

		if(isset($dataInicial) && isset($dataFinal)){
			$vendas = VendaCaixa::filtroDataApp(
				$this->parseDate($dataInicial),
				$this->parseDate($dataFinal, true),
				$request->empresa_id
			);
		}else if(isset($estado)){
			$vendas = VendaCaixa::filtroEstadoApp(
				$estado,
				$request->empresa_id
			);
		}

		// $vendas = Venda::orderBy('id', 'desc')->get();
		foreach($vendas as $v){
			foreach($v->itens as $i){
				$i->produto;
			}
			$v->cliente;
			$v->natureza;
		}
		return response()->json($vendas, 200);
	}

	private function itetable($array){
		$temp = [];
		foreach($array as $key => $a){
			$t = [
				'cod' => $key,
				'value' => $a
			];
			array_push($temp, $t);
		}
		return $temp;
	}

	public function getVenda($id){
		$venda = VendaCaixa::find($id);
		$venda->cliente;
		$venda->natureza;
		// $venda->itens;
		foreach($venda->itens as $i){
			$i->produto;
		}
		return response()->json($venda, 200);
	}

	public function salvar(Request $request){
		try{
			$config = ConfigNota::first();

			$arrVenda = [
				'cliente_id' => null,
				'usuario_id' => $request->usuario_id,
				'valor_total' => $request->total,
				'NFcNumero' => 0,
				'natureza_id' => $config->nat_op_padrao,
				'chave' => '',
				'path_xml' => '',
				'estado' => 'DISPONIVEL',
				'tipo_pagamento' => $request->tipoPagamento,
				'forma_pagamento' => $request->formaPagamento,
				'dinheiro_recebido' => $request->valor_recebido,
				'troco' => $request->troco,
				'nome' => '',
				'cpf' => $request->cpf ?? '',
				'observacao' => $request->observacao ?? '',
				'desconto' => $request->desconto,
				'acrescimo' => 0,
				'pedido_delivery_id' => 0,
				'empresa_id' => $request->empresa_id
			];

			$result = VendaCaixa::create($arrVenda);

			$itens = $request->itens;
			$stockMove = new StockMove();
			foreach ($itens as $i) {
				$t = [
					'venda_caixa_id' => $result->id,
					'produto_id' => (int) $i['item_id'],
					'quantidade' => (float) str_replace(",", ".", $i['quantidade']),
					'valor' => (float) str_replace(",", ".", $i['valor']),
					'item_pedido_id' => null, 
					'observacao' => ''
				];
				ItemVendaCaixa::create([
					'venda_caixa_id' => $result->id,
					'produto_id' => (int) $i['item_id'],
					'quantidade' => (float) str_replace(",", ".", $i['quantidade']),
					'valor' => (float) str_replace(",", ".", $i['valor']),
					'item_pedido_id' => null, 
					'observacao' => ''
				]);

				$prod = Produto
				::where('id', $i['item_id'])
				->first();

				if(!empty($prod->receita)){
				//baixa por receita
					$receita = $prod->receita; 
					foreach($receita->itens as $rec){


						if(!empty($rec->produto->receita)){ 

							$receita2 = $rec->produto->receita; 

							foreach($receita2->itens as $rec2){
								$stockMove->downStock(
									$rec2->produto_id, 
									(float) str_replace(",", ".", $i['quantidade']) * 
									($rec2->quantidade/$receita2->rendimento)
								);
							}
						}else{

							$stockMove->downStock(
								$rec->produto_id, 
								(float) str_replace(",", ".", $i['quantidade']) * 
								($rec->quantidade/$receita->rendimento)
							);
						}
					}
				}else{
					$stockMove->downStock(
						(int) $i['item_id'], (float) str_replace(",", ".", $i['quantidade']));
				}
			}

			return response()->json($result->id, 200);

		}catch(\Exception $e){
			return response()->json($e->getMessage(), 403);
		}
	}

	private function parseDate($date, $plusDay = false){
		if($plusDay == false)
			return date('Y-m-d', strtotime(str_replace("/", "-", $date)));
		else
			return date('Y-m-d', strtotime("+1 day",strtotime(str_replace("/", "-", $date))));
	}

	public function delete(Request $request){
		$venda = VendaCaixa::find($request->id);
		$delete = $venda->delete();
		return response()->json($delete, 200);
	}

	public function renderizarDanfe($id){

		$venda = VendaCaixa::find($id);

		$config = ConfigNota::where('empresa_id', $venda->empresa_id)->first();

		$cnpj = str_replace(".", "", $config->cnpj);
		$cnpj = str_replace("/", "", $cnpj);
		$cnpj = str_replace("-", "", $cnpj);
		$cnpj = str_replace(" ", "", $cnpj);

		$nfe_service = new NFCeService([
			"atualizacao" => date('Y-m-d h:i:s'),
			"tpAmb" => (int)$config->ambiente,
			"razaosocial" => $config->razao_social,
			"siglaUF" => $config->UF,
			"cnpj" => $cnpj,
			"schemes" => "PL_009_V4",
			"versao" => "4.00",
			"tokenIBPT" => "AAAAAAA",
			"CSC" => $config->csc,
			"CSCid" => $config->csc_id
		], $venda->empresa_id);


		$nfe = $nfe_service->gerarNFCe($id);

		$xml = $nfe['xml'];
		$signed = $nfe_service->sign($xml);
		$public = getenv('SERVIDOR_WEB') ? 'public/' : '';

		try {
			$danfce = new Danfce($signed);
			$danfce->monta($logo);
			$pdf = $danfce->render();
			header('Content-Type: application/pdf');
			return response($pdf)
			->header('Content-Type', 'application/pdf');
		} catch (InvalidArgumentException $e) {
			return response()->json("erro", 401);
			echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
		}  
	}

	public function cupomNaoFiscal($id){
		$venda = VendaCaixa::
		where('id', $id)
		->first();
		$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
		$pathLogo = $public.'imgs/logo.jpg';

		$cupom = new Cupom($venda, $pathLogo);
		$cupom->monta();
		$pdf = $cupom->render();

		return response($pdf)
		->header('Content-Type', 'application/pdf');
	}



}