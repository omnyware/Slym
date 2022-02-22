<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VendaCaixa;
use App\Helpers\StockMove;
use App\ConfigNota;
use App\NaturezaOperacao;
use App\Categoria;
use App\Produto;
use App\Cliente;
use App\Tributacao;
use App\Usuario;
use App\Certificado;
use App\ListaPreco;
use App\AberturaCaixa;
use App\ProdutoPizza;

class FrontBoxController extends Controller
{
    protected $empresa_id = null;
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->empresa_id = $request->empresa_id;
            $value = session('user_logged');
            if(!$value){
                return redirect("/login");
            }  
            return $next($request);
        });
    }

    public function index(){

        $config = ConfigNota::
        where('empresa_id', $this->empresa_id)
        ->first();

        $naturezas = NaturezaOperacao::
        where('empresa_id', $this->empresa_id)
        ->get();

        $categorias = Categoria::
        where('empresa_id', $this->empresa_id)
        ->get();

        $produtos = Produto::
        where('empresa_id', $this->empresa_id)
        ->get();

        $tributacao = Tributacao::
        where('empresa_id', $this->empresa_id)
        ->get();

        $tiposPagamento = VendaCaixa::tiposPagamento();
        $config = ConfigNota::
        where('empresa_id', $this->empresa_id)
        ->first();

        $certificado = Certificado::
        where('empresa_id', $this->empresa_id)
        ->first();

        $usuario = Usuario::find(get_id_user());

        if(count($naturezas) == 0 || count($produtos) == 0 || $config == null || count($categorias) == 0 || $tributacao == null){

            return view("frontBox/alerta")
            ->with('produtos', count($produtos))
            ->with('categorias', count($categorias))
            ->with('naturezas', $naturezas)
            ->with('config', $config)
            ->with('tributacao', $tributacao)
            ->with('title', "Validação para Emitir");
        }else{

            if($config->nat_op_padrao == 0){

                session()->flash('mensagem_erro', 'Informe a natureza de operação para o PDV!');
                return redirect('/configNF');
            }else{
                $tiposPagamentoMulti = VendaCaixa::tiposPagamentoMulti();
                $produtos = Produto::
                where('empresa_id', $this->empresa_id)
                ->orderBy('nome')->get();
                foreach($produtos as $p){
                    $p->listaPreco;
                    $estoque_atual = 0;
                    if($p->estoque){
                        if($p->unidade_venda == 'UN' || $p->unidade_venda == 'UNID'){
                            $estoque_atual = number_format($p->estoque->quantidade);
                        }else{
                            $estoque_atual = $p->estoque->quantidade;
                        }
                    }
                    $p->estoque_atual = $estoque_atual;
                }
                $categorias = Categoria::
                where('empresa_id', $this->empresa_id)
                ->orderBy('nome')->get();

                $clientes = Cliente::orderBy('razao_social')
                ->where('empresa_id', $this->empresa_id)
                ->get();

                return view('frontBox/main')
                ->with('frenteCaixa', true)
                ->with('tiposPagamento', $tiposPagamento)
                ->with('config', $config)
                ->with('certificado', $certificado)
                ->with('listaPreco', ListaPreco::all())
                ->with('disableFooter', true)
                ->with('usuario', $usuario)
                ->with('produtos', $produtos)
                ->with('clientes', $clientes)
                ->with('categorias', $categorias)
                ->with('tiposPagamentoMulti', $tiposPagamentoMulti)
                ->with('title', 'Frente de Caixa');
            }
        }
    }

    private function cancelarNFCe($venda){
        $config = ConfigNota::
        where('empresa_id', $this->empresa_id)
        ->first();

        $cnpj = str_replace(".", "", $config->cnpj);
        $cnpj = str_replace("/", "", $cnpj);
        $cnpj = str_replace("-", "", $cnpj);
        $cnpj = str_replace(" ", "", $cnpj);
        $nfe_service = new NFeService([
            "atualizacao" => date('Y-m-d h:i:s'),
            "tpAmb" => 2,
            "razaosocial" => $config->razao_social,
            "siglaUF" => $config->UF,
            "cnpj" => $cnpj,
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "XTZOH6COASX5DYLKBUZXG5TABFG7ZFTQVSA2",
            "CSCid" => "000001"
        ], 65);

        $nfce = $nfe_service->cancelarNFCe($venda->id, "Troca de produtos requisitada pelo cliente");
        return is_array($nfce);
    }

    public function deleteVenda($id){
        $venda = VendaCaixa
        ::where('id', $id)
        ->first();

        if(valida_objeto($venda)){
            $stockMove = new StockMove();

            foreach($venda->itens as $i){
                if($i->produto->receita){
                    $receita = $i->produto->receita;
                    foreach($receita->itens as $rec){

                        if($i->itemPedido != NULL && $i->itemPedido->tamanho != NULL){
                            $totalSabores = count($i->itemPedido->sabores);
                            $produtoPizza = ProdutoPizza::
                            where('produto_id', $i->produto->delivery->id)
                            ->where('tamanho_id', $i->itemPedido->tamanho->id)
                            ->first();

                            $stockMove->pluStock(
                                $rec->produto_id, $i->quantidade 
                      * 
                                ((($rec->quantidade/$totalSabores)/$receita->pedacos)*$produtoPizza->tamanho->pedacos)/$receita->rendimento
                            );

                        }else{
                            $stockMove->pluStock($rec->produto_id, 
                                $i->quantidade);
                        }
                    }
                }else{
                    $stockMove->pluStock($i->produto_id, 
                        $i->quantidade); // -50 na altera valor compra
                }
            }

            if($venda->delete()){
                session()->flash("mensagem_sucesso", "Venda removida com sucesso!");
            }else{
                session()->flash('mensagem_erro', 'Erro ao remover venda!');
            }
            return redirect('/frenteCaixa/devolucao');
        }else{
            return redirect('/403');
        }

    }

    public function list(){
        // $vendas = VendaCaixa::
        // orderBy('id', 'desc')
        // ->get();

        $vendas = VendaCaixa::filtroData(
            $this->parseDate(date("Y-m-d")),
            $this->parseDate(date("Y-m-d"), true)
        );

        $somaTiposPagamento = $this->somaTiposPagamento($vendas);

        return view('frontBox/list')
        ->with('vendas', $vendas)
        ->with('frenteCaixa', true)
        ->with('somaTiposPagamento', $somaTiposPagamento)
        ->with('info', "Lista de vendas de Hoje: " . date("d/m/Y") )
        ->with('title', 'Lista de Vendas na Frente de Caixa');
    }

    private function somaTiposPagamento($vendas){
        $tipos = $this->preparaTipos();

        foreach($vendas as $v){
            if(isset($tipos[$v->tipo_pagamento])){
                if($v->tipo_pagamento != 99){
                    $tipos[$v->tipo_pagamento] += $v->valor_total;
                }else{
                    if($v->valor_pagamento_1 > 0){
                        $tipos[$v->tipo_pagamento_1] += $v->valor_pagamento_1;
                    }
                    if($v->valor_pagamento_2 > 0){
                        $tipos[$v->tipo_pagamento_2] += $v->valor_pagamento_2;
                    }
                    if($v->valor_pagamento_3 > 0){
                        $tipos[$v->tipo_pagamento_3] += $v->valor_pagamento_3;
                    }
                }
            }
        }
        return $tipos;

    }

    private function preparaTipos(){
        $temp = [];
        foreach(VendaCaixa::tiposPagamento() as $key => $tp){
            $temp[$key] = 0;
        }
        return $temp;
    }

    public function devolucao(){
        $vendas = VendaCaixa::
        orderBy('id', 'desc')
        ->where('empresa_id', $this->empresa_id)
        ->limit(20)
        ->get();

        return view('frontBox/devolucao')
        ->with('vendas', $vendas)
        ->with('frenteCaixa', true)
        ->with('nome', '')
        ->with('nfce', '')
        ->with('valor', '')
        ->with('info', "Lista das ultimas 20 vendas")

        ->with('title', 'Devolução');
    }

    public function filtro(Request $request){
        $dataInicial = $request->data_inicial;
        $dataFinal = $request->data_final;

        $vendas = VendaCaixa::filtroData(
            $this->parseDate($dataInicial),
            $this->parseDate($dataFinal, true)
        );

        $somaTiposPagamento = $this->somaTiposPagamento($vendas);

        return view('frontBox/list')
        ->with('vendas', $vendas)
        ->with('dataInicial', $dataInicial)
        ->with('somaTiposPagamento', $somaTiposPagamento)
        ->with('info', "Lista de vendas período: $dataInicial até $dataFinal")
        ->with('dataFinal', $dataFinal)
        ->with('frenteCaixa', true)
        ->with('info', "Lista das ultimas 20 vendas")
        ->with('title', 'Filtro de Vendas na Frente de Caixa');
    }


    private function parseDate($date, $plusDay = false){
        if($plusDay == false)
            return date('Y-m-d', strtotime(str_replace("/", "-", $date)));
        else
            return date('Y-m-d', strtotime("+1 day",strtotime(str_replace("/", "-", $date))));
    }



    public function filtroCliente(Request $request){

        $vendas = VendaCaixa::filtroCliente($request->nome);
        return view('frontBox/devolucao')
        ->with('vendas', $vendas)
        ->with('frenteCaixa', true)
        ->with('valor', '')
        ->with('nome', $request->nome)
        ->with('nfce', '')
        ->with('info', "Filtro cliente: $request->nome")

        ->with('title', 'Filtro por cliente');
    }


    public function filtroNFCe(Request $request){

        $vendas = VendaCaixa::filtroNFCe($request->nfce);
        return view('frontBox/devolucao')
        ->with('vendas', $vendas)
        ->with('frenteCaixa', true)
        ->with('valor', '')
        ->with('nfce', $request->nfce)
        ->with('nome', '')
        ->with('info', "Filtro NFCE: $request->nfce")
        ->with('title', 'Filtro por NFCe');
    }

    public function filtroValor(Request $request){

        $vendas = VendaCaixa::filtroValor($request->valor);
        return view('frontBox/devolucao')
        ->with('vendas', $vendas)
        ->with('frenteCaixa', true)
        ->with('nfce', '')
        ->with('valor', $request->valor)
        ->with('nome', '')
        ->with('info', "Filtro valor: $request->valor")

        ->with('title', 'Filtro por Valor');
    }

    public function fechar(){
        $abertura = AberturaCaixa::where('ultima_venda', 0)
        ->where('empresa_id', $this->empresa_id)
        ->orderBy('id', 'desc')->first();

        $ultimaFechada = AberturaCaixa::where('ultima_venda', '>', 0)
        ->where('empresa_id', $this->empresa_id)
        ->orderBy('id', 'desc')->first();

        $ultimaVendaCaixa = VendaCaixa::
        where('empresa_id', $this->empresa_id)
        ->orderBy('id', 'desc')->first();

        $vendas = [];
        $somaTiposPagamento = [];
        if($ultimaVendaCaixa != null){
            $ultimaVendaCaixa = $ultimaVendaCaixa->id;

            $vendas = VendaCaixa
            ::whereBetween('id', [($ultimaFechada != null ? $ultimaFechada->ultima_venda+1 : 0), 
                $ultimaVendaCaixa])
            ->get();

            $somaTiposPagamento = $this->somaTiposPagamento($vendas);

        }
        if($abertura == null){
            return redirect('/frenteCaixa')->with('erro', 'O caixa esta fechado!!');
        }else{
            return view('frontBox/fechar_caixa')
            ->with('vendas', $vendas)
            ->with('abertura', $abertura)
            ->with('somaTiposPagamento', $somaTiposPagamento)
            ->with('title', 'Fechar caixa');
        }
    }

    public function fecharPost(Request $request){
        $id = $request->abertura_id;
        $abertura = AberturaCaixa::find($id);
        $ultimaVendaCaixa = VendaCaixa::
        where('empresa_id', $this->empresa_id)
        ->orderBy('id', 'desc')->first();

        $abertura->ultima_venda = $ultimaVendaCaixa->id;
        $abertura->save();
        session()->flash("mensagem_sucesso", "Caixa fechado com sucesso!");
        return redirect('frenteCaixa/list');
    }

    public function fechamentos(){
        $aberturas = AberturaCaixa::where('ultima_venda', '>', 0)
        ->where('empresa_id', $this->empresa_id)->get();
        $arr = [];

        for($i = 0; $i < sizeof($aberturas); $i++){
            $atual = $aberturas[$i]->ultima_venda;
            if($i == 0){
                $anterior = 0;
            }else{
                $anterior = $aberturas[$i-1]->ultima_venda;
            }
            $vendas = VendaCaixa
            ::whereBetween('id', [$anterior+1, 
                $atual])
            ->get();

            $total = 0;
            foreach($vendas as $v){
                $total += $v->valor_total;
            }

            $temp = [
                'inicio' => \Carbon\Carbon::parse($aberturas[$i]->created_at)->format('d/m/Y H:i:s'),
                'fim' => \Carbon\Carbon::parse($aberturas[$i]->updated_at)->format('d/m/Y H:i:s'),
                'total' => $total,
                'id' => $aberturas[$i]->id
            ];

            array_push($arr, $temp);
        }

        usort($arr, function ($a, $b) {
            return ($a['id'] < $b['id']) ? 1 : -1;
        });

        return view('frontBox/fechamentos')
        ->with('fechamentos', $arr)
        ->with('title', 'Lista de Caixas');
    }

    public function listaFechamento($id){
        $aberturas = AberturaCaixa::
        where('empresa_id', $this->empresa_id)
        ->get();
        $abertura = null;
        $inicio = 0;
        $fim = 0;

        for($i = 0; $i < sizeof($aberturas); $i++){
            if($aberturas[$i]->id == $id){
                $abertura = $aberturas[$i];
                if($i > 0){
                    $inicio = $aberturas[$i-1]->ultima_venda +1;
                }

                $fim = $aberturas[$i]->ultima_venda;
            }
        }

        $vendas = [];
        $somaTiposPagamento = [];


        $vendas = VendaCaixa
        ::whereBetween('id', [$inicio, 
            $fim])
        ->get();

        $somaTiposPagamento = $this->somaTiposPagamento($vendas);

        return view('frontBox/lista_fecha_caixa')
        ->with('vendas', $vendas)
        ->with('abertura', $abertura)
        ->with('somaTiposPagamento', $somaTiposPagamento)
        ->with('title', 'Detalhe fecha caixa');
    }

}
