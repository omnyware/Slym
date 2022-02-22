<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venda;
use App\ItemVenda;
use App\ItemCompra;
use App\VendaCaixa;
use App\ItemVendaCaixa;
use App\Compra;
use App\Estoque;
use App\Produto;
use App\Funcionario;
use App\ComissaoVenda;
use Dompdf\Dompdf;

class RelatorioController extends Controller
{
	protected $empresa_id = null;
	public function __construct(){
		$this->middleware(function ($request, $next) {
			$this->empresa_id = $request->empresa_id;
			$value = session('user_logged');
			if(!$value){
				return redirect("/login");
			}
			return $next($request);
		});
	}

	public function index(){
		$produtos = Produto::
		where('empresa_id', $this->empresa_id)
		->get();

		$funcionarios = Funcionario::
		where('empresa_id', $this->empresa_id)
		->get();

		return view('relatorios/index')
		->with('relatorioJS', true)
		->with('produtos', $produtos)
		->with('funcionarios', $funcionarios)
		->with('title', 'Relatórios');
	}

	public function filtroVendas(Request $request){
		$data_inicial = $request->data_inicial;
		$data_final = $request->data_final;
		$total_resultados = $request->total_resultados;
		$ordem = $request->ordem;

		if($data_final && $data_final){
			$data_inicial = $this->parseDate($data_inicial);
			$data_final = $this->parseDate($data_final, true);
		}

		$vendas = Venda
		::select(\DB::raw('DATE_FORMAT(vendas.data_registro, "%d-%m-%Y") as data, sum(vendas.valor_total) as total'))

		->orWhere(function($q) use ($data_inicial, $data_final){
			if($data_inicial && $data_final){
				return $q->whereBetween('vendas.data_registro', [$data_inicial, 
					$data_final]);
			}
		})
		->where('vendas.empresa_id', $this->empresa_id)
		->groupBy('data')
		->orderBy($ordem == 'data' ? 'data' : 'total', $ordem == 'data' ? 'desc' : $ordem)


		->limit($total_resultados ?? 1000000)
		->get();

		$vendasCaixa = VendaCaixa
		::select(\DB::raw('DATE_FORMAT(venda_caixas.data_registro, "%d-%m-%Y") as data, sum(venda_caixas.valor_total) as total'))

		->orWhere(function($q) use ($data_inicial, $data_final){
			if($data_inicial && $data_final){
				return $q->whereBetween('venda_caixas.data_registro', [$data_inicial, 
					$data_final]);
			}
		})
		->where('venda_caixas.empresa_id', $this->empresa_id)
		->groupBy('data')
		->orderBy($ordem == 'data' ? 'data' : 'total', $ordem == 'data' ? 'desc' : $ordem)
		->limit($total_resultados ?? 1000000)
		->get();

		$arr = $this->uneArrayVendas($vendas, $vendasCaixa);
		if($total_resultados){
			$arr = array_slice($arr, 0, $total_resultados);
		}
		usort($arr, function($a, $b) use ($ordem){
			if($ordem == 'asc') return $a['total'] > $b['total'];
			else if($ordem == 'desc') return $a['total'] < $b['total'];
			else return $a['data'] < $b['data'];
		});

		if(sizeof($arr) == 0){

			session()->flash("mensagem_erro", "Relatório sem registro!");
			return redirect('/relatorios');
		}

		$p = view('relatorios/relatorio_venda')
		->with('ordem', $ordem == 'asc' ? 'Menos' : 'Mais')

		->with('data_inicial', $request->data_inicial)
		->with('data_final', $request->data_final)
		->with('vendas', $arr);

		// return $p;

		$domPdf = new Dompdf(["enable_remote" => true]);
		$domPdf->loadHtml($p);

		$pdf = ob_get_clean();

		$domPdf->setPaper("A4");
		$domPdf->render();
		$domPdf->stream("relatorio_venda.pdf");
	}

	public function filtroCompras(Request $request){
		$data_inicial = $request->data_inicial;
		$data_final = $request->data_final;
		$total_resultados = $request->total_resultados;
		$ordem = $request->ordem;

		if($data_final && $data_final){
			$data_inicial = $this->parseDate($data_inicial);
			$data_final = $this->parseDate($data_final, true);
		}

		$compras = Compra
		::select(\DB::raw('DATE_FORMAT(compras.created_at, "%d-%m-%Y") as data, sum(compras.valor) as total,
			count(id) as compras_diarias'))
		// ->join('item_compras', 'item_compras.compra_id', '=', 'item_compras.id')
		->orWhere(function($q) use ($data_inicial, $data_final){
			if($data_final && $data_final){
				return $q->whereBetween('compras.created_at', [$data_inicial, 
					$data_final]);
			}
		})
		->where('empresa_id', $this->empresa_id)
		->groupBy('data')
		->orderBy('total', $ordem)

		->limit($total_resultados ?? 1000000)
		->get();

		if(sizeof($compras) == 0){

			session()->flash("mensagem_erro", "Relatório sem registro!");
			return redirect('/relatorios');
		}

		$p = view('relatorios/relatorio_compra')
		->with('data_inicial', $request->data_inicial)
		->with('data_final', $request->data_final)
		->with('compras', $compras);

		$domPdf = new Dompdf(["enable_remote" => true]);
		$domPdf->loadHtml($p);

		$pdf = ob_get_clean();

		$domPdf->setPaper("A4");
		$domPdf->render();
		$domPdf->stream("relatorio de compras.pdf");
	}

	public function filtroVendaProdutos(Request $request){
		$data_inicial = $request->data_inicial;
		$data_final = $request->data_final;
		$total_resultados = $request->total_resultados;
		$ordem = $request->ordem;

		if($data_final && $data_final){
			$data_inicial = $this->parseDate($data_inicial);
			$data_final = $this->parseDate($data_final, true);
		}

		$itensVenda = ItemVenda
		::select(\DB::raw('produtos.id as id, produtos.nome as nome, produtos.valor_venda as valor_venda, sum(item_vendas.quantidade) as total, sum(item_vendas.quantidade * item_vendas.valor) as total_dinheiro'))
		->join('produtos', 'produtos.id', '=', 'item_vendas.produto_id')
		->orWhere(function($q) use ($data_inicial, $data_final){
			if($data_final && $data_final){
				return $q->whereBetween('item_vendas.created_at', [$data_inicial, 
					$data_final]);
			}
		})
		->where('produtos.empresa_id', $this->empresa_id)
		->groupBy('produtos.id')
		->orderBy('total', $ordem)

		// ->limit($total_resultados ?? 1000000)
		->get();



		$itensVendaCaixa = ItemVendaCaixa
		::select(\DB::raw('produtos.id as id, produtos.nome as nome, produtos.valor_venda as valor_venda, sum(item_venda_caixas.quantidade) as total, sum(item_venda_caixas.quantidade * item_venda_caixas.valor) as total_dinheiro'))
		->join('produtos', 'produtos.id', '=', 'item_venda_caixas.produto_id')
		->orWhere(function($q) use ($data_inicial, $data_final){
			if($data_final && $data_final){
				return $q->whereBetween('item_venda_caixas.created_at', [$data_inicial, 
					$data_final]);
			}
		})
		->where('produtos.empresa_id', $this->empresa_id)
		->groupBy('produtos.id')
		->orderBy('total', $ordem)

		// ->limit($total_resultados ?? 1000000)
		->get();

		$arr = $this->uneArrayProdutos($itensVenda, $itensVendaCaixa);

		if(sizeof($arr) == 0){

			session()->flash("mensagem_erro", "Relatório sem registro!");
			return redirect('/relatorios');
		}

		if($total_resultados){
			$arr = array_slice($arr, 0, $total_resultados);
		}

		usort($arr, function($a, $b) use ($ordem){
			if($ordem == 'asc') return $a['total'] > $b['total'];
			else return $a['total'] < $b['total'];
		});
		$p = view('relatorios/relatorio_venda_produtos')
		->with('ordem', $ordem == 'asc' ? 'Menos' : 'Mais')
		->with('data_inicial', $request->data_inicial)
		->with('data_final', $request->data_final)
		->with('itens', $arr);

		// return $p;	

		$domPdf = new Dompdf(["enable_remote" => true]);
		$domPdf->loadHtml($p);

		$pdf = ob_get_clean();

		$domPdf->setPaper("A4");
		$domPdf->render();
		$domPdf->stream("relatorio de produtos.pdf");
	}


	public function filtroVendaClientes(Request $request){
		$data_inicial = $request->data_inicial;
		$data_final = $request->data_final;
		$total_resultados = $request->total_resultados;
		$ordem = $request->ordem;

		if($data_final && $data_final){
			$data_inicial = $this->parseDate($data_inicial);
			$data_final = $this->parseDate($data_final, true);
		}

		$vendas = Venda
		::select(\DB::raw('clientes.id as id, clientes.razao_social as nome, count(*) as total, sum(valor_total) as total_dinheiro'))
		->join('clientes', 'clientes.id', '=', 'vendas.cliente_id')
		->orWhere(function($q) use ($data_inicial, $data_final){
			if($data_final && $data_final){
				return $q->whereBetween('vendas.data_registro', [$data_inicial, 
					$data_final]);
			}
		})
		->where('vendas.empresa_id', $this->empresa_id)
		->groupBy('clientes.id')
		->orderBy('total', $ordem)

		->limit($total_resultados ?? 1000000)
		->get();

		if(sizeof($vendas) == 0){

			session()->flash("mensagem_erro", "Relatório sem registro!");
			return redirect('/relatorios');
		}


		$p = view('relatorios/relatorio_clientes')
		->with('ordem', $ordem == 'asc' ? 'Menos' : 'Mais')
		->with('data_inicial', $request->data_inicial)
		->with('data_final', $request->data_final)
		->with('vendas', $vendas);

		// return $p;



		$domPdf = new Dompdf(["enable_remote" => true]);
		$domPdf->loadHtml($p);

		$pdf = ob_get_clean();

		$domPdf->setPaper("A4", "landscape");
		$domPdf->render();
		$domPdf->stream("relatorio de compras.pdf");
	}

	public function filtroEstoqueMinimo(Request $request){
		$data_inicial = $request->data_inicial;
		$data_final = $request->data_final;
		$total_resultados = $request->total_resultados;
		$ordem = $request->ordem;
		
		if($data_final && $data_final){
			$data_inicial = $this->parseDate($data_inicial);
			$data_final = $this->parseDate($data_final, true);
		}

		$produtos = Produto::
		where('empresa_id', $this->empresa_id)
		->get();
		$arrDesfalque = [];
		foreach($produtos as $p){
			if($p->estoque_minimo > 0){
				$estoque = Estoque::where('produto_id', $p->id)->first();
				$temp = null;
				if($estoque == null){
					$temp = [
						'id' => $p->id,
						'nome' => $p->nome,
						'estoque_minimo' => $p->estoque_minimo,
						'estoque_atual' => 0,
						'total_comprar' => $p->estoque_minimo,
						'valor_compra' => 0
					];
				}else{
					$temp = [
						'id' => $p->id,
						'nome' => $p->nome,
						'estoque_minimo' => $p->estoque_minimo,
						'estoque_atual' => $estoque->quantidade,
						'total_comprar' => $p->estoque_minimo - $estoque->quantidade,
						'valor_compra' => $estoque->valor_compra
					];
				}

				array_push($arrDesfalque, $temp);

			}
		}

		if($total_resultados){
			$arrDesfalque = array_slice($arrDesfalque, 0, $total_resultados);
		}

		// print_r($arrDesfalque);

		$p = view('relatorios/relatorio_estoque_minimo')
		->with('ordem', $ordem == 'asc' ? 'Menos' : 'Mais')
		->with('data_inicial', $request->data_inicial)
		->with('data_final', $request->data_final)
		->with('itens', $arrDesfalque);

		// return $p;

		$domPdf = new Dompdf(["enable_remote" => true]);
		$domPdf->loadHtml($p);

		$pdf = ob_get_clean();

		$domPdf->setPaper("A4", "landscape");
		$domPdf->render();
		$domPdf->stream("relatorio de estoque minimo.pdf");
	}

	public function filtroVendaDiaria(Request $request){
		$data = $request->data_inicial;
		$total_resultados = $request->total_resultados;
		$ordem = $request->ordem;

		$data_inicial = null;
		$data_final = null;

		if(strlen($data) == 0){
			session()->flash("mensagem_erro", "Informe o dia para gerar o relatório!");
			return redirect('/relatorios');
		}else{
			$data_inicial = $this->parseDateDay($data);
			$data_final = $this->parseDateDay($data, true);
		}

		$vendas = Venda
		::select(\DB::raw('vendas.id, DATE_FORMAT(vendas.data_registro, "%d-%m-%Y %H:%i") as data, valor_total'))
		->join('item_vendas', 'item_vendas.venda_id', '=', 'vendas.id')
		->orWhere(function($q) use ($data_inicial, $data_final){
			if($data_final && $data_final){
				return $q->whereBetween('vendas.created_at', [$data_inicial, 
					$data_final]);
			}
		})
		->where('vendas.empresa_id', $this->empresa_id)
		->groupBy('vendas.id')

		->limit($total_resultados ?? 1000000)
		->get();

		$vendasCaixa = VendaCaixa
		::select(\DB::raw('venda_caixas.id, DATE_FORMAT(venda_caixas.data_registro, "%d-%m-%Y %H:%i") as data, valor_total'))
		->join('item_venda_caixas', 'item_venda_caixas.venda_caixa_id', '=', 'venda_caixas.id')

		->orWhere(function($q) use ($data_inicial, $data_final){
			if($data_final && $data_final){
				return $q->whereBetween('venda_caixas.created_at', [$data_inicial, 
					$data_final]);
			}
		})
		->where('venda_caixas.empresa_id', $this->empresa_id)
		->groupBy('venda_caixas.id')
		->limit($total_resultados ?? 1000000)
		->get();


		$arr = $this->uneArrayVendasDay($vendas, $vendasCaixa);
		if($total_resultados){
			$arr = array_slice($arr, 0, $total_resultados);
		}

		// usort($arr, function($a, $b) use ($ordem){
		// 	if($ordem == 'asc') return $a['total'] > $b['total'];
		// 	else if($ordem == 'desc') return $a['total'] < $b['total'];
		// 	else return $a['data'] < $b['data'];
		// });

		if(sizeof($arr) == 0){

			session()->flash("mensagem_erro", "Relatório sem registro!");
			return redirect('/relatorios');
		}

		$p = view('relatorios/relatorio_diario')
		->with('ordem', $ordem == 'asc' ? 'Menos' : 'Mais')

		->with('data_inicial', $request->data_inicial)
		->with('data_final', $request->data_final)
		->with('vendas', $arr);

		// return $p;

		$domPdf = new Dompdf(["enable_remote" => true]);
		$domPdf->loadHtml($p);

		$pdf = ob_get_clean();

		$domPdf->setPaper("A4");
		$domPdf->render();
		$domPdf->stream("relatorio de vendas.pdf");
	}

	private function uneArrayVendas($vendas, $vendasCaixa){
		$adicionados = [];
		$arr = [];

		foreach($vendas as $v){

			$temp = [
				'data' => $v->data,
				'total' => $v->total,
				// 'itens' => $v->itens
			];
			array_push($adicionados, $v->data);
			array_push($arr, $temp);
			
		}

		foreach($vendasCaixa as $v){


			if(!in_array($v->data, $adicionados)){


				$temp = [
					'data' => $v->data,
					'total' => $v->total,
					// 'itens' => $v->itens
				];
				array_push($adicionados, $v->data);
				array_push($arr, $temp);
			}else{
				for($aux = 0; $aux < count($arr); $aux++){
					if($arr[$aux]['data'] == $v->data){
						$arr[$aux]['total'] += $v->total;
						// $arr[$aux]['itens'] += $i->itens;
					}
				}
			}

		}
		return $arr;
	}

	private function uneArrayVendasDay($vendas, $vendasCaixa){
		$adicionados = [];
		$arr = [];

		foreach($vendas as $v){

			$temp = [
				'id' => $v->id,
				'data' => $v->data,
				'total' => $v->valor_total,
				'itens' => $v->itens
			];
			array_push($adicionados, $v->data);
			array_push($arr, $temp);
			
		}

		foreach($vendasCaixa as $v){

			$temp = [
				'id' => $v->id,
				'data' => $v->data,
				'total' => $v->valor_total,
				'itens' => $v->itens
			];

			array_push($adicionados, $v->data);
			array_push($arr, $temp);
			
		}
		return $arr;
	}

	private function uneArrayProdutos($itemVenda, $itemVendasCaixa){
		$adicionados = [];
		$arr = [];

		foreach($itemVenda as $i){

			$temp = [
				'id' => $i->id,
				'nome' => $i->nome,
				'valor_venda' => $i->valor_venda,
				'total' => $i->total,
				'total_dinheiro' => $i->total_dinheiro,
			];
			array_push($adicionados, $i->id);
			array_push($arr, $temp);
			
		}

		foreach($itemVendasCaixa as $i){
			if(!in_array($i->id, $adicionados)){
				$temp = [
					'id' => $i->id,
					'nome' => $i->nome,
					'valor_venda' => $i->valor_venda,
					'total' => $i->total,
					'total_dinheiro' => $i->total_dinheiro,
				];
				array_push($adicionados, $i->id);
				array_push($arr, $temp);
			}else{
				for($aux = 0; $aux < count($arr); $aux++){
					if($arr[$aux]['id'] == $i->id){
						$arr[$aux]['total'] += $i->total;
						$arr[$aux]['total_dinheiro'] += $i->total;
					}
				}
			}
		}

		return $arr;
	}

	private static function parseDate($date, $plusDay = false){
		if($plusDay == false)
			return date('Y-m-d', strtotime(str_replace("/", "-", $date)));
		else
			return date('Y-m-d', strtotime("+1 day",strtotime(str_replace("/", "-", $date))));
	}

	private static function parseDateDay($date, $plusDay = false){
		if($plusDay == false)
			return date('Y-m-d', strtotime(str_replace("/", "-", $date))) . " 00:00";
		else
			return date('Y-m-d', strtotime(str_replace("/", "-", $date))) . " 23:59";

	}



	public function filtroLucro(Request $request){
		$data_inicial = $request->data_inicial;
		$data_final = $request->data_final;
		$tipo = $request->tipo;

		if($tipo == 'detalhado'){
			if(!$data_inicial){
				session()->flash("mensagem_erro", "Informe a data para gerar o relatório!");
				return redirect('/relatorios');
			}

			$data_inicial = $this->parseDate($data_inicial);
			$data_final = $this->parseDate($data_inicial, true);

			$vendas = Venda
			::whereBetween('vendas.created_at', [$data_inicial, 
				$data_final])
			->where('empresa_id', $this->empresa_id)
			->groupBy('created_at')
			->get();

			$vendasCaixa = VendaCaixa
			::whereBetween('venda_caixas.created_at', [$data_inicial, 
				$data_final])
			->where('empresa_id', $this->empresa_id)
			->groupBy('created_at')
			->get();


			$arr = [];
			foreach($vendas as $v){
				$total = $v->valor_total;
				$somaValorCompra = 0;
				foreach($v->itens as $i){
				//pega valor de compra
					$vCompra = 0;
					$vCompra = $i->produto->valor_compra;
					if(!$vCompra == 0){
						$estoque = Estoque::ultimoValorCompra($i->produto_id);

						if($estoque != null){
							$vCompra = $estoque->valor_compra;
						}
					}

					$somaValorCompra = $i->quantidade * $vCompra;
				}

				$lucro = $total - $somaValorCompra;
				if($somaValorCompra == 0){
					$somaValorCompra = 1;
				}
				$temp = [
					'valor_venda' => $total,
					'valor_compra' => $somaValorCompra,
					'lucro' => $lucro,
					'lucro_percentual' => 
					number_format((($somaValorCompra - $total)/$somaValorCompra*100)*-1, 2),
					'local' => 'NF-e',
					'cliente' => $v->cliente->razao_social,
					'horario' => \Carbon\Carbon::parse($v->created_at)->format('H:i')
				];
				array_push($arr, $temp);

			}

			foreach($vendasCaixa as $v){
				$total = $v->valor_total;
				$somaValorCompra = 0;
				foreach($v->itens as $i){
				//pega valor de compra
					$vCompra = 0;
					$vCompra = $i->produto->valor_compra;
					if(!$vCompra == 0){
						$estoque = Estoque::ultimoValorCompra($i->produto_id);

						if($estoque != null){
							$vCompra = $estoque->valor_compra;
						}
					}

					$somaValorCompra = $i->quantidade * $vCompra;
				}

				$lucro = $total - $somaValorCompra;

				if($somaValorCompra == 0){
					$somaValorCompra = 1;
				}

				$temp = [
					'valor_venda' => $total,
					'valor_compra' => $somaValorCompra,
					'lucro' => $lucro,
					'lucro_percentual' => 
					number_format((($somaValorCompra - $total)/$somaValorCompra*100)*-1, 2),
					'local' => 'PDV',
					'cliente' => $v->cliente ? $v->cliente->razao_social : 'Cliente padrão',
					'horario' => \Carbon\Carbon::parse($v->created_at)->format('H:i')
				];
				array_push($arr, $temp);


			}

			if(sizeof($arr) == 0){

				session()->flash("mensagem_erro", "Relatório sem registro!");
				return redirect('/relatorios');
			}


			$p = view('relatorios/lucro_detalhado')
			->with('data_inicial', $request->data_inicial)
			->with('lucros', $arr);

			// return $p;

			$domPdf = new Dompdf(["enable_remote" => true]);
			$domPdf->loadHtml($p);

			$pdf = ob_get_clean();

			$domPdf->setPaper("A4");
			$domPdf->set_paper('letter', 'landscape');
			$domPdf->render();
			$domPdf->stream("relatorio de lucro detalhado.pdf");



		}else{

			if($data_final && $data_final){
				$data_inicial = $this->parseDate($data_inicial);
				$data_final = $this->parseDate($data_final, true);
			}
			if(!$data_inicial || !$data_final){
				session()->flash("mensagem_erro", "Informe o periodo corretamente para gerar o relatório!");
				return redirect('/relatorios');

			}

			$vendas = Venda
			::whereBetween('vendas.created_at', [$data_inicial, 
				$data_final])
			->where('empresa_id', $this->empresa_id)
			->groupBy('created_at')
			->get();

			$vendasCaixa = VendaCaixa
			::whereBetween('venda_caixas.created_at', [$data_inicial, 
				$data_final])
			->where('empresa_id', $this->empresa_id)
			->groupBy('created_at')
			->get();


			$tempVenda = [];
			foreach($vendas as $v){
				$total = $v->valor_total;
				$somaValorCompra = 0;
				foreach($v->itens as $i){
				//pega valor de compra
					$vCompra = 0;
					$vCompra = $i->produto->valor_compra;
					if(!$vCompra == 0){
						$estoque = Estoque::ultimoValorCompra($i->produto_id);

						if($estoque != null){
							$vCompra = $estoque->valor_compra;
						}
					}

					$somaValorCompra = $i->quantidade * $vCompra;
				}

				$lucro = $total - $somaValorCompra;

				if(!isset($tempVenda[\Carbon\Carbon::parse($v->created_at)->format('d/m/Y')])){
					$tempVenda[\Carbon\Carbon::parse($v->created_at)->format('d/m/Y')] = $lucro;
				}else{
					$tempVenda[\Carbon\Carbon::parse($v->created_at)->format('d/m/Y')] += $lucro;
				}

			}

			$tempCaixa = [];
			foreach($vendasCaixa as $v){
				$total = $v->valor_total;
				$somaValorCompra = 0;
				foreach($v->itens as $i){
				//pega valor de compra
					$vCompra = 0;
					$vCompra = $i->produto->valor_compra;
					if(!$vCompra == 0){
						$estoque = Estoque::ultimoValorCompra($i->produto_id);

						if($estoque != null){
							$vCompra = $estoque->valor_compra;
						}
					}

					$somaValorCompra = $i->quantidade * $vCompra;
				}

				$lucro = $total - $somaValorCompra;

				if(!isset($tempCaixa[\Carbon\Carbon::parse($v->created_at)->format('d/m/Y')])){
					$tempCaixa[\Carbon\Carbon::parse($v->created_at)->format('d/m/Y')] = $lucro;
				}else{
					$tempCaixa[\Carbon\Carbon::parse($v->created_at)->format('d/m/Y')] += $lucro;
				}

			}

			// print_r($tempVenda);
			// print_r($tempCaixa);

			$arr = $this->criarArrayDeDatas($data_inicial, $data_final, $tempVenda, $tempCaixa);


			$p = view('relatorios/lucro')
			->with('data_inicial', $request->data_inicial)
			->with('data_final', $request->data_final)
			->with('lucros', $arr);

			// return $p;

			$domPdf = new Dompdf(["enable_remote" => true]);
			$domPdf->loadHtml($p);

			$pdf = ob_get_clean();

			$domPdf->setPaper("A4");
			$domPdf->render();
			$domPdf->stream("relatorio de lucro.pdf");
		}
	}

	private function gerarLucroDetalhado(){

	}

	private function criarArrayDeDatas($inicio, $fim, $tempVenda, $tempCaixa){
		$diferenca = strtotime($fim) - strtotime($inicio);
		$dias = floor($diferenca / (60 * 60 * 24));
		$global = [];
		$dataAtual = $inicio;
		for($aux = 0; $aux < $dias+1; $aux++){
			// echo \Carbon\Carbon::parse($dataAtual)->format('d/m/Y');


			$rs['data'] = $this->parseViewData($dataAtual);
			if(isset($tempCaixa[\Carbon\Carbon::parse($dataAtual)->format('d/m/Y')])){
				$rs['valor_caixa'] = $tempCaixa[\Carbon\Carbon::parse($dataAtual)->format('d/m/Y')];
			}else{
				$rs['valor_caixa'] = 0;
			}
			if(isset($tempVenda[\Carbon\Carbon::parse($dataAtual)->format('d/m/Y')])){
				$rs['valor'] = $tempVenda[\Carbon\Carbon::parse($dataAtual)->format('d/m/Y')];
			}else{
				$rs['valor'] = 0;
			}

			array_push($global, $rs);


			$dataAtual = date('Y-m-d', strtotime($dataAtual. '+1day'));
		}


		return $global;
	}

	private function parseViewData($date){
		return date('d/m/Y', strtotime(str_replace("/", "-", $date)));
	}

	public function estoqueProduto(Request $request){
		$ordem = $request->ordem;
		$total_resultados = $request->total_resultados;

		$produtos = Produto
		::select(\DB::raw('produtos.id, produtos.referencia, produtos.estoque_minimo, produtos.nome, produtos.unidade_venda, estoques.quantidade, produtos.valor_venda'))
		->join('estoques', 'produtos.id', '=', 'estoques.produto_id')
		->limit($total_resultados ?? 1000000)
		->where('produtos.empresa_id', $this->empresa_id)
		->orderBy('produtos.nome');


		if($ordem == 'qtd'){
		// ->orderBy('total', $ordem)
			$produtos = $produtos->orderBy('estoques.quantidade', 'desc');
		}

		$produtos = $produtos->get();

		foreach($produtos as $p){
			$item = ItemCompra::
			where('produto_id', $p->id)
			->orderBy('id', 'desc')
			->first();
			if($item != null){
				$p->data_ultima_compra = \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:m');
			}else{
				$p->data_ultima_compra = '--';
			}
		}

		// echo $produtos;
		// die();


		$p = view('relatorios/relatorio_estoque')
		->with('ordem', $ordem == 'asc' ? 'Menos' : 'Mais')
		->with('produtos', $produtos);

		// return $p;

		$domPdf = new Dompdf(["enable_remote" => true]);
		$domPdf->loadHtml($p);

		$pdf = ob_get_clean();

		$domPdf->setPaper("A4", "landscape");
		$domPdf->render();
		$domPdf->stream("relatorio de estoque.pdf");
	}

	public function comissaoVendas(Request $request){
		$data_inicial = $request->data_inicial;
		$data_final = $request->data_final;
		$funcionario = $request->funcionario;
		$produto = $request->produto;

		$comissoes = ComissaoVenda
		::select(\DB::raw('comissao_vendas.created_at, comissao_vendas.venda_id, comissao_vendas.valor, funcionarios.nome as funcionario'))
		->where('funcionarios.empresa_id', $this->empresa_id)
		->join('funcionarios', 'funcionarios.id', '=', 'comissao_vendas.funcionario_id');
		if($data_final && $data_final){
			$data_inicial = $this->parseDate($data_inicial);
			$data_final = $this->parseDate($data_final, true);

			$comissoes
			->whereBetween('comissao_vendas.created_at', [$data_inicial, 
				$data_final]);
		}

		if($funcionario != 'null'){
			$comissoes = $comissoes->where('funcionario_id', $funcionario);
			$funcionario = Funcionario::find($funcionario)->nome;
		}

		$comissoes = $comissoes->get();

		$temp = [];
		foreach($comissoes as $c){
			$c->valor_total_venda = $this->getValorDaVenda($c);;

			if($produto != 'null'){
				// echo $c;
				$res = $this->getVenda($c, $produto);
				if($res){
					array_push($temp, $c);
				}
			}else{
				array_push($temp, $c);
			}
		}

		if($produto != 'null'){
			$produto = Produto::find($produto)->nome;
		}


		$p = view('relatorios/relatorio_comissao')
		->with('funcionario', $funcionario)
		->with('produto', $produto)
		->with('data_inicial', $request->data_inicial)
		->with('data_final', $request->data_final)
		->with('comissoes', $comissoes);

		// return $p;

		$domPdf = new Dompdf(["enable_remote" => true]);
		$domPdf->loadHtml($p);

		$pdf = ob_get_clean();

		$domPdf->setPaper("A4", "landscape");
		$domPdf->render();
		$domPdf->stream("relatorio de comissão.pdf");

		// ->join('vendas', 'vendas.id', '=', 'comissao_vendas.venda_id');

	}

	private function getValorDaVenda($comissao){
		$tipo = $comissao->tipo();
		$venda = null;
		if($tipo == 'PDV'){
			$venda = VendaCaixa::find($comissao->venda_id);
		}else{
			$venda = Venda::find($comissao->venda_id);
		}
		if($venda == null) return 0;
		return $venda->valor_total;
	}

	private function getVenda($comissao, $produto_id){
		$tipo = $comissao->tipo();
		if($tipo == 'PDV'){
			$venda = VendaCaixa::find($comissao->venda_id);
			foreach($venda->itens as $i){
				if($i->produto_id == $produto_id){
					return true;
				}
			}
			return false;
		}else{
			$venda = Venda::find($comissao->venda_id);
			foreach($venda->itens as $i){
				if($i->produto_id == $produto_id){
					return true;
				}
			}
			return false;
		}
	}
}
