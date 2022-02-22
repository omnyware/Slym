<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedidaCte extends Model
{
    protected $fillable = [
        'cte_id', 'tipo_medida', 'quantidade_carga', 'cod_unidade'
    ];
}
