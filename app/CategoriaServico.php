<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaServico extends Model
{
    protected $fillable = [
        'nome', 'empresa_id'
    ];
}
