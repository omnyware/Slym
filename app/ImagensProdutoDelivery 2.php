<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagensProdutoDelivery extends Model
{	
	protected $fillable = [
		'produto_id', 'path'
	];

	public function produto(){
        return $this->hasOne('App\ProdutoDelivery', 'id', 'produto_id');
    }
	
}
