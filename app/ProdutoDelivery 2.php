<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ItemPedidoDelivery;

class ProdutoDelivery extends Model
{
    protected $fillable = [
		'categoria_id', 'produto_id', 'valor', 'descricao',
		'ingredientes', 'status', 'destaque', 'limite_diario', 'valor_anterior', 'empresa_id'
	];

	public function produto(){
		return $this->belongsTo(Produto::class, 'produto_id');
	}

	public function categoria(){
		return $this->belongsTo(CategoriaProdutoDelivery::class, 'categoria_id');
	}

	public function galeria(){
		return $this->hasMany('App\ImagensProdutoDelivery', 'produto_id', 'id');
	}

	public function pizza(){
		return $this->hasMany('App\ProdutoPizza', 'produto_id', 'id');
	}

	public function itemPedido(){
		$dataInicial = date('Y-m-d', strtotime(date('Y-m-d')));
		$dataFinal = date('Y-m-d', strtotime("+1 day",strtotime(date('Y-m-d'))));
        $itensHoje = ItemPedidoDelivery::
        where('produto_id', $this->id)
        ->whereBetween('created_at', [$dataInicial, 
            $dataFinal])
        ->get();


        return count($itensHoje) >= $this->limite_diario ? false: true;
    }
}
