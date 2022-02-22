<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fornecedor;
use App\Cidade;
use App\Cliente;

class ProviderController extends Controller
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
        $fornecedores = Fornecedor::where('empresa_id', $this->empresa_id)
        ->get();
        return view('fornecedores/list')
        ->with('fornecedores', $fornecedores)
        ->with('title', 'Fornecedores');
    }

    public function new(){
        $cidades = Cidade::all();
        $estados = Cliente::estados();

        return view('fornecedores/register')
        ->with('pessoaFisicaOuJuridica', true)
        ->with('cidadeJs', true)
        ->with('cidades', $cidades)
        ->with('estados', $estados)
        ->with('title', 'Cadastrar Fornecedor');
    }

    public function save(Request $request){
        $provider = new Fornecedor();
        $this->_validate($request);

        $cidade = $request->input('cidade');
        $cidade = explode("-", $cidade);
        $cidade = $cidade[0];
        $request->merge([ 'cidade_id' => $cidade]);
        $request->merge([ 'telefone' => $request->input('telefone') ?? '']);
        $request->merge([ 'celular' => $request->input('celular') ?? '']);
        $request->merge([ 'ie_rg' => $request->input('ibase_errmsg()') ?? '']);
        $request->merge([ 'email' => $request->email ?? '']);

        $result = $provider->create($request->all());

        if($result){
            session()->flash("mensagem_sucesso", "Fornecedor cadastrado com sucesso!");
        }else{

            session()->flash('mensagem_erro', 'Erro ao cadastrar fornecedor!');
        }
        
        return redirect('/fornecedores');
    }

    public function edit($id){
        $provider = new Fornecedor(); //Model
        
        $resp = $provider
        ->where('id', $id)->first();  

        $cidades = Cidade::all();
        $estados = Cliente::estados();

        if(valida_objeto($resp)){

            return view('fornecedores/register')
            ->with('cidadeJs', true)
            ->with('pessoaFisicaOuJuridica', true)
            ->with('forn', $resp)
            ->with('cidades', $cidades)
            ->with('estados', $estados)
            ->with('title', 'Editar Fornecedor');
        }else{
            return redirect('403');
        }

    }

    public function update(Request $request){
        $provider = new Fornecedor();

        $id = $request->input('id');
        $resp = $provider
        ->where('id', $id)->first(); 

        $this->_validate($request);

        $cidade = $request->input('cidade');
        $cidade = explode("-", $cidade);
        $cidade = $cidade[0];
        

        $resp->razao_social = $request->input('razao_social');
        $resp->nome_fantasia = $request->input('nome_fantasia');
        $resp->cpf_cnpj = $request->input('cpf_cnpj');
        $resp->ie_rg = $request->input('ie_rg') ?? '';

        $resp->rua = $request->input('rua');
        $resp->numero = $request->input('numero');
        $resp->bairro = $request->input('bairro');

        $resp->telefone = $request->input('telefone') ?? '';
        $resp->celular = $request->input('celular') ?? '';
        $resp->email = $request->input('email');
        $resp->cep = $request->input('cep');
        $resp->cidade_id = $cidade;

        $result = $resp->save();
        if($result){
            session()->flash('mensagem_sucesso', 'Fornecedor atualizado com sucesso!');
        }else{
            session()->flash('mensagem_erro', 'Erro ao atualizar fornecedor!');
        }
        
        return redirect('/fornecedores'); 
    }

    public function find($id){
        $fornecedor = Fornecedor::
        where('id', $id)
        ->first();
        
        echo json_encode($this->insertCidade($fornecedor));
    }

    private function insertCidade($fornecedor){
        $cidade = Cidade::getId($fornecedor->cidade_id);
        $fornecedor['nome_cidade'] = $cidade->nome;
        return $fornecedor;
    }

    public function delete($id){
        try{
            $resp = Fornecedor
            ::where('id', $id)
            ->first();
            if(valida_objeto($resp)){

                if($resp->delete()){
                    session()->flash('mensagem_sucesso', 'Registro removido!');
                }else{
                    session()->flash('mensagem_erro', 'Erro!');
                }
                return redirect('/fornecedores');
            }else{
                return redirect('403');
            }
        }catch(\Exception $e){
            return view('errors.sql')
            ->with('title', 'Erro ao deletar fornecedor')
            ->with('motivo', 'Não é possivel remover fornecedor, presentes em compras!');
        }
    }


    private function _validate(Request $request){
        $rules = [
            'razao_social' => 'required|max:100',
            'nome_fantasia' => 'required|max:80',
            'cpf_cnpj' => 'required',
            'rua' => 'required|max:80',
            'numero' => 'required|max:10',
            'bairro' => 'required|max:50',
            'telefone' => 'max:20',
            'celular' => 'max:20',
            'email' => 'max:40',
            'cep' => 'required',
            'cidade' => 'required',
            'ie_rg' => 'max:20',
        ];

        $messages = [
            'razao_social.required' => 'O campo Razão social é obrigatório.',
            'razao_social.max' => '100 caracteres maximos permitidos.',
            'nome_fantasia.required' => 'O campo Nome Fantasia é obrigatório.',
            'nome_fantasia.max' => '80 caracteres maximos permitidos.',
            'cpf_cnpj.required' => 'O campo CPF/CNPJ é obrigatório.',
            'rua.required' => 'O campo Rua é obrigatório.',
            'ie_rg.max' => '20 caracteres maximos permitidos.',
            'rua.max' => '80 caracteres maximos permitidos.',
            'numero.required' => 'O campo Numero é obrigatório.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'cidade.required' => 'O campo Cidade é obrigatório.',
            'numero.max' => '10 caracteres maximos permitidos.',
            'bairro.required' => 'O campo Bairro é obrigatório.',
            'bairro.max' => '50 caracteres maximos permitidos.',
            'telefone.required' => 'O campo Celular é obrigatório.',
            'telefone.max' => '20 caracteres maximos permitidos.',
            'celular.required' => 'O campo Celular 2 é obrigatório.',
            'celular.max' => '20 caracteres maximos permitidos.',

            'email.required' => 'O campo Email é obrigatório.',
            'email.max' => '40 caracteres maximos permitidos.',
            'email.email' => 'Email inválido.',


        ];
        $this->validate($request, $rules, $messages);
    }

    public function all(){
        $providers = Fornecedor::
        where('empresa_id', $this->empresa_id)
        ->get();
        $arr = array();
        foreach($providers as $c){
            $arr[$c->id. ' - ' .$c->razao_social] = null;
                //array_push($arr, $temp);
        }
        echo json_encode($arr);
    }
}
