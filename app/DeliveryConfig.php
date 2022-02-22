<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryConfig extends Model
{
	protected $fillable = [
		'link_face', 'link_twiteer', 'link_google', 'link_instagram', 'telefone',
		'endereco', 'tempo_medio_entrega', 'valor_entrega', 'tempo_maximo_cancelamento', 
		'nome_exibicao_web', 'latitude', 'longitude', 'politica_privacidade', 'entrega_gratis_ate', 'valor_km',
		'usar_bairros', 'maximo_km_entrega', 'maximo_adicionais', 'maximo_adicionais_pizza'
	];

	public function nomeExib($posicao){
		$temp = explode(" ", $this->nome_exibicao_web);
		return $temp[$posicao];
	}
}
