<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motoboy extends Model
{
    protected $fillable = [
        'nome', 'telefone1', 'telefone2', 'telefone3', 'cpf', 'rg', 'endereco', 'tipo_transporte'
    ];

    public static function tiposTransporte(){
    	return [
    		'Bau'
    	];
    }
}
