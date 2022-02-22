<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use App\Venda;
use App\Usuario;
use App\ConfigNota;
use App\Helpers\Menu;

class ValidaAcesso
{

	public function handle($request, Closure $next){

		$value = session('user_logged');
		if(!$value){
			return redirect("/login");
		}

		if($request->ajax()){
			return $next($request);
		}

		if($value['super']){
			return $next($request);
		}

		$uri = $_SERVER['REQUEST_URI'];
		$uri = explode("/", $uri);
		$uri = "/".$uri[1];
		$value = session('user_logged');
		$usuario = Usuario::find($value['id']);
		$permissao = json_decode($usuario->permissao);

		foreach($permissao as $p){
			if($p == $uri){
				return $next($request);
			}
		}
		$valida = $this->validaRotaInexistente($uri);
		
		if($valida){
			return redirect('/error');
		}else{
			// se a rota nao disponivel no helper menu.php quer dizer que não precisa ser controlada
			return $next($request);
		}

	}

	private function validaRotaInexistente($uri){
		$existe = false;
		$menu = new Menu();
		$menu = $menu->getMenu();
		foreach($menu as $m){
			foreach($m['subs'] as $s){
				if($s['rota'] == $uri){
					$existe = true;
				}
			}
		}
		return $existe;
	}

}