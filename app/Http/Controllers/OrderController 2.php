<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrdemServico;
use App\ServicoOs;
use App\EstadoOs;
use App\FuncionarioOs;
use App\Funcionario;
use App\RelatorioOs;
use App\Servico;
use App\Cliente;
use App\ConfigNota;
use App\Helpers\StockMove;
use \Carbon\Carbon;

class OrderController extends Controller
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
        $orders = OrdemServico::
        where('empresa_id', $this->empresa_id)
        ->orderBy('id', 'desc')
        ->paginate(20);
        return view('os/list')
        ->with('orders', $orders)
        ->with('print', true)
        ->with('links', true)
        ->with('title', 'Orders de Serviço');
    }

    public function new(){
        $clientes = Cliente::
        where('empresa_id', $this->empresa_id)
        ->orderBy('razao_social')->get();
        return view('os/register')
        ->with('client', true)
        ->with('clientes', $clientes)
        ->with('estados', EstadoOs::values())
        ->with('title', 'Nova Ordem de Serviço');
    }

    public function delete($id){
        $ordem = OrdemServico::find($id);
        if(valida_objeto($ordem)){
            if($ordem->delete()){
                session()->flash("mensagem_sucesso", "Ordem de serviço removida!");
            }else{
                session()->flash("mensagem_erro", "Erro ao remover!");
            }
            return redirect("/ordemServico");
        }else{
            return redirect('/403');
        }

    }

    public function save(Request $request){
        $this->_validate($request);

        $order = new OrdemServico();
        $request->merge([ 'valor' =>str_replace(",", ".", $request->input('valor'))]);

        $cliente = $request->input('cliente');
        $cliente = explode("-", $cliente);
        $cliente = $cliente[0];

        $result = $order->create([
            'descricao' => $request->input('descricao'),
            'usuario_id' => get_id_user(),
            'cliente_id' => $cliente,
            'empresa_id' => $this->empresa_id
        ]);


        if($result){
            session()->flash("mensagem_sucesso", "OS gerada!");
        }else{
            session()->flash('mensagem_erro', 'Erro ao gerar OS!');
        }

        return redirect("/ordemServico/servicosordem/$result->id");
    }

    public function servicosordem($ordemId){
        $ordem = OrdemServico::
        where('id', $ordemId)
        ->first();

        if(valida_objeto($ordem)){
            $servicos = Servico::
            where('empresa_id', $this->empresa_id)
            ->get();

            $funcionarios = Funcionario::
            where('empresa_id', $this->empresa_id)
            ->get();

            $temServicos = count(Servico::where('empresa_id', $this->empresa_id)->get()) > 0;
            $temFuncionarios = count(Funcionario::where('empresa_id', $this->empresa_id)->get()) > 0;
         // echo json_encode($ordem->servicos);
            return view('os/servicos')
            ->with('ordem', $ordem)
            ->with('relatorioJs', true)
            ->with('funcionario', true)
            ->with('servicos', $servicos)
            ->with('funcionarios', $funcionarios)
            ->with('temServicos', $temServicos)
            ->with('temFuncionarios', $temFuncionarios)
            ->with('title', 'Novo serviço para OS')
            ->with('servicoJs', true);
        }else{
            return redirect('/403');
        }
    }


    public function addServico(Request $request){
        $this->_validateServicoOs($request);

        $servicoOs = new ServicoOs();

        $servico = $request->input('servico');
        $servico = explode("-", $servico);
        $servico = $servico[0];

        $ordem = OrdemServico::
        where('id', $request->input('ordem_servico_id'))
        ->first();

        $servicoObj = Servico::
        where('id', $servico)
        ->first();

        $ordem->valor += $servicoObj->valor * $request->input('quantidade');

        $result = $servicoOs->create([
            'quantidade' => $request->input('quantidade'),
            'ordem_servico_id' => $request->input('ordem_servico_id'),
            'servico_id' => $servico
        ]);

        $ordem->save();

        if($result){
            session()->flash("mensagem_sucesso", "Serviço adicionado!");
        }else{
            session()->flash('mensagem_erro', 'Erro ao adicionar!');
        }

        return redirect("/ordemServico/servicosordem/$request->ordem_servico_id");
    }

    public function deleteServico($id){
        $obj = ServicoOs
        ::where('id', $id)
        ->first();
        $id = $obj->ordemServico->id;

        if(valida_objeto($obj->ordemServico)){
            $ordem = OrdemServico::
            where('id', $id)
            ->first();

            $servico = Servico::
            where('id', $obj->servico->id)
            ->first();

            $ordem->valor -= $obj->quantidade * $servico->valor;
            $ordem->save();

            $delete = $obj->delete();
            if($delete){
                session()->flash('mensagem_sucesso', 'Serviço removido!');
            }else{
                session()->flash('mensagem_erro', 'Erro!');
            }

            return redirect("/ordemServico/servicosordem/$id");
        }else{
            return redirect('/403');
        }
    }

    public function addRelatorio($id){
        $ordem = OrdemServico::
        where('id', $id)
        ->first();

        if(valida_objeto($ordem)){
            return view('os/addRelatorio')
            ->with('ordem', $ordem)
            ->with('title', 'Novo Relatório');
        }else{
            return redirect('/403');
        }
    }

    public function editRelatorio($id){
        $relatorio = RelatorioOs::
        where('id', $id)
        ->first();
        if(valida_objeto($relatorio->ordemServico)){
            $ordem = $relatorio->ordemServico;
            return view('os/addRelatorio')
            ->with('ordem', $ordem)
            ->with('relatorio', $relatorio)
            ->with('title', 'Editar Relatório');
        }else{
            return redirect('/403');
        }
    }

    public function alterarEstado($id){
        $ordem = OrdemServico::
        where('id', $id)
        ->first();

        if(valida_objeto($ordem)){
            return view('os/alterarEstado')
            ->with('ordem', $ordem)
            ->with('title', 'Alterar Estado de OS');
        }else{
            return redirect('/403');
        }
    }

    public function alterarEstadoPost(Request $request){
        $ordem = OrdemServico::
        where('id', $request->id)
        ->first();

        $ordem->estado = $request->novo_estado;
        $result = $ordem->save();

        if($result){
            session()->flash('mensagem_sucesso', 'Estado Alterado!');
        }else{
            session()->flash('mensagem_erro', 'Erro!');
        }

        return redirect("/ordemServico/servicosordem/$request->id");
    }

    public function filtro(Request $request){

        $dataInicial = $request->data_inicial;
        $dataFinal = $request->data_final;
        $cliente = $request->cliente;
        $estado = $request->estado;
        $orders = null;

        if(isset($cliente) && isset($dataInicial) && isset($dataFinal)){
            $orders = OrdemServico::filtroDataFornecedor(
                $cliente, 
                $this->parseDate($dataInicial),
                $this->parseDate($dataFinal, true),
                $estado
            );
        }else if(isset($cliente) && isset($dataFinal)){
            $orders = OrdemServico::filtroData(
                $this->parseDate($dataInicial),
                $this->parseDate($dataFinal, true),
                $estado
            );
        }else if(isset($cliente)){
            $orders = OrdemServico::filtroCliente(
                $cliente,
                $estado
            );
        }else{
            $orders = OrdemServico::orderBy('id', 'desc')->get();
        }

        return view('os/list')
        ->with('orders', $orders)
        ->with('title', 'Orders de Serviço');
    }

    public function saveRelatorio(Request $request){
        $this->_validateRelatorio($request);

        $relatorioOs = new RelatorioOs();

        $result = $relatorioOs->create([
            'usuario_id' => get_id_user(),
            'ordem_servico_id' => $request->input('ordemId'),
            'texto' => $request->texto
        ]);

        if($result){
            session()->flash("mensagem_sucesso", "Relatorio adicionado!");
        }else{
            session()->flash('mensagem_erro', 'Erro ao adicionar!');
        }

        return redirect("/ordemServico/servicosordem/$request->ordemId");
    }

    public function updateRelatorio(Request $request){
        $this->_validateRelatorio($request);

        $id = $request->input('id');
        $resp = RelatorioOs::
        where('id', $id)
        ->first(); 

        $resp->texto = $request->input('texto');
        $result = $resp->save();
        if($result){
            session()->flash("mensagem_sucesso", "Relatorio editado!");
        }else{
            session()->flash('mensagem_erro', 'Erro ao editar!');
        }

        return redirect("/ordemServico/servicosordem/$request->ordemId");
    }

    public function deleteRelatorio($id){
        $obj = RelatorioOs::
        where('id', $id)
        ->first();
        if(valida_objeto($obj->ordemServico)){
            $id = $obj->ordemServico->id;
            $delete = $obj->delete();
            if($delete){
                session()->flash('mensagem_sucesso', 'Relatório removido!');
            }else{
                session()->flash('mensagem_erro', 'Erro!');
            }

            return redirect("/ordemServico/servicosordem/$id");
        }else{
            return redirect('/403');
        }
    }

    private function _validate(Request $request){
        $rules = [
            'cliente' => 'required',
            'descricao' => 'required',
        ];

        $messages = [
            'cliente.required' => 'O campo cliente é obrigatório.',
            'descricao.required' => 'O campo descrição é obrigatório.'
        ];

        $this->validate($request, $rules, $messages);
    }

    private function _validateServicoOs(Request $request){
        $rules = [
            'servico' => 'required',
            'quantidade' => 'required',
        ];

        $messages = [
            'servico.required' => 'O campo serviço é obrigatório.',
            'quantidade.required' => 'O campo quantidade é obrigatório.'
        ];

        $this->validate($request, $rules, $messages);
    }

    private function _validateFuncionario(Request $request){
        $rules = [
            'funcionario' => 'required',
            'funcao' => 'required',
        ];

        $messages = [
            'funcionario.required' => 'O campo funcionario é obrigatório.',
            'funcao.required' => 'O campo função é obrigatório.'
        ];

        $this->validate($request, $rules, $messages);
    }

    private function _validateRelatorio(Request $request){
        $rules = [
            'texto' => 'required|min:15',
        ];

        $messages = [
            'texto.required' => 'O campo texto é obrigatório.',
            'texto.min' => 'Minimo de 15 caracteres.',
        ];

        $this->validate($request, $rules, $messages);
    }

    public function cashFlow(){

        $dateStart = $this->validDate(Date('Y-m-d'));
        $dateLast = $this->validDate(Date('Y-m-d'), true);
        $orders = Order::
        whereBetween('date_register', [$dateStart, $dateLast])
        ->get();

        return view('os/flow')
        ->with('orders', $orders)
        ->with('print', true)
        ->with('title', 'Orders de Serviço');
    }

    public function find(Request $request){
        $id = $request->id;
        $order = ordemServico::find($id);
        return $order;
        $services = [];
        $products = [];

        foreach($order->budget->services as $o){
            $temp = [
                'quantity' => $o->quantity,
                'value' => $o->value,
                'name' => $o->service->description   
            ];
            array_push($services, $temp);
        }

        foreach($order->budget->products as $o){
            $temp = [
                'quantity' => $o->quantity,
                'value' => $o->value,
                'name' => $o->product->name   
            ];
            array_push($products, $temp);
        }

        $resp = [
            'id' => $order->id,
            'warranty' => $order->warranty,
            'client' => $order->budget->client->name,
            'services' => $services,
            'payment_form' => $order->payment_form,
            'products' => $products,
            'note' => $order->note,
        ];
        echo json_encode($resp);
    }

    public function cashFlowFilter(Request $request){
        $dateStart = $this->validDate($request->input('date_start'));
        $dateLast = $this->validDate($request->input('date_last'), true);
        $orders = Order::
        whereBetween('date_register', [$dateStart, $dateLast])
        ->get();

        return view('os/flow')
        ->with('orders', $orders)
        ->with('print', true)
        ->with('title', 'Orders de Serviço');
    }

    private function validDate($date, $plusDay = false){
        $date = str_replace('/', '-', $date);
        if($plusDay)
            $date = date("Y-m-d", strtotime("$date +1 day"));
        return Carbon::parse( $date . ' 00:00:00')->format('Y-m-d H:i:s');
    }

    public function print($id){
        $order = Order
        ::where('id', $id)
        ->first();

        if(valida_objeto($order)){
            return view('os/print')
            ->with('order', $order)
        //->with('print', true)
            ->with('title', 'Orders de Serviço');
        }else{
            return redirect('/403');
        }
    }

    public function imprimir($id){
        $ordem = OrdemServico::find($id);
        if(valida_objeto($ordem)){
            $config = ConfigNota::
            where('empresa_id', $this->empresa_id)
            ->first();

            if($config == null){
                return redirect('/configNF');
            }

            return view('os/print')
            ->with('ordem', $ordem)
            ->with('config', $config)
            ->with('title', 'Imprimindo OS');
        }else{
            return redirect('/403');
        }
    }


// funcinarios

    public function saveFuncionario(Request $request){
        $this->_validateFuncionario($request);

        $funcionarioOs = new FuncionarioOs();

        $funcionario = $request->input('funcionario');
        $funcionario = explode("-", $funcionario);
        $funcionario = $funcionario[0];

        $ordem = OrdemServico::
        where('id', $request->input('ordem_servico_id'))
        ->first();

        $funcionarioObj = Funcionario::find($funcionario);

        $result = $funcionarioOs->create([
            'funcao' => $request->input('funcao'),
            'ordem_servico_id' => $request->input('ordem_servico_id'),
            'funcionario_id' => $funcionarioObj->id,
            'usuario_id' => get_id_user(),
        ]);

        if($result){
            session()->flash("mensagem_sucesso", "Funcionario adicionado!");
        }else{
            session()->flash('mensagem_erro', 'Erro ao adicionar!');
        }

        return redirect("/ordemServico/servicosordem/$request->ordem_servico_id");
    }



    public function deleteFuncionario($id){
        $obj = FuncionarioOs
        ::where('id', $id)
        ->first();

        if(valida_objeto($obj->ordemServico)){
            $id = $obj->ordemServico->id;

            $ordem = OrdemServico::
            where('id', $id)
            ->first();

            $delete = $obj->delete();
            if($delete){
                session()->flash('mensagem_sucesso', 'Registro removido!');
            }else{
                session()->flash('mensagem_erro', 'Erro!');
            }

            return redirect("/ordemServico/servicosordem/$id");
        }else{
            return redirect('/403');
        }
    }

    public function alterarStatusServico($servicoId){
        $servicoOs = ServicoOs::
        where('id', $servicoId)
        ->first();

        if(valida_objeto($servicoOs->ordemServico)){

            $servicoOs->status = !$servicoOs->status;
            $servicoOs->save();

            session()->flash('mensagem_sucesso', 'Status de serviço alterado!');
            return redirect("/ordemServico/servicosordem/".$servicoOs->servico->id);
        }else{
            return redirect('/403');
        }
    }

//fim funcionarios
}
