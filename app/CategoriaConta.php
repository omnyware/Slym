<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaConta extends Model
{
    protected $fillable = [
        'nome', 'empresa_id'
    ];
}
