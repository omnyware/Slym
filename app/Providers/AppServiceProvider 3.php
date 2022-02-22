<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\ItemCompra;
use App\Produto;
use App\ContaPagar;
use App\ContaReceber;
use App\Estoque;
use Illuminate\Http\Request;
use App\Helpers\Menu;


class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {   

        view()->composer('*',function($view){

            $menu = new Menu();

            // print_r($menu->getMenu());

            // die();


            $value = session('user_logged');

            $empresa_id = $value['empresa'];

            $alertas = [];
            $semValidade = $this->verificaItensSemValidade($empresa_id);
            if($semValidade) {
                array_push($alertas, 
                    [
                        'msg' => 'Existe itens em estoque sem cadastro de data de validade!',
                        'titulo' => 'Alerta validade',
                        'link' => '/compras/produtosSemValidade'
                    ]
                );
            }

            $alertaValidade = $this->verificaValidadeProdutos($empresa_id);
            if($alertaValidade) {
                array_push($alertas, 
                    [
                        'msg' => 'Existe Produtos com validade próxima!',
                        'titulo' => 'Validade próxima',
                        'link' => '/compras/validadeAlerta'
                    ]
                );
            }

            $somaContas = $this->verificaContasPagar($empresa_id);
            if($somaContas > 0) {
                $dataHoje = date('d/m/Y', strtotime("-". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
                $dataFutura = date('d/m/Y', strtotime("+". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
                array_push($alertas, 
                    [
                        'msg' => 'Contas a pagar R$'.number_format($somaContas, 2),
                        'titulo' => 'Alerta contas',
                        'link' => '/contasPagar/filtro?fornecedor=&data_inicial='.$dataHoje.'&data_final='.$dataFutura.'&status=todos'
                    ]
                );
            }


            $somaContas = $this->verificaContasReceber($empresa_id);
            if($somaContas > 0) {
                $dataHoje = date('d/m/Y', strtotime("-". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
                $dataFutura = date('d/m/Y', strtotime("+". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
                array_push($alertas, 
                    [
                        'msg' => 'Contas a receber R$'.number_format($somaContas, 2),
                        'titulo' => 'Receber',
                        'link' => '/contasReceber/filtro?cliente=&data_inicial='.$dataHoje.'&data_final='.$dataFutura.'&status=todos'
                    ]
                );
            }

            if (\Schema::hasTable('produtos')){

                $produtos = Produto::all();
                $contDesfalque = 0;
                foreach($produtos as $p){
                    if($p->estoque_minimo > 0){
                        $estoque = Estoque::
                        where('produto_id', $p->id)
                        ->where('empresa_id', $empresa_id)
                        ->first();
                        $temp = null;
                        if($estoque == null){
                            $contDesfalque++;
                        }else{
                            $contDesfalque++;
                        }

                    }
                }

                if($contDesfalque > 0){
                    array_push($alertas, 
                        [
                            'msg' => 'Produtos com estoque minimo: ' . $contDesfalque,
                            'titulo' => 'Alerta estoque',
                            'link' => '/relatorios/filtroEstoqueMinimo'
                        ]
                    );
                }

                $rotaAtiva = $this->rotaAtiva();

            }


            $view->with('alertas', $alertas);
            $view->with('rotaAtiva', $rotaAtiva);
            $view->with('menu', $menu->getMenu());
        });
        

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function rotaAtiva(){
        if (isset($_SERVER['REQUEST_URI'])){ 
            $uri = $_SERVER['REQUEST_URI'];
            $uri = explode("/", $uri);
            $uri = $uri[1];

            $rotaDeCadastros = [
                'categorias', 'produtos', 'clientes', 'fornecedores', 'transportadoras', 'funcionarios',
                'categoriasServico', 'servicos', 'categoriasConta', 'veiculos', 'usuarios'
            ];

            $rotaDeEntradas = [
                'compraFiscal', 'compraManual', 'compras', 'cotacao'
            ];

            $rotaDeEstoque = [
                'estoque'
            ];

            $rotaFinanceiro = [
                'contasPagar', 'contasReceber', 'fluxoCaixa', 'graficos', 'relatorios'
            ];

            $rotaConfig = [
                'configNF', 'escritorio', 'naturezaOperacao', 'tributos', 'enviarXml', 'dfe'
            ];

            $rotaVenda = [
                'vendas', 'frenteCaixa', 'orcamentoVenda', 'ordemServico', 'vendasEmCredito', 'devolucao',
                'agendamentos'
            ];

            $rotaCTe = [
                'cte', 'categoriaDespesa'
            ];

            $rotaMDFe = [
                'mdfe'
            ];

            if(in_array($uri, $rotaDeCadastros)) return 'Cadastros';
            if(in_array($uri, $rotaDeEntradas)) return 'Entradas';
            if(in_array($uri, $rotaDeEstoque)) return 'Estoque';
            if(in_array($uri, $rotaFinanceiro)) return 'Financeiro';
            if(in_array($uri, $rotaConfig)) return 'Configurações';
            if(in_array($uri, $rotaVenda)) return 'Vendas';
            if(in_array($uri, $rotaCTe)) return 'CT-e';
            if(in_array($uri, $rotaMDFe)) return 'MDF-e';

        }else{
            return "";
        }
    }

    private function verificaItensSemValidade($empresa_id){
        if (\Schema::hasTable('produtos')){
            $produtos = Produto::select('id')
            ->where('alerta_vencimento', '>', 0)
            ->where('empresa_id', $empresa_id)
            ->get();
            $itensCompra = ItemCompra::where('validade', NULL)
            ->limit(100)->get();


            foreach($itensCompra as $i){
                foreach($produtos as $p){
                    if($p->id == $i->produto_id){
                        return true;
                    }
                }
            }
            return false;
        }
    }

    private function verificaValidadeProdutos($empresa_id){
        if (\Schema::hasTable('item_compras')){

            $dataHoje = date('Y-m-d', strtotime("-30 days",strtotime(date('Y-m-d'))));
            $dataFutura = date('Y-m-d', strtotime("+30 days",strtotime(date('Y-m-d'))));

            $itens = ItemCompra::
            whereBetween('validade', [$dataHoje, $dataFutura])
            ->limit(300)->get();


            foreach($itens as $i){
                $strValidade = strtotime($i->validade);
                $strHoje = strtotime(date('Y-m-d'));
                $dif = $strValidade - $strHoje;
                $dif = $dif/24/60/60;
                if($dif <= $i->produto->alerta_vencimento) return true;
            }

            return false;
        }
    }

    private function verificaContasPagar($empresa_id){

        if (\Schema::hasTable('conta_pagars')){
            $dataHoje = date('Y-m-d', strtotime("-". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
            $dataFutura = date('Y-m-d', strtotime("+". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));

            $somaContas = ContaPagar::
            selectRaw('sum(valor_integral) as valor')
            ->whereBetween('data_vencimento', [$dataHoje, $dataFutura])
            ->where('status', 0)
            ->where('empresa_id', $empresa_id)
            ->first();

            return $somaContas->valor ?? 0;
        }
    }

    private function verificaContasReceber($empresa_id){
        if (\Schema::hasTable('conta_recebers')){
           $dataHoje = date('Y-m-d', strtotime("-". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
           $dataFutura = date('Y-m-d', strtotime("+". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));

           $somaContas = ContaReceber::
           selectRaw('sum(valor_integral) as valor')
           ->whereBetween('data_vencimento', [$dataHoje, $dataFutura])
           ->where('status', 0)
           ->where('empresa_id', $empresa_id)
           ->first();

           return $somaContas->valor ?? 0;
       }
   }
}
