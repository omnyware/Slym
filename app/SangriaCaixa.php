<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SangriaCaixa extends Model
{
    protected $fillable = [
        'usuario_id', 'valor', 'empresa_id'
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
