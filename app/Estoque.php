<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ItemPurchase;
use App\Produto;

class Estoque extends Model
{
	protected $fillable = [
        'produto_id', 'quantidade', 'valor_compra', 'validade', 'empresa_id'
    ];

    public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }

    public function valorCompra(){
        return number_format($this->valor_compra/$this->produto->conversao_unitaria, 2);
    }

    public function value_purchase($productId = null){

    	$item = ItemPurchase::
    	where('produto_id', $productId)
    	->orderBy('id', 'desc')
    	->first();
    	return $item != null ? $item->value : 0;
    }

    public static function ultimoValorCompra($productId){
        $estoque = Estoque::
        where('produto_id', $productId)
        ->orderBy('id', 'desc')
        ->first();

        return $estoque;
    }

    public function valorCompraUnitário(){
        $produto = Produto::find($this->produto_id);

        $valorMedio = $this->valor_compra/$produto->conversao_unitaria;
        return $valorMedio * $this->quantidade;
    }

}
