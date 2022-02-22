<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tributacao;
class TributoController extends Controller
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

	public function index(Request $request){

		$regimes = Tributacao::regimes();
		$tributo = Tributacao::
		where('empresa_id', $request->empresa_id)
		->first();
		return view('tributos/index')
		->with('tributo', $tributo)
		->with('regimes', $regimes)
		->with('title', 'Configurar Tributação');
	}


	public function save(Request $request){
		
		$this->_validate($request);
		if($request->id == 0){
			$result = Tributacao::create([
				'icms' => __replace($request->icms),
				'pis' => __replace($request->pis),
				'cofins' => __replace($request->cofins),
				'ipi' => __replace($request->ipi),
				'regime' => $request->regime,
				'ncm_padrao' => $request->ncm_padrao ?? '',
				'empresa_id' => $request->empresa_id
			]);
		}else{
			$trib = Tributacao::
			where('empresa_id', $request->empresa_id)
			->first();

			$trib->icms = $request->icms;
			$trib->pis = $request->pis;
			$trib->cofins = $request->cofins;
			$trib->ipi = $request->ipi;
			$trib->regime = $request->regime;
			$trib->ncm_padrao = $request->ncm_padrao;

			$result = $trib->save();
		}

		if($result){
			session()->flash("mensagem_sucesso", "Tributação configurada com sucesso!");
		}else{
			session()->flash('mensagem_erro', 'Erro ao configurar tributação!');
		}

		return redirect('/tributos');
	}


	private function _validate(Request $request){
		$rules = [
			'icms' => 'required',
			'pis' => 'required',
			'cofins' => 'required',
			'ipi' => 'required'
		];

		$messages = [
			'icms.required' => 'O campo ICMS é obrigatório.',
			'pis.required' => 'O campo PIS é obrigatório.',
			'cofins.required' => 'O campo COFINS é obrigatório.',
			'ipi.required' => 'O campo IPI é obrigatório.'
		];
		$this->validate($request, $rules, $messages);
	}
}
