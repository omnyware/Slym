<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeliveryConfig;
use App\MercadoConfig;
use App\ClienteDelivery;
use App\CategoriaProdutoDelivery;
use App\ProdutoDelivery;
use App\ItemPedidoDelivery;
use App\BannerTopo;
use App\BannerMaisVendido;
use App\Rules\CelularDup;
use App\PedidoDelivery;
use App\BairroDelivery;
use Comtele\Services\TextMessageService;
use App\FuncionamentoDelivery;
use Mail;

class MercadoController extends Controller
{

    protected $imagensRandom = [];
    public function __construct(){

        $categorias = CategoriaProdutoDelivery::all();
        if(sizeof($categorias) > 0){
            $temp = [];
            for($aux = 0; $aux < 4; $aux++){
                $n = rand(0, sizeof($categorias)-1);
                array_push($this->imagensRandom, $categorias[$n]->path);
            }
        }
    }

    public function index(){

        $deliveryLancheAtivo = getenv('DELIVERY');
        $deliveryMercadoAtivo = getenv('DELIVERY_MERCADO');

        if($deliveryMercadoAtivo == 0 && $deliveryLancheAtivo == 1){
            return redirect('/');
        }else if($deliveryMercadoAtivo == 0 && $deliveryLancheAtivo == 0){
            return redirect('/login');
        }

        $config = DeliveryConfig::first();
        $mercadoConfig = MercadoConfig::first();
        $categoriaBlocos = $this->categoriaBlocos();
        $itesMaisVendidosDaSemana = ItemPedidoDelivery::maisVendidosDaSemana();
        $produtos = $this->produtosDeliveryLimit();
        if($itesMaisVendidosDaSemana[0]->id == null) $itesMaisVendidosDaSemana = [];

        if($mercadoConfig == null){
            return redirect('/login');
        }

        $bannersTopo = BannerTopo::where('ativo', true)->get();
        $maisVendido = null;
        $BannerMaisVendido = BannerMaisVendido::all();
        if(sizeof($BannerMaisVendido) > 0){
            $maisVendido = $BannerMaisVendido[rand(0, sizeof($BannerMaisVendido)-1)];
        }
        $rota = 'inicio';

        $produtoEmDestaque = [];
        if(sizeof($itesMaisVendidosDaSemana) == 0){
            $produtoEmDestaque = $this->produtoEmDestaque();
        }

        return view('delivery_mercado/index')
        ->with('config', $config)
        ->with('mercadoConfig', $mercadoConfig)
        ->with('categorias', $categoriaBlocos)
        ->with('itesMaisVendidosDaSemana', $itesMaisVendidosDaSemana)
        ->with('produtos', $produtos)
        ->with('rota', $rota)
        ->with('produtoEmDestaque', $produtoEmDestaque)
        ->with('imagens', $this->imagensRandom)
        ->with('bannersTopo', $bannersTopo)
        ->with('BannerMaisVendido', $maisVendido)
        ->with('title', 'Inicio');
    }

    private function categoriaBlocos(){
        $categorias = CategoriaProdutoDelivery::all();
        $sizeBloco1 = 3;
        $sizeBloco2 = 3;
        $sizeBloco3 = 3;

        $arrBloco1 = [];
        $arrBloco2 = [];
        $arrBloco3 = [];

        foreach($categorias as $key => $c){

            if(sizeof($arrBloco1) < $sizeBloco1){
                array_push($arrBloco1, $c);
            } else if(sizeof($arrBloco1) == $sizeBloco1 && sizeof($arrBloco2) < $sizeBloco2){
               array_push($arrBloco2, $c);
           } else if(sizeof($arrBloco2) == $sizeBloco2 && sizeof($arrBloco3) < $sizeBloco3){
               array_push($arrBloco3, $c);
           }
       }


       return [
          'bloco1' => $arrBloco1,
          'bloco2' => $arrBloco2,
          'bloco3' => $arrBloco3,
      ];
  }

  private function produtoEmDestaque(){
    return ProdutoDelivery::
    where('destaque', 1)
    ->limit(6)
    ->get();
}

private function produtosDeliveryLimit($limit = 6){
 $produtos = ProdutoDelivery::
 limit($limit)
 ->get();
 return $produtos;
}

public function categorias(){
    $categorias = CategoriaProdutoDelivery::all();
    $config = DeliveryConfig::first();
    $mercadoConfig = MercadoConfig::first();
    $rota = 'categorias';
    return view('delivery_mercado/categorias')
    ->with('config', $config)
    ->with('rota', $rota)
    ->with('imagens', $this->imagensRandom)
    ->with('mercadoConfig', $mercadoConfig)
    ->with('categorias', $categorias)

    ->with('title', 'Categorias');
}

public function produto($id){
    $cliente = session('cliente_log');
    if($cliente == null){
        session()->flash('message_erro', 'Faça o login ou cadastre-se');
        return redirect("/delivery/login");
    }
    $produto = ProdutoDelivery::find($id);
    $config = DeliveryConfig::first();
    $mercadoConfig = MercadoConfig::first();
    $rota = 'categorias';

    return view('delivery_mercado/produto')
    ->with('config', $config)
    ->with('rota', $rota)
    ->with('imagens', $this->imagensRandom)
    ->with('mercadoConfig', $mercadoConfig)
    ->with('produto', $produto)

    ->with('title', 'Ver Produto');
}

public function login(){
    $rota = 'login';
    $config = DeliveryConfig::first();
    $mercadoConfig = MercadoConfig::first();

    return view('delivery_mercado/login')
    ->with('config', $config)
    ->with('mercadoConfig', $mercadoConfig)
    ->with('rota', $rota)
    ->with('imagens', $this->imagensRandom)
    ->with('title', 'Login');
}

public function loginUser(Request $request){
    $mailPhone = $request->mail_phone;
    $mailPhone = str_replace(" ", "", $mailPhone);
    $senha = md5($request->senha);
    $cliente = null;
    if(is_numeric($mailPhone)){

        if(strlen($mailPhone) != 11){
            session()->flash('message_erro_telefone', 'Digite o telefone seguindo este padrao de exemplo 43999998888 - 11 Digitos.');
            return redirect('/delivery/login');
        }

        $cliente = ClienteDelivery::where('celular', $this->setaMascaraPhone($mailPhone))
        ->where('senha', $senha)
        ->first();

    }else{
        $cliente = ClienteDelivery::where('email', $mailPhone)
        ->where('senha', $senha)
        ->first();
    }

    if($cliente == null){
        session()->flash('message_erro', 'Credenciais inválidas.');
        return redirect('/delivery/login');
    }else{

        if($cliente->ativo == 0){
            $celular = $cliente->celular;
            $celular = str_replace("-", "", $celular);
            $celular = str_replace(" ", "", $celular);
            if(getenv("AUTENTICACAO_SMS") == 1) $this->sendSms($celular, $cliente->token);

            if(getenv("AUTENTICACAO_EMAIL") == 1) $this->sendEmailLink($cliente->email, $cliente->token);
            $config = DeliveryConfig::first();
            $mercadoConfig = MercadoConfig::first();
            $rota = 'login';

            return view('delivery_mercado/autenticar')

            ->with('celular', $cliente->celular)
            ->with('config', $config)
            ->with('mercadoConfig', $mercadoConfig)
            ->with('rota', $rota)
            ->with('imagens', $this->imagensRandom)
            ->with('cadastro_ative_mercado_js', true)
            ->with('title', 'AUTENTICAR');
        }else{
            $session = [
                'id' => $cliente->id,
                'nome' => $cliente->nome,
            ];
            session(['cliente_log' => $session]);
            session()->flash("message_sucesso", "Bem vindo ". $cliente->nome);
            return redirect('/delivery'); 
        }
    }
}

public function cadastrar(){
    $rota = 'login';
    $config = DeliveryConfig::first();
    $mercadoConfig = MercadoConfig::first();

    return view('delivery_mercado/cadastrar')
    ->with('config', $config)
    ->with('mercadoConfig', $mercadoConfig)
    ->with('rota', $rota)
    ->with('imagens', $this->imagensRandom)
    ->with('title', 'Cadastrar-se');
}

public function produtos($categoriaId){
    $cliente = session('cliente_log');
    
    $rota = 'categorias';
    $config = DeliveryConfig::first();
    $mercadoConfig = MercadoConfig::first();

    $produtos = ProdutoDelivery::
    where('categoria_id', $categoriaId)
    ->where('status', 1)
    ->get();

    $categoria = CategoriaProdutoDelivery::find($categoriaId);

    $produtos = $this->atribuirQuantidadeAosProdutos($produtos);


    return view('delivery_mercado/produtos')
    ->with('config', $config)
    ->with('mercadoConfig', $mercadoConfig)
    ->with('rota', $rota)
    ->with('categoria', $categoria)
    ->with('imagens', $this->imagensRandom)
    ->with('produtos', $produtos)
    ->with('title', 'Produtos');
}

private function atribuirQuantidadeAosProdutos($produtos){

    $cliente = session('cliente_log');
    $cliente = ClienteDelivery::find($cliente['id']);
    $temp = [];
    if($cliente == null) {
        foreach($produtos as $p){
            $p['quantidade'] = 0.000;
            array_push($temp, $p);
        }
        return $temp;
    }

    $carrinho = PedidoDelivery
    ::where('estado', 'nv')
    ->where('cliente_id', $cliente->id)
    ->where('valor_total', '=', 0)
    ->first();



    foreach($produtos as $p){
        $p['quantidade'] = $p->produto->unidade_venda == 'UNID' ? 0 : number_format(0, 3);
        if(isset($carrinho->itens)){
            foreach($carrinho->itens as $item){
                if($item->produto_id == $p->id){

                    if($p->produto->unidade_venda == 'UNID'){
                        $p->quantidade = (int) $item->quantidade;
                    }else{
                     $p->quantidade = number_format($item->quantidade, 3);
                 }
             }
         }
     }
     array_push($temp, $p);
 }

 return $temp;

}

public function salvarRegistro(Request $request){

    $this->_validate($request);

    $cod = rand(100000, 888888);
    $request->merge([ 'senha' => md5($request->senha)]);
    $request->merge([ 'ativo' => false]);
    $request->merge([ 'token' => $cod]);

    $result = ClienteDelivery::create($request->all());
    if($result){



        $celular = $request->celular;
        $celular = str_replace(" ", "", $celular);
        $celular = str_replace("-", "", $celular);

        if(getenv("AUTENTICACAO_SMS") == 1){
            $this->sendSms($celular, $cod);
        }
        else if(getenv("AUTENTICACAO_EMAIL") == 1) { 
            $this->sendEmailLink($request->email, $cod);
        }else{
            $cliente = ClienteDelivery::find($result->id);
            $session = [
                'id' => $cliente->id,
                'nome' => $cliente->nome,
            ];
            $cliente->ativo = 1;
            $cliente->save();
            session(['cliente_log' => $session]);
            session()->flash("message_sucesso", "Bem vindo ". $cliente->nome);
            return redirect('/delivery'); 
        }

        $config = DeliveryConfig::first();
        $mercadoConfig = MercadoConfig::first();
        $rota = 'login';

        return view('delivery_mercado/autenticar')

        ->with('celular', $request->celular)
        ->with('config', $config)
        ->with('mercadoConfig', $mercadoConfig)
        ->with('rota', $rota)
        ->with('imagens', $this->imagensRandom)
        ->with('cadastro_ative_mercado_js', true)
        ->with('title', 'AUTENTICAR');

    }else{
        session()->flash('message_erro', 'Erro ao se registrar!');
        return redirect('/delivery');
    }
}

private function _validate(Request $request){
    $rules = [
        'nome' => 'required|max:30',
        'sobre_nome' => 'required|max:30',
        'senha' => 'required|min:4|max:10|same:senha_confirma',
        'celular' => ['required','min:13', 'max:15',new CelularDup],
        'email' => 'required|max:50|email',
        'senha_confirma' => 'required'

    ];

    $messages = [
        'nome.required' => 'O campo nome é obrigatório.',
        'nome.max' => 'Maximo de 30 caracteres',
        'sobre_nome.required' => 'O campo sobre nome é obrigatório.',
        'sobre_nome.max' => 'Maximo de 30 caracteres',
        'senha.required' => 'O campo senha é obrigatório.',
        'senha.max' => 'Maximo de 10 caracteres',
        'senha.min' => 'Maximo de 4 caracteres',
        'senha.same' => 'Senhas não coincidem',
        'senha_confirma.required' => 'O campo confirma senha é obrigatório',
        'celular.required' => 'O campo celular é obrigatório.',
        'celular.min' => 'Minimo de 15 caracteres',
        'celular.max' => 'Maximo de 15 caracteres',
        'email.required' => 'O campo email é obrigatório.',
        'email.max' => 'Maximo de 50 caracteres',
        'email.email' => 'Email inválido'
    ];
    $this->validate($request, $rules, $messages);
}

public function validaToken(Request $request){
    $token = $request->codToken;
    $celular = $request->celular;

    if(substr($celular, 8,1) != "-")
        $validCelular = $this->setMask($celular);
    else
        $validCelular = $celular;

    $cliente = ClienteDelivery::where('celular', $validCelular)
    ->first();

    if($cliente->token == $token){
        $cliente->ativo = true;
        $cliente->save();
        $session = [
            'id' => $cliente->id,
            'nome' => $cliente->nome,
        ];
        session(['cliente_log' => $session]);
        session()->flash("message_sucesso", "Bem vindo ". $cliente->nome."!");
        return response()->json(true, 200);
    }else{
        session()->flash("message_erro", "Código de verificação inválido");
        return response()->json(false, 204);
    }
}

private function setMask($celular){
    $c = substr($celular, 0, 2) . " " . 
    substr($celular, 2,5) . "-" . substr($celular, 7,4);
    return $c;
}

private function sendSms($phone, $cod){
    $nomeEmpresa = getenv('SMS_NOME_EMPRESA');
    $nomeEmpresa = str_replace("_", " ",  $nomeEmpresa);
    $nomeEmpresa = str_replace("_", " ",  $nomeEmpresa);
    $content = $nomeEmpresa. " codigo de Autorizacao ". $cod;
    $textMessageService = new TextMessageService(getenv('SMS_KEY'));
    $res = $textMessageService->send("Sender", $content, [$phone]);
    return $res;
}

private function sendEmailLink($email, $cod){
    Mail::send('mail.link_verifica', ['link' => md5("$cod-$email")], function($m) use ($email){
        $nomeEmail = getenv('MAIL_NAME');
        $nomeEmail = str_replace("_", " ", $nomeEmail);
        $m->from(getenv('MAIL_USERNAME'), $nomeEmail);
        $m->subject('Autenticação');
        $m->to($email);
    });
}

private function setaMascaraPhone($phone){
    $n = substr($phone, 0, 2) . " ";
    $n .= substr($phone, 2, 5)."-";
    $n .= substr($phone, 7, 4);
    return $n;
}

public function logoff(){
    session()->forget('cliente_log');

    session()->flash('message_erro', 'Logoff realizado.');
    return redirect("/delivery/login");
}

public function carrinho(){
    $cliente = session('cliente_log');
    $cliente = ClienteDelivery::find($cliente['id']);

    if($cliente == null){
        session()->flash('message_erro', 'Faça o login ou cadastre-se');
        return redirect("/delivery/login");
    }

    $pedido = PedidoDelivery::where('estado', 'nv')
    ->where('cliente_id', $cliente->id)
    ->first();

    if($pedido == null){
        session()->flash('message_erro', 'Carrinho vazio!');
        return redirect("/delivery");
    }

    if($pedido->valor_total == 0){
        $rota = '';
        $config = DeliveryConfig::first();
        $mercadoConfig = MercadoConfig::first();

        return view('delivery_mercado/carrinho')
        ->with('config', $config)
        ->with('mercadoConfig', $mercadoConfig)
        ->with('rota', $rota)
        ->with('pedido', $pedido)
        ->with('imagens', $this->imagensRandom)
        ->with('title', 'Carrinho');
    }else{
        session()->flash('message_erro', 'Você já possui um pedido, aguarde o processamento!');
        return redirect("/delivery");
    }
}

public function finalizar(Request $request){
    $cliente = session('cliente_log');
    $cliente = ClienteDelivery::find($cliente['id']);
    if($cliente == null){
        return redirect('/delivery');
    }
    $pedido = PedidoDelivery::find($request->pedido_id);

    $rota = '';
    $config = DeliveryConfig::first();
    $mercadoConfig = MercadoConfig::first();

    $funcionamento = $this->funcionamento();

    $pagseguroAtivo = getenv("PAGSEGURO_ATIVO");
    $pagseguroEmail = getenv("PAGSEGURO_EMAIL");
    $pagseguroToken = getenv("PAGSEGURO_TOKEN");

    $pagseguroAtivado = false;
    if($pagseguroAtivo == 1 && strlen($pagseguroEmail) > 10 && strlen($pagseguroToken) > 10){
        $pagseguroAtivado = true;
    }

    if(!$funcionamento['status']){
        if($funcionamento['funcionamento'] != null){
            session()->flash("message_erro", "Delivery das " .$funcionamento['funcionamento']->inicio_expediente. " às ".$funcionamento['funcionamento']->fim_expediente);

        }else{
            session()->flash("message_erro", "Não haverá delivery no dia de hoje!");
        }
        return redirect('/delivery'); 
    }

    if(!$pedido || count($pedido->itens) == 0){
        session()->flash("message_erro", "Carrinho vazio!");
        return redirect('/delivery'); 
    }

    $enderecos = $cliente->enderecos;

    $ultimoPedido = PedidoDelivery::
    where('cliente_id', $cliente->id)
    ->where('valor_total', '>', 0)
    ->orderBy('id', 'desc')
    ->first();

    $cartoes = $this->getPedidosPagSeguro($cliente->id);
    $bairros = BairroDelivery::orderBy('nome')->get();
    return view('delivery_mercado/finalizar')
    ->with('config', $config)
    ->with('mercadoConfig', $mercadoConfig)
    ->with('ultimoPedido', $ultimoPedido)
    ->with('rota', $rota)
    ->with('pedido', $pedido)
    ->with('mapaJs', true)
    ->with('forma_pagamento', true)
    ->with('pagseguroAtivado', $pagseguroAtivado)
    ->with('cartoes', $cartoes)
    ->with('cliente', $cliente)
    ->with('bairros', $bairros)
    ->with('usar_bairros', $config->usar_bairros)
    ->with('enderecos', $enderecos)
    ->with('total', $pedido->somaItens())
    ->with('imagens', $this->imagensRandom)
    ->with('title', 'Finalizar');
}

private function funcionamento(){
    $atual = strtotime(date('H:i'));
    $dias = FuncionamentoDelivery::dias();
    $hoje = $dias[date('w')];
    $func = FuncionamentoDelivery::where('dia', $hoje)->first();

    if($func){
        if($atual >= strtotime($func->inicio_expediente) && $atual < strtotime($func->fim_expediente) && $func->ativo){
            return ['status' => true, 'funcionamento' => $func];
        }else{
            return ['status' => false, 'funcionamento' => $func];
        }
    }else{
        return ['status' => false, 'funcionamento' => null];
    }

}

private function getPedidosPagSeguro($clienteId){
    $pedidos = PedidoDelivery::where('cliente_id', $clienteId)
    ->get();
    $arr = [];
    $cartaoInserido = [];
    foreach($pedidos as $p){
        if($p->forma_pagamento == 'pagseguro'){
            if(!in_array($p->pagseguro->numero_cartao, $cartaoInserido)){
                $p->pagseguro->src_bandeira = 'https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/'.
                $p->pagseguro->bandeira . '.png';
                array_push($arr, $p->pagseguro);
                array_push($cartaoInserido, $p->pagseguro->numero_cartao);
            }
        }
    }

    return $arr;
}

public function finalizarPedido(Request $request){
    $data = $request['data'];
    $pedido = PedidoDelivery::
    where('id', $data['pedido_id'])
    ->where('estado', 'nv')
    ->first();
    if($pedido){
        $total = $pedido->somaItens();

        if($data['desconto']){
            $total -= str_replace(",", ".", $data['desconto']);
        }

        if($data['endereco_id'] != 'balcao'){
            $total += $data['valor_entrega'];
        }

        $pedido->forma_pagamento = $data['forma_pagamento'];
        $pedido->observacao = $data['observacao'] ? substr($data['observacao'], 0, 50) : '';
        $pedido->endereco_id = $data['endereco_id'] == 'balcao' ? null : $data['endereco_id'];
        $pedido->valor_total = $total;
        $pedido->telefone = $data['telefone'];
        $pedido->troco_para = $data['troco'] ? str_replace(",", ".", $data['troco']) : 0;
        $pedido->data_registro = date('Y-m-d H:i:s');
        $pedido->desconto = $data['desconto'] ? str_replace(",", ".", $data['desconto']) : 0;

        if($data['cupom'] != ''){
            $cupom = CodigoDesconto::
            where('codigo', $data['cupom'])
            ->first();

            if($cupom->cliente_id != null){
                $cupom->ativo = false;
                $cupom->save();
            }

            $pedido->cupom_id= $cupom ? $cupom->id : NULL;
        }

        $pedido->save();

        return response()->json($pedido, 200);
    }else{
        return response()->json(false, 401);

    }
}

public function finalizado($id){
    $clienteLog = session('cliente_log');
    $pedido = PedidoDelivery::
    where('estado', 'nv')
    ->where('valor_total', '!=', 0)
    ->where('id', $id)
    ->where('cliente_id', $clienteLog['id'])
    ->first();

    if($pedido){
        $rota = '';
        $config = DeliveryConfig::first();
        $mercadoConfig = MercadoConfig::first();
        return view('delivery_mercado/pedido_finalizado')
        ->with('pedido', $pedido)
        ->with('config', $config)
        ->with('mercadoConfig', $mercadoConfig)
        ->with('rota', $rota)
        ->with('imagens', $this->imagensRandom)
        ->with('title', 'Pedido Finalizado');
    }else{
        session()->flash("message_erro", "Pedido inexistente");
        return redirect('/delivery');
    }
}

public function pedidoPendente(){
    session()->flash('message_erro', 'Você já possui um pedido, aguarde o processamento!');
    return redirect("/delivery");
}

public function meusPedidos(){

    $clienteLog = session('cliente_log');
    $pedidos = PedidoDelivery::
    where('cliente_id', $clienteLog['id'])
    ->orderBy('id', 'desc')
    ->where('valor_total', '>', 0)
    ->get();


    $rota = 'meus_pedidos';
    $config = DeliveryConfig::first();
    $mercadoConfig = MercadoConfig::first();

    return view('delivery_mercado/historico')
    ->with('pedidos', $pedidos)
    ->with('historico', true)
    ->with('rota', $rota)
    ->with('config', $config)
    ->with('mercadoConfig', $mercadoConfig)
    ->with('imagens', $this->imagensRandom)
    ->with('title', 'Historico');

}

public function detalhePedido($id){
    $clienteLog = session('cliente_log');
    $pedido = PedidoDelivery::
    where('cliente_id', $clienteLog['id'])
    ->where('id', $id)
    ->first();

    $rota = 'meus_pedidos';
    $config = DeliveryConfig::first();
    $mercadoConfig = MercadoConfig::first();

    return view('delivery_mercado/detalhePedido')
    ->with('pedido', $pedido)
    ->with('historico', true)
    ->with('rota', $rota)
    ->with('config', $config)
    ->with('mercadoConfig', $mercadoConfig)
    ->with('imagens', $this->imagensRandom)
    ->with('title', 'Detalhe do pedido ' . $id);

}

public function pedir_novamente($id){
    $clienteLog = session('cliente_log');

    $pedidoTemp = PedidoDelivery
    ::where('estado', 'nv')
    ->where('cliente_id', $clienteLog['id'])
    ->where('valor_total', 0)
    ->first();

    if($pedidoTemp != null){ 
        $pedidoTemp->delete();
    }

    $pedidoAnterior = PedidoDelivery::find($id);

    if($pedidoAnterior->estado != 'nv'){

        $clienteLog = session('cliente_log');

        $pedido = PedidoDelivery::create([
            'cliente_id' => $pedidoAnterior->cliente_id,
            'valor_total' => 0,
            'telefone' => '',
            'observacao' => '',
            'forma_pagamento' => '',
            'estado'=> 'nv',
            'motivoEstado'=> '',
            'endereco_id' => NULL,
            'troco_para' => 0,
            'cupom_id' => NULL,
            'desconto' => 0,
            'app' => false
        ]);


        foreach($pedidoAnterior->itens as $i){

            $item = ItemPedidoDelivery::create([
                'pedido_id' => $pedido->id,
                'produto_id' => $i->produto_id,
                'status' => false,
                'observacao' => $i->observacao,
                'quantidade' => $i->quantidade,
                'tamanho_id' => $i->tamanho_id
            ]);

            if($i->tamanho != null){

                foreach($i->sabores as $s){
                    ItemPizzaPedido::create([
                        'item_pedido' => $item->id,
                        'sabor_id' => $s->sabor_id
                    ]);
                }
            }

            foreach($i->itensAdicionais as $a){

                $itemAdd = ItemPedidoComplementoDelivery::create([
                    'item_pedido_id' => $item->id,
                    'complemento_id' => $a->complemento_id,
                    'quantidade' => 1,
                ]);
            }
        }
        session()->flash("message_sucesso", "Itens do pedido adicionados ao seu carrinho!");
        return redirect('/delivery/carrinho');
    }else{
        session()->flash("message_erro", "Não foi possivel pedir novamente!");
        return redirect('/delivery/meusPedidos');
    }
}

public function pesquisaProduto(Request $request){
    $pesquisa = $request->search;

    if($pesquisa == '' || $pesquisa == ' '){
        return redirect('/delivery');
    }

    $produtos = ProdutoDelivery::
    select('produto_deliveries.*')
    ->join('produtos', 'produtos.id', '=', 'produto_deliveries.produto_id')
    ->where('produtos.nome', 'LIKE', "%$pesquisa%")
    ->get();

    $rota = 'categorias';
    $config = DeliveryConfig::first();
    $mercadoConfig = MercadoConfig::first();

    $produtos = $this->atribuirQuantidadeAosProdutos($produtos);

    return view('delivery_mercado/produtos')
    ->with('config', $config)
    ->with('mercadoConfig', $mercadoConfig)
    ->with('pesquisa', $pesquisa)
    ->with('rota', $rota)
    ->with('imagens', $this->imagensRandom)
    ->with('produtos', $produtos)
    ->with('title', 'Produtos');
}

public function recuperarSenha(){

    $rota = 'login';
    $config = DeliveryConfig::first();
    $mercadoConfig = MercadoConfig::first();
    return view('delivery_mercado/recuperarSenha')
    ->with('rota', $rota)
    ->with('config', $config)
    ->with('mercadoConfig', $mercadoConfig)
    ->with('imagens', $this->imagensRandom)

    ->with('title', 'Recuperar Senha');
}

public function enviarSenha(Request $request){
    $mailPhone = $request->mail_phone;

    $mailPhone = str_replace(" ", "", $mailPhone);

    $cliente = null;
    if(is_numeric($mailPhone)){

        if(strlen($mailPhone) != 11){
            session()->flash('message_erro_telefone', 'Digite o telefone seguindo este padrao de exemplo 43999998888 - 11 Digitos.');
            return redirect("/delivery/esqueci-senha");
        }

        $cliente = ClienteDelivery::where('celular', $this->setaMascaraPhone($mailPhone))
        ->first();

    }else{
        $cliente = ClienteDelivery::where('email', $mailPhone)
        ->first();
    }

    if($cliente == null){
        session()->flash('message_erro', 'Email ou telefone não encontrado.');
        return redirect('/delivery/esqueci-senha');
    }else{
        $newPass = $this->randomPassword();
        if(getenv("AUTENTICACAO_SMS") == 1) {

            $this->sendSmsSenha($mailPhone, $newPass);
            $cliente->senha = md5($newPass);
            $cliente->save();
            session()->flash('message_sucesso', 'SMS enviado com sua nova senha, aguarde o recebimento...');
            return redirect('/delivery/login');
        }
        if(getenv("AUTENTICACAO_EMAIL") == 1 && getenv("SERVIDOR_WEB") == 1) {

            Mail::send('mail.nova_senha', ['senha' => $newPass], function($m) use ($cliente){

                $nomeEmail = getenv('MAIL_NAME');
                $nomeEmail = str_replace("_", " ", $nomeEmail);
                $m->from(getenv('MAIL_USERNAME'), $nomeEmail);

                $m->subject('recuperacao de senha');
                $m->to($cliente->email);
            });
            $cliente->senha = md5($newPass);
            $cliente->save();
            session()->flash('message_sucesso', 'Email enviado com sua nova senha, aguarde o recebimento...');
            return redirect('/delivery/esqueci-senha');
        }else{
            session()->flash('message_sucesso', 'Nada configurado.');
            return redirect('/delivery/login');
        }
        
        
    }

}

private function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890';
    $pass = array(); 
    $alphaLength = strlen($alphabet) - 1; 
    for ($i = 0; $i < 4; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); 
}

private function sendSmsSenha($phone, $cod){
    $nomeEmpresa = getenv('SMS_NOME_EMPRESA');
    $nomeEmpresa = str_replace("_", " ",  $nomeEmpresa);
    $nomeEmpresa = str_replace("_", " ",  $nomeEmpresa);
    $content = $nomeEmpresa. ", sua nova senha é ". $cod;
    $textMessageService = new TextMessageService(getenv('SMS_KEY'));
    $res = $textMessageService->send("Sender", $content, [$phone]);
    return $res;
}

}
