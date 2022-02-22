<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\NaturezaOperacao;
class Produto extends Model
{
	protected $fillable = [
		'nome', 'categoria_id', 'cor', 'valor_venda', 'NCM', 'CST_CSOSN', 'CST_PIS', 'CST_COFINS', 'CST_IPI', 'unidade_compra', 'unidade_venda', 'composto', 'codBarras', 'conversao_unitaria', 'valor_livre', 'perc_icms', 'perc_pis', 'perc_cofins', 'perc_ipi', 'CFOP_saida_estadual', 'CFOP_saida_inter_estadual', 'codigo_anp', 
		'descricao_anp', 'perc_iss', 'cListServ', 'imagem', 'alerta_vencimento', 'valor_compra', 'gerenciar_estoque', 'estoque_minimo', 'referencia', 'empresa_id', 'largura', 'comprimento', 'altura', 'peso_liquido', 'peso_bruto', 'ativo', 'limite_maximo_desconto'
	];

	public function categoria(){
		return $this->belongsTo(Categoria::class, 'categoria_id');
	}

	public function receita(){
		return $this->hasOne('App\Receita', 'produto_id', 'id');
	}

	public function estoque(){
		return $this->hasOne('App\Estoque', 'produto_id', 'id');
	}
	
	public function delivery(){
		return $this->hasOne('App\ProdutoDelivery', 'produto_id', 'id');
	}

	public function listaPreco(){
		return $this->hasMany('App\ProdutoListaPreco', 'produto_id', 'id');
	}

	public static function verificaCadastrado($ean, $nome, $referencia){
		$value = session('user_logged');
		$empresa_id = $value['empresa'];
		$result = null;
		$result = Produto::
		where('referencia', $referencia)
		->where('empresa_id', $empresa_id)
		->first();

		if(!$result){
			$result = Produto::
			where('nome', $nome)
			->where('empresa_id', $empresa_id)
			->first();
		}

		if(!$result){
			$result = Produto::
			where('codBarras', $ean)
			->where('codBarras', '!=', 'SEM GTIN')
			->where('empresa_id', $empresa_id)
			->first();
		}

		//verifica por codBarras e nome o PROD

		return $result;
	}

	public static function unidadesMedida(){
		return [
			"AMPOLA",
			"BALDE",
			"BANDEJ",
			"BARRA",
			"BISNAG",
			"BLOCO",
			"BOBINA",
			"BOMB",
			"CAPS",
			"CART",
			"CENTO",
			"CJ",
			"CM",
			"CM2",
			"CX",
			"CX2",
			"CX3",
			"CX5",
			"CX10",
			"CX15",
			"CX20",
			"CX25",
			"CX50",
			"CX100",
			"DISP",
			"DUZIA",
			"EMBAL",
			"FARDO",
			"FOLHA",
			"FRASCO",
			"GALAO",
			"GF",
			"GRAMAS",
			"JOGO",
			"KG",
			"KIT",
			"LATA",
			"LITRO",
			"M",
			"M2",
			"M3",
			"MILHEI",
			"ML",
			"MWH",
			"PACOTE",
			"PALETE",
			"PARES",
			"PC",
			"POTE",
			"K",
			"RESMA",
			"ROLO",
			"SACO",
			"SACOLA",
			"TAMBOR",
			"TANQUE",
			"TON",
			"TUBO",
			"UNID",
			"VASIL",
			"VIDRO"
		];
	}

	public static function listaCSTCSOSN(){
		return [
			'00' => 'Tributa integralmente',
			'10' => 'Tributada e com cobrança do ICMS por substituição tributária',
			'20' => 'Com redução da Base de Calculo',
			'30' => 'Isenta / não tributada e com cobrança do ICMS por substituição tributária',
			'40' => 'Isenta',
			'41' => 'Não tributada',
			'50' => 'Com suspensão',
			'51' => 'Com diferimento',
			'60' => 'ICMS cobrado anteriormente por substituição tributária',
			'70' => 'Com redução da BC e cobrança do ICMS por substituição tributária',
			'90' => 'Outras',

			'101' => 'Tributada pelo Simples Nacional com permissão de crédito',
			'102' => 'Tributada pelo Simples Nacional sem permissão de crédito',
			'103' => 'Isenção do ICMS no Simples Nacional para faixa de receita bruta',
			'201' => 'Tributada pelo Simples Nacional com permissão de crédito e com cobrança do ICMS por substituição tributária',
			'202' => 'Tributada pelo Simples Nacional sem permissão de crédito e com cobrança do ICMS por substituição tributária',
			'203' => 'Isenção do ICMS no Simples Nacional para faixa de receita bruta e com cobrança do ICMS por substituição tributária',
			'300' => 'Imune',
			'400' => 'Não tributada pelo Simples Nacional',
			'500' => 'ICMS cobrado anteriormente por substituição tributária (substituído) ou por antecipação',
			'900' => 'Outros',
		];
	}

	public static function listaCST_PIS_COFINS(){
		return [
			'01' => 'Operação Tributável com Alíquota Básica',
			'02' => 'Operação Tributável com Alíquota por Unidade de Medida de Produto',
			'03' => 'Operação Tributável com Alíquota por Unidade de Medida de Produto',
			'04' => 'Operação Tributável Monofásica – Revenda a Alíquota Zero',
			'05' => 'Operação Tributável por Substituição Tributária',
			'06' => 'Operação Tributável a Alíquota Zero', 
			'07' => 'Operação Isenta da Contribuição', 
			'08' => 'Operação sem Incidência da Contribuição', 
			'09' => 'Operação com Suspensão da Contribuição', 
			'49' => 'Outras Operações de Saída'
		];
	}

	public static function listaCST_IPI(){
		return [
			'50' => 'Saída Tributada',
			'51' => 'Saída Tributável com Alíquota Zero',
			'52' => 'Saída Isenta',
			'53' => 'Saída Não Tributada',
			'54' => 'Saída Imune',
			'55' => 'Saída com Suspensão',
			'99' => 'Outras Saídas'
		];
	}

	public static function firstNatureza($empresa_id){
		return NaturezaOperacao::
		where('empresa_id', $empresa_id)
		->first();
	}

	public static function lista_ANP(){
		return [
			'210101001' => 	'GAS COMBUSTIVEL',
			'420301002' =>	'OUTROS OLEOS DIESEL',
			'210201001' =>	'PROPANO',
			'420301003' =>	'OLEO DIESEL FORA DE ESPECIFICACAO',
			'210201002' =>	'PROPANO ESPECIAL',
			'510101001' =>	'OLEO COMBUSTIVEL A1',
			'210201003' =>	'PROPENO',
			'510101002' =>	'OLEO COMBUSTIVEL A2',
			'210202001' =>	'BUTANO',
			'510101003' =>	'OLEO COMBUSTIVEL A FORA DE ESPECIFICACAO',
			'210202002' =>	'BUTANO ESPECIAL',
			'510102001' =>	'OLEO COMBUSTIVEL B1',
			'210202003' =>	'BUTADIENO',
			'510102002' =>	'OLEO COMBUSTIVEL B2',
			'210203001' =>	'GLP', 
			'510102003' =>	'OLEO COMBUSTIVEL B FORA DE ESPECIFICACAO',
			'210203002' =>	'GLP FORA DE ESPECIFICACAO',
			'510201001' =>	'OLEO COMBUSTIVEL MARITIMO',
			'210204001' =>	'GAS LIQUEFEITO INTERMEDIARIO',	
			'510201002' =>	'OLEO COMBUSTIVEL MARÍTIMO FORA DE ESPECIFICACAO',
			'210204002' =>	'OUTROS GASES LIQUEFEITOS',
			'510201003' =>	'OLEO COMBUSTIVEL MARÍTIMO MISTURA (MF)',
			'210301001' =>	'ETANO',
			'510301001' =>	'OUTROS OLEOS COMBUSTIVEIS',
			'210301002' =>	'ETENO',
			'510301002' =>	'ÓLEOS COMBUSTIVEIS PARA EXPORTACAO',
			'210302001' =>	'OUTROS GASES	',
			'510301003' =>	'OLEO COMBUSTIVEL PARA GERAAOO ELETRICA',
			'210302002' =>	'GAS INTERMEDIARIO',	
			'540101001' =>	'COQUE VERDE',
			'210302003' =>	'GAS DE XISTO',	
			'540101002' =>	'COQUE CALCINADO',
			'210302004' =>	'GAS ACIDO',
			'810101001' =>	'ETANOL HIDRATADO COMUM',
			'220101001' =>	'GAS NATURAL UMIDO',	
			'810101002' =>	'ETANOL HIDRATADO ADITIVADO',
			'220101002' =>	'GAS NATURAL SECO',	
			'810101003' =>	'ETANOL HIDRATADO FORA DE ESPECIFICACAO',
			'220101003' =>	'GAS NATURAL COMPRIMIDO',	
			'810102001' =>	'ETANOL ANIDRO',
			'220101004' =>	'GAS NATURAL LIQUEFEITO',	
			'810102002' =>	'ETANOL ANIDRO FORA DE ESPECIFICACAO',
			'220101005' =>	'GAS NATURAL VEICULAR',	
			'810102003' =>	'ETANOL ANIDRO PADRAO',
			'220101006' =>	'GAS NATURAL VEICULAR PADRAO',	
			'810102004' =>	'ETANOL ANIDRO COM CORANTE',
			'220102001' =>	'GASOLINA NATURAL (C5+)',	
			'810201001' =>	'ALCOOL METILICO',
			'220102002' =>	'LIQUIDO DE GAS NATURAL',	
			'810201002' =>	'OUTROS ALCOOIS',
			'320101001' =>	'GASOLINA A COMUM', 
			'820101001' =>	'BIODIESEL B100', 
			'320101002' =>	'GASOLINA A PREMIUM	', 
			'820101002' =>	'DIESEL B4 S1800 - COMUM', 
			'320101003' =>	'GASOLINA A FORA DE ESPECIFICACAO', 	
			'820101003' =>	'OLEO DIESEL B S1800 - COMUM', 
			'320102001' =>	'GASOLINA C COMUM', 	
			'820101004' =>	'DIESEL B10', 
			'320102002' =>	'GASOLINA C ADITIVADA', 	
			'820101005' =>	'DIESEL B15', 
			'320102003' =>	'GASOLINA C PREMIUM', 
			'820101006' =>	'DIESEL B20 S1800 - COMUM', 
			'320102004' =>	'GASOLINA C FORA DE ESPECIFICACAO', 	
			'820101007' =>	'DIESEL B4 S1800 - ADITIVADO',
			'320103001' =>	'GASOLINA AUTOMOTIVA PADRAO	',
			'820101008' =>	'DIESEL B4 S500 - COMUM',
			'320103002' =>	'OUTRAS GASOLINAS AUTOMOTIVAS',
			'820101009' =>	'DIESEL B4 S500 - ADITIVADO',
			'320201001' =>	'GASOLINA DE AVIACAO',
			'820101010' =>	'BIODIESEL FORA DE ESPECIFICACAO',
			'320201002' =>	'GASOLINA DE AVIAÇÃO FORA DE ESPECIFICACAO',
			'820101011' =>	'OLEO DIESEL B S1800 - ADITIVADO',
			'320301001' =>	'OUTRAS GASOLINAS',
			'820101012' =>	'OLEO DIESEL B S500 - COMUM',
			'320301002' =>	'GASOLINA PARA EXPORTACAO',	
			'820101013' =>	'OLEO DIESEL B S500 - ADITIVADO',
			'410101001' =>	'QUEROSENE DE AVIACAO',	
			'820101014' =>	'DIESEL B20 S1800 - ADITIVADO',
			'410101002' =>	'QUEROSENE DE AVIAÇÃO FORA DE ESPECIFICACAO	',
			'820101015' =>	'DIESEL B20 S500 - COMUM',
			'410102001' =>	'QUEROSENE ILUMINANTE	',
			'820101016' =>	'DIESEL B20 S500 - ADITIVADO',
			'410102002' =>	'QUEROSENE ILUMINANTE FORA DE ESPECIFICACAO	',
			'820101017' =>	'DIESEL MARÍTIMO - DMA B2',
			'410103001' =>	'OUTROS QUEROSENES	',
			'820101018' =>	'DIESEL MARITIMO - DMA B5',
			'420101003' =>	'OLEO DIESEL A S1800 - FORA DE ESPECIFICACAO',	
			'820101019' =>	'DIESEL MARITIMO - DMB B2',
			'420101004' =>	'OLEO DIESEL A S1800 - COMUM',	
			'820101020' =>	'DIESEL MARITIMO - DMB B5',
			'420101005' =>	'OLEO DIESEL A S1800 - ADITIVADO',	
			'820101021' =>	'DIESEL NAUTICO B2 ESPECIAL - 200 PPM ENXOFRE',
			'420102003' =>	'OLEO DIESEL A S500 - FORA DE ESPECIFICACAO',	
			'820101022' =>	'DIESEL B2 ESPECIAL - 200 PPM ENXOFRE',
			'420102004' =>	'OLEO DIESEL A S500 - COMUM',	
			'820101025' =>	'DIESEL B30',
			'420102005' =>	'OLEO DIESEL A S500 - ADITIVADO	',
			'820101026' =>	'DIESEL B S1800 PARA GERACAO DE ENERGIA ELETRICA',
			'420102006' =>	'OLEO DIESEL A S50	',
			'820101027' =>	'DIESEL B S500 PARA GERACAO DE ENERGIA ELETRICA',
			'420104001' =>	'OLEO DIESEL AUTOMOTIVO ESPECIAL - ENXOFRE 200 PPM	',
			'820101028' =>	'OLEO DIESEL B S50 - ADITIVADO',
			'420105001' =>	'OLEO DIESEL A S10',	
			'820101029' =>	'OLEO DIESEL B S50 - COMUM',
			'420201001' =>	'DMA - MGO',	
			'820101030' =>	'DIESEL B20 S50 COMUM',
			'420201002' =>	'OLEO DIESEL MARITIMO FORA DE ESPECIFICACAO',	
			'820101031' =>	'DIESEL B20 S50 ADITIVADO',
			'420201003' =>	'DMB - MDO',	
			'820101032' =>	'DIESEL B S50 PARA GERACAO DE ENERGIA ELETRICA',
			'420202001' =>	'OLEO DIESEL NAUTICO ESPECIAL - ENXOFRE 200 PPM',	
			'820101033' =>	'OLEO DIESEL B S10 - ADITIVADO',
			'420301001' =>	'OLEO DIESEL PADRAO',	
			'820101034' =>	'OLEO DIESEL B S10 - COMUM'
		];
	}

	public function somaVendas(){
		$sql = \DB::table('item_vendas')
		->select(\DB::raw('SUM(quantidade) as quantidade'))
		->where('produto_id', $this->id)
		->first();
		return $sql->quantidade ? $sql->quantidade : 0;
	}

	public function estoqueAtual(){
		$estoque = $this->estoque;
		if($this->gerenciar_estoque == 0) return '--';

		if(!$estoque) return 0;
		if($estoque){
			if($this->unidade_venda == 'UN' || $this->unidade_venda == 'UNID'){
				return number_format($estoque->quantidade);
			}
			return $estoque->quantidade;
		}

	}

}
