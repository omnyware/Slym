<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Veiculo;
class VeiculoController extends Controller
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
        $veiculos = Veiculo::
        where('empresa_id', $this->empresa_id)
        ->get();
        return view('veiculos/list')
        ->with('veiculos', $veiculos)
        ->with('title', 'Veiculos');
    }

    public function new(){
        $tipos = Veiculo::tipos();
        $tiposRodado = Veiculo::tiposRodado();
        $tiposCarroceria = Veiculo::tiposCarroceria();
        $tiposProprietario = Veiculo::tiposProprietario();
        $ufs = Veiculo::cUF();

        return view('veiculos/register')
        ->with('tipos', $tipos)
        ->with('tiposRodado', $tiposRodado)
        ->with('tiposCarroceria', $tiposCarroceria)
        ->with('tiposProprietario', $tiposProprietario)
        ->with('ufs', $ufs)
        ->with('veiculoJs', true)
        ->with('title', 'Cadastrar Veiculo');
    }

    public function save(Request $request){
        $veiculo = new Veiculo();
        $this->_validate($request);

        $result = $veiculo->create($request->all());

        if($result){
            session()->flash("mensagem_sucesso", "Veiculo cadastrado com sucesso.");
        }else{
            session()->flash('mensagem_erro', 'Erro ao cadastrar veiculo.');
        }

        return redirect('/veiculos');
    }

    public function edit($id){
      $tipos = Veiculo::tipos();
        $veiculo = new Veiculo(); //Model

        $tiposRodado = Veiculo::tiposRodado();
        $tiposCarroceria = Veiculo::tiposCarroceria();
        $tiposProprietario = Veiculo::tiposProprietario();
        $ufs = Veiculo::cUF();

        $resp = $veiculo
        ->where('id', $id)
        ->first();  
        if(valida_objeto($resp)){

            return view('veiculos/register')
            ->with('veiculo', $resp)
            ->with('tipos', $tipos)
            ->with('tiposRodado', $tiposRodado)
            ->with('tiposCarroceria', $tiposCarroceria)
            ->with('tiposProprietario', $tiposProprietario)
            ->with('ufs', $ufs)
            ->with('veiculoJs', true)
            ->with('title', 'Editar Veiculo');
        }else{
            return redirect('/403');
        }

    }

    public function update(Request $request){
    	$veiculo = new Veiculo();

    	$id = $request->input('id');
    	$resp = $veiculo
    	->where('id', $id)
    	->first(); 

    	$this->_validate($request);
    	
    	$resp->cor = $request->input('cor');
    	$resp->marca = $request->input('marca');
    	$resp->modelo = $request->input('modelo');
    	$resp->placa = $request->input('placa');
        $resp->tipo = $request->input('tipo');
        $resp->uf = $request->input('uf');
        $resp->rntrc = $request->input('rntrc');
        $resp->tipo = $request->input('tipo');
        $resp->tipo_carroceira = $request->input('tipo_carroceira');
        $resp->tipo_rodado = $request->input('tipo_rodado');
        $resp->tara = $request->input('tara');
        $resp->capacidade = $request->input('capacidade');
        $resp->proprietario_nome = $request->input('proprietario_nome');
        $resp->proprietario_ie = $request->input('proprietario_ie');
        $resp->proprietario_uf = $request->input('proprietario_uf');
        $resp->proprietario_tp = $request->input('proprietario_tp');
        $resp->proprietario_documento = $request->input('proprietario_documento');

        $result = $resp->save();
        if($result){
            session()->flash('mensagem_sucesso', 'Veiculo editado com sucesso!');
        }else{
            session()->flash('mensagem_erro', 'Erro ao editar veiculo!');
        }

        return redirect('/veiculos'); 
    }

    public function delete($id){
        try{
            $resp = Veiculo::
            where('id', $id)
            ->first();
            if(valida_objeto($resp)){
                if($resp->delete()){
                    session()->flash('mensagem_sucesso', 'Registro removido!');
                }else{
                    session()->flash('mensagem_erro', 'Erro!');
                }
                return redirect('/veiculos');
            }else{
                return redirect('/403');
            }
        }catch(\Exception $e){
            return view('errors.sql')
            ->with('title', 'Erro ao deletar veiculo')
            ->with('motivo', 'Não é possivel remover veiculos presentes em transportes!');
        }
    }


    private function _validate(Request $request){
        $rules = [
            'placa' => 'required|max:8',
            'cor' => 'required|max:10',
            'marca' => 'required|max:20',
            'modelo' => 'required|max:20',
            'tara' => 'required|max:10',
            'rntrc' => 'required|min:8',
            'capacidade' => 'required|max:10',
            'proprietario_nome' => 'required|max:40',
            'proprietario_ie' => 'required|max:13',
            'proprietario_documento' => 'required|max:20',
        ];

        $messages = [
            'placa.required' => 'O campo placa é obrigatório.',
            'nome.max' => '8 caracteres maximos permitidos.',
            'cor.required' => 'O campo cor é obrigatório.',
            'cor.max' => '10 caracteres maximos permitidos.',
            'marca.required' => 'O campo marca é obrigatório.',
            'marca.max' => '20 caracteres maximos permitidos.',
            'modelo.required' => 'O campo modelo é obrigatório.',
            'modelo.max' => '20 caracteres maximos permitidos.',

            'tara.required' => 'O campo tara é obrigatório.',
            'tara.max' => '10 caracteres maximos permitidos.',

            'rntrc.required' => 'O campo RNTRC é obrigatório.',
            'rntrc.min' => '8 caracteres minimos permitidos.',

            'proprietario_nome.required' => 'O campo Nome proprietário é obrigatório.',
            'proprietario_nome.max' => '40 caracteres maximos permitidos.',
            'proprietario_ie.required' => 'O campo I.E proprietário é obrigatório.',
            'proprietario_ie.max' => '13 caracteres maximos permitidos.',
            'proprietario_documento.required' => 'O campo CPF/CNPJ proprietário é obrigatório.',
            'proprietario_documento.max' => '20 caracteres maximos permitidos.'
        ];
        $this->validate($request, $rules, $messages);
    }
}
