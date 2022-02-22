<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\ItemCompra;
use App\Produto;
use App\ContaPagar;
use App\ContaReceber;

class AlertProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $alertas = [];
        $semValidade = $this->verificaItensSemValidade();
        if($semValidade) {
            array_push($alertas, 
                [
                    'msg' => 'Existe itens em estoque sem cadastro de data de validade!',
                    'icon' => 'view_module',
                    'link' => '/compras/produtosSemValidade'
                ]
            );
        }

        $alertaValidade = $this->verificaValidadeProdutos();
        if($alertaValidade) {
            array_push($alertas, 
                [
                    'msg' => 'Existe Produtos com validade próxima!',
                    'icon' => 'sim_card_alert',
                    'link' => '/compras/validadeAlerta'
                ]
            );
        }

        $somaContas = $this->verificaContasPagar();
        if($somaContas > 0) {
            $dataHoje = date('d/m/Y', strtotime("-". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
            $dataFutura = date('d/m/Y', strtotime("+". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
            array_push($alertas, 
                [
                    'msg' => 'Contas a pagar R$'.number_format($somaContas, 2),
                    'icon' => 'money_off',
                    'link' => '/contasPagar/filtro?fornecedor=&data_inicial='.$dataHoje.'&data_final='.$dataFutura.'&status=todos'
                ]
            );
        }

        $somaContas = $this->verificaContasReceber();
        if($somaContas > 0) {
            $dataHoje = date('d/m/Y', strtotime("-". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
            $dataFutura = date('d/m/Y', strtotime("+". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
            array_push($alertas, 
                [
                    'msg' => 'Contas a receber R$'.number_format($somaContas, 2),
                    'icon' => 'attach_money',
                    'link' => '/contasReceber/filtro?cliente=&data_inicial='.$dataHoje.'&data_final='.$dataFutura.'&status=todos'
                ]
            );
        }

        view()->composer('*',function($view) use($alertas){
            $view->with('alertas', $alertas);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function verificaItensSemValidade(){
        $produtos = Produto::select('id')->where('alerta_vencimento', '>', 0)->get();
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

    private function verificaValidadeProdutos(){
        $dataHoje = date('Y-m-d', strtotime("-30 days",strtotime(date('Y-m-d'))));
        $dataFutura = date('Y-m-d', strtotime("+30 days",strtotime(date('Y-m-d'))));
        // $produtos = Produto::select('id')->where('alerta_vencimento', '>', 0)->get();
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

    private function verificaContasPagar(){
     $dataHoje = date('Y-m-d', strtotime("-". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
     $dataFutura = date('Y-m-d', strtotime("+". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));

     $somaContas = ContaPagar::
     selectRaw('sum(valor_integral) as valor')
     ->whereBetween('data_vencimento', [$dataHoje, $dataFutura])
     ->where('status', 0)
     ->first();

     return $somaContas->valor ?? 0;
 }

 private function verificaContasReceber(){
     $dataHoje = date('Y-m-d', strtotime("-". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));
     $dataFutura = date('Y-m-d', strtotime("+". getenv('ALERTA_CONTAS_DIAS') ." days",strtotime(date('Y-m-d'))));

     $somaContas = ContaReceber::
     selectRaw('sum(valor_integral) as valor')
     ->whereBetween('data_vencimento', [$dataHoje, $dataFutura])
     ->where('status', 0)
     ->first();

     return $somaContas->valor ?? 0;
 }
}
