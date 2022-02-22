<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaPreco extends Model
{
    protected $fillable = [
		'nome', 'percentual_alteracao', 'empresa_id'
	];

	public function itens(){
        return $this->hasMany('App\ProdutoListaPreco', 'lista_id', 'id');
    }
}
