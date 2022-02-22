<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplementoDelivery extends Model
{
    protected $fillable = [
		'nome', 'valor', 'categoria_id', 'empresa_id'
	];

	public function nome(){
		$nome = explode('>', $this->nome);
		if(sizeof($nome) > 1) return $nome[1];
		return $this->nome;
	}
}
