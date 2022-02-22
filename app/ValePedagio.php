<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValePedagio extends Model
{
    protected $fillable = [
		'mdfe_id', 'cnpj_fornecedor', 'cnpj_fornecedor_pagador', 'numero_compra', 'valor'
	];
}
