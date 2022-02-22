<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContaReceber extends Model
{
	protected $fillable = [
		'venda_id', 'data_vencimento', 'data_recebimento', 'valor_integral', 'valor_recebido', 
		'referencia', 'categoria_id', 'status', 'empresa_id'
	];

	public function venda(){
		return $this->belongsTo(Venda::class, 'venda_id');
	}

	public function categoria(){
		return $this->belongsTo(CategoriaConta::class, 'categoria_id');
	}

	public static function filtroData($dataInicial, $dataFinal, $status){
		$value = session('user_logged');
        $empresa_id = $value['empresa'];
		$c = ContaReceber::
		orderBy('conta_recebers.data_vencimento', 'asc')
		->where('empresa_id', $empresa_id)
		->whereBetween('conta_recebers.data_vencimento', [$dataInicial, 
			$dataFinal]);

		if($status == 'pago'){
			$c->where('status', true);
		} else if($status == 'pendente'){
			$c->where('status', false);
		}
		return $c->get();
	}
	public static function filtroDataFornecedor($cliente, $dataInicial, $dataFinal, $status){
		$value = session('user_logged');
        $empresa_id = $value['empresa'];
		$c = ContaReceber::
		orderBy('conta_recebers.data_vencimento', 'asc')
		->join('vendas', 'vendas.id' , '=', 'conta_recebers.venda_id')
		->join('clientes', 'clientes.id' , '=', 'vendas.cliente_id')
		->where('clientes.razao_social', 'LIKE', "%$cliente%")
		->where('empresa_id', $empresa_id)
		->whereBetween('conta_recebers.data_vencimento', [$dataInicial, 
			$dataFinal]);

		if($status == 'pago'){
			$c->where('status', true);
		} else if($status == 'pendente'){
			$c->where('status', false);
		}
		return $c->get();
	}

	public static function filtroFornecedor($cliente, $status){
		$value = session('user_logged');
        $empresa_id = $value['empresa'];
		$c = ContaReceber::
		orderBy('conta_recebers.data_vencimento', 'asc')
		->join('vendas', 'vendas.id' , '=', 'conta_recebers.venda_id')
		->join('clientes', 'clientes.id' , '=', 'vendas.cliente_id')
		->where('empresa_id', $empresa_id)
		->where('razao_social', 'LIKE', "%$cliente%");

		if($status == 'pago'){
			$c->where('status', true);
		} else if($status == 'pendente'){
			$c->where('status', false);
		}
		
		return $c->get();
	}

	public static function filtroStatus($status){
		$value = session('user_logged');
        $empresa_id = $value['empresa'];

		$c = ContaReceber::
		where('empresa_id', $empresa_id)
		->orderBy('conta_recebers.data_vencimento', 'asc');
		if($status == 'pago'){
			$c->where('status', true);
		} else if($status == 'pendente'){
			$c->where('status', false);
		}
		
		return $c->get();
	}
}
