<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AberturaCaixa extends Model
{
    protected $fillable = [
        'usuario_id', 'valor', 'ultima_venda', 'empresa_id'
    ];
}
