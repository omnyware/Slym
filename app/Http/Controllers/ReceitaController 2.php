<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Receita;
use App\ItemReceita;

class ReceitaController extends Controller
{

	public function __construct(){
        $this->middleware(function ($request, $next) {
            $value = session('user_logged');
            if(!$value){
                return redirect("/login");
            }else{
                if($value['acesso_cliente'] == 0){
                    return redirect("/sempermissao");
                }
            }
            return $next($request);
        });
    }
    
	public function save(Request $request){

		$request->merge(['rendimento' => $request->rendimento > 0 ?
			$request->rendimento : 'a'
		]);

		if(strlen($request->pedacos)){
			$request->merge(['pedacos' => $request->pedacos > 0 ?
				$request->pedacos : 'a'
			]);
		}

		$this->_validate($request);

		
		$result = Receita::create([
			'produto_id' => $request->produto_id,
			'descricao' => $request->descricao,
			'rendimento' => $request->rendimento,
			'tempo_preparo' => (int) $request->tempo_preparo,
			'valor_custo' => 0,
			'pizza' => $request->pedacos ? true : false,
			'pedacos' => $request->pedacos ?? 0

		]);

		if($result){
			session()->flash('color', 'blue');
			session()->flash("message", "Cadastrado com sucesso!");
		}else{
			session()->flash('color', 'red');
			session()->flash('message', 'Erro ao cadastrar!');
		}

		return redirect("/produtos/receita/$request->produto_id");
	}

	public function update(Request $request){
		$this->_validate($request);
		$receita = Receita::
		where('id', $request->receita_id)
		->first();

		$receita->descricao = $request->descricao;
		$receita->rendimento = $request->rendimento;
		$receita->tempo_preparo = (int) $request->tempo_preparo;
		$receita->pizza = $request->pedacos ? true: false;
		$receita->pedacos = $request->pedacos;

		$result = $receita->save();

		if($result){
			session()->flash('color', 'blue');
			session()->flash("message", "Atualizado com sucesso!");
		}else{
			session()->flash('color', 'red');
			session()->flash('message', 'Erro ao atualizar!');
		}

		return redirect("/produtos/receita/" . $receita->produto->id);
	}

	public function saveItem(Request $request){
		$this->_validateItem($request);
		$produto = $request->input('produto');
		$produto = explode("-", $produto);
		$produto = $produto[0];

		$result = ItemReceita::create([
			'receita_id' => $request->receita_id,
			'produto_id' => $produto,
			'quantidade' => str_replace(",", ".", $request->quantidade),
			'medida' => $request->medida
		]);

		if($result){
			session()->flash('color', 'blue');
			session()->flash("message", "Cadastrado com sucesso!");
		}else{
			session()->flash('color', 'red');
			session()->flash('message', 'Erro ao cadastrar!');
		}

		return redirect("/produtos/receita/$request->produto_id");
	}

	private function _validate(Request $request){
		$rules = [
			'rendimento' => 'required|numeric',
			'tempo_preparo' => 'required',
			'pedacos' => $request->pedacos ? 'numeric' : ''

		];

		$messages = [
			'rendimento.required' => 'O campo redimento é obrigatório.',
			'rendimento.numeric' => 'Digite um valor maior que 0.',
			'tempo_preparo.required' => 'O campo tempo de preparo é obrigatório.',
			'pedacos.numeric' => 'Informe um valor maior que 0.'

		];

		$this->validate($request, $rules, $messages);
	}

	private function _validateItem(Request $request){
		$rules = [
			'produto' => 'required',
			'quantidade' => 'required',
		];

		$messages = [
			'produto.required' => 'O campo produto é obrigatório.',
			'produto.min' => 'Clique sobre o produto desejado.',
			'quantidade.required' => 'O campo quantidade é obrigatório.',
		];

		$this->validate($request, $rules, $messages);
	}

	public function deleteItem($id){
		$obj = ItemReceita
		::where('id', $id)
		->first();

		$delete = $obj->delete();

		if($delete){
			session()->flash('color', 'blue');
			session()->flash('message', 'Registro removido!');
		}else{
			session()->flash('color', 'red');
			session()->flash('message', 'Erro!');
		}

		$id = $obj->receita->produto->id;
		return redirect("/produtos/receita/$id");
	}
}
