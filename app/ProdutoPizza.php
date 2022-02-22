<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TamanhoPizza;

class ProdutoPizza extends Model
{
    protected $fillable = [ 
		'produto_id', 'tamanho_id', 'valor'
	];

	public function tamanho(){
		return $this->belongsTo(TamanhoPizza::class, 'tamanho_id');
	}

	public function produto(){
		return $this->belongsTo(ProdutoDelivery::class, 'produto_id');
	}

	public static function tamanhoNaoCadastrado($tamanho, $prod){

		foreach($prod->pizza as $pp){

			if($pp->tamanho->id == $tamanho){
				return true;
			}
		}
		return false;
	}
}
