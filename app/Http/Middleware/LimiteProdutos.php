<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use App\Produto;
use App\Empresa;

class LimiteProdutos
{

	public function handle($request, Closure $next){

		$value = session('user_logged');
		$empresa_id = $value['empresa'];
		$empresa = Empresa::find($empresa_id);
		$dataExp = $empresa->planoEmpresa->expiracao;
		$dataCriacao = substr($empresa->planoEmpresa->created_at, 0, 10);

		$produtos = Produto::
		whereBetween('created_at', [$dataCriacao, 
            $dataExp])
		->where('empresa_id', $empresa_id)
		->get();

		$contProdutos = sizeof($produtos);

		if($empresa->planoEmpresa->plano->maximo_produtos == -1){
			return $next($request);
		}

		if($contProdutos < $empresa->planoEmpresa->plano->maximo_produtos){
			return $next($request);
		} else {
            session()->flash('mensagem_erro', 'Maximo de podutos atingidos ' . $contProdutos);
			return redirect()->back();
		}
		
	}

}