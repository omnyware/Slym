<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use App\Cte;
use App\Empresa;

class LimiteCTe
{

	public function handle($request, Closure $next){

		$value = session('user_logged');
		$empresa_id = $value['empresa'];
		$empresa = Empresa::find($empresa_id);
		$dataExp = $empresa->planoEmpresa->expiracao;
		$dataCriacao = substr($empresa->planoEmpresa->created_at, 0, 10);

		$vendas = Cte::
		whereBetween('created_at', [$dataCriacao, 
            $dataExp])
		->where('empresa_id', $empresa_id)
		->where('cte_numero', '>', 0)
		->get();

		$cont = sizeof($vendas);

		if($empresa->planoEmpresa->plano->maximo_cte == -1){
			return $next($request);
		}

		if($cont < $empresa->planoEmpresa->plano->maximo_cte){
			return $next($request);
		} else {
            return response()->json('Limite de emissão de CT-e atingido!!', 407);
		}
		
	}

}