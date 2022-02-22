<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\App;

class AppController extends Controller
{
    public function daily(Request $request){ //POST
    	$clientId = $request->cliente_id;
    	$date = date("Y-m-d 00:00:00");
    	$dateLast = date('Y-m-d 00:00:00', strtotime('+1 day'));
    	$app = new App();

    	$values = App
    	::where('client_id', 1)
    	->whereBetween('date_register', [$date, $dateLast])
    	->sum('value');

    	echo json_encode($values);
    }

    public function filter(Request $request){ //POST
    	$clientId = $request->cliente_id;
    	$dataInicial = $this->convertData($request->dataInicial) . " 00:00:00";
    	$dataFinal = $this->convertData($request->dataFinal) . " 00:00:00";
    	$dataFinal = date($dataFinal, strtotime('+1 day'));

    	$app = new App();

    	$values = App
    	::select('date_register', 'value')
    	->where('client_id', 1)
    	->whereBetween('date_register', [$dataInicial, $dataFinal])
    	->get();

    	echo json_encode($values);
    }

    private function convertData($data){
		return date('Y-m-d', strtotime(str_replace("/", "-", $data)));
    }

    public function insertCredit(Request $request){ //POST
    	 $clientId = $request->cliente_id;
    	 $value = $request->value;
    	 $app = new App();

    	$result = $app->create([
            'client_id' => $clientId,
            'value' => $value
        ]);
    	if($result)
        echo json_encode(true);

    }

    public function dailySite(){
    	$date = date("Y-m-d 00:00:00");
    	$dateLast = date('Y-m-d 00:00:00', strtotime('+1 day'));
    	$values = App
    	::where('client_id', 1)
    	->whereBetween('date_register', [$date, $dateLast])
    	->sum('value');

        return view('juckbox/list')
        ->with('values', $values)
        ->with('title', 'JuckBox');
    }
}
