<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManifestaDfe extends Model
{
    protected $fillable = [
		'chave', 'nome', 'documento', 'valor', 'num_prot', 'data_emissao', 
		'sequencia_evento', 'fatura_salva', 'tipo', 'nsu', 'empresa_id'
	];

	public function estado(){
		if($this->tipo == 0){
			return "--";
		}else if($this->tipo == 1){
			return "Ciência";
		}else if($this->tipo == 2){
			return "Confirmada";
		}else if($this->tipo == 2){
			return "Desconhecimento";
		}else if($this->tipo == 2){
			return "Operação não realizada";
		}
	}
}
