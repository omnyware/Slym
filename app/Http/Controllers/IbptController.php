<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IBPT;
use App\ItemIBTE;

class IbptController extends Controller
{
	public function index(){
		$ibtes = IBPT::all();
		return view('ibpt/list')
		->with('ibtes', $ibtes)
		->with('title', 'IBPT');
	}

	public function new(){
		$todos = IBPT::estados();
		$estados = [];
		foreach($todos as $uf){
			$res = IBPT::where('uf', $uf)->first();
			if($res == null){
				array_push($estados, $uf);
			}
		}

		return view('ibpt/new')
		->with('estados', $estados)
		->with('title', 'IBPT');
	}

	public function refresh($id){
		$ibpt = IBPT::find($id);
		
		return view('ibpt/new')
		->with('ibpt', $ibpt)
		->with('title', 'IBPT');
	}

	public function importar(Request $request){
		if ($request->hasFile('file')){
			$file = $request->file;
			$handle = fopen($file, "r");
			$row = 0;
			$linhas = [];

			if($request->ibpt_id == 0){
				$result = IBPT::create(
					[
						'uf' => $request->uf,
						'versao' => $request->versao,
					]
				);
			}else{
				$result = IBPT::find($request->ibpt_id);
				$result->versao = $request->versao;
				$result->save();
				ItemIBTE::where('ibte_id', $request->ibpt_id)->delete();
			}

			while ($line = fgetcsv($handle, 1000, ";")) {
				if ($row++ == 0) {
					continue;
				}
				
				$data = [
					'ibte_id' => $result->id,
					'codigo' => $line[0],
					'descricao' => $line[3],
					'nacional_federal' => $line[4],
					'importado_federal' => $line[5],
					'estadual' => $line[6],
					'municipal' => $line[7] 
				];
				ItemIBTE::create($data);

			}
			if($request->ibpt_id > 0){
				session()->flash('mensagem_sucesso', 'Importação atualizada para '.$request->uf);
			}else{
				session()->flash('mensagem_sucesso', 'Importação concluída para '.$request->uf);
			}
			return redirect("/ibpt");


		}else{
			if($request->ibpt_id > 0){
				$result = IBPT::find($request->ibpt_id);
				$result->versao = $request->versao;
				session()->flash('mensagem_sucesso', 'Versão atualizada!');
				$result->save();
			}else{
				session()->flash('mensagem_erro', 'Arquivo inválido!');
			}
			return redirect("/ibpt");
		}
	}

	public function ver($id){
		$ibpt = IBPT::find($id);
		$itens = ItemIBTE::where('ibte_id', $id)->paginate(100);
		return view('ibpt/ver')
		->with('ibpt', $ibpt)
		->with('itens', $itens)
		->with('links', true)
		->with('title', 'IBPT');
	}

}
