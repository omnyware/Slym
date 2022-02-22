<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = [
		'nome', 'descricao', 'logradouro', 'numero', 'bairro', 'cidade', 'status',
		'inicio', 'fim', 'empresa_id'
	];

	public function funcionarios(){
        return $this->hasMany('App\EventoFuncionario', 'evento_id', 'id');
    }

    public function atividades(){
        return $this->hasMany('App\AtividadeEvento', 'evento_id', 'id');
    }
}
