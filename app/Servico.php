<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $fillable = [
        'nome', 'unidade_cobranca', 'valor', 'categoria_id', 'empresa_id', 'tempo_servico'
    ];

    public function categoria(){
        return $this->belongsTo(CategoriaServico::class, 'categoria_id');
    }
}
