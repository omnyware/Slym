<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemVenda extends Model
{
    protected $fillable = [
		'produto_id', 'venda_id', 'quantidade', 'valor'
	];

	public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }

    
}
