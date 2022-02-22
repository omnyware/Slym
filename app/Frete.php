<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frete extends Model
{
    protected $fillable = [
        'valor', 'placa', 'tipo', 'uf', 'numeracaoVolumes', 'peso_liquido', 'peso_bruto',
        'especie', 'marca', 'qtdVolumes'
    ];
}
