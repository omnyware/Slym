<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $fillable = [
        'funcionario_id', 'cliente_id', 'data', 'inicio', 'termino', 'observacao', 'total',
        'desconto', 'acrescimo', 'status', 'empresa_id'
    ];

    public function itens(){
        return $this->hasMany('App\ItemAgendamento', 'agendamento_id', 'id');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function funcionario(){
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }

}
