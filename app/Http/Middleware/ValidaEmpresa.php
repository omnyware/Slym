<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use App\Venda;
use App\ConfigNota;

class ValidaEmpresa
{

	public function handle($request, Closure $next){

		$response = $next($request);

		$value = session('user_logged');

		return $next($response);
	}

}