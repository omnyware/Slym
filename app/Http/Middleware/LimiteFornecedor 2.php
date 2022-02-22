<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use App\Fornecedor;
use App\Empresa;

class LimiteFornecedor
{

	public function handle($request, Closure $next){

		$value = session('user_logged');
		$empresa_id = $value['empresa'];
		$empresa = Empresa::find($empresa_id);
		$dataExp = $empresa->planoEmpresa->expiracao;
		$dataCriacao = substr($empresa->planoEmpresa->created_at, 0, 10);

		$fornecedores = Fornecedor::
		whereBetween('created_at', [$dataCriacao, 
            $dataExp])
		->where('empresa_id', $empresa_id)
		->get();

		$contForn = sizeof($fornecedores);

		if($empresa->planoEmpresa->plano->maximo_fornecedores == -1){
			return $next($request);
		}

		if($contForn < $empresa->planoEmpresa->plano->maximo_fornecedores){
			return $next($request);
		} else {
            session()->flash('mensagem_erro', 'Maximo de podutos atingidos ' . $contForn);
			return redirect()->back();
		}
		
	}

}