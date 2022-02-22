<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventoFuncionario extends Model
{
    protected $fillable = [
		'evento_id', 'funcionario_id'
	];

	public function funcionario(){
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }
}
