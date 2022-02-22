<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SangriaCaixa;
use App\AberturaCaixa;
class SangriaCaixaController extends Controller
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

	public function save(Request $request){
		$result = SangriaCaixa::create([
			'usuario_id' => get_id_user(),
			'valor' => str_replace(",", ".", $request->valor),
			'empresa_id' => $this->empresa_id
		]);
		echo json_encode($result);

	}

	public function diaria(){
		$ab = AberturaCaixa::where('ultima_venda', 0)->orderBy('id', 'desc')->first();

		date_default_timezone_set('America/Sao_Paulo');
		$hoje = date("Y-m-d") . " 00:00:00";
		$amanha = date('Y-m-d', strtotime('+1 days')). " 00:00:00";
		$sangrias = SangriaCaixa::
		whereBetween('data_registro', [$ab->created_at, 
			$amanha])
		->where('empresa_id', $this->empresa_id)
		->get();
		echo json_encode($this->setUsuario($sangrias));
	}

	private function setUsuario($sangrias){
		for($aux = 0; $aux < count($sangrias); $aux++){
			$sangrias[$aux]['nome_usuario'] = $sangrias[$aux]->usuario->nome;
		}
		return $sangrias;
	}


}
