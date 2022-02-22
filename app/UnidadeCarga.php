<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadeCarga extends Model
{
    protected $fillable = [
		'info_id', 'id_unidade_carga', 'quantidade_rateio'
	];
}
