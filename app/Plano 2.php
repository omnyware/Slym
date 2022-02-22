<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
	protected $fillable = [
		'nome', 'valor', 'maximo_clientes', 'maximo_produtos', 'maximo_fornecedores', 'maximo_nfes',
		'maximo_nfces', 'maximo_cte', 'maximo_mdfe'
	];
}
