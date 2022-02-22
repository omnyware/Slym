<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use App\Venda;
use App\VendaCaixa;
use App\ComplementoDelivery;
use App\TamanhoPizza;
use App\ProdutoPizza;
class ProdutoRestController extends Controller
{
    //App

	public function pesquisa(Request $request){
		$pesquisa = $request->input('pesquisa');
		$produtos = Produto::where('nome', 'LIKE', "%$pesquisa%")->get();
		foreach($produtos as $p){
			$p->categoria;
		}
		return response()->json($produtos, 200);
	}

	public function maisPedidos(){
		$produtos = $this->maisVendido();
		$temp = [];
		foreach($produtos as $key => $p){
			$produto = Produto::where('id', $key)->first();
			$produto->categoria;
			if(count($temp) < 2){
				array_push($temp, $produto);
			}
		}

		return response()->json($temp, 200);
	}

	public function adicionais(){
		$adicionais = ComplementoDelivery::all();
		return response()->json($adicionais, 200);
	}

	public function tamanhosPizza(){
		$tamanhos = TamanhoPizza::all();
		return response()->json($tamanhos, 200);
	}

	public function saboresPorTamanho(Request $request){

		$tamanho = TamanhoPizza::
		where('id', $request->tamanho)
		->first();

		$sabores = $tamanho->produtoPizza;
		$temp = [];
		foreach($sabores as $s){
			$s->produto->produto;
			$s->maximo_sabores = $tamanho->maximo_sabores;
			if($request->saborPrincipal != $s->produto->produto->id){
				array_push($temp, $s);
			}
		}

		return response()->json($temp, 200);
		
	}

	public function dividePizza(){
		return response()->json((int)getenv("DIVISAO_VALOR_PIZZA"), 200);
	}

	public function pizzaValorPorTamanho(Request $request){
		$produto = Produto::
		where('id', $request->produto)
		->first();

		$p = ProdutoPizza::
		where('produto_id', $produto->delivery->id)
		->where('tamanho_id', $request->tamanho)
		->first();

		if($p != null) return response()->json($p->valor, 200);
		else return response()->json(0, 200);

	}

	private function maisVendido(){
		$vendas = Venda::limit(100)->get();
		$vendasCaixa = VendaCaixa::limit(100)->get();

		$temp = [];
		foreach($vendas as $v){
			foreach($v->itens as $i){
				if(isset($temp[$i->produto->id])){
					$temp[$i->produto->id] += $i->quantidade;
				}else{
					$temp[$i->produto->id] = $i->quantidade;
				}

			}
		}

		foreach($vendasCaixa as $v){
			foreach($v->itens as $i){
				if(isset($temp[$i->produto->id])){
					$temp[$i->produto->id] += $i->quantidade;
				}else{
					$temp[$i->produto->id] = $i->quantidade;
				}

			}
		}

		arsort($temp);
		
		return $temp;
	}



}
