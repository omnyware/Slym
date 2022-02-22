<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
	protected $fillable = [
		'fornecedor_id', 'usuario_id', 'nf', 'desconto', 'valor', 'observacao', 'xml_path',
		'chave', 'estado', 'numero_emissao', 'empresa_id'
	];

	public function fornecedor(){
		return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
	}

	public function usuario(){
		return $this->belongsTo(Usuario::class, 'usuario_id');
	}

	public function itens(){
        return $this->hasMany('App\ItemCompra', 'compra_id', 'id');
    }

    public function fatura(){
        return $this->hasMany('App\ContaPagar', 'compra_id', 'id');
    }

    public function somaItems(){
		if(count($this->itens) > 0){
			$total = 0;
			foreach($this->itens as $t){
				$total += $t->quantidade * $t->valor_unitario;
			}
			return $total;
		}else{
			return 0;
		}
	}

	public static function filtroData($dataInicial, $dataFinal){
		$value = session('user_logged');
        $empresa_id = $value['empresa'];
		$c = Compra::
		select('compras.*')
		->whereBetween('compras.crated_at', [$dataInicial, 
			$dataFinal])
		->where('compras.empresa_id', $empresa_id);
		return $c->get();
	}
	
	public static function filtroDataFornecedor($fornecedor, $dataInicial, $dataFinal){
		$value = session('user_logged');
        $empresa_id = $value['empresa'];
		$c = Compra::
		select('compras.*')
		->join('fornecedors', 'fornecedors.id' , '=', 'compras.fornecedor_id')
		->where('fornecedors.razao_social', 'LIKE', "%$fornecedor%")
		->whereBetween('compras.created_at', [$dataInicial, 
			$dataFinal])
		->where('compras.empresa_id', $empresa_id);

		return $c->get();
	}

	public static function filtroFornecedor($fornecedor){
		$value = session('user_logged');
        $empresa_id = $value['empresa'];
		$c = Compra::
		select('compras.*')
		->join('fornecedors', 'fornecedors.id' , '=', 'compras.fornecedor_id')
		->where('razao_social', 'LIKE', "%$fornecedor%")
		->where('compras.empresa_id', $empresa_id);

		return $c->get();
	}


	public static function pesquisaProduto($pesquisa){
		$value = session('user_logged');
        $empresa_id = $value['empresa'];
		return Compra::
		select('compras.*')
		->join('item_compras', 'compras.id' , '=', 'item_compras.compra_id')
		->join('produtos', 'produtos.id' , '=', 'item_compras.produto_id')
		->where('produtos.nome', 'LIKE', "%$pesquisa%")
		->where('compras.empresa_id', $empresa_id)
		->get();
	}

	public static function tiposPagamento(){
        return [
            '01' => 'Dinheiro',
            '02' => 'Cheque',
            '03' => 'Cartão de Crédito',
            '04' => 'Cartão de Débito',
            '05' => 'Crédito Loja',
            '10' => 'Vale Alimentação',
            '11' => 'Vale Refeição',
            '12' => 'Vale Presente',
            '13' => 'Vale Combustível',
            '14' => 'Duplicata Mercantil',
            '15' => 'Boleto Bancário',
            '90' => 'Sem pagamento',
            '99' => 'Outros',
        ];
    }

}
