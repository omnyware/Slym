<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaturaOrcamento extends Model
{
     protected $fillable = [
        'valor', 'vencimento', 'orcamento_id', 'empresa_id'
    ];

    public function orcamento(){
        return $this->belongsTo(Orcamento::class, 'orcamento_id');
    }

}
