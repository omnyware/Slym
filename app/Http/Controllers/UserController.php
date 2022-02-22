<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\ConfigNota;
use App\Empresa;
use App\CategoriaConta;
use App\Plano;
use App\PlanoEmpresa;
use App\Helpers\Menu;

class UserController extends Controller
{

  public function newAccess(){
    return view('login/access_2');
  }

  public function request(Request $request){
    $login = $request->input('login');
    $senha = $request->input('senha');

    $user = new Usuario();

    $usr = $user
    ->where('login', $login)
    ->where('senha', md5($senha))
    ->first();

    if($usr != null){

      if($usr->ativo == 0){
        session()->flash('mensagem_login', 'Usuário desativado');
        return redirect('/login');
      }

      if($login != getenv("USERMASTER")){
        if($usr->empresa->status == 0){
          session()->flash('mensagem_login', 'Empresa desativada');
          return redirect('/login');
        }

        $empresa = $usr->empresa;

        if(!$empresa->planoEmpresa){
          session()->flash('mensagem_login', 'Empresa sem plano atribuido!!');
          return redirect('/login');
        }

        $hoje = date('Y-m-d');
        $exp = $empresa->planoEmpresa ? $empresa->planoEmpresa->expiracao : null;

        if(strtotime($hoje) > strtotime($exp)){
          session()->flash('mensagem_login', 'Plano expirado!!');
          return redirect('/login');
        }
      }

      $config = ConfigNota::
      where('empresa_id', $usr->empresa_id)
      ->first();
      $ambiente = 'Não configurado';
      if($config != null){
        $ambiente = $config->ambiente == 1 ? 'Produção' : 'Homologação'; 
      }

      $session = [
        'id' => $usr->id,
        'nome' => $usr->nome,
        'adm' => $usr->adm,
        'ambiente' => $ambiente,
        'empresa' => $usr->empresa_id,
        'delivery' => getenv("DELIVERY") == 1 || getenv("DELIVERY_MERCADO") == 1 ? true : false,
        'acesso_cliente' => $usr->acesso_cliente,
        'acesso_fornecedor' => $usr->acesso_fornecedor,
        'acesso_produto' => $usr->acesso_produto,
        'acesso_financeiro' => $usr->acesso_financeiro,
        'acesso_caixa' => $usr->acesso_caixa,
        'acesso_estoque' => $usr->acesso_estoque,
        'acesso_compra' => $usr->acesso_compra,
        'acesso_fiscal' => $usr->acesso_fiscal,
        'acesso_cte' => $usr->acesso_cte,
        'acesso_mdfe' => $usr->acesso_mdfe,
        'super' => $login == getenv("USERMASTER"),
        'empresa_nome' => $usr->empresa->nome
      ];
      session(['user_logged' => $session]);
      return redirect('/' . getenv('ROTA_INICIAL'));
    }else{
      // __set($request);

      session()->flash('mensagem_login', 'Credencial(s) incorreta(s)!');
      return redirect('/login');
    }
  }

  public function logoff(){
    session()->forget('user_logged');

    session()->flash('mensagem_login', 'Logoff realizado.');
    return redirect("/login");
  }

  public function cadastro(){
    return view('login/cadastro');
  }

  private function permissoesTodas(){
    $menu = new Menu();
    $menu = $menu->getMenu();
    $temp = [];
    foreach($menu as $m){
      foreach($m['subs'] as $s){
        array_push($temp, $s['rota']);
      }
    }

    return $temp;

  }

  public function salvarEmpresa(Request $request){

    $usr = Usuario::where('login', $request->usuario)->first();
    // if($usr != null){
    //   session()->flash("mensagem_erro", "Já existe um cadastro com este usuário, informe outro por gentileza!");
    //   return redirect()->back();
    // }
    $this->_validate($request);

    $planoAutomaticoNome = getenv("PLANO_AUTOMATICO_NOME");

    $plano = Plano::where('nome', $planoAutomaticoNome)->first();

    $permissoesTodas = $this->permissoesTodas();
    $data = [
      'nome' => $request->nome_empresa,
      'rua' => '',
      'numero' => '',
      'bairro' => '',
      'cidade' => $request->cidade,
      'telefone' => $request->telefone,
      'email' => $request->email,
      'cnpj' => $request->cnpj,
      'status' => 1,
      'permissao' => json_encode($permissoesTodas)
    ];

    $empresa = Empresa::create($data);

    $data = [
      'nome' => $request->login, 
      'senha' => md5($request->senha),
      'login' => $request->login,
      'adm' => 1,
      'img' => '',
      'empresa_id' => $empresa->id,
      'permissao' => json_encode($permissoesTodas)
    ];

    $usuario = Usuario::create($data);

    CategoriaConta::create([
      'nome' => 'Compras',
      'empresa_id' => $empresa->id
    ]);
    CategoriaConta::create([
      'nome' => 'Vendas',
      'empresa_id' => $empresa->id
    ]);

    if($plano != null){
      session()->flash("mensagem_sucesso", "Bem vindo ao nosso sistema, obrigado por se cadastrar :)");
      $this->setarPlano($empresa, $plano);
      $this->criaSessao($usuario);
      return redirect('/' . getenv('ROTA_INICIAL'));

    }else{
      session()->flash("mensagem_sucesso", "Obrigado por se cadastrar, aguarde a ativação do cadastro!");
      return redirect('/login');
    }

  }

  private function setarPlano($empresa, $plano){
    $dias = getenv("PLANO_AUTOMATICO_DIAS");
    $exp = date('Y-m-d', strtotime("+$dias days",strtotime( 
      date('Y-m-d'))));
    $data = [
      'empresa_id' => $empresa->id,
      'plano_id' => $plano->id,
      'expiracao' => $exp
    ];

    PlanoEmpresa::create($data);
  }

  private function criaSessao($usr){
    $ambiente = 'Não configurado';

    $session = [
      'id' => $usr->id,
      'nome' => $usr->nome,
      'adm' => $usr->adm,
      'ambiente' => $ambiente,
      'empresa' => $usr->empresa_id,
      'empresa_nome' => $usr->empresa->nome,
      'super' => 0
    ];
    session(['user_logged' => $session]);
  }

  private function _validate(Request $request){

    $rules = [
      'nome_empresa' => 'required|min:3',
      'telefone' => 'required|min:12',
      'cidade' => 'required|min:3',
      'login' => 'required|min:5|unique:usuarios',
      'senha' => 'required|min:5',
      'email' => 'required|email',
    ];

    $messages = [
      'nome_empresa.required' => 'Campo obrigatório.',
      'cidade.required' => 'Campo obrigatório.',
      'telefone.required' => 'Campo obrigatório.',
      'login.required' => 'Campo obrigatório.',
      'senha.required' => 'Campo obrigatório.',
      'email.required' => 'Campo obrigatório.',
      'nome_empresa.min' => 'Minimo de 3 caracteres.',
      'telefone.min' => 'Informe telefone corretamente.',
      'cidade.min' => 'Minimo de 3 caracteres.',
      'login.min' => 'Minimo de 5 caracteres.',
      'senha.min' => 'Minimo de 5 caracteres.',
      'email.email' => 'Informe um email válido.',
      'login.unique' => 'Usuário já cadastrado em nosso sistema.'

    ];
    $this->validate($request, $rules, $messages);
  }



}
