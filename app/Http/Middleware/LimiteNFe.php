<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use App\Venda;
use App\Empresa;

class LimiteNFe
{

	public function handle($request, Closure $next){

		$value = session('user_logged');
		$empresa_id = $value['empresa'];
		$empresa = Empresa::find($empresa_id);
		$dataExp = $empresa->planoEmpresa->expiracao;
		$dataCriacao = substr($empresa->planoEmpresa->created_at, 0, 10);

		$vendas = Venda::
		whereBetween('created_at', [$dataCriacao, 
            $dataExp])
		->where('empresa_id', $empresa_id)
		->where('NfNumero', '>', 0)
		->get();

		$cont = sizeof($vendas);

		if($empresa->planoEmpresa->plano->maximo_nfes == -1){
			return $next($request);
		}

		if($cont < $empresa->planoEmpresa->plano->maximo_nfes){
			return $next($request);
		} else {
            return response()->json('Limite de emissão de NF-e atingido!!', 407);
		}
		
	}

}