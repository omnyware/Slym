<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devolucao extends Model
{
	protected $fillable = [
		'fornecedor_id', 'usuario_id', 'natureza_id', 'data_registro', 'valor_integral', 
		'valor_devolvido', 'motivo', 'observacao', 'estado', 'devolucao_parcial', 
		'chave_nf_entrada', 'nNf', 'vFrete', 'vDesc', 'chave_gerada', 'numero_gerado', 'empresa_id'
	];

	public function fornecedor(){
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function natureza(){
        return $this->belongsTo(NaturezaOperacao::class, 'natureza_id');
    }

    public function itens(){
        return $this->hasMany('App\ItemDevolucao', 'devolucao_id', 'id');
    }
}
