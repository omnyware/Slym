<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeliveryConfig;

class ConfigDeliveryController extends Controller
{
	public function __construct(){
		$this->middleware(function ($request, $next) {
			$value = session('user_logged');
			if(!$value){
				return redirect("/login");
			}
			return $next($request);
		});
	}

    function sanitizeString($str){
		return preg_replace('{\W}', ' ', preg_replace('{ +}', ' ', strtr(
			utf8_decode(html_entity_decode($str)),
			utf8_decode('ÀÁÃÂÉÊÍÓÕÔÚÜÇÑàáãâéêíóõôúüçñ'),
			'AAAAEEIOOOUUCNaaaaeeiooouucn')));
	}

	public function index(){
		$config = DeliveryConfig::
		first();
		return view('configDelivery/index')
		->with('config', $config)
		->with('title', 'Configurar Parametros de Delivery');
	}


	public function save(Request $request){
		$this->_validate($request);
		$result = false;
		if($request->id == 0){
			$result = DeliveryConfig::create([
				'link_face' => $request->link_face ?? '',
				'link_twiteer' => $request->link_twiteer ?? '',
				'link_google' => $request->link_google ?? '',
				'link_instagram' => $request->link_instagram ?? '',
				'telefone' => $this->sanitizeString($request->telefone),
				'endereco' => $this->sanitizeString($request->endereco),
				'tempo_medio_entrega' => $this->sanitizeString($request->tempo_medio_entrega),
				'valor_entrega' => str_replace(",", ".", $request->valor_entrega),
				'tempo_maximo_cancelamento' => $request->tempo_maximo_cancelamento,
				'nome_exibicao_web' => $request->nome_exibicao_web,
				'latitude' => $request->latitude,
				'longitude' => $request->longitude,
				'politica_privacidade' => $request->politica_privacidade ?? '',
				'entrega_gratis_ate' => $request->entrega_gratis_ate ?? 0,
				'valor_km' => $request->valor_km ? str_replace(",", ".", $request->valor_km) : 0,
				'usar_bairros' => $request->usar_bairros ? true : false,
				'maximo_km_entrega' => $request->maximo_km_entrega ? true : false,
				'maximo_adicionais' => $request->maximo_adicionais,
				'maximo_adicionais_pizza' => $request->maximo_adicionais_pizza
			]);
		}else{
			$config = DeliveryConfig::
			first();

			$config->link_face = $request->link_face ?? '';
			$config->link_twiteer = $request->link_twiteer ?? '';
			$config->link_google = $request->link_google ?? '';
			$config->link_instagram = $request->link_instagram ?? '';
			$config->telefone = $this->sanitizeString($request->telefone);
			$config->endereco = $this->sanitizeString($request->endereco);
			$config->tempo_medio_entrega = $this->sanitizeString($request->tempo_medio_entrega);
			$config->valor_entrega = str_replace(",", ".", $request->valor_entrega);
			$config->tempo_maximo_cancelamento = $request->tempo_maximo_cancelamento;
			$config->nome_exibicao_web = $request->nome_exibicao_web;
			$config->latitude = $request->latitude;
			$config->longitude = $request->longitude;
			$config->politica_privacidade = $request->politica_privacidade ?? '';
			$config->entrega_gratis_ate = $request->entrega_gratis_ate ?? 0;
			$config->valor_km = $request->valor_km ?? 0;
			$config->maximo_km_entrega = $request->maximo_km_entrega ?? 0;
			$config->usar_bairros = $request->usar_bairros ? true : false;
			$config->maximo_adicionais = $request->maximo_adicionais;
			$config->maximo_adicionais_pizza = $request->maximo_adicionais_pizza;

			$result = $config->save();
		}

		if($request->hasFile('file')){
    		//unlink anterior
    		$file = $request->file('file');
    		$nomeImagem = "logo.png";
    		$upload = $file->move(public_path('images'), $nomeImagem);
    	}

		if($result){
			session()->flash("mensagem_sucesso", "Configurado com sucesso!");
		}else{
			session()->flash('mensagem_erro', 'Erro ao configurar!');
		}

		return redirect('/configDelivery');
	}


	private function _validate(Request $request){
		$rules = [
			'link_face' => 'max:255',
			'link_twiteer' => 'max:255',
			'link_google' => 'max:255',
			'link_instagram' => 'max:255',
			'telefone' => 'required|max:20',
			'endereco' => 'required|max:80',
			'tempo_medio_entrega' => 'required|max:10',
			'tempo_maximo_cancelamento' => 'required',
			'valor_entrega' => 'required',
			'nome_exibicao_web' => 'required|max:30',
			'latitude' => 'required|max:10',
			'longitude' => 'required|max:10',
			'politica_privacidade' => 'max:400',
			'maximo_adicionais' => 'required',
			'maximo_adicionais_pizza' => 'required'
		];

		$messages = [
			'link_face.max' => '255 caracteres maximos permitidos.',
			'link_twiteer.max' => '255 caracteres maximos permitidos.',
			'link_google.max' => '255 caracteres maximos permitidos.',
			'link_instagram.max' => '255 caracteres maximos permitidos.',
			'telefone.required' => 'O campo Telefone é obrigatório.',
			'telefone.max' => '20 caracteres maximos permitidos.',
			'endereco.required' => 'O campo endereço é obrigatório.',
			'endereco.max' => '90 caracteres maximos permitidos.',
			'tempo_medio_entrega.required' => 'O campo Tempo Medio de Entrega é obrigatório.',
			'tempo_maximo_cancelamento.required' => 'O campo Tempo Maximo de Cancelamento é obrigatório.',
			'tempo_medio_entrega.max' => '10 caracteres maximos permitidos.',
			'valor_entrega.required' => 'O campo Valor de Entrega é obrigatório.',
			'nome_exibicao_web.required' => 'O campo Nome Exibição é obrigatório.',
			'nome_exibicao_web.max' => '30 caracteres maximos permitidos.',
			'latitude.required' => 'O campo Latitude é obrigatório.',
			'latitude.max' => '10 caracteres maximos permitidos.',
			'longitude.required' => 'O campo Longitude é obrigatório.',
			'longitude.max' => '10 caracteres maximos permitidos.',
			'politica_privacidade.max' => '400 caracteres maximos permitidos.',

			'maximo_adicionais.required' => 'Campo obrigatório.',
			'maximo_adicionais_pizza.required' => 'Campo obrigatório.',

		];
		$this->validate($request, $rules, $messages);
	}


}
