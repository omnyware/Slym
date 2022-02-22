<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ClienteDelivery;

class CodigoDesconto extends Model
{
    protected $fillable = [
		'codigo', 'valor', 'tipo', 'cliente_id', 'ativo', 'push', 'sms'
	];

	public function cliente(){
		return $this->belongsTo(ClienteDelivery::class, 'cliente_id');
	}

	public function totalDeClientesAtivosCad(){
		$clientesAtivos = ClienteDelivery::
		where('ativo', true)
		->get();

		return count($clientesAtivos);
	}
}
