<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaProdutoDelivery extends Model
{
    protected $fillable = [
        'nome', 'descricao', 'path', 'empresa_id'
    ];

    public function produtos(){
        return $this->hasMany('App\ProdutoDelivery', 'categoria_id', 'id');
    }

    public function adicionais(){
        return $this->hasMany('App\ListaComplementoDelivery', 'categoria_id', 'id');
    }
}
