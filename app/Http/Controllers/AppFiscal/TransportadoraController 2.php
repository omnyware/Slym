<?php

namespace App\Http\Controllers\AppFiscal;

use Illuminate\Http\Request;
use App\Transportadora;
use App\Cidade;

class TransportadoraController extends Controller
{
	public function index(Request $request){
		$transportadoras = Transportadora::
		where('empresa_id', $request->empresa_id)
		->get();
		foreach($transportadoras as $c){
			$c->cidade;
		}
		return response()->json($transportadoras, 200);
	}
}