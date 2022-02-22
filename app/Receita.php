<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    protected $fillable = [
		'descricao', 'produto_id', 'valor_custo', 'rendimento', 'tempo_preparo', 'pizza', 'pedacos'
	];

	public function itens(){
        return $this->hasMany('App\ItemReceita', 'receita_id', 'id');
    }

    public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
