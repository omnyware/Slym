<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\ClienteDelivery;
use App\Produto;
use App\PedidoDelivery;
use App\Venda;
use App\VendaCaixa;
use App\ContaPagar;
use App\ContaReceber;
use App\Usuario;

class HomeController extends Controller
{
    protected $empresa_id = null;
    protected $acesso_financeiro = false;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->empresa_id = $request->empresa_id;
            $value = session('user_logged');
            if(!$value){
                return redirect("/login");
            }else{
                $usuario = Usuario::find($value['id']);
                $permissao = json_decode($usuario->permissao);
                // print_r($permissao);
                if(in_array("/contasPagar", $permissao) || in_array("/contasReceber", $permissao)){
                    $this->acesso_financeiro = true;
                }
            }
            return $next($request);
        });
    }
    
    public function index()
    {
        $totalizacao = $this->totalizacao();

        $dataFinal = date('d/m/Y');
        $dataInicial = date('d/m/Y', strtotime('-6 day'));

        return view('default/grafico')
        ->with('graficoHomeJs', true)
        ->with('totalDeProdutos', $totalizacao['totalDeProdutos'])
        ->with('totalDeClientes', $totalizacao['totalDeClientes'])
        ->with('totalDeVendas', $totalizacao['totalDeVendas'])
        ->with('totalDePedidos', $totalizacao['totalDePedidos'])
        ->with('totalDeContaReceber', $totalizacao['totalDeContaReceber'])
        ->with('totalDeContaPagar', $totalizacao['totalDeContaPagar'])
        ->with('dataInicial', $dataInicial)
        ->with('dataFinal', $dataFinal)
        ->with('title', 'Bem Vindo');
    }

    private function totalizacao(){
        $totalDeProdutos = count(Produto::where('empresa_id', $this->empresa_id)->get());
        $totalDeClientes = count(Cliente::where('empresa_id', $this->empresa_id)->get());


        return [
            'totalDeClientes' => $totalDeClientes,
            'totalDeProdutos' => $totalDeProdutos,
            'totalDeVendas' => $this->totalDeVendasHoje(),
            'totalDePedidos' => $this->totalDePedidosDeDliveryHoje(),
            'totalDeContaReceber' => $this->totalDeContaReceberHoje(),
            'totalDeContaPagar' => $this->totalDeContaPagarHoje(),
        ];
    }

    private function totalDeVendasHoje(){
        $vendas = Venda::
        select(\DB::raw('sum(valor_total) as total'))
        ->whereBetween('data_registro', [date("Y-m-d"), 
            date('Y-m-d', strtotime('+1 day'))])
        ->where('empresa_id', $this->empresa_id)
        ->first();

        $vendaCaixas = VendaCaixa::
        select(\DB::raw('sum(valor_total) as total'))
        ->whereBetween('data_registro', [date("Y-m-d"), 
            date('Y-m-d', strtotime('+1 day'))])
        ->where('empresa_id', $this->empresa_id)
        ->first();


        return $vendas->total + $vendaCaixas->total;

    }

    private function totalDePedidosDeDliveryHoje(){
        $pedidos = PedidoDelivery::
        select(\DB::raw('count(*) as linhas'))
        ->whereBetween('data_registro', [date("Y-m-d"), 
            date('Y-m-d', strtotime('+1 day'))])
        ->first();
        return $pedidos->linhas;
    }

    private function totalDeContaReceberHoje(){
        $contas = ContaReceber::
        select(\DB::raw('sum(valor_integral) as total'))
        ->whereBetween('data_vencimento', [date("Y-m-d"), 
            date('Y-m-d', strtotime('+1 day'))])
        ->where('status', false)
        ->where('empresa_id', $this->empresa_id)
        ->first(); 
        if($this->acesso_financeiro == 0) return 0;
        return $contas->total ?? 0;
    }

    private function totalDeContaPagarHoje(){
        $contas = ContaPagar::
        select(\DB::raw('sum(valor_integral) as total'))
        ->whereBetween('data_vencimento', [date("Y-m-d"), 
            date('Y-m-d', strtotime('+1 day'))])
        ->where('status', false)
        ->where('empresa_id', $this->empresa_id)
        ->first(); 
        if($this->acesso_financeiro == 0) return 0;
        return $contas->total ?? 0;
    }



    public function faturamentoDosUltimosSeteDias(){

        $arrayVendas = [];
        for($aux = 0; $aux > -7; $aux--){
            $vendas = Venda::
            select(\DB::raw('sum(valor_total) as total'))
            ->whereBetween('data_registro', 
                [
                    date('Y-m-d', strtotime($aux.' day')), 
                    date('Y-m-d', strtotime(($aux+1).' day'))
                ]
            )
            ->where('empresa_id', $this->empresa_id)
            ->first();


            $vendaCaixas = VendaCaixa::
            select(\DB::raw('sum(valor_total) as total'))
            ->whereBetween('data_registro', 
                [
                    date('Y-m-d', strtotime($aux.' day')), 
                    date('Y-m-d', strtotime(($aux+1).' day'))
                ]
            )
            ->where('empresa_id', $this->empresa_id)
            ->first();
            $temp = [
                'data' => date('d/m', strtotime(($aux).' day')),
                'total' => number_format(($vendas->total + $vendaCaixas->total), 2)
            ];
            array_push($arrayVendas, $temp);
        }
        if($this->acesso_financeiro == 0){
            return response()->json(array_reverse([]));
        }
        return response()->json(array_reverse($arrayVendas));
        
    }

    public function faturamentoFiltrado(Request $request){

        $dataInicial = strtotime(str_replace("/", "-", $request->data_inicial));
        $dataFinal = strtotime(str_replace("/", "-", $request->data_final));

        $diferenca = ($dataFinal - $dataInicial)/86400; //86400 segundos do dia

        $arrayVendas = [];
        
        if($diferenca+1 > 30){ //filtrar por mes

            $total = 0;
            for($aux = 0; $aux > (($diferenca+1)*-1); $aux--){
                $vendas = Venda::
                select(\DB::raw('sum(valor_total) as total'))
                ->whereBetween('data_registro', 
                    [
                        date('Y-m-d', strtotime($aux.' day')), 
                        date('Y-m-d', strtotime(($aux+1).' day'))
                    ]
                )
                ->where('empresa_id', $this->empresa_id)
                ->first();


                $vendaCaixas = VendaCaixa::
                select(\DB::raw('sum(valor_total) as total'))
                ->whereBetween('data_registro', 
                    [
                        date('Y-m-d', strtotime($aux.' day')), 
                        date('Y-m-d', strtotime(($aux+1).' day'))
                    ]
                )
                ->where('empresa_id', $this->empresa_id)
                ->first();

                if($this->confereMesNoArray($arrayVendas, date('m/Y', strtotime(($aux).' day')))){
                    $cont = 0;
                    foreach($arrayVendas as $arr){
                        if($arr['data'] == date('m/Y', strtotime(($aux).' day'))){
                            $arrayVendas[$cont]['total'] += $vendas->total + $vendaCaixas->total;

                        }
                        $cont++;
                    }
                }else{
                    $temp = [
                        'data' => date('m/Y', strtotime(($aux).' day')),
                        'total' => number_format($total, 2)
                    ];
                    array_push($arrayVendas, $temp);
                }
                
            }
            
        }else{ //filtro por dia
            for($aux = 0; $aux > (($diferenca+1)*-1); $aux--){
                $vendas = Venda::
                select(\DB::raw('sum(valor_total) as total'))
                ->whereBetween('data_registro', 
                    [
                        date('Y-m-d', strtotime($aux.' day')), 
                        date('Y-m-d', strtotime(($aux+1).' day'))
                    ]
                )
                ->where('empresa_id', $this->empresa_id)
                ->first();


                $vendaCaixas = VendaCaixa::
                select(\DB::raw('sum(valor_total) as total'))
                ->whereBetween('data_registro', 
                    [
                        date('Y-m-d', strtotime($aux.' day')), 
                        date('Y-m-d', strtotime(($aux+1).' day'))
                    ]
                )
                ->where('empresa_id', $this->empresa_id)
                ->first();
                $temp = [
                    'data' => date('d/m', strtotime(($aux).' day')),
                    'total' => number_format(($vendas->total + $vendaCaixas->total), 2)
                ];
                array_push($arrayVendas, $temp);
            }
        }
        if($this->acesso_financeiro == 0){
            return response()->json(array_reverse([]));
        }
        return response()->json(array_reverse($arrayVendas));
        
    }

    private function confereMesNoArray($arr, $mes){
        foreach($arr as $a){
            if($a['data'] == $mes) return true;
        }
        return false;
    }


}
