<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FuncionamentoDelivery;

class FuncionamentoDeliveryController extends Controller
{
	public function __construct(){
		$this->middleware(function ($request, $next) {
			$value = session('user_logged');
			if(!$value){
				return redirect("/login");
			}
			return $next($request);
		});
	}

	public function index(){
		$funcionamentos = FuncionamentoDelivery::
		all();
		$dias = $this->verificaDiasInserido();
		return view('funcionamentoDelivery/index')
		->with('funcionamentos', $funcionamentos)
		->with('dias', $dias)
		->with('controleHorarioJs', true)
		->with('title', 'Funcionamento de Delivery');
	}

	private function verificaDiasInserido(){
		
		$temp = [];
		$dias = FuncionamentoDelivery::dias();
		foreach($dias as $d){
			$v = FuncionamentoDelivery::where('dia', $d)->first();
			if(!$v){
				array_push($temp, $d);
			}
		}
		return $temp;
	}

	public function save(Request $request){
		$this->_validate($request);
		if($request->id == 0){
			$result = FuncionamentoDelivery::create([
				'dia' => $request->dia,
				'ativo' => true,
				'inicio_expediente' => $request->inicio,
				'fim_expediente' => $request->fim
			]);
		}else{
			$f = FuncionamentoDelivery::
			where('id', $request->id)
			->first();

			$f->inicio_expediente = $request->inicio;
			$f->fim_expediente = $request->fim;
			$result = $f->save();
		}

		if($result){
			session()->flash('color', 'green');
			session()->flash("message", "Configurado com sucesso!");
		}else{
			session()->flash('color', 'red');
			session()->flash('message', 'Erro ao configurar!');
		}

		return redirect('/funcionamentoDelivery');
	}

	public function edit($id){
		$funcionamentos = FuncionamentoDelivery::
		all();

		$funcionamento = FuncionamentoDelivery::where('id', $id)->first();

		$dias = $this->verificaDiasInserido();
		return view('funcionamentoDelivery/index')
		->with('funcionamentos', $funcionamentos)
		->with('dias', $dias)
		->with('controleHorarioJs', true)
		->with('funcionamento', $funcionamento)
		->with('title', 'Funcionamento de Delivery');
	}

	public function alterarStatus($id){
		$funcionamento = FuncionamentoDelivery::where('id', $id)->first();
		$funcionamento->ativo = !$funcionamento->ativo;
		$funcionamento->save();

		session()->flash('color', 'blue');
		session()->flash("message", "Dia " .
		($funcionamento->ativo ? 'Ativado' : 'Desativado') . "!");
		return redirect('/funcionamentoDelivery');
	}


	private function _validate(Request $request){
		$rules = [
			'inicio' => 'required|min:5',
			'fim' => 'required|min:5',
			
		];

		$messages = [
			'inicio.required' => 'O campo Inicio é obrigatório.',
			'fim.required' => 'O campo Fim é obrigatório.',
			'inicio.min' => 'Campo inválido.',
			'fim.min' => 'Campo inválido.',


		];
		$this->validate($request, $rules, $messages);
	}
}
