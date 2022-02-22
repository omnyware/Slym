<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
	protected $fillable = [
		'razao_social', 'nome_fantasia', 'bairro', 'numero', 'rua', 'cpf_cnpj', 'telefone', 'celular', 'email', 'cep', 'ie_rg', 'consumidor_final', 'limite_venda', 'cidade_id', 'contribuinte', 'rua_cobranca', 'numero_cobranca', 'bairro_cobranca', 'cep_cobranca', 'cidade_cobranca_id', 'empresa_id'
	];

	public function cidade(){
		return $this->belongsTo(Cidade::class, 'cidade_id');
	}

	public static function estados(){
		return [
			"AC",
			"AL",
			"AM",
			"AP",
			"BA",
			"CE",
			"DF",
			"ES",
			"GO",
			"MA",
			"MG",
			"MS",
			"MT",
			"PA",
			"PB",
			"PE",
			"PI",
			"PR",
			"RJ",
			"RN",
			"RS",
			"RO",
			"RR",
			"SC",
			"SE",
			"SP",
			"TO",
			
		];
	}
}
