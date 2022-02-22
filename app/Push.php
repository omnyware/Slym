<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Push extends Model
{
	protected $fillable = [
		'cliente_id', 'titulo', 'texto', 'status', 'path_img', 'referencia_produto'
	];

	public function cliente(){
		return $this->belongsTo(ClienteDelivery::class, 'cliente_id');
	}

}
