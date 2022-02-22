<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Usuario;
use App\CategoriaConta;
use App\Plano;
use App\PlanoEmpresa;
use App\Helpers\Menu;

class EmpresaController extends Controller
{
	public function __construct(){
		$this->middleware(function ($request, $next) {
			$value = session('user_logged');
			if(!$value){
				return redirect("/login");
			}

			if(!$value['super']){
				return redirect('/graficos');
			}
			return $next($request);
		});
	}

	public function index(){
		$empresas = Empresa::all();
		return view('empresas/list')
		->with('empresas', $empresas)
		->with('title', 'SUPER');
	}

	public function filtro(Request $request){
		$empresas = Empresa::
		where('nome', 'LIKE', "%$request->nome%")->get();

		return view('empresas/list')
		->with('empresas', $empresas)
		->with('title', 'SUPER');
	}

	public function nova(){
		return view('empresas/register')
		->with('empresaJs', true)
		->with('title', 'SUPER');
	}

	private function validaPermissao($request){
		$menu = new Menu();
		$arr = $request->all();
		$arr = (array) ($arr);
		$menu = $menu->getMenu();
		$temp = [];
		foreach($menu as $m){
			foreach($m['subs'] as $s){
				$nome = str_replace(" ", "_", $s['nome']);
				if(isset($arr[$nome])){
					array_push($temp, $s['rota']);
				}
			}
		}

		return $temp;
	}

	public function save(Request $request){
		$permissao = $this->validaPermissao($request);

		$this->_validate($request);

		$data = [
			'nome' => $request->nome,
			'rua' => $request->rua,
			'numero' => $request->numero,
			'bairro' => $request->bairro,
			'cidade' => $request->cidade,
			'telefone' => $request->telefone,
			'email' => $request->email,
			'cnpj' => $request->cnpj,
			'status' => 1,
			'permissao' => json_encode($permissao)
		];

		$empresa = Empresa::create($data);
		if($empresa){
			$data = [
				'nome' => $request->nome_usuario, 
				'senha' => md5($request->senha),
				'login' => $request->login,
				'adm' => 1,
				'ativo' => 1,
				'permissao' => json_encode($permissao),
				'img' => '',
				'empresa_id' => $empresa->id
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

			session()->flash("mensagem_sucesso", "Empresa cadastrada!");
			return redirect('empresas');
		}

	}

	private function _validate(Request $request){
		$rules = [
			'nome' => 'required',
			'cnpj' => 'required',
			'rua' => 'required',
			'numero' => 'required',
			'bairro' => 'required',
			'cidade' => 'required',
			'login' => 'required|unique:usuarios',
			'senha' => 'required',
			'telefone' => 'required',
			'email' => 'required',
			'nome_usuario' => 'required',
		];

		$messages = [
			'nome.required' => 'Campo obrigatório.',
			'cnpj.required' => 'Campo obrigatório.',
			'rua.required' => 'Campo obrigatório.',
			'numero.required' => 'Campo obrigatório.',
			'bairro.required' => 'Campo obrigatório.',
			'cidade.required' => 'Campo obrigatório.',
			'login.required' => 'Campo obrigatório.',
			'telefone.required' => 'Campo obrigatório.',
			'email.required' => 'Campo obrigatório.',
			'senha.required' => 'Campo obrigatório.',
			'nome_usuario.required' => 'Campo obrigatório.',
			'login.unique' => 'Usuário já cadastrado no sistema.'
		];

		$this->validate($request, $rules, $messages);
	}

	public function delete($id){
		Empresa::find($id)->delete();
		session()->flash("mensagem_sucesso", "Empresa removida!");
		return redirect('empresas');
	}

	public function detalhes($id){
		$empresa = Empresa::find($id);
		$hoje = date('Y-m-d');
		$planoExpirado = false;

		$permissoesAtivas = $empresa->permissao;
		$permissoesAtivas = json_decode($permissoesAtivas);
		
		if($empresa->planoEmpresa){
			$exp = $empresa->planoEmpresa->expiracao;
			if(strtotime($hoje) > strtotime($exp)){
				$planoExpirado = true;
			}
		}

		$value = session('user_logged');

		if($value['super']){
			$permissoesAtivas = $this->detalhesMaster();
		}

		return view('empresas.detalhes')
		->with('empresa', $empresa)
		->with('planoExpirado', $planoExpirado)
		->with('permissoesAtivas', $permissoesAtivas)
		->with('empresaJs', true)
		->with('title', 'Detalhes');
	}

	private function detalhesMaster(){
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

	public function alterarSenha($id){
		$empresa = Empresa::find($id);
		return view('empresas.alterar_senha')
		->with('empresa', $empresa)
		->with('title', 'Alteração de senha');
	}

	public function alterarSenhaPost(Request $request){
		$empresa = Empresa::find($request->id);
		$senha = $request->senha;

		foreach($empresa->usuarios as $u){
			$u->senha = md5($senha);
			$u->save();
		}

		session()->flash("mensagem_sucesso", "Senhas alteradas!");
		return redirect('/empresas/detalhes/' . $empresa->id);
	}

	public function update(Request $request){
		$empresa = Empresa::find($request->id);

		$permissao = $this->validaPermissao($request);

		$empresa->nome = $request->nome;
		$empresa->rua = $request->rua;
		$empresa->numero = $request->numero;
		$empresa->bairro = $request->bairro;
		$empresa->cidade = $request->cidade;
		$empresa->telefone = $request->telefone;
		$empresa->email = $request->email;
		$empresa->cnpj = $request->cnpj;
		$empresa->status = $request->status ? 1 : 0;
		$empresa->permissao = json_encode($permissao);
		$empresa->save();

		session()->flash("mensagem_sucesso", "Dados atualziados!");
		return redirect()->back();
	}

	public function setarPlano($id){
		$empresa = Empresa::find($id);
		$planos = Plano::all();

		if(sizeof($planos) == 0){
			session()->flash("mensagem_erro", "Cadastre um plano primeiramente");
			return redirect('/planos');

		}

		$exp = date('d/m/Y', strtotime("+30 days",strtotime(str_replace("/", "-", 
			date('Y-m-d')))));

		return view('empresas.setar_plano')
		->with('empresa', $empresa)
		->with('planos', $planos)
		->with('exp', $exp)
		->with('title', 'Setar Plano');
	}

	public function setarPlanoPost(Request $request){
		$empresa = Empresa::find($request->id);
		$plano = $empresa->planoEmpresa;
		if($plano != null){
			$plano->delete();
		}
		$plano = $request->plano;
		$expiracao = $this->parseDate($request->expiracao);

		$data = [
			'empresa_id' => $empresa->id,
			'plano_id' => $plano,
			'expiracao' => $expiracao
		];

		PlanoEmpresa::create($data);
		session()->flash("mensagem_sucesso", "Plano atribuido!");

		return redirect('/empresas/detalhes/'. $empresa->id);
	}

	private function parseDate($date){
		return date('Y-m-d', strtotime(str_replace("/", "-", $date)));
	}


}
