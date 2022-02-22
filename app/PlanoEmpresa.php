<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanoEmpresa extends Model
{
    protected $fillable = [
        'empresa_id', 'plano_id', 'expiracao'
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function plano(){
        return $this->belongsTo(Plano::class, 'plano_id');
    }
}
