<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use App\Evento;
use App\Empresa;

class LimiteEvento
{

	public function handle($request, Closure $next){

		$value = session('user_logged');
		$empresa_id = $value['empresa'];
		$empresa = Empresa::find($empresa_id);
		$dataExp = $empresa->planoEmpresa->expiracao;
		$dataCriacao = substr($empresa->planoEmpresa->created_at, 0, 10);

		$eventos = Evento::
		whereBetween('created_at', [$dataCriacao, 
            $dataExp])
		->where('empresa_id', $empresa_id)
		->get();

		$contEventos = sizeof($eventos);

		if($empresa->planoEmpresa->plano->maximo_evento == -1){
			return $next($request);
		}

		if($contEventos < $empresa->planoEmpresa->plano->maximo_evento){
			return $next($request);
		} else {
            session()->flash('mensagem_erro', 'Maximo de eventos atingidos ' . $contEventos);
			return redirect()->back();
		}
		
	}

}