<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use App\VendaCaixa;
use App\Empresa;

class LimiteNFCe
{

	public function handle($request, Closure $next){

		$value = session('user_logged');
		$empresa_id = $value['empresa'];
		$empresa = Empresa::find($empresa_id);
		$dataExp = $empresa->planoEmpresa->expiracao;
		$dataCriacao = substr($empresa->planoEmpresa->created_at, 0, 10);

		$vendas = VendaCaixa::
		whereBetween('created_at', [$dataCriacao, 
            $dataExp])
		->where('empresa_id', $empresa_id)
		->where('NFcNumero', '>', 0)
		->get();

		$cont = sizeof($vendas);

		if($empresa->planoEmpresa->plano->maximo_nfces == -1){
			return $next($request);
		}

		if($cont < $empresa->planoEmpresa->plano->maximo_nfces){
			return $next($request);
		} else {
            return response()->json('Limite de emissão de NFC-e atingido!!', 407);
		}
		
	}

}