<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use App\Venda;
use App\ConfigNota;

class VerificaEmpresa
{

	public function handle($request, Closure $next){

		$value = session('user_logged');
        $request->merge([ 'empresa_id' => $value['empresa'] ?? null]);

		return $next($request);
	}

}