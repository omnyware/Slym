<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TypeService;
class TypeServiceController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $value = session('user_logged');
            if(!$value && $_SERVER['REQUEST_URI'] != "/tipoServico/byModel"){
                return redirect("/login");
            }
            return $next($request);
        });
    }

    public function index(){
        $types = TypeService::all();
        return view('typeServices/list')
        ->with('types', $types)
        ->with('title', 'Tipos de Serviço');
    }

    public function new(){
        return view('typeServices/register')
        ->with('title', 'Cadastrar Tipo de Serviço');
    }

    public function save(Request $request){
        $type = new TypeService();
        $this->_validate($request);

        $result = $type->create($request->all());

        if($result){
            session()->flash('color', 'blue');
            session()->flash("message", "Tipo de Serviço cadastrado com sucesso.");
        }else{
            session()->flash('color', 'red');
            session()->flash('message', 'Erro ao cadastrar tipo de serviço.');
        }
        
        return redirect('/tipoServico');
    }

    public function edit($id){
        $type = new TypeService(); //Model

        $resp = $type
        ->where('id', $id)->first();  

        return view('typeServices/register')
        ->with('type', $resp)
        ->with('title', 'Editar Tipo de Serviço');

    }

    public function update(Request $request){
        $type = new TypeService();

        $id = $request->input('id');
        $resp = $type
        ->where('id', $id)->first(); 

        $this->_validate($request);
        

        $resp->name = $request->input('name');

        $result = $resp->save();
        if($result){
            session()->flash('color', 'green');
            session()->flash('message', 'Categoria editada com sucesso!');
        }else{
            session()->flash('color', 'red');
            session()->flash('message', 'Erro ao editar categoria!');
        }
        
        return redirect('/tipoServico'); 
    }

    public function delete($id){
        $delete = TypeService
        ::where('id', $id)
        ->delete();
        if($delete){
            session()->flash('color', 'blue');
            session()->flash('message', 'Registro removido!');
        }else{
            session()->flash('color', 'red');
            session()->flash('message', 'Erro!');
        }
        return redirect('/tipoServico');
    }


    private function _validate(Request $request){
        $rules = [
            'name' => 'required|max:100'
        ];

        $messages = [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => '100 caracteres maximos permitidos.'
        ];
        $this->validate($request, $rules, $messages);
    }

    public function byModel(Request $request){
        $id = $request->id;
        $types = TypeService
        ::join('services', 'services.type_id', '=', 'type_services.id')
        ->where('services.model_id', $id)
        ->get();
        echo json_encode($types);
    }
}
