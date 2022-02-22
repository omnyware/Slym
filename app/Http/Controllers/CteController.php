<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CTeService;
use App\ConfigNota;
use App\Cte;
use App\Cidade;
use App\Cliente;
use App\Certificado;
use App\MedidaCte;
use App\ComponenteCte;
use App\Veiculo;
use App\CategoriaDespesaCte;
use App\NaturezaOperacao;
use App\DespesaCte;
use App\ReceitaCte;
use App\Tributacao;

class CTeController extends Controller
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
		$ctes = Cte::
		where('estado', 'DISPONIVEL')
		->where('empresa_id', $this->empresa_id)
		->paginate(10);

		$tributacao = Tributacao::
        where('empresa_id', $this->empresa_id)
        ->get();

		$menos30 = $this->menos30Dias();
		$date = date('d/m/Y');

		$grupos = Cte::gruposCte();
		$certificado = Certificado::
		where('empresa_id', $this->empresa_id)
		->first();
		return view("cte/list")
		->with('ctes', $ctes)
		->with('cteEnvioJs', true)
		->with('links', true)
		->with('dataInicial', $date)
		->with('grupos', $grupos)
		->with('certificado', $certificado)
		->with('dataFinal', $date)
		->with('title', "Lista de CT-e");
		
	}

	public function filtro(Request $request){

		$dataInicial = $request->data_inicial;
		$dataFinal = $request->data_final;
		$cliente = $request->cliente;
		$estado = $request->estado;
		$ctes = null;

		$grupos = Cte::gruposCte();
		$certificado = Certificado::
		where('empresa_id', $this->empresa_id)
		->first();

		if(isset($cliente) && isset($dataInicial) && isset($dataFinal)){
			$ctes = Cte::filtroDataCliente(
				$cliente, 
				$this->parseDate($dataInicial),
				$this->parseDate($dataFinal, true),
				$estado
			);
		}else if(isset($dataInicial) && isset($dataFinal)){
			$ctes = Cte::filtroData(
				$this->parseDate($dataInicial),
				$this->parseDate($dataFinal, true),
				$estado
			);
		}else if(isset($cliente)){
			$ctes = Cte::filtroCliente(
				$cliente,
				$estado
			);

		}else{
			$ctes = Cte::filtroEstado(
				$estado
			);
		}

		return view("cte/list")
		->with('ctes', $ctes)
		->with('cteEnvioJs', true)
		->with('grupos', $grupos)
		->with('cliente', $cliente)
		->with('certificado', $certificado)
		->with('dataInicial', $dataInicial)
		->with('dataFinal', $dataFinal)
		->with('estado', $estado)

		->with('title', "Filtro de Cte");
	}

	public function nova(){
		$lastCte = Cte::lastCTe();
		$unidadesMedida = Cte::unidadesMedida();
		$tiposMedida = Cte::tiposMedida();
		$tiposTomador = Cte::tiposTomador();
		$listaCST = Cte::listaCST();
		$naturezas = NaturezaOperacao::
		where('empresa_id', $this->empresa_id)
		->get();

		$modals = Cte::modals();
		$veiculos = Veiculo::
		where('empresa_id', $this->empresa_id)
		->get();

		$config = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();

		$clienteCadastrado = Cliente::
		where('empresa_id', $this->empresa_id)
		->first();

		$clientes = Cliente::
		where('empresa_id', $this->empresa_id)
		->orderBy('razao_social')
		->get();

		foreach($clientes as $c){
			$c->cidade;
		}
		$cidades = Cidade::all();
		if(count($naturezas) == 0 || count($veiculos) == 0 || $config == null || $clienteCadastrado == null){
			return view("cte/erro")
			->with('veiculos', $veiculos)
			->with('naturezas', $naturezas)
			->with('config', $config)
			->with('clienteCadastrado', $clienteCadastrado)
			->with('title', "Validação para Emitir");

		}else{
			return view("cte/register")
			->with('naturezas', $naturezas)
			->with('cteJs', true)
			->with('unidadesMedida', $unidadesMedida)
			->with('tiposMedida', $tiposMedida)
			->with('tiposTomador', $tiposTomador)
			->with('listaCST', $listaCST)
			->with('modals', $modals)
			->with('veiculos', $veiculos)
			->with('clientes', $clientes)
			->with('cidades', $cidades)
			->with('config', $config)
			->with('lastCte', $lastCte)
			->with('title', "Nova CT-e");
		}
	}

	public function salvar(Request $request){
		$cte = $request->data;

		$municipio_envio = (int) explode("-", $cte['municipio_envio'])[0];
		$municipio_fim = (int) explode("-", $cte['municipio_fim'])[0];
		$municipio_inicio = (int) explode("-", $cte['municipio_inicio'])[0];
		$municipio_tomador = (int) explode("-", $cte['municipio_tomador'])[0];


		$result = Cte::create([
			'chave_nfe' => $cte['chave_nfe'] ?? '',
			'remetente_id' => $cte['remetente'],
			'destinatario_id' => $cte['destinatario'],
			'usuario_id' => get_id_user(),
			'natureza_id' => $cte['natureza'],
			'tomador' => $cte['tomador'],
			'municipio_envio' => $municipio_envio,
			'municipio_inicio' => $municipio_fim,
			'municipio_fim' => $municipio_inicio,
			'logradouro_tomador' => $cte['logradouro_tomador'],
			'numero_tomador' => $cte['numero_tomador'],
			'bairro_tomador' => $cte['bairro_tomador'],
			'cep_tomador' => $cte['cep_tomador'],
			'municipio_fim' => $municipio_fim,
			'municipio_tomador' => $municipio_tomador,
			'observacao' => $cte['obs'] ?? '',
			'data_previsata_entrega' => $this->parseDate($cte['data_prevista_entrega']),
			'produto_predominante' => $cte['produto_predominante'],
			'cte_numero' => 0,
			'sequencia_cce' => 0,
			'chave' => '',
			'path_xml' => '',
			'estado' => 'DISPONIVEL',

			'valor_transporte' => str_replace(",", ".", $cte['valor_transporte']),
			'valor_receber' => str_replace(",", ".", $cte['valor_receber']),
			'valor_carga' => str_replace(",", ".", $cte['valor_carga']),

			'retira' => $cte['retira'],
			'detalhes_retira' => $cte['detalhes_retira'] ?? '',
			'modal' => $cte['modal'],
			'veiculo_id' => $cte['veiculo_id'],
			'tpDoc' => $cte['tpDoc'] ?? '',
			'descOutros' => $cte['descOutros'] ?? '',
			'nDoc' => $cte['nDoc'] ?? 0,
			'vDocFisc' => $cte['vDocFisc'] ?? 0,
			'CST' => $cte['CST'],
			'empresa_id' => $this->empresa_id

		]);

		if(isset($cte['medidias'])){
			foreach($cte['medidias'] as $c){
				$medida = MedidaCte::create([
					'cod_unidade' => explode("-", $c['unidade_medida'])[0],
					'tipo_medida'=> $c['tipo_medida'],
					'quantidade_carga' => str_replace(",", ".", $c['quantidade']),
					'cte_id' => $result->id
				]);
			}
		}

		if(isset($cte['componentes'])){
			foreach($cte['componentes'] as $c){
				$medida = ComponenteCte::create([
					'nome' => $c['nome'],
					'valor' => str_replace(",", ".", $c['valor']),
					'cte_id' => $result->id
				]);
			}
		}
		echo json_encode($result);
	}

	public function detalhar($id){
		$cte = Cte::
		where('id', $id)
		->first();
		if(valida_objeto($cte)){
			return view("cte/detalhe")
			->with('cte', $cte)
			->with('title', "Detalhe de Cte $id");
		}else{
			return redirect('/403');
		}
	}

	public function custos($id){
		$categorias = CategoriaDespesaCte::
		where('empresa_id', $this->empresa_id)
		->get();

		$cte = Cte::
		where('id', $id)
		->first();

		if(valida_objeto($cte)){
			return view("cte/custos")
			->with('cte', $cte)
			->with('categorias', $categorias)
			->with('title', "Custos Cte $id");
		}else{
			return redirect('/403');
		}
	}

	public function saveReceita(Request $request){
		$result = ReceitaCte::create([
			'descricao' => $request->descricao,		
			'valor' => str_replace(",", ".", $request->valor),
			'cte_id' => $request->cte_id		
		]);

		if($result){
			session()->flash('mensagem_sucesso', 'Receita adicionada!');
		}else{
			session()->flash('mensagem_erro', 'Erro!');
		}
		return redirect('cte/custos/'.$request->cte_id);
	}

	public function saveDespesa(Request $request){
		$result = DespesaCte::create([
			'descricao' => $request->descricao,		
			'categoria_id' => $request->categoria_id,		
			'valor' => str_replace(",", ".", $request->valor),
			'cte_id' => $request->cte_id	
		]);

		if($result){
			session()->flash('mensagem_sucesso', 'Despesa adicionada!');
		}else{
			session()->flash('mensagem_erro', 'Erro!');
		}
		return redirect('cte/custos/'.$request->cte_id);
	}

	public function chaveNfeDuplicada(Request $request){
		$res = Cte::
		where('chave_nfe', 'LIKE', "%$request->chave%")
		->where('empresa_id', $this->empresa_id)
		->first();
		if($res != null){
			echo true;
		}else{
			echo false;
		}
	}

	public function delete($id){
		$despesa = Cte::
		where('id', $id)
		->first();
		if(valida_objeto($despesa)){
			if($despesa->delete()){
				session()->flash('mensagem_sucesso', 'CT-e removida!');
			}else{
				session()->flash('mensagem_erro', 'Erro!');
			}
			return redirect('cte');
		}else{
			return redirect('/403');
		}
	}

	public function deleteDespesa($id){
		$despesa = DespesaCte::
		where('id', $id)
		->first();

		if($despesa->delete()){
			session()->flash('mensagem_sucesso', 'Despesa removida!');
		}else{
			session()->flash('mensagem_erro', 'Erro!');
		}
		return redirect('cte/custos/'.$despesa->cte->id);
	}

	public function deleteReceita($id){
		$receita = ReceitaCte::
		where('id', $id)
		->first();

		if($receita->delete()){
			session()->flash('mensagem_sucesso', 'Receita removida!');
		}else{
			session()->flash('mensagem_erro', 'Erro!');
		}
		return redirect('cte/custos/'.$receita->cte->id);
	}

	private function menos30Dias(){
		return date('d/m/Y', strtotime("-30 days",strtotime(str_replace("/", "-", 
			date('Y-m-d')))));
	}

	private function parseDate($date, $plusDay = false){
		if($plusDay == false)
			return date('Y-m-d', strtotime(str_replace("/", "-", $date)));
		else
			return date('Y-m-d', strtotime("+1 day",strtotime(str_replace("/", "-", $date))));
	}

	public function importarXml(Request $request){

		if ($request->hasFile('file')){
			$arquivo = $request->hasFile('file');
			$xml = simplexml_load_file($request->file);

			$cidade = Cidade::getCidadeCod($xml->NFe->infNFe->emit->enderEmit->cMun);
			$dadosEmitente = [
				'cpf' => $xml->NFe->infNFe->emit->CPF,
				'cnpj' => $xml->NFe->infNFe->emit->CNPJ,  				
				'razaoSocial' => $xml->NFe->infNFe->emit->xNome, 				
				'nomeFantasia' => $xml->NFe->infNFe->emit->xFant,
				'logradouro' => $xml->NFe->infNFe->emit->enderEmit->xLgr,
				'numero' => $xml->NFe->infNFe->emit->enderEmit->nro,
				'bairro' => $xml->NFe->infNFe->emit->enderEmit->xBairro,
				'cep' => $xml->NFe->infNFe->emit->enderEmit->CEP,
				'fone' => $xml->NFe->infNFe->emit->enderEmit->fone,
				'ie' => $xml->NFe->infNFe->emit->IE,
				'cidade_id' => $cidade->id,
				'empresa_id' => $this->empresa_id
			];

			$emitente = $this->verificaClienteCadastrado($dadosEmitente);

			$cidade = Cidade::getCidadeCod($xml->NFe->infNFe->dest->enderDest->cMun);
			$dadosDestinatario = [
				'cpf' => $xml->NFe->infNFe->dest->CPF,
				'cnpj' => $xml->NFe->infNFe->dest->CNPJ,  				
				'razaoSocial' => $xml->NFe->infNFe->dest->xNome, 				
				'nomeFantasia' => $xml->NFe->infNFe->dest->xFant,
				'logradouro' => $xml->NFe->infNFe->dest->enderDest->xLgr,
				'numero' => $xml->NFe->infNFe->dest->enderDest->nro,
				'bairro' => $xml->NFe->infNFe->dest->enderDest->xBairro,
				'cep' => $xml->NFe->infNFe->dest->enderDest->CEP,
				'fone' => $xml->NFe->infNFe->dest->enderDest->fone,
				'ie' => $xml->NFe->infNFe->dest->IE,
				'cidade_id' => $cidade->id,
				'empresa_id' => $this->empresa_id
			];

			$destinatario = $this->verificaClienteCadastrado($dadosDestinatario);

			$chave = substr($xml->NFe->infNFe->attributes()->Id, 3, 44);

			$somaQuantidade = 0;
			foreach($xml->NFe->infNFe->det as $item) {
				$somaQuantidade += $item->prod->qCom;
			}

			$unidade = $xml->NFe->infNFe->det[0]->prod->uCom;
			if($unidade == 'M2'){
				$unidade = '04';
			}else if($unidade == 'M3'){
				$unidade = '00';
			}else if($unidade == 'KG'){
				$unidade = '01';
			}else if($unidade == 'UNID'){
				$unidade = '03';
			}else if($unidade == 'TON'){
				$unidade = '02';
			}


			$dadosDaNFe = [
				'remetente' => $emitente->id,
				'destinatario' => $destinatario->id,
				'chave' => $chave,
				'produto_predominante' => $xml->NFe->infNFe->det[0]->prod->xProd,
				'unidade' => $unidade,
				'valor_carga' => $xml->NFe->infNFe->total->ICMSTot->vProd,
				'munipio_envio' => $emitente->cidade->id . " - " . $emitente->cidade->nome . "(" .$emitente->cidade->uf . ")",
				'munipio_final' => $destinatario->cidade->id . " - " . $destinatario->cidade->nome . "(" .$destinatario->cidade->uf . ")",
				'componente' => 'Transporte',
				'valor_frete' => $xml->NFe->infNFe->total->ICMSTot->vFrete,
				'quantidade' => number_format($somaQuantidade, 4),
				'data_entrega' => date('d/m/Y')
			];

			// echo "<pre>";
			// print_r($dadosDaNFe);
			// echo "</pre>";

			$lastCte = Cte::lastCTe();
			$unidadesMedida = Cte::unidadesMedida();
			$tiposMedida = Cte::tiposMedida();
			$tiposTomador = Cte::tiposTomador();
			$listaCST = Cte::listaCST();
			$naturezas = NaturezaOperacao::
			where('empresa_id', $this->empresa_id)
			->get();

			$modals = Cte::modals();
			$veiculos = Veiculo::
			where('empresa_id', $this->empresa_id)
			->get();

			$config = ConfigNota::
			where('empresa_id', $this->empresa_id)
			->first();

			$clienteCadastrado = Cliente::
			where('empresa_id', $this->empresa_id)
			->first();

			$clientes = Cliente::
			where('empresa_id', $this->empresa_id)
			->orderBy('razao_social')->get();
			foreach($clientes as $c){
				$c->cidade;
			}
			$cidades = Cidade::all();

			return view("cte/register_xml")
			->with('naturezas', $naturezas)
			->with('cteJs', true)
			->with('unidadesMedida', $unidadesMedida)
			->with('tiposMedida', $tiposMedida)
			->with('tiposTomador', $tiposTomador)
			->with('listaCST', $listaCST)
			->with('modals', $modals)
			->with('veiculos', $veiculos)
			->with('cidades', $cidades)
			->with('config', $config)
			->with('lastCte', $lastCte)
			->with('clientes', $clientes)
			->with('dadosDaNFe', $dadosDaNFe)
			->with('emitente', $emitente)
			->with('destinatario', $destinatario)
			->with('title', "Nova CT-e");

		}

	}

	private function verificaClienteCadastrado($cliente){

		if($cliente['cnpj'] != ''){
			$cli = Cliente::
			where('empresa_id', $this->empresa_id)
			->where('cpf_cnpj', $this->formataCnpj($cliente['cnpj']))->first();
		}else{
			$cli = Cliente::
			where('empresa_id', $this->empresa_id)
			->where('cpf_cnpj', $cliente['cpf'])->first();
		}
		if($cli == null){
			$result = Cliente::create(
				[
					'razao_social' => $cliente['razaoSocial'], 
					'nome_fantasia' => $cliente['nomeFantasia'] != '' ? $cliente['nomeFantasia'] : $cliente['razaoSocial'],
					'bairro' => $cliente['bairro'],
					'numero' => $cliente['numero'],
					'rua' => $cliente['logradouro'],
					'cpf_cnpj' => $cliente['cnpj'] ? $this->formataCnpj($cliente['cnpj']) : $cliente['cpf'],
					'telefone' => $cliente['razaoSocial'],
					'celular' => '',
					'email' => 'teste@teste.com',
					'cep' => $cliente['cep'],
					'ie_rg' => $cliente['ie'],
					'consumidor_final' => 0,
					'limite_venda' => 0,
					'cidade_id' => $cliente['cidade_id'],
					'contribuinte' => 1,
					'rua_cobranca' => '',
					'numero_cobranca' => '',
					'bairro_cobranca' => '',
					'cep_cobranca' => '',
					'cidade_cobranca_id' => NULL,
					'empresa_id' => $this->empresa_id
				]
			);
			$cliente = Cliente::find($result->id);
			return $cliente;
		}
		return $cli;
	}

	private function formataCnpj($cnpj){
		$temp = substr($cnpj, 0, 2);
		$temp .= ".".substr($cnpj, 2, 3);
		$temp .= ".".substr($cnpj, 5, 3);
		$temp .= "/".substr($cnpj, 8, 4);
		$temp .= "-".substr($cnpj, 12, 2);
		return $temp;
	}

	public function edit($id){
		$cte = Cte::find($id);
		$lastCte = Cte::lastCTe();
		$unidadesMedida = Cte::unidadesMedida();
		$tiposMedida = Cte::tiposMedida();
		$tiposTomador = Cte::tiposTomador();
		$listaCST = Cte::listaCST();

		$modals = Cte::modals();

		$cidades = Cidade::all();

		$naturezas = NaturezaOperacao::
		where('empresa_id', $this->empresa_id)
		->get();


		$veiculos = Veiculo::
		where('empresa_id', $this->empresa_id)
		->get();

		$config = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();

		$clienteCadastrado = Cliente::
		where('empresa_id', $this->empresa_id)
		->first();

		$clientes = Cliente::
		where('empresa_id', $this->empresa_id)
		->orderBy('razao_social')
		->get();

		foreach($clientes as $c){
			$c->cidade;
		}

		return view("cte/register")
		->with('naturezas', $naturezas)
		->with('cteJs', true)
		->with('unidadesMedida', $unidadesMedida)
		->with('tiposMedida', $tiposMedida)
		->with('tiposTomador', $tiposTomador)
		->with('listaCST', $listaCST)
		->with('modals', $modals)
		->with('veiculos', $veiculos)
		->with('clientes', $clientes)
		->with('cidades', $cidades)
		->with('config', $config)
		->with('cte', $cte)
		->with('lastCte', $lastCte)
		->with('title', "Editar CT-e");

	}

	public function update(Request $request){
		$data = $request->data;

		$cte_id = $data['cte_id'];
		$chave_nfe = $data['chave_nfe'] ?? '';
		$remetente = $data['remetente'];
		$destinatario = $data['destinatario'];
		$tomador = $data['tomador'];
		$municipio_envio = $data['municipio_envio'];
		$municipio_inicio = $data['municipio_inicio'];
		$municipio_fim = $data['municipio_fim'];
		$numero_tomador = $data['numero_tomador'];
		$bairro_tomador = $data['bairro_tomador'];
		$municipio_tomador = $data['municipio_tomador'];
		$logradouro_tomador = $data['logradouro_tomador'];
		$cep_tomador = $data['cep_tomador'];
		$valor_carga = $data['valor_carga'];
		$valor_receber = $data['valor_receber'];
		$valor_transporte = $data['valor_transporte'];
		$produto_predominante = $data['produto_predominante'];
		$detalhes_retira = $data['detalhes_retira'] ?? '';
		$data_prevista_entrega = \Carbon\Carbon::parse(str_replace("/", "-", $data['data_prevista_entrega']))->format('Y-m-d');

		$tpDoc = $data['tpDoc'];
		$vDocFisc = $data['vDocFisc'];
		$nDoc = $data['nDoc'];
		$descOutros = $data['descOutros'];

		$natureza = $data['natureza'];
		$veiculo_id = $data['veiculo_id'];
		$obs = $data['obs'] ?? '';


		$medidas = $data['medidias'];
		$componentes = $data['componentes'];

		$cst = $data['CST'];

		$cte = Cte::find($cte_id);

		$cte->chave_nfe = $chave_nfe;
		$cte->remetente_id = $remetente;
		$cte->destinatario_id = $destinatario;
		$cte->tomador = $tomador;
		$cte->municipio_envio = $municipio_envio;
		$cte->municipio_inicio = $municipio_inicio;
		$cte->numero_tomador = $numero_tomador;
		$cte->bairro_tomador = $bairro_tomador;
		$cte->municipio_tomador = $municipio_tomador;
		$cte->logradouro_tomador = $logradouro_tomador;
		$cte->cep_tomador = $cep_tomador;
		$cte->valor_carga = str_replace(",", ".", $valor_carga);
		$cte->valor_receber = str_replace(",", ".", $valor_receber);
		$cte->valor_transporte = str_replace(",", ".", $valor_transporte);
		$cte->produto_predominante = $produto_predominante;
		$cte->data_previsata_entrega = $data_prevista_entrega;
		$cte->detalhes_retira = $detalhes_retira;
		$cte->tpDoc = $tpDoc;
		$cte->vDocFisc = $vDocFisc;
		$cte->nDoc = $nDoc;
		$cte->descOutros = $descOutros;
		$cte->natureza_id = $natureza;
		$cte->veiculo_id = $veiculo_id;
		$cte->observacao = $obs;
		$cte->CST = $cst;


		try{
			$cte->save();

			MedidaCte::where('cte_id', $cte_id)->delete();


			if($medidas){

				foreach($medidas as $c){
					$medida = MedidaCte::create([
						'cod_unidade' => explode("-", $c['cod_unidade'])[0],
						'tipo_medida'=> $c['tipo_medida'],
						'quantidade_carga' => str_replace(",", ".", $c['quantidade_carga']),
						'cte_id' => $cte_id
					]);
				}
			}

			ComponenteCte::where('cte_id', $cte_id)->delete();

			if($componentes){
				foreach($componentes as $c){
					$medida = ComponenteCte::create([
						'nome' => $c['nome'],
						'valor' => str_replace(",", ".", $c['valor']),
						'cte_id' => $cte_id
					]);
				}
			}
			return response()->json("ok", 200);
		}catch(\Exception $e){
			return response()->json($e->getMessage(), 401);
		}
	}


}
