<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemIBTE extends Model
{
    protected $fillable = [
		'ibte_id', 'codigo', 'descricao', 'nacional_federal', 'importado_federal', 'estadual',
		'municipal'
	];
}
