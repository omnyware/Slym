<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContatoFuncionario extends Model
{
	protected $fillable = [
		'nome', 'telefone', 'funcionario_id'
	];

	public function funcionario(){
		return $this->belongsTo(Funcionario::class, 'funcionario_id');
	}
}
