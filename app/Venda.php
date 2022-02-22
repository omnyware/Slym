<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Devolucao;
use App\ConfigNota;
use App\Compra;

class Venda extends Model
{
    protected $fillable = [
        'cliente_id', 'usuario_id', 'frete_id', 'valor_total', 'forma_pagamento', 'NfNumero',
        'natureza_id', 'chave', 'path_xml', 'estado', 'observacao', 'desconto', 'transportadora_id', 'sequencia_cce', 'tipo_pagamento', 'empresa_id', 'chave_ref', 'serie'
    ];

    public function duplicatas(){
        return $this->hasMany('App\ContaReceber', 'venda_id', 'id');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function natureza(){
        return $this->belongsTo(NaturezaOperacao::class, 'natureza_id');
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function frete(){
        return $this->belongsTo(Frete::class, 'frete_id');
    }

    public function transportadora(){
        return $this->belongsTo(Transportadora::class, 'transportadora_id');
    }

    public function itens(){
        return $this->hasMany('App\ItemVenda', 'venda_id', 'id');
    }

    public static function lastNF($empresa_id = null){
        if($empresa_id == null){
            $value = session('user_logged');
            $empresa_id = $value['empresa'];
        }else{
            $empresa_id = $empresa_id;
        }

        $config = ConfigNota::
        where('empresa_id', $empresa_id)
        ->first();

        $venda = Venda::
        where('NfNumero', '!=', 0)
        ->where('empresa_id', $empresa_id)
        ->where('serie', '=', $config->numero_serie_nfe)
        ->orderBy('NfNumero', 'desc')
        ->first();

        $venda = Venda::
        where('NfNumero', '!=', 0)
        ->where('empresa_id', $empresa_id)
        ->where('serie', '=', $config->numero_serie_nfe)
        ->orderBy('NfNumero', 'desc')
        ->first();

        $devolucao = Devolucao::
        where('numero_gerado', '!=', 0)
        ->where('empresa_id', $empresa_id)
        ->where('serie', '=', $config->numero_serie_nfe)
        ->orderBy('numero_gerado', 'desc')
        ->first();

        $compra = Compra::
        where('numero_emissao', '!=', 0)
        ->where('empresa_id', $empresa_id)
        ->where('serie', '=', $config->numero_serie_nfe)
        ->orderBy('numero_emissao', 'desc')
        ->first();

        $numeroDevolucao = $devolucao != null ? $devolucao->numero_gerado : 0;
        $numeroCompra = $compra != null ? $compra->numero_emissao : 0;
        $numeroVenda = $venda != null ? $venda->NfNumero : 0;

        if($venda != null || $devolucao != null || $compra != null){
            $numeroConfig = ConfigNota::
            where('empresa_id', $empresa_id)->first()->ultimo_numero_nfe ?? 0;
            if($numeroDevolucao > $numeroVenda && $numeroDevolucao > $numeroCompra && $numeroDevolucao > $numeroConfig){
                return $numeroDevolucao;
            }
            else if($numeroVenda > $numeroDevolucao && $numeroVenda > $numeroCompra && $numeroVenda > $numeroConfig){
                return $numeroVenda;
            }
            else if($numeroCompra > $numeroDevolucao && $numeroCompra > $numeroVenda && $numeroCompra > $numeroConfig){
                return $numeroCompra;
            }else{
                return $numeroConfig;
            }


        }else{
            return ConfigNota::where('empresa_id', $empresa_id)->first()->ultimo_numero_nfe;
        }

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

    public static function filtroData($dataInicial, $dataFinal, $estado){
        $value = session('user_logged');
        $empresa_id = $value['empresa'];
        $c = Venda::
        select('vendas.*')
        ->whereBetween('data_registro', [$dataInicial, 
            $dataFinal])
        ->where('vendas.empresa_id', $empresa_id)
        ->where('vendas.forma_pagamento', '!=', 'conta_crediario');

        if($estado != 'TODOS') $c->where('vendas.estado', $estado);
        
        return $c->get();
    }

    public static function filtroDataCliente($cliente, $dataInicial, $dataFinal, $estado){
        $value = session('user_logged');
        $empresa_id = $value['empresa'];
        $c = Venda::
        select('vendas.*')
        ->join('clientes', 'clientes.id' , '=', 'vendas.cliente_id')
        ->where('clientes.razao_social', 'LIKE', "%$cliente%")
        ->where('vendas.forma_pagamento', '!=', 'conta_crediario')
        ->where('vendas.empresa_id', $empresa_id)

        ->whereBetween('data_registro', [$dataInicial, 
            $dataFinal]);

        if($estado != 'TODOS') $c->where('vendas.estado', $estado);
        return $c->get();
    }

    public static function filtroCliente($cliente, $estado){
        $value = session('user_logged');
        $empresa_id = $value['empresa'];
        $c = Venda::
        select('vendas.*')
        ->join('clientes', 'clientes.id' , '=', 'vendas.cliente_id')
        ->where('clientes.razao_social', 'LIKE', "%$cliente%")
        ->where('vendas.empresa_id', $empresa_id)
        ->where('vendas.forma_pagamento', '!=', 'conta_crediario');

        if($estado != 'TODOS') $c->where('vendas.estado', $estado);
        
        return $c->get();
    }

    public static function filtroEstado($estado){
        $value = session('user_logged');
        $empresa_id = $value['empresa'];
        $c = Venda::
        where('vendas.estado', $estado)
        ->where('vendas.empresa_id', $empresa_id)
        ->where('vendas.forma_pagamento', '!=', 'conta_crediario');
        return $c->get();
    }


    public static function filtroDataApp($dataInicial, $dataFinal, $estado, $empresa_id){

        $c = Venda::
        select('vendas.*')
        ->whereBetween('data_registro', [$dataInicial, 
            $dataFinal])
        ->where('vendas.empresa_id', $empresa_id)
        ->where('vendas.forma_pagamento', '!=', 'conta_crediario');

        if($estado != 'TODOS') $c->where('vendas.estado', $estado);
        
        return $c->get();
    }

    public static function filtroDataClienteApp($cliente, $dataInicial, $dataFinal, $estado, $empresa_id){

        $c = Venda::
        select('vendas.*')
        ->join('clientes', 'clientes.id' , '=', 'vendas.cliente_id')
        ->where('clientes.razao_social', 'LIKE', "%$cliente%")
        ->where('vendas.forma_pagamento', '!=', 'conta_crediario')
        ->where('vendas.empresa_id', $empresa_id)

        ->whereBetween('data_registro', [$dataInicial, 
            $dataFinal]);

        if($estado != 'TODOS') $c->where('vendas.estado', $estado);
        return $c->get();
    }

    public static function filtroClienteApp($cliente, $estado, $empresa_id){

        $c = Venda::
        select('vendas.*')
        ->join('clientes', 'clientes.id' , '=', 'vendas.cliente_id')
        ->where('clientes.razao_social', 'LIKE', "%$cliente%")
        ->where('vendas.empresa_id', $empresa_id)
        ->where('vendas.forma_pagamento', '!=', 'conta_crediario');

        if($estado != 'TODOS') $c->where('vendas.estado', $estado);
        
        return $c->get();
    }

    public static function filtroEstadoApp($estado, $empresa_id){

        $c = Venda::
        where('vendas.estado', $estado)
        ->where('vendas.empresa_id', $empresa_id)
        ->where('vendas.forma_pagamento', '!=', 'conta_crediario');
        return $c->get();
    }

    public function getTipoPagamento(){
        foreach(Venda::tiposPagamento() as $key => $t){
            if($this->tipo_pagamento == $key) return $t;
        }
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
