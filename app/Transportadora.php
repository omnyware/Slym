<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transportadora extends Model
{
    protected $fillable = [
		'razao_social', 'cnpj_cpf', 'ie_rg', 'logradouro', 'cidade_id', 'empresa_id'
	];

	public function cidade(){
		return $this->belongsTo(Cidade::class, 'cidade_id');
	}
}
