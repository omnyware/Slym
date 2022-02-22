<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compra;
use App\ItemPurchase;
use App\Helpers\StockMove;
use App\Services\NFeEntradaService;
use App\ConfigNota;
use App\NaturezaOperacao;
use NFePHP\DA\NFe\Danfe;
use App\ItemCompra;
use App\Produto;

class PurchaseController extends Controller
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
        $totalRegistros = count(Compra::where('empresa_id', $this->empresa_id)->get());
        $compras = Compra::
        orderBy('id', 'desc')
        ->where('empresa_id', $this->empresa_id)
        ->paginate(15);

        $somaCompraMensal = $this->somaCompraMensal();
        return view('compraManual/listAll')
        ->with('compras', $compras)
        ->with('somaCompraMensal', $somaCompraMensal)
        ->with('links', true)
        ->with('graficoJs', true)
        ->with('title', 'Compras');
        
    }

    public function pesquisa(Request $request){
        $compras = Compra::pesquisaProduto($request->pesquisa);
        $totalRegistros = count($compras);

        $somaCompraMensal = $this->somaCompraMensal();
        return view('compraManual/listAll')
        ->with('compras', $compras)
        ->with('somaCompraMensal', $somaCompraMensal)
        ->with('graficoJs', true)
        ->with('title', 'Pequisa de Produto em Compras');
        
    }

    
    private function somaCompraMensal(){
        $compras = Compra::
        where('empresa_id', $this->empresa_id)
        ->get();
        $temp = [];
        $soma = 0;
        $mesAnterior = null;
        $anoAnterior = null;

        foreach($compras as $key => $c){
            $date = $c->created_at;
            $mes = substr($date, 5, 2);
            $ano = substr($date, 0, 4);


            if($mesAnterior != $mes){
                $temp["Mes: ".$mes."/$ano"] = $c->valor;
            }else{
                $temp["Mes: ".$mesAnterior."/$anoAnterior"] += $c->valor;

            }
            $mesAnterior = $mes;
            $anoAnterior = $ano;
        }

        return $temp;
    }

    

    private function somaCompraMensalFiltro($compras){
        $temp = [];
        $soma = 0;
        $mesAnterior = null;
        $anoAnterior = null;


        foreach($compras as $c){
            $date = $c->created_at;
            $mes = substr($date, 5, 2);
            $ano = substr($date, 0, 4);

            if($mesAnterior != $mes){
                $temp["Mes: ".$mes."/$ano"] = $c->valor;
            }else{
                $temp["Mes: ".$mesAnterior."/$anoAnterior"] += $c->valor;
            }
            $mesAnterior = $mes;
            $anoAnterior = $ano;
        }

        return $temp;
    }

    private function somaCompraDiarioFiltro($compras){
        $temp = [];
        $soma = 0;
        $diaAnterior = null;
        $mesAnterior = null;
        $s = 0;

        foreach($compras as $c){
            $date = $c->created_at;
            $dia = substr($date, 8, 2);
            $mes = substr($date, 5, 2);
            if($diaAnterior != $dia){
                $temp["Dia: ".$dia."/$mes"] = $c->valor;
            }else{
                $temp["Dia: ".$diaAnterior."/$mesAnterior"] += $c->valor;
                $s += $c->valor;
            }
            $mesAnterior = $mes;
            $diaAnterior = $dia;
        }

        return $temp;
    }
    private function diferencaEntreDatas($data1, $data2){
        $dif = strtotime($data2) - strtotime($data1);
        return floor($dif / (60 * 60 * 24));
    }

    public function filtro(Request $request){
        $dataInicial = $request->data_inicial;
        $dataFinal = $request->data_final;
        $fornecedor = $request->fornecedor;
        $compras = null;
        $diferencaDatas = null;

        if($dataInicial == null || $dataFinal == null || $fornecedor == null){

            session()->flash('mensagem_erro', 'Informe o fornecedor, data inicial e data final!');
            return redirect('/compras');
        }
        if(isset($fornecedor) && isset($dataInicial) && isset($dataFinal)){
            $compras = Compra::filtroDataFornecedor($fornecedor, $this->parseDate($dataInicial), $this->parseDate($dataFinal, true));
            $diferencaDatas = $this->diferencaEntreDatas($this->parseDate($dataInicial), $this->parseDate($dataFinal));
        }else if(isset($dataInicial) && isset($dataFinal)){
            $compras = Compra::filtroData($this->parseDate($dataInicial), $this->parseDate($dataFinal, true)
        );
            $diferencaDatas = $this->diferencaEntreDatas($this->parseDate($dataInicial), $this->parseDate($dataFinal));

        }else if(isset($fornecedor)){
            $compras = Compra::filtroFornecedor($fornecedor);
        }


        if($diferencaDatas > 31 || $diferencaDatas == null){
            $somaCompraMensal = $this->somaCompraMensalFiltro($compras);
        }else{
            $somaCompraMensal = $this->somaCompraDiarioFiltro($compras);
        }

        return view('compraManual/listAll')
        ->with('compras', $compras)
        ->with('fornecedor', $fornecedor)
        ->with('dataInicial', $dataInicial)
        ->with('dataFinal', $dataFinal)
        ->with('somaCompraMensal', $somaCompraMensal)
        ->with('graficoJs', true)
        ->with('infoDados', "Contas filtradas")
        ->with('title', 'Filtro Compras');

    }

    private function parseDate($date, $plusDay = false){

        if($plusDay == false)
            return date('Y-m-d', strtotime(str_replace("/", "-", $date)));
        else
            return date('Y-m-d', strtotime("+1 day",strtotime(str_replace("/", "-", $date))));
    }

    public function downloadXml($id){
        $compra = Compra::
        where('id', $id)
        ->first();
        if(valida_objeto($compra)){
            $public = getenv('SERVIDOR_WEB') ? 'public/' : '';
            if($compra->nf > 0) return response()->download($public.'xml_entrada/'.$compra->chave. '.xml');
            else return response()->download($public.'xml_entrada_emitida/'.$compra->chave. '.xml');
        }else{
            return redirect('/403');
        }
    }

    public function downloadXmlCancela($id){
        $compra = Compra::
        where('id', $id)
        ->first();
        if(valida_objeto($compra)){
            $public = getenv('SERVIDOR_WEB') ? 'public/' : '';
            return response()->download($public.'xml_nfe_entrada_cancelada/'.$compra->chave. '.xml');
        }else{
            return redirect('/403');
        }
    }

    public function detalhes($id){
        $compra = Compra::
        where('id', $id)
        ->first();
        if(valida_objeto($compra)){
            return view('compraManual/detail')
            ->with('compra', $compra)
            ->with('title', 'Detalhes da compra');
        }else{
            return redirect('/403');
        }
    }

    public function delete($id){
        $compra = Compra::
        where('id', $id)
        ->first();
        if(valida_objeto($compra)){
            $stockMove = new StockMove();
            $public = getenv('SERVIDOR_WEB') ? 'public/' : '';

            if($compra->xml_path != "" && file_exists($public."xml_entrada/$compra->xml_path")){
                unlink($public."xml_entrada/$compra->xml_path");
            }
            foreach($compra->itens as $i){
        // baixa de estoque
                $stockMove->downStock($i->produto->id, $i->quantidade);
                $i->delete();
            } 

            if($compra->delete()){
                session()->flash('mensagem_sucesso', 'Registro removido!');
            }else{
                session()->flash('mensagem_erro', 'Erro!');
            }
            return redirect('/compras');
        }else{
            return redirect('/403');
        }
    }

    public function emitirEntrada($id){
        $compra = Compra::find($id);
        if(valida_objeto($compra)){
            $naturezas = NaturezaOperacao::
            where('empresa_id', $this->empresa_id)
            ->get();

            $tiposPagamento = Compra::tiposPagamento();
            return view('compraManual/emitirEntrada')
            ->with('compra', $compra)
            ->with('naturezas', $naturezas)
            ->with('tiposPagamento', $tiposPagamento)
            ->with('NFeEntradaJS', true)
            ->with('title', 'Emitir NF-e Entrada');
        }else{
            return redirect('/403');
        }
    }

    public function gerarEntrada(Request $request){
        $compra = Compra::find($request->compra_id);
        if(valida_objeto($compra)){

            $config = ConfigNota::
            where('empresa_id', $this->empresa_id)
            ->first();

            $cnpj = str_replace(".", "", $config->cnpj);
            $cnpj = str_replace("/", "", $cnpj);
            $cnpj = str_replace("-", "", $cnpj);
            $cnpj = str_replace(" ", "", $cnpj);

            $nfe_service = new NFeEntradaService([
                "atualizacao" => date('Y-m-d h:i:s'),
                "tpAmb" => (int)$config->ambiente,
                "razaosocial" => $config->razao_social,
                "siglaUF" => $config->UF,
                "cnpj" => $cnpj,
                "schemes" => "PL_009_V4",
                "versao" => "4.00",
                "tokenIBPT" => "AAAAAAA",
                "CSC" => $config->csc,
                "CSCid" => $config->csc_id
            ], 55);

            header('Content-type: text/html; charset=UTF-8');
            $natureza = NaturezaOperacao::find($request->natureza);
            
            $nfe = $nfe_service->gerarNFe($compra, $natureza, $request->tipo_pagamento);

            $signed = $nfe_service->sign($nfe['xml']);
            $resultado = $nfe_service->transmitir($signed, $nfe['chave']);
            if(substr($resultado, 0, 4) != 'Erro'){
                $compra->chave = $nfe['chave'];
            // $venda->path_xml = $nfe['chave'] . '.xml';
                $compra->estado = 'APROVADO';
                $compra->numero_emissao = $nfe['nNf'];

                $compra->save();
                return response()->json($resultado, 200);

            }else{
                $compra->estado = 'REJEITADO';
                $compra->save();
                return response()->json($resultado, 401);

            }
        }else{
            return response()->json("Não permitido!!", 403);

        }
    }

    public function imprimir($id){
        $compra = Compra::find($id);
        if(valida_objeto($compra)){

            $public = getenv('SERVIDOR_WEB') ? 'public/' : '';
            $xml = null;
            if(file_exists($public.'xml_entrada_emitida/'.$compra->chave.'.xml')){
                $xml = file_get_contents($public.'xml_entrada_emitida/'.$compra->chave.'.xml');
            }else if(file_exists($public.'xml_entrada/'.$compra->chave.'.xml')){
                $xml = file_get_contents($public.'xml_entrada/'.$compra->chave.'.xml');
            }else{
                session()->flash('mensagem_erro', 'Xml não encontrado!');
                return redirect('/compras');
            }
            $config = ConfigNota::
            where('empresa_id', $this->empresa_id)
            ->first();
            
            if($config->logo){
                $logo = 'data://text/plain;base64,'. base64_encode(file_get_contents($public.'logos/' . $config->logo));
            }else{
                $logo = null;
            }
        // $docxml = FilesFolders::readFile($xml);

            try {
                $danfe = new Danfe($xml);
                $id = $danfe->monta($logo);
                $pdf = $danfe->render();
                header('Content-Type: application/pdf');
                echo $pdf;
            } catch (InvalidArgumentException $e) {
                echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
            }  
        }else{
            return redirect('/403');
        }
    }

    public function cancelarEntrada(Request $request){

        $config = ConfigNota::
        where('empresa_id', $this->empresa_id)
        ->first();

        $cnpj = str_replace(".", "", $config->cnpj);
        $cnpj = str_replace("/", "", $cnpj);
        $cnpj = str_replace("-", "", $cnpj);
        $cnpj = str_replace(" ", "", $cnpj);

        $nfe_service = new NFeEntradaService([
            "atualizacao" => date('Y-m-d h:i:s'),
            "tpAmb" => (int)$config->ambiente,
            "razaosocial" => $config->razao_social,
            "siglaUF" => $config->UF,
            "cnpj" => $cnpj,
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => $config->csc,
            "CSCid" => $config->csc_id
        ], 55);

        $compra = Compra::find($request->compra_id);
        $nfe = $nfe_service->cancelar($compra, $request->justificativa);
        if($this->isJson($nfe)){
            $compra->estado = 'CANCELADO';
            $compra->save();

        }
        echo json_encode($nfe);

    }

    private function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function produtosSemValidade(){
        $produtos = Produto::select('id')
        ->where('alerta_vencimento', '>', 0)
        ->where('empresa_id', $this->empresa_id)
        ->get();

        $estoque = ItemCompra::where('validade', NULL)
        ->limit(100)->get();

        $itensSemEstoque = [];
        foreach($estoque as $e){
            foreach($produtos as $p){
                if($p->id == $e->produto_id && $e->produto->empresa_id == $this->empresa_id){
                    array_push($itensSemEstoque, $e);
                }
            }
        }
        return view('compraManual/itens_sem_estoque')
        ->with('itens', $itensSemEstoque)
        ->with('title', 'Itens sem Estoque');
    }

    public function salvarValidade(Request $request){
        $tamanhoArray = $request->tamanho_array;
        $contErro = 0;

        for($aux = 0; $aux < $tamanhoArray; $aux++){

            $validade = str_replace("/", "-", $request->input('validade_'.$aux));
            $id = $request->input('id_'.$aux);

            if(strlen($validade) == 10){ // tamanho data ok
                $item = ItemCompra::find($id);
                $dataHoje = strtotime(date('Y-m-d'));
                $validadeForm = strtotime(\Carbon\Carbon::parse($validade)->format('Y-m-d'));
                if($validadeForm > $dataHoje){ // confirma data futura
                    $item->validade = \Carbon\Carbon::parse($validade)->format('Y-m-d');
                    $item->save();
                }else{
                    $contErro++;
                }
            }else{
                $contErro++;
            }
        }
        if($contErro == 0){
            session()->flash('mensagem_sucesso', 'Validades inseridas para os itens!');
        }else{
            session()->flash('mensagem_erro', 'Erro no formulário para os itens abaixo!');
        }
        return redirect('/compras/produtosSemValidade');
        
    }

    public function validadeAlerta(){
        $dataHoje = date('Y-m-d', strtotime("-30 days",strtotime(date('Y-m-d'))));
        $dataFutura = date('Y-m-d', strtotime("+30 days",strtotime(date('Y-m-d'))));
        // $produtos = Produto::select('id')->where('alerta_vencimento', '>', 0)->get();
        $itensCompra = ItemCompra::
        whereBetween('validade', [$dataHoje, $dataFutura])
        ->limit(300)->get();
        $itens = [];
        foreach($itensCompra as $i){
            $strValidade = strtotime($i->validade);
            $strHoje = strtotime(date('Y-m-d'));
            $dif = $strValidade - $strHoje;
            $dif = $dif/24/60/60;

            if($dif <= $i->produto->alerta_vencimento && $i->produto->empresa_id == $this->empresa_id){
                array_push($itens, $i);
            }
        }

        return view('compraManual/validade_alerta')
        ->with('itens', $itens)
        ->with('title', 'Produtos com validade próxima');
    }

}
