<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuncionamentoDelivery extends Model
{

    protected $fillable = [
        'ativo', 'dia', 'inicio_expediente', 'fim_expediente'
    ];

    public static function dias(){
    	return [
            'DOMINGO',
    		'SEGUNDA',	
    		'TERÇA',	
    		'QUARTA',	
    		'QUINTA',	
    		'SEXTA',	
    		'SABADO'
    	];
    }
}
