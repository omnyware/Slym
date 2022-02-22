<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ConfigNota;
class Cte extends Model
{
    protected $fillable = [
        'chave_nfe', 'remetente_id', 'destinatario_id', 'usuario_id', 'natureza_id', 'tomador',
        'municipio_envio', 'municipio_inicio', 'municipio_fim', 'logradouro_tomador', 'numero_tomador', 'bairro_tomador', 'cep_tomador', 'municipio_tomador',
        'valor_transporte', 'valor_receber', 'valor_carga', 
        'produto_predominante', 'data_previsata_entrega', 'observacao',
        'sequencia_cce', 'cte_numero', 'chave', 'path_xml', 'estado', 'retira', 'detalhes_retira',
        'modal', 'veiculo_id', 'tpDoc', 'descOutros', 'nDoc', 'vDocFisc', 'empresa_id', 'globalizado', 'CST'
    ];


   // 0-Remetente; 1-Expedidor; 2-Recebedor; 3-Destinatário

    public function getTomador(){
        if($this->tomador == 0) return 'Remetente';
        else if($this->tomador == 1) return 'Expedidor';
        else if($this->tomador == 2) return 'Recebedor';
        else if($this->tomador == 3) return 'Destinatário';
    }

    public function componentes(){
        return $this->hasMany('App\ComponenteCte', 'cte_id', 'id');
    }

    public function medidas(){
        return $this->hasMany('App\MedidaCte', 'cte_id', 'id');
    }

    public function natureza(){
        return $this->belongsTo(NaturezaOperacao::class, 'natureza_id');
    }

    public function despesas(){
        return $this->hasMany('App\DespesaCte', 'cte_id', 'id');
    }

    public function receitas(){
        return $this->hasMany('App\ReceitaCte', 'cte_id', 'id');
    }

    public function somaDespesa(){
        $total = 0;
        foreach($this->despesas as $d){
            $total += $d->valor;
        }
        return $total;
    }

    public function somaReceita(){
        $total = 0;
        foreach($this->receitas as $r){
            $total += $r->valor;
        }
        return $total;
    }

    public function destinatario(){
        return $this->belongsTo(Cliente::class, 'destinatario_id');
    }

    public function veiculo(){
        return $this->belongsTo(Veiculo::class, 'veiculo_id');
    }

    public function remetente(){
        return $this->belongsTo(Cliente::class, 'remetente_id');
    }

    public function municipioTomador(){
        return $this->belongsTo(Cidade::class, 'municipio_tomador');
    }

    public function municipioEnvio(){
        return $this->belongsTo(Cidade::class, 'municipio_envio');
    }

    public static function lastCTe(){
        $value = session('user_logged');
        $empresa_id = $value['empresa'];
        $cte = Cte::
        where('cte_numero', '!=', 0)
        ->where('empresa_id', $empresa_id)
        ->orderBy('cte_numero', 'desc')
        ->first();

        $config = ConfigNota::
        where('empresa_id', $empresa_id)
        ->first();
        if($cte == null) {
            return $config->ultimo_numero_cte;
        }else{ 

            return $config->ultimo_numero_cte > $cte->cte_numero ? $config->ultimo_numero_cte : $cte->cte_numero;

        }
    }

    public static function unidadesMedida(){
        return [
            '00' => 'M3',
            '01' => 'KG',
            '02' => 'TON',
            '03' => 'UNIDADE',
            '04' => 'M2',
        ];
    }

    public static function modals(){
        return [
            '01' => 'RODOVIARIO',
            '02' => 'AEREO',
            '03' => 'AQUAVIARIO',
            '04' => 'FERROVIARIO', 
            '05' => 'DUTOVIARIO', 
            '06' => 'MULTIMODAL',
        ];
    }

    public static function tiposMedida(){
        return [
            'PESO BRUTO',
            'PESO DECLARADO',
            'PESO CUBADO',
            'PESO AFORADO', 
            'PESO AFERIDO',
            'LITRAGEM', 
            'CAIXAS'
        ];
    }

    public static function tiposTomador(){
        return [
            '0' => 'Remetente',
            '1' => 'Expedidor', 
            '2' => 'Recebedor',
            '3' => 'Destinatário'
        ];
    }

    public static function gruposCte(){
        return [
            'ide',
            'toma03',
            'toma04',
            'enderToma',
            'autXML',
            'compl',
            'ObsCont',
            'ObsFisco',
            'emit',
            'enderEmit',
            'rem',
            'enderReme',
            'infNF',
            'infOutros',
            'infUnidTransp',
            'IacUnidCarga',
            'infUnidCarga',
            'exped',
            'enderExped',
            'receb',
            'enderReceb',
            'dest',
            'enderDest',
            'vPrest',
            'Comp',
            'imp',
            'ICMS',
            'infQ',
            'docAnt'
        ];
    }

    public static function listaCST(){
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
            'SN' => 'Simples Nacional',
        ];
    }

    public static function filtroData($dataInicial, $dataFinal, $estado){
        $value = session('user_logged');
        $empresa_id = $value['empresa'];
        $c = Cte::
        where('empresa_id', $empresa_id)
        ->whereBetween('data_registro', [$dataInicial, 
            $dataFinal]);

        if($estado != 'TODOS') $c->where('ctes.estado', $estado);

        return $c->get();
    }

    public static function filtroDataCliente($cliente, $dataInicial, $dataFinal, $estado){
        $value = session('user_logged');
        $empresa_id = $value['empresa'];
        $c = Cte::
        select('ctes.*')
        ->join('clientes', 'clientes.id' , '=', 'ctes.cliente_id')
        ->where('ctes.empresa_id', $empresa_id)
        ->where('clientes.razao_social', 'LIKE', "%$cliente%")

        ->whereBetween('data_registro', [$dataInicial, 
            $dataFinal]);

        if($estado != 'TODOS') $c->where('ctes.estado', $estado);
        return $c->get();
    }

    public static function filtroCliente($cliente, $estado){
        $value = session('user_logged');
        $empresa_id = $value['empresa'];
        $c = Cte::
        select('ctes.*')
        ->join('clientes', 'clientes.id' , '=', 'ctes.cliente_id')
        ->where('ctes.empresa_id', $empresa_id)
        ->where('clientes.razao_social', 'LIKE', "%$cliente%");

        if($estado != 'TODOS') $c->where('ctes.estado', $estado);

        return $c->get();
    }

    public static function filtroEstado($estado){
        $value = session('user_logged');
        $empresa_id = $value['empresa'];
        $c = Cte::
        where('ctes.empresa_id', $empresa_id)
        ->where('ctes.estado', $estado);

        return $c->get();
    }
}
