<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
	protected $fillable = [
		'nome', 'bairro', 'numero', 'rua', 'cpf', 'rg', 'telefone', 'celular', 
		'email', 'data_registro', 'empresa_id', 'usuario_id', 'percentual_comissao'
	];

	public function contatos(){
		return $this->hasMany('App\ContatoFuncionario', 'funcionario_id', 'id');
	}

	public function usuario(){
		return $this->belongsTo(Usuario::class, 'usuario_id');
	}
}
