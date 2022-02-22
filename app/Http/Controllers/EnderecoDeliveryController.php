<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClienteDelivery;
use App\BairroDelivery;
use App\EnderecoDelivery;

class EnderecoDeliveryController extends Controller
{

    public function save(Request $request){
    	$data = $request['data'];

        $bairroNome = '';
        $bairroId = 0;

        $bairro = explode(":", $data['bairro']);
        if(isset($bairro[0]) && $bairro[0] == 'id'){
            $bairroId = $bairro[1];
        }else{
            $bairroNome = $data['bairro'];
        }

        $result = EnderecoDelivery::create([
          'cliente_id' => $data['cliente_id'],
          'rua' => $data['rua'],
          'numero' => $data['numero'],

          'bairro' => $bairroNome,
          'bairro_id' => $bairroId,

          'referencia' => $data['referencia'],
          'latitude' => $data['latitude'] ? substr($data['latitude'], 0, 10) : '',
          'longitude' => $data['longitude'] ? substr($data['longitude'], 0, 10) : ''
      ]);
        if($result) echo json_encode($result);
        else echo json_encode(false);
    }

    public function get(Request $request){
        try{
            $endereco = EnderecoDelivery::find($request->endereco_id);
            return response()->json($endereco, 200);
        }catch(\Exception $e){
            return response()->json(null, 401);
        }
    }

    public function getValorBairro(Request $request){
        $endereco = EnderecoDelivery::find($request->endereco_id);
        if($endereco->bairro_id > 0){
            $bairro = BairroDelivery::find($endereco->bairro_id);
            return response()->json($bairro->valor_entrega, 200);
        }
        
        return response()->json(0, 401);
    }
}
