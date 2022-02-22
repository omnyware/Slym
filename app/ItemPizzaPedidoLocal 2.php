<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProdutoPizza;
class ItemPizzaPedidoLocal extends Model
{
    protected $fillable = [
		'item_pedido', 'sabor_id'
	];

	public function produto(){
		return $this->belongsTo(ProdutoDelivery::class, 'sabor_id');
	}

	public function itensPedido(){
		return $this->hasMany('App\ItemPedidoDelivery', 'id', 'item_pedido');
	}

	public function maiorValor($saborId, $tamanho_id){
		$p = ProdutoPizza::
		where('tamanho_id', $tamanho_id)
		->where('produto_id', $saborId)
		->first();

		return $p->valor;
	}
}
