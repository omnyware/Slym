<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    protected $fillable = [
		'pedido_id', 'produto_id', 'quantidade', 'status', 'tamanho_pizza_id', 'observacao', 'valor', 'impresso'
	];

	public function pedido(){
		return $this->belongsTo(Pedido::class, 'pedido_id');
	}

	public function produto(){
		return $this->belongsTo(Produto::class, 'produto_id');
	}

	public function tamanho(){
        return $this->belongsTo(TamanhoPizza::class, 'tamanho_pizza_id');
    }

    public function itensAdicionais(){
        return $this->hasMany('App\ItemPedidoComplementoLocal', 'item_pedido', 'id');
    }

    public function sabores(){
        return $this->hasMany('App\ItemPizzaPedidoLocal', 'item_pedido', 'id');
    }

    public function nomeDoProduto(){
        if(count($this->sabores) == 0){
            $nome = $this->produto->nome;
            if($this->observacao != ''){
               $nome .= " | obs: " .$this->observacao;
            }

            if(sizeof($this->itensAdicionais) > 0){
                $nome .= " | Adicional: ";
                foreach($this->itensAdicionais as $a){
                    $nome .= $a->adicional->nome;
                }
            }

            return $nome;
        }else{
            $cont = 1;
            $nome = "";
            foreach($this->sabores as $s){
                $nome .= $cont."/".count($this->sabores) . " " . $s->produto->produto->nome;
            }
            $nome .= " | Tamanho: " . $this->tamanho->nome();

            if(sizeof($this->itensAdicionais) > 0){
                $nome .= " | Adicional: ";
                foreach($this->itensAdicionais as $a){
                    $nome .= $a->adicional->nome();
                }
            }

            if($this->observacao != ''){
               $nome .= " | " .$this->observacao;
            }
            return $nome;
        }
    }
}
