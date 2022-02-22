<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    protected $fillable = [
        'cliente_id', 'usuario_id', 'frete_id', 'valor_total', 'forma_pagamento', 'email_enviado','natureza_id', 'estado', 'observacao', 'desconto', 'transportadora_id', 'tipo_pagamento', 'validade', 'venda_id', 'empresa_id'
    ];

    public function duplicatas(){
        return $this->hasMany('App\FaturaOrcamento', 'orcamento_id', 'id');
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
        return $this->hasMany('App\ItemOrcamento', 'orcamento_id', 'id');
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
        $c = Orcamento::
        select('orcamentos.*')
        ->whereBetween('created_at', [$dataInicial, 
            $dataFinal])
        ->where('orcamentos.forma_pagamento', '!=', 'conta_crediario');

        if($estado != 'TODOS') $c->where('orcamentos.estado', $estado);
        
        return $c->get();
    }

    public static function filtroDataCliente($cliente, $dataInicial, $dataFinal, $estado){
        $c = Orcamento::
        select('orcamentos.*')
        ->join('clientes', 'clientes.id' , '=', 'orcamentos.cliente_id')
        ->where('clientes.razao_social', 'LIKE', "%$cliente%")
        ->where('orcamentos.forma_pagamento', '!=', 'conta_crediario')

        ->whereBetween('orcamentos.created_at', [$dataInicial, 
            $dataFinal]);

        if($estado != 'TODOS') $c->where('orcamentos.estado', $estado);
        return $c->get();
    }

    public static function filtroCliente($cliente, $estado){
        $c = Orcamento::
        select('orcamentos.*')
        ->join('clientes', 'clientes.id' , '=', 'orcamentos.cliente_id')
        ->where('clientes.razao_social', 'LIKE', "%$cliente%")
        ->where('orcamentos.forma_pagamento', '!=', 'conta_crediario');

        if($estado != 'TODOS') $c->where('orcamentos.estado', $estado);
        
        return $c->get();
    }

    public function validaFatura($data){
        $strotimeData = strtotime($data);
        foreach($this->duplicatas as $dp){
            $strtotimeVencimento = strtotime($dp->vencimento);
            if($strotimeData - $strtotimeVencimento < 0){
                return false;
            }
        }
        return true;
    }

    public static function filtroEstado($estado){
        $c = Orcamento::
        where('orcamentos.estado', $estado);
        return $c->get();
    }

    public function getTipoPagamento(){
        foreach(Orcamento::tiposPagamento() as $key => $t){
            if($this->tipo_pagamento == $key) return $t;
        }
    }

    public function somaParcelas(){
        $soma = 0;
        foreach($this->duplicatas as $dp){
            $soma += $dp->valor;
        }
        return $soma;
    }

    public function validaGerarVenda(){
        if($this->valor_total - $this->desconto != $this->somaParcelas()) return false;

        if(sizeof($this->itens) == 0) return false;

        return true;
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
