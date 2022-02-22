<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servico;
use App\CategoriaServico;
use App\TypeService;
class ServiceController extends Controller
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
        $servicos = Servico::
        where('empresa_id', $this->empresa_id)
        ->get();
        return view('servicos/list')
        ->with('servicos', $servicos)
        ->with('title', 'Serviços');
    }

    public function pesquisa(Request $request){
        $pesquisa = $request->input('pesquisa');
        $servicos = Servico::where('nome', 'LIKE', "%$pesquisa%")
        ->where('empresa_id', $this->empresa_id)
        ->get();
        return view('servicos/list')
        ->with('servicos', $servicos)
        ->with('title', 'Serviços');
    }

    public function new(){
        $categorias = CategoriaServico::
        where('empresa_id', $this->empresa_id)
        ->get();
        if(sizeof($categorias) == 0){
            session()->flash('color', 'red');
            session()->flash('mensagem_erro', 'Cadastre uma categoria primeiramente!');
            return redirect('/categoriasServico');
        }
        return view('servicos/register')
        ->with('categorias', $categorias)
        ->with('title', 'Cadastrar Servico');
    }

    public function save(Request $request){
        $servico = new Servico();
        $this->_validate($request);

        $request->merge([ 'valor' => __replace($request->valor)]);
        $request->merge([ 'comissao' => $request->comissao ? __replace($request->comissao) : 0]);

        $result = $servico->create($request->all());

        if($result){
            session()->flash("mensagem_sucesso", "Serviço cadastrado com sucesso!");
        }else{
            session()->flash('mensagem_erro', 'Erro ao cadastrar serviço!');
        }
        
        return redirect('/servicos');
    }

    public function edit($id){
        $servico = new Servico(); //Model
        $categorias = CategoriaServico::
        where('empresa_id', $this->empresa_id)
        ->get();
        $resp = $servico
        ->where('id', $id)->first();  
        if(valida_objeto($resp)){
            return view('servicos/register')
            ->with('servico', $resp)
            ->with('categorias', $categorias)
            ->with('title', 'Editar Serviço');
        }else{
            return redirect('/403');
        }

    }

    public function update(Request $request){
        $servico = new Servico();

        $id = $request->input('id');
        $resp = $servico
        ->where('id', $id)->first(); 

        $this->_validate($request);
        $valor = __replace($request->input('valor'));
        $comissao = __replace($request->input('comissao'));

        $resp->nome = $request->input('nome');
        $resp->unidade_cobranca = $request->input('unidade_cobranca');
        $resp->categoria_id = $request->input('categoria_id');
        $resp->valor = $valor;
        $resp->comissao = $comissao;
        $resp->tempo_servico = $request->tempo_servico;

        $result = $resp->save();
        if($result){
            session()->flash('mensagem_sucesso', 'Serviço atualizado com sucesso!');
        }else{
            session()->flash('mensagem_erro', 'Erro ao atualizar serviço!');
        }
        
        return redirect('/servicos'); 
    }

    public function delete($id){
        try{
            $resp = Servico
            ::where('id', $id)
            ->first();
            if(valida_objeto($resp)){
                if($rest->delete()){
                    session()->flash('mensagem_sucesso', 'Serviço removido!');
                }else{
                    session()->flash('mensagem_erro', 'Erro!');
                }
                return redirect('/servicos');
            }else{
                return redirect('/403');
            }
        }catch(\Exception $e){
            return view('errors.sql')
            ->with('title', 'Erro ao deletar serviços')
            ->with('motivo', 'Não é possivel remover serviços, incluidos em OS!');
        }
    }

    private function _validate(Request $request){
        $rules = [
            'valor' => 'required',
            'nome' => 'required|max:60'
        ];

        $messages = [
            'valor.required' => 'O campo valor é obrigatório.',
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => '60 caracteres maximos permitidos.'
        ];
        $this->validate($request, $rules, $messages);
    }

    public function all(){
        $services = Servico::
        where('empresa_id', $this->empresa_id)
        ->get();
        $arr = array();
        foreach($services as $s){
            $arr[$s->id. ' - ' .$s->nome] = null;
                //array_push($arr, $temp);
        }
        echo json_encode($arr);
    }

    public function getValue(Request $request){
        $id = $request->input('id');
        $service = Servico::
        where('id', $id)
        ->first();
        echo json_encode($service->value);
    }
}
