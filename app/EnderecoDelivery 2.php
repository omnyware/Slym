<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BairroDelivery;

class EnderecoDelivery extends Model
{
	protected $fillable = [
		'cliente_id', 'rua', 'numero', 'bairro', 'bairro_id', 'referencia', 'latitude', 'longitude'
	];

	public function cliente(){
        return $this->belongsTo(ClienteDelivery::class, 'cliente_id');
    }

    public function bairro(){
        if($this->bairro_id > 0){
        	$bairro = BairroDelivery::find($this->bairro_id);
        	if($bairro != null){
        		return $bairro->nome;
        	}else{
        		return "Bairro não encontrado!";
        	}
        }else{
        	return $this->bairro;
        }
    }

    public function bairroComValor(){
        if($this->bairro_id > 0){
        	$bairro = BairroDelivery::find($this->bairro_id);
        	if($bairro != null){
        		return $bairro->nome . ", R$ " . $bairro->valor_entrega;
        	}else{
        		return "Bairro não encontrado!";
        	}
        }else{
        	return $this->bairro;
        }
    }
}
