<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NaturezaOperacao extends Model
{
    protected $fillable = [
		'natureza', 'CFOP_entrada_estadual', 'CFOP_entrada_inter_estadual',
		'CFOP_saida_estadual', 'CFOP_saida_inter_estadual', 'empresa_id', 'mensagem'
	];
}
