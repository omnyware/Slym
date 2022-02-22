<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mdfe extends Model
{

	protected $fillable = [
		'uf_inicio', 'uf_fim', 'encerrado', 'data_inicio_viagem', 'carga_posterior', 'veiculo_tracao_id', 
		'veiculo_reboque_id', 'estado', 'seguradora_nome', 'seguradora_cnpj', 'numero_apolice',
		'numero_averbacao', 'valor_carga', 'quantidade_carga', 'info_complementar', 
		'info_adicional_fisco', 'cnpj_contratante', 'mdfe_numero', 'condutor_nome', 'condutor_cpf',
		'tp_emit', 'tp_transp', 'lac_rodo', 'chave', 'protocolo', 'empresa_id', 
		'produto_pred_nome', 'produto_pred_ncm', 'produto_pred_cod_barras', 'cep_carrega',
		'cep_descarrega', 'tp_carga'
	];

	public function veiculoTracao(){
		return $this->belongsTo(Veiculo::class, 'veiculo_tracao_id');
	}
	public function veiculoReboque(){
		return $this->belongsTo(Veiculo::class, 'veiculo_reboque_id');
	}

	public function municipiosCarregamento(){
		return $this->hasMany('App\MunicipioCarregamento', 'mdfe_id', 'id');
	}

	public function ciots(){
		return $this->hasMany('App\Ciot', 'mdfe_id', 'id');
	}

	public function percurso(){
		return $this->hasMany('App\Percurso', 'mdfe_id', 'id');
	}

	public function valesPedagio(){
		return $this->hasMany('App\ValePedagio', 'mdfe_id', 'id');
	}

	public function infoDescarga(){
		return $this->hasMany('App\InfoDescarga', 'mdfe_id', 'id');
	}

	public static function filtroData($dataInicial, $dataFinal, $estado){
		$value = session('user_logged');
		$empresa_id = $value['empresa'];
		$c = Mdfe::
		where('empresa_id', $empresa_id)
		->whereBetween('created_at', [$dataInicial, 
			$dataFinal]);

		if($estado != 'TODOS') $c->where('estado', $estado);

		return $c->get();
	}

	public static function lastMdfe(){
		$value = session('user_logged');
		$empresa_id = $value['empresa'];
		$mdfe = Mdfe::
		where('mdfe_numero', '!=', 0)
		->where('empresa_id', $empresa_id)
		->orderBy('mdfe_numero', 'desc')
		->first();

		if($mdfe == null) {
			return ConfigNota::
			where('empresa_id', $empresa_id)
			->first()->ultimo_numero_mdfe;
		}
		else{ 
			$configNum = ConfigNota::
			where('empresa_id', $empresa_id)
			->first()->ultimo_numero_mdfe;
			return $configNum > $mdfe->mdfe_numero ? $configNum : $mdfe->mdfe_numero;
		}
	}

	public function itens(){
		return $this->hasMany('App\ItemVenda', 'venda_id', 'id');
	}

	public static function cUF(){
		return [
			'12' => 'AC',
			'27' => 'AL',
			'13' => 'AM',
			'16' => 'AP',
			'29' => 'BA',
			'23' => 'CE',
			'53' => 'DF',
			'32' => 'ES',
			'52' => 'GO',
			'21' => 'MA',
			'31' => 'MG',
			'50' => 'MS',
			'51' => 'MT',
			'15' => 'PA',
			'25' => 'PB',
			'26' => 'PE',
			'22' => 'PI',
			'41' => 'PR',
			'33' => 'RJ',
			'24' => 'RN',
			'11' => 'RO',
			'14' => 'RR',
			'43' => 'RS',
			'42' => 'SC',
			'28' => 'SE',
			'35' => 'SP',
			'17' => 'TO'
		];

	}

	public static function tiposUnidadeTransporte(){
		return [
			'1' => 'Rodoviário Tração',
			'2' => 'Rodoviário Reboque',
			'3' => 'Navio',
			'4' => 'Balsa',
			'5' => 'Aeronave',
			'6' => 'Vagão',
			'7' => 'Outros'
		];
	}

	public static function tiposCarga(){
		return [
			'01' => 'Granel sólido', 
			'02' => 'Granel líquido', 
			'03' => 'Frigorificada', 
			'04' => 'Conteinerizada', 
			'05' => 'Carga Geral',
			'06' => 'Neogranel',
			'07' => 'Perigosa (granel sólido)',
			'08' => 'Perigosa (granel líquido)',
			'09' => 'Perigosa (carga frigorificada)',
			'10' => 'Perigosa (conteinerizada)',
			'11' => 'Perigosa (carga geral)'
		];
	}
}
