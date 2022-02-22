<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use App\ItemPedido;
use App\ItemPizzaPedidoLocal;
use App\Produto;
use App\ProdutoPizza;
use App\ItemPedidoComplementoLocal;
use App\ComplementoDelivery;
use App\VendaCaixa;
use App\ConfigNota;
use App\BairroDelivery;
use App\PedidoDelete;
use App\TamanhoPizza;
use App\Mesa;
use App\Usuario;
use Comtele\Services\TextMessageService;
use NFePHP\DA\NFe\CupomPedido;
use NFePHP\DA\NFe\Itens;
use App\Certificado;
use App\Categoria;
use App\Cliente;
use App\AberturaCaixa;

class PedidoController extends Controller{

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
    $pedidos = Pedido::
    where('desativado', false)
    ->where('empresa_id', $this->empresa_id)
    ->get();

    $mesas = Mesa::
    where('empresa_id', $this->empresa_id)
    ->get();
    $mesasParaAtivar = $this->mesasParaAtivar();

    $mesasFechadas = $this->mesasFechadas();

    return view('pedido/list')
    ->with('pedidos', $pedidos)
    ->with('mesas', $mesas)
    ->with('atribuirComandaJs', true)
    ->with('mesasParaAtivar', $mesasParaAtivar)
    ->with('mesasFechadas', $mesasFechadas)
    ->with('title', 'Lista de Pedidos');
  }

  private function mesasParaAtivar(){
    $mesas = Pedido::where('mesa_ativa', false)
    ->where('mesa_id', '!=', null)
    ->where('empresa_id', $this->empresa_id)
    ->get();
    return $mesas;
  }

  private function mesasFechadas(){
    $mesas = Pedido::where('fechar_mesa', true)
    ->where('mesa_id', '!=', null)
    ->where('desativado', false)
    ->where('empresa_id', $this->empresa_id)
    ->get();
    return $mesas;
  }


  public function abrir(Request $request){
    $comanda = Pedido::
    where('comanda', $request->comanda)
    ->where('desativado', false)
    ->first();
    if(empty($comanda)){
     $res = Pedido::create([
      'comanda' => $request->comanda,
      'observacao' => $request->observacao ?? '',
      'status' => false,
      'nome' => '',
      'rua' => '',
      'numero' => '',
      'bairro_id' => null,
      'referencia' => '',
      'telefone' => '',
      'desativado' => false,
      'mesa_id' => $request->mesa_id != 'null' ? $request->mesa_id : null,
      'empresa_id' => $this->empresa_id
    ]);
     if($res) {

      session()->flash('mensagem_sucesso', 'Comanda aberta com sucesso!');
    }
  }else{

    session()->flash('mensagem_erro', 'Esta comanda encontra-se ativa!');
  }
  return redirect('/pedidos');
}


public function ver($id){
  $pedido = Pedido::
  where('id', $id)
  ->first();
  if(valida_objeto($pedido)){
    $bairros = BairroDelivery::orderBy('nome')->get();
    $produtos = Produto::orderBy('nome')->get();
    $tamanhos = TamanhoPizza::all();

    $pizzas = [];

    foreach($produtos as $p){
      if($p->delivery){
        $p->delivery->pizza;

        foreach($p->delivery->pizza as $pz){
          $pz->tamanho;
        }
        if(sizeof($p->delivery->pizza) > 0){
          array_push($pizzas, $p);
        }

      } 
    }

    // $adicionais = ComplementoDelivery::
    // where('empresa_id', $this->empresa_id)
    // ->get();
    // foreach($adicionais as $a){
    //   $a->nome = $a->nome();
    // }

    $adicionais = [];

    return view('pedido/ver')
    ->with('pedido', $pedido)
    ->with('bairros', $bairros)
    ->with('produtos', $produtos)
    ->with('pizzas', $pizzas)
    ->with('tamanhos', $tamanhos)
    ->with('adicionais', $adicionais)
    ->with('pedidoJs', true)
    ->with('title', 'Comanda '.$id);
  }else{
    return redirect('/403');
  }
}

public function alterarStatus($id){
  $item = ItemPedido::
  where('id', $id)
  ->first();

  $item->status = 1;
  $item->save();

  session()->flash('mensagem_sucesso', 'Produto '. $item->produto->nome . ' marcado como concluido!');
  return redirect("/pedidos/ver/".$item->pedido->id);
}

public function deleteItem($id){
 $item = ItemPedido::
 where('id', $id)
 ->first();

 //armazena item

 PedidoDelete::create(
  [
    'pedido_id' => $item->pedido_id,
    'produto' => $item->nomeDoProduto(),
    'quantidade' => $item->quantidade,
    'valor' => $item->valor,
    'data_insercao' => \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s'),
    'empresa_id' => $this->empresa_id
  ]
);
 //fim armazena item

 if($item->delete()){

   session()->flash('mensagem_sucesso', 'Item removido!');
 }else{

   session()->flash('mensagem_erro', 'Erro');
 }
 return redirect('/pedidos/ver/'.$item->pedido_id);
}

public function desativar($id){
  $item = Pedido::
  where('id', $id)
  ->first();

  if(valida_objeto($item)){
    $item->desativado = true;
    $res = $item->save();

    if($res){

      session()->flash('mensagem_sucesso', 'Comanda desativada!');
    }else{

      session()->flash('mensagem_erro', 'Erro');
    }
    return redirect('/pedidos');
  }else{
    return redirect('/403');
  }
}

public function emAberto(){
  $pedidos = ItemPedido::where('status', false)
  ->get();

  return response()->json(count($pedidos), 200);
}


public function saveItem(Request $request){

  $this->_validateItem($request);
  $pedido = Pedido::
  where('id', $request->id)
  ->first();

  $produto = $request->input('produto');
  $produto = explode("-", $produto);
  $produto = $produto[0];

  $result = ItemPedido::create([
    'pedido_id' => $pedido->id,
    'produto_id' => $produto,
    'quantidade' => str_replace(",", ".", $request->quantidade),
    'status' => false,
    'tamanho_pizza_id' => $request->tamanho_pizza_id ?? NULL,
    'observacao' => $request->observacao ?? '',
    'valor' => str_replace(",", ".", $request->valor),
    'impresso' => false
  ]);

  if($request->tamanho_pizza_id && $request->sabores_escolhidos){
    $saborDup = false;

    $sabores = explode(",", $request->sabores_escolhidos);
    if(count($sabores) > 0){
      foreach($sabores as $sab){
        $prod = Produto
        ::where('id', $sab)
        ->first();

        $item = ItemPizzaPedidoLocal::create([
          'item_pedido' => $result->id,
          'sabor_id' => $prod->delivery->id,
        ]);

        if($prod->id == $produto) $saborDup = true;
      }
    }
    
    if(!$saborDup){
      $prod = Produto
      ::where('id', $produto)
      ->first();
      $item = ItemPizzaPedidoLocal::create([
        'item_pedido' => $result->id,
        'sabor_id' => $prod->delivery->id,
      ]);
    }
  }else if($request->tamanho_pizza_id){
    $prod = Produto
    ::where('id', $produto)
    ->first();
    $item = ItemPizzaPedidoLocal::create([
      'item_pedido' => $result->id,
      'sabor_id' => $prod->delivery->id,
    ]);
  }

  if($request->adicioanis_escolhidos){
    $adicionais = explode(",", $request->adicioanis_escolhidos);
    foreach($adicionais as $id){
      $id = (int)$id;

      $adicional = ComplementoDelivery
      ::where('id', $id)
      ->first();


      $item = ItemPedidoComplementoLocal::create([
        'item_pedido' => $result->id,
        'complemento_id' => $adicional->id,
        'quantidade' => str_replace(",", ".", $request->quantidade),
      ]);
    }
  }


  if($result){
    session()->flash('mensagem_sucesso', 'Item adicionado!');
  }else{
    session()->flash('mensagem_erro', 'Erro');
  }
  return redirect('/pedidos/ver/'.$pedido->id);
}

private function _validateItem(Request $request){
  $validaTamanho = false;
  if($request->input('produto')){
    $produto = $request->input('produto');
    $produto = explode("-", $produto);
    $produto = $produto[0];

    $p = Produto::
    where('id', $produto)
    ->first();

    if(strpos(strtolower($p->categoria->nome), 'izza') !== false){
      $validaTamanho = true;
    }
  }
  $rules = [
    'produto' => 'required',
    'quantidade' => 'required',
    'tamanho_pizza_id' => $validaTamanho ? 'required' : '',
  ];

  $messages = [
    'produto.required' => 'O campo produto é obrigatório.',

    'quantidade.required' => 'O campo quantidade é obrigatório.',
    'tamanho_pizza_id.required' => 'Selecione um tamanho.',
  ];

  $this->validate($request, $rules, $messages);
}

public function finalizar($id){
  $pedido = Pedido::
  where('id', $id)
  ->first();

  $atributes = $this->addAtributes($pedido->itens);

  $usuario = Usuario::find(get_id_user());
  $tiposPagamento = VendaCaixa::tiposPagamento();
  $config = ConfigNota::
  where('empresa_id', $this->empresa_id)
  ->first();

  $certificado = Certificado::
  where('empresa_id', $this->empresa_id)
  ->first();

  $tiposPagamentoMulti = VendaCaixa::tiposPagamentoMulti();
  $produtos = Produto::where('empresa_id', $this->empresa_id)
  ->orderBy('nome')->get();
  $categorias = Categoria::
  where('empresa_id', $this->empresa_id)
  ->get();

  $clientes = Cliente::where('empresa_id', $this->empresa_id)
  ->orderBy('razao_social')->get();

  $abertura = AberturaCaixa::where('empresa_id', $this->empresa_id)
  ->where('ultima_venda', 0)->orderBy('id', 'desc')->first();

  if($abertura != null){
    //se caixa aberto
    return view('frontBox/main')
    ->with('itens', $atributes)
    ->with('cod_comanda', $pedido->comanda)
    ->with('frenteCaixa', true)
    ->with('tiposPagamento', $tiposPagamento)
    ->with('tiposPagamentoMulti', $tiposPagamentoMulti)
    ->with('config', $config)
    ->with('usuario', $usuario)
    ->with('clientes', $clientes)
    ->with('produtos', $produtos)
    ->with('categorias', $categorias)
    ->with('certificado', $certificado)
    ->with('bairro', $pedido->bairro)
    ->with('title', 'Finalizar Comanda '.$id);
  }else{
    session()->flash('mensagem_erro', 'Abra o caixa primeiramente!');
    return redirect()->back();
  }
}


private function addAtributes($itens){
  $temp = [];
  foreach($itens as $i){
    $i->produto;

    if(!empty($i->sabores)){
      $i->sabores;

      $valorAdicional = 0;

      foreach($i->itensAdicionais as $ad){
        $valorAdicional += $ad->adicional->valor;
      }

      $i->valorAdicional = $valorAdicional;



      $maiorValor = 0;
      $somaValores = 0; 
      foreach($i->sabores as $sb){
        $sb->produto->produto;
        
        $v = $sb->maiorValor($sb->sabor_id, $i->tamanho_pizza_id);
        $somaValores += $v;
        if($v > $maiorValor) $maiorValor = $v;

        
      }

      if(getenv("DIVISAO_VALOR_PIZZA") == 1){
        $divide = sizeof($i->sabores);
        $divide = $divide == 0 ? 1 : $divide; 
        $i->maiorValor = $somaValores/$divide;
      }

    }
    $i->produto->valor_venda = $i->valor;

    if($i->maiorValor < $i->valor) $i->maiorValor = $i->valor;
    $i->produto_id = $i->produto->id;
    $i->produto->nome = $i->produto->nome;
    $i->item_pedido = $i->id;
    array_push($temp, $i);
  }
        // echo json_encode($temp);
  return $temp;
}

public function itensPendentes(){
  $itens = ItemPedido::
  where('status', false)
  ->get();

  echo json_encode(count($itens));
}

public function sms(Request $request){
  $data = $request->data;
  $phone = $data['numero'];
  $msg = $data['msg'];
  $res = $this->sendSms($phone, $msg);
  echo json_encode($res);
}

private function sendSms($phone, $msg){
  $nomeEmpresa = getenv('SMS_NOME_EMPRESA');
  $nomeEmpresa = str_replace("_", " ",  $nomeEmpresa);
  $nomeEmpresa = str_replace("_", " ",  $nomeEmpresa);
  $content = $msg;
  $textMessageService = new TextMessageService(getenv('SMS_KEY'));
  $res = $textMessageService->send("Sender", $content, [$phone]);
  return $res;
}

public function imprimirPedido($id){
  $pedido = Pedido::
  where('id', $id)
  ->where('empresa_id', $this->empresa_id)
  ->first();
  if(valida_objeto($resp)){
    $public = getenv('SERVIDOR_WEB') ? 'public/' : '';
    $pathLogo = $public.'imgs/logo.jpg';

    $cupom = new CupomPedido($pedido, $pathLogo);
    $cupom->monta();
    $pdf = $cupom->render();
  // file_put_contents($public.'pdf/CUPOM_PEDIDO.pdf',$pdf);
  // return redirect($public.'pdf/CUPOM_PEDIDO.pdf');

    return response($pdf)
    ->header('Content-Type', 'application/pdf');
  }else{
    return redirect('/403');
  }
}

public function itensParaFrenteCaixa(Request $request){
  $cod = $request->cod;

  $pedido = Pedido::
  where('comanda', $cod)
  ->where('status', 0)
  ->where('empresa_id', $this->empresa_id)
  ->where('desativado', 0)
  ->first();

  if($pedido == null) return response()->json("Nao existe", 401);

  $atributes = $this->addAtributes($pedido->itens);
  return response()->json($atributes, 200);
}

public function setarBairro(Request $request){
  $pedido = Pedido::find($request->pedido_id);
  if(valida_objeto($resp)){
    $pedido->bairro_id = $request->bairro_id;
    $res = $pedido->save();
    return response()->json($res, 200);
  }else{
    return redirect('/403');
  }
}

public function setarEndereco(Request $request){
  $pedido = Pedido::find($request->pedido_id);
  if(valida_objeto($resp)){
    $pedido->nome = $request->nome;
    $pedido->rua = $request->rua;
    $pedido->numero = $request->numero;
    $pedido->telefone = $request->telefone;
    $pedido->referencia = $request->referencia;
    $res = $pedido->save();


    session()->flash('mensagem_sucesso', 'Endereço setado!');
    return redirect('/pedidos/ver/'.$request->pedido_id);
  }else{
    return redirect('/403');
  }
}

public function imprimirItens(Request $request){
  $ids = $request->ids;
  $ids = explode(",", $ids);
  $itens = [];
  


  foreach($ids as $i){
    if($i != null){
      $item = ItemPedido::find($i);
      $item->impresso = true;
      $item->save();
      array_push($itens, $item);
    }
  }
  if(sizeof($itens) > 0){

    $public = getenv('SERVIDOR_WEB') ? 'public/' : '';
    $pathLogo = $public.'imgs/logo.jpg';
    $cupom = new Itens($itens, $pathLogo);

    $pdf = $cupom->render();
    return response($pdf)
    ->header('Content-Type', 'application/pdf');
  }else{
    echo "Selecione ao menos um item!";
  }

  // header('Content-Type: application/pdf');
  // echo $pdf;

  

}

public function controleComandas(){
  $comandas = Pedido::
  limit(30)
  ->where('empresa_id', $this->empresa_id)
  ->orderBy('id', 'desc')
  ->get();
  return view('pedido/controle_comandas')
  ->with('comandas', $comandas)
  ->with('mensagem', '*Listando os 30 ultimos registros')
  ->with('title', 'Controle de Comandas');
}

public function verDetalhes($id){
  $pedido = Pedido::find($id);
  $removidos = PedidoDelete::where('pedido_id', $id)->where('empresa_id', $this->empresa_id)->get();

  return view('pedido/detalhes')
  ->with('pedido', $pedido)
  ->with('removidos', $removidos)
  ->with('title', 'Detalhes comanda ' . $pedido->comanda);
}

public function filtroComanda(Request $request){
  if($request->data_inicial == null || $request->data_final == null){
    return redirect()->back();
  }

  $data_inicial = $this->parseDate($request->data_inicial);
  $data_final = $this->parseDate($request->data_final, true);
  $numero_comanda = $request->numero_comanda;

  if($numero_comanda != null){
    $comandas = Pedido::
    whereBetween('created_at', [$data_inicial, 
      $data_final])
    ->where('empresa_id', $this->empresa_id)
    ->where('comanda', $numero_comanda)
    ->get();
  }else{
    $comandas = Pedido::
    whereBetween('created_at', [$data_inicial, 
      $data_final])
    ->where('empresa_id', $this->empresa_id)
    ->get();
  }

  return view('pedido/controle_comandas')
  ->with('comandas', $comandas)
  ->with('mensagem', '*Listando os resultados do filtro')
  ->with('title', 'Controle de Comandas');
}

private function parseDate($date, $plusDay = false){
  if($plusDay == false)
    return date('Y-m-d', strtotime(str_replace("/", "-", $date)));
  else
    return date('Y-m-d', strtotime("+1 day",strtotime(str_replace("/", "-", $date))));
}

public function mesas(){
  $pedidos = Pedido::
  where('desativado', false)
  ->where('mesa_id', '!=', null)
  ->where('empresa_id', $this->empresa_id)
  ->groupBy('mesa_id')
  ->get();
  return view('pedido/mesas')
  ->with('pedidos', $pedidos)
  ->with('title', 'Mesas em aberto');
}

public function verMesa($mesa_id){
  $mesa = Mesa::find($mesa_id);
  $pedidos = Pedido::
  where('mesa_id', $mesa_id)
  ->where('desativado', false)
  ->where('empresa_id', $this->empresa_id)
  ->where('status', false)
  ->get();
  return view('pedido/verMesa')
  ->with('mesa', $mesa)
  ->with('pedidos', $pedidos)
  ->with('title', 'Comandas da Mesa');
}

public function ativarMesa($id){
  $pedido = Pedido::find($id);
  if(valida_objeto($resp)){
    $pedido->mesa_ativa = true;
    $pedido->Save();

    session()->flash('mensagem_sucesso', 'Mesa ativada com sucesso!');

    return redirect('/pedidos');
  }else{
    return redirecT('/403');
  }
}

public function atribuirComanda(Request $request){

  $pedido = Pedido::find($request->pedido_id);
  if(valida_objeto($resp)){
    $pedido->observacao = $request->observacao ?? '';
    if(!$request->comanda){
      session()->flash('mensagem_erro', 'Informe a comanda!');
      return redirect()->back();
    }
    $pedido->comanda = $request->comanda;

    $pedido->save();

    session()->flash('mensagem_sucesso', 'Comanda atribuida a ' . $pedido->mesa->nome . '!');

    return redirect('/pedidos');
  }else{
    return redirect('/403');
  }

}

public function atribuirMesa(Request $request){
  $pedido = Pedido::find($request->pedido_id);
  $pedido->mesa_id = $request->mesa;

  $pedido->save();
  session()->flash('mensagem_sucesso', 'Mesa atribuida a comanda ' . $pedido->comanda . '!');
  return redirect('/pedidos');
}

}
