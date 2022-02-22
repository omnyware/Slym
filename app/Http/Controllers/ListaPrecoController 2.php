<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ListaPreco;
use App\Produto;
use App\ProdutoListaPreco;

class ListaPrecoController extends Controller
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
		$lista = ListaPreco::
		where('empresa_id', $this->empresa_id)
		->get();

		return view('listaPreco/list')
		->with('lista', $lista)
		->with('title', 'Lista de Preços');
	}

	public function new(){
		return view('listaPreco/register')
		->with('title', 'Cadastrar Lista de Preço');
	}

	public function save(Request $request){
		$this->_validate($request);
        $request->merge([ 'percentual_alteracao' => $request->percentual_alteracao ? __replace($request->percentual_alteracao) : 0]);

		$result = ListaPreco::create($request->all());

		if($result){
			session()->flash("mensagem_sucesso", "Lista cadastrada com sucesso.");
		}else{
			session()->flash('mensagem_erro', 'Erro ao cadastrar lista.');
		}
		return redirect('/listaDePrecos');
	}

	public function edit($id){
		$lista = ListaPreco::find($id);
		if(valida_objeto($lista)){

			return view('listaPreco/register')
			->with('lista', $lista)
			->with('title', 'Cadastrar Lista de Preço');
		}else{
			return redirect('/403');
		}
	}

	public function update(Request $request){
		$this->_validate($request);

		$lista = ListaPreco::find($request->id);
		$lista->nome = $request->nome;
		$lista->percentual_alteracao = __replace($request->percentual_alteracao);

		if($lista->save()){
			session()->flash("mensagem_sucesso", "Lista atualizada com sucesso.");
		}else{
			session()->flash('mensagem_erro', 'Erro ao atualizar lista.');
		}
		return redirect('/listaDePrecos');
	}

	private function _validate(Request $request){
		$rules = [
			'nome' => 'required|max:40',
			'percentual_alteracao' => 'required',
		];

		$messages = [
			'nome.required' => 'O campo nome é obrigatório.',
			'nome.max' => '40 caracteres maximos permitidos.',
			'percentual_alteracao.required' => 'Campo obrigatório.'

		];
		$this->validate($request, $rules, $messages);
	}

	public function ver($id){

		$produtos = Produto::
		where('empresa_id', $this->empresa_id)
		->get();
		$lista = ListaPreco::find($id);
		if(valida_objeto($lista)){

			return view('listaPreco/ver')
			->with('lista', $lista)
			->with('produtos', $produtos)
			->with('title', 'Lista de Preço');
		}else{
			return redirect('/403');
		}
	}

	public function gerar($id){

		$produtos = Produto::
		where('empresa_id', $this->empresa_id)
		->get();
		$lista = ListaPreco::find($id);

		if(valida_objeto($lista)){

			foreach($produtos as $p){
				$valorCompra = $p->valor_compra;
				$valorVenda = $p->valor_venda;

				$valor = 0;

				if($valorCompra > 0){
					$valor = $valorCompra + (($valorCompra*$lista->percentual_alteracao)/100);
				}else{
					$valor = $valorVenda + (($valorVenda*$lista->percentual_alteracao)/100);
				}

				$data = [
					'valor_venda' => $p->valor_venda,
					'lista_id' => $id,
					'produto_id' => $p->id,
					'percentual_lucro' => $lista->percentual_alteracao,
					'valor' => $valor
				];

				$res = ProdutoListaPreco::create($data);

			}
			session()->flash("mensagem_sucesso", "Produtos cadastrados na lista $lista->nome");
			return redirect()->back();
		}else{
			return redirect('/403');
		}
	}

	public function editValor($id){
		$produto = ProdutoListaPreco::find($id);
		return view('listaPreco/editarProduto')
		->with('produto', $produto)
		->with('title', 'Editar valor do produto');
	}

	public function salvarPreco(Request $request){
		$produto = ProdutoListaPreco::find($request->id);

		$valorLucro = 0;

		$valorCompra = $produto->produto->valor_compra;
		$valorVenda = $produto->produto->valor_venda;

		$novoValor = __replace($request->novo_valor);
		if($valorCompra > 0){

			if($valorCompra > $novoValor){
				$valorLucro = (($valorCompra-$novoValor)/$novoValor)*100;
			}else{
				$valorLucro = (($novoValor-$valorCompra)/$valorCompra)*100;
			}

		}else{
			if($valorVenda > $novoValor){
				$valorLucro = (($valorVenda-$novoValor)/$novoValor)*100;
			}else{
				$valorLucro = (($novoValor-$valorVenda)/$valorVenda)*100;
			}
		}


		$produto->valor = $novoValor;
		$produto->percentual_lucro = $valorLucro;
		$produto->save();

		session()->flash("mensagem_sucesso", "Valor atualizado do produto " . $produto->produto->nome);
		return redirect('/listaDePrecos/ver/' . $produto->lista->id);
	}

	public function delete($id){
		$lista = ListaPreco::find($id);
		if(valida_objeto($lista)){

			$lista->delete();

			session()->flash("mensagem_sucesso", "Lista removida!");
			return redirect('/listaDePrecos');
		}else{
			return redirect('/403');
		}
	}

	public function pesquisa(){
		$listas = ListaPreco::
		where('empresa_id', $this->empresa_id)
		->get();
		return view('listaPreco/pesquisa')
		->with('resultados', [])
		->with('listas', $listas)
		->with('title', 'Pesquisa de Preços');
	}

	public function filtro(Request $request){
		$listas = ListaPreco::
		where('empresa_id', $this->empresa_id)
		->get();
		$produto = $request->produto;
		$listaId = $request->lista;
		$resultados = Produto::
		where('nome', 'LIKE', "%$produto%")
		->where('empresa_id', $this->empresa_id)
		->get();

		foreach($resultados as $p){
			$lista = ProdutoListaPreco::
			where('lista_id', $listaId)
			->where('produto_id', $p->id)
			->first();

			if($lista && $lista->valor > 0){
				$p->valor_lista = $lista->valor;
			}
		}	

		return view('listaPreco/pesquisa')
		->with('resultados', $resultados)
		->with('listas', $listas)
		->with('title', 'Pesquisa de Preços');
	}
}
