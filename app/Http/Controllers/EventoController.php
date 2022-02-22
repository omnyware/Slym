<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evento;
use App\Funcionario;
use App\EventoFuncionario;
use App\Servico;
use App\CategoriaServico;
use App\Usuario;
use App\AtividadeEvento;
use App\AtividadeServico;
use Dompdf\Dompdf;
use App\ConfigNota;
use NFePHP\DA\NFe\EventoPrint;

class EventoController extends Controller
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
		$value = session('user_logged');

		$usuario = Usuario::find($value['id']);
		$temp = [];
		$eventos = Evento::
		where('empresa_id', $this->empresa_id)
		->orderBy('id', 'desc')
		->get();

		foreach($eventos as $e){
			$add = false;
			foreach($e->funcionarios as $f){
				if($usuario->funcionario && $usuario->funcionario->id == $f->funcionario_id){
					$add = true;
					array_push($temp, $e);
				}
			}

			if($usuario->adm && $add == false){
				array_push($temp, $e);
			}
		}

		return view('eventos/list')
		->with('title', 'Eventos')
		->with('eventos', $temp);
	}

	public function pesquisa(Request $request){
		$eventos = Evento::
		where('empresa_id', $this->empresa_id)
		->where('nome', 'LIKE', "%$request->pesquisa%")
		->get();

		return view('eventos/list')
		->with('title', 'Eventos')
		->with('eventos', $eventos);
	}

	public function novo(){
		return view('eventos/register')
		->with('title', 'Novo Evento');
	}

	private function parseDate($date){
		return date('Y-m-d', strtotime(str_replace("/", "-", $date)));
	}

	public function save(Request $request){
		$this->_validate($request);
		$inicio = $this->parseDate($request->inicio);
		$fim = $this->parseDate($request->fim);

		$request->merge([ 'inicio' => $inicio]);
		$request->merge([ 'fim' => $fim]);
		$request->merge([ 'status' => $request->status ? true : false]);

		$result = Evento::create($request->all());

		if($result){
			session()->flash("mensagem_sucesso", "Evento cadastrado com sucesso!");
		}else{
			session()->flash('mensagem_erro', 'Erro ao cadastrar evento!');
		}

		return redirect('/eventos');

	}

	public function update(Request $request){
		$this->_validate($request);
		
		$evento = Evento::find($request->id);

		$inicio = $this->parseDate($request->inicio);
		$fim = $this->parseDate($request->fim);

		$evento->status = $request->status ? true : false;
		$evento->nome = $request->nome;
		$evento->descricao = $request->descricao;
		$evento->logradouro = $request->logradouro;
		$evento->numero = $request->numero;
		$evento->bairro = $request->bairro;
		$evento->cidade = $request->cidade;
		$evento->inicio = $inicio;
		$evento->fim = $fim;

		if($evento->save()){
			session()->flash("mensagem_sucesso", "Evento atualizado com sucesso!");
		}else{
			session()->flash('mensagem_erro', 'Erro ao atualizar evento!');
		}
		return redirect('/eventos');

	}

	public function delete($id){
		$evento = Evento::find($id);
		if($evento->delete()){
			session()->flash("mensagem_sucesso", "Evento removido com sucesso!");
		}else{
			session()->flash('mensagem_erro', 'Erro ao remover evento!');
		}
		return redirect('/eventos');
	}

	private function _validate(Request $request){

		$rules = [
			'nome' => 'required|max:100',
			'descricao' => 'required|max:200',
			'logradouro' => 'required|max:80',
			'numero' => 'required|max:10',
			'bairro' => 'required|max:30',
			'cidade' => 'required|max:50',
			'inicio' => 'required|min:8',
			'fim' => 'required|min:8'
		];

		$messages = [
			'nome.required' => 'Campo obrigatório',
			'nome.max' => 'Máximo de 100 caracteres',
			'descricao.required' => 'Campo obrigatório',
			'descricao.max' => 'Máximo de 200 caracteres',
			'logradouro.required' => 'Campo obrigatório',
			'logradouro.max' => 'Máximo de 80 caracteres',
			'numero.required' => 'Campo obrigatório',
			'numero.max' => 'Máximo de 10 caracteres',
			'bairro.required' => 'Campo obrigatório',
			'bairro.max' => 'Máximo de 30 caracteres',
			'cidade.required' => 'Campo obrigatório',
			'cidade.max' => 'Máximo de 50 caracteres',
			'inicio.required' => 'Campo obrigatório',
			'inicio.min' => 'Campo obrigatório',
			'fim.required' => 'Campo obrigatório',
			'fim.min' => 'Campo obrigatório',
		];
		$this->validate($request, $rules, $messages);
	}

	public function edit($id){
		$evento = Evento::find($id);

		if(valida_objeto($evento)){
			return view('eventos/register')
			->with('evento', $evento)
			->with('title', 'Editar Evento');
		}else{
			return redirect('/403');
		}
	}

	public function funcionarios($id){
		$evento = Evento::find($id);
		if(valida_objeto($evento)){
			$funcionarios = Funcionario::
			where('empresa_id', $this->empresa_id)
			->get();

			return view('eventos/funcionarios')
			->with('funcionarios', $funcionarios)
			->with('evento', $evento)
			->with('title', 'Funcionários para evento');
		}else{
			return redirect('/403');
		}
	}

	public function saveFuncionario(Request $request){
		$evento_id = $request->evento;
		$funcionario_id = $request->funcionario;

		$arr = [
			'evento_id' => $evento_id,
			'funcionario_id' => $funcionario_id
		];
		$res = EventoFuncionario::create($arr);
		if($res){
			session()->flash("mensagem_sucesso", "Funcionário adicionado com sucesso!");
		}else{
			session()->flash('mensagem_erro', 'Erro ao adicionar Funcionário!');
		}
		return redirect()->back();
	}

	public function removeFuncionario($id){
		$f = EventoFuncionario::find($id);
		if($f->delete()){
			session()->flash("mensagem_sucesso", "Funcionário removido com sucesso!");
		}else{
			session()->flash('mensagem_erro', 'Erro ao remover Funcionário!');
		}
		return redirect()->back();
	}


	// atividades

	public function atividades($id){
		$evento = Evento::find($id);
		if(valida_objeto($evento)){
			return view('eventos/atividades')
			->with('evento', $evento)
			->with('atividades', $evento->atividades)
			->with('title', 'Atividades evento');
		}else{
			return redirect('/403');
		}
	}

	public function filtroAtividade(Request $request){
		$estado = $request->estado;
		$responsavel = $request->responsavel;
		$evento = Evento::find($request->evento_id);
		if(valida_objeto($evento)){
			$atividades = AtividadeEvento::
			where('evento_id', $evento->id);

			if($estado != 'TODOS'){
				$atividades->where('status', $estado);
			}

			if($responsavel){
				$atividades->where('responsavel_nome', 'LIKE', "%$responsavel%");
			}

			$atividades = $atividades->get();
			return view('eventos/atividades')
			->with('evento', $evento)
			->with('atividades', $atividades)
			->with('title', 'Atividades evento');
		}else{
			return redirect('/403');
		}
	}

	public function novaAtividade($id){
		$evento = Evento::find($id);
		if(valida_objeto($evento)){
			$servicos = Servico::
			where('empresa_id', $this->empresa_id)
			->get();

			$categorias = CategoriaServico::
			where('empresa_id', $this->empresa_id)
			->get();

			$hora = date('H:i');

			return view('eventos/nova_atividade')
			->with('evento', $evento)
			->with('servicos', $servicos)
			->with('categorias', $categorias)
			->with('hora', $hora)
			->with('eventoJs', true)
			->with('title', 'Nova Atividade');
		}else{
			return redirect('/403');
		}
	}

	public function salvarAtividade(Request $request){
		$this->_validateAtividade($request);
		$usuario = Usuario::find(get_id_user());
		if(!$usuario->funcionario){
			session()->flash('mensagem_erro', 'Contate o admin para atribuir seu usuário como funcionário');
			return redirect()->back();
		}
		$servicos_selecionados = $request->servicos_selecionados;

		$servicos_selecionados = explode(",", $servicos_selecionados);

		try{
			$atividade = [
				'responsavel_nome' => $request->responsavel_nome,
				'responsavel_telefone' => $request->responsavel_telefone,
				'crianca_nome' => $request->crianca_nome,
				'inicio' => $request->inicio,
				'fim' => $request->fim,
				'total' => $request->total,
				'status' => 0,
				'evento_id' => $request->id,
				'funcionario_id' => $usuario->funcionario->id
			];

			$res = AtividadeEvento::create($atividade);

			foreach($servicos_selecionados as $s){
				$arr = [
					'servico_id' => $s,
					'atividade_id' => $res->id
				];
				AtividadeServico::create($arr);
			}
			
			session()->flash("mensagem_sucesso", "Atividade registrada!");
		}catch(\Exception $e){
			session()->flash("mensagem_erro", "Erro inesperado!");
		}

		return redirect('/eventos/atividades/'.$request->id);
	}

	public function imprimirComprovante($id){

		$atividade = AtividadeEvento::find($id);
		$public = getenv('SERVIDOR_WEB') ? 'public/' : '';

		$config = ConfigNota::
		where('empresa_id', $this->empresa_id)
		->first();

		$public = getenv('SERVIDOR_WEB') ? 'public/' : '';
		$pathLogo = $public.'logos/' . $config->logo;

		$cupom = new EventoPrint($atividade, $pathLogo);
		$cupom->monta();
		$pdf = $cupom->render();

		return response($pdf)
		->header('Content-Type', 'application/pdf');
	}

	private function _validateAtividade(Request $request){

		$rules = [
			'responsavel_nome' => 'required|max:50',
			'responsavel_telefone' => 'required|max:15',
			'crianca_nome' => 'required|max:50',
			'inicio' => 'required|min:5',
			'fim' => 'required|min:5',
			'servicos_selecionados' => 'required'
		];

		$messages = [
			'responsavel_nome.required' => 'Campo obrigatório',
			'responsavel_nome.max' => 'Máximo de 50 caracteres',
			'responsavel_telefone.required' => 'Campo obrigatório',
			'responsavel_telefone.max' => 'Máximo de 15 caracteres',
			'crianca_nome.required' => 'Campo obrigatório',
			'crianca_nome.max' => 'Máximo de 50 caracteres',
			'inicio.required' => 'Campo obrigatório',
			'inicio.min' => 'Informe corretamente',
			'fim.required' => 'Campo obrigatório',
			'fim.min' => 'Informe corretamente',
			'servicos_selecionados.required' => 'Selecione um serviço',

		];
		$this->validate($request, $rules, $messages);
	}

	public function finalizarAtividade($id){
		$atividade = AtividadeEvento::find($id);

		$dataHoje = date('Y-m-d');
		$horaAgora = date('H:i');
		$inicio = $atividade->inicio;
		$fim = $atividade->fim;

		$inicio = $dataHoje . " " . $inicio;
		$fim = $dataHoje . " " . $fim;
		$agora = $dataHoje . " " . $horaAgora;

		$diferencaContratada = strtotime($fim) - strtotime($inicio);
		$diferencaReal = strtotime($agora) - strtotime($inicio);
		$diferencaContratada = floor($diferencaContratada / 60);
		$diferencaReal = floor($diferencaReal / 60);

		$arrParaCobrar = [];
		$soma = 0;
		foreach($atividade->servicos as $s){
			$tempo = $s->servico->tempo_servico;
			$valor = $s->servico->valor;
			$dif = $diferencaReal/$diferencaContratada;
			$dif = (int)$dif+1;

			$soma += $valorServico = $dif * $valor;
			$temp = [
				'valor' => $valorServico,
				'servico' => $s->servico->nome
			];

			array_push($arrParaCobrar, $temp);
		}

		return view('eventos/finalizar_atividade')
		->with('atividade', $atividade)
		->with('diferencaContratada', $diferencaContratada)
		->with('diferencaReal', $diferencaReal)
		->with('soma', $soma)
		->with('arrParaCobrar', $arrParaCobrar)
		->with('title', 'Finalizar atividade');
	}

	public function finalizarAtividadeSave(Request $request){
		$atividade = $request->atividade;
		$atividade = AtividadeEvento::find($atividade);

		$atividade->fim = date('H:i');
		$atividade->status = 1;
		$atividade->total = __replace($request->valor_total);

		if($atividade->save()){
			session()->flash("mensagem_sucesso", "Atividade finalizada com sucesso!");
		}else{
			session()->flash('mensagem_erro', 'Erro ao finalizar!');
		}
		return redirect('/eventos/atividades/'. $atividade->evento->id);
	}

	public function movimentacao(){
		$funcionarios = Funcionario::
		where('empresa_id', $this->empresa_id)
		->get();

		$eventos = Evento::
		where('empresa_id', $this->empresa_id)
		->orderBy('id', 'desc')
		->get();

		$atividades = AtividadeEvento::
		select('atividade_eventos.*')
		->join('eventos', 'eventos.id' , '=', 'atividade_eventos.evento_id')
		->where('eventos.empresa_id', $this->empresa_id)
		->whereBetween('atividade_eventos.created_at', [date('Y-m-d') . ' 00:00:00', 
			date('Y-m-d') . ' 23:59:00'])
		->paginate(40);


		return view('eventos/movimentacao')
		->with('atividades', $atividades)
		->with('funcionarios', $funcionarios)
		->with('eventos', $eventos)
		->with('links', true)
		->with('title', 'Movimentação');
	}

	public function movimentacaoFiltro(Request $request){
		$funcionarios = Funcionario::
		where('empresa_id', $this->empresa_id)
		->get();

		$eventos = Evento::
		where('empresa_id', $this->empresa_id)
		->orderBy('id', 'desc')
		->get();


		$atividades = AtividadeEvento::
		select('atividade_eventos.*')
		->join('eventos', 'eventos.id' , '=', 'atividade_eventos.evento_id')
		->where('eventos.empresa_id', $this->empresa_id);

		if($request->funcionario != 'todos'){
			$atividades->where('atividade_eventos.funcionario_id', $request->funcionario);
		}
		if($request->evento != 'todos'){
			$atividades->where('atividade_eventos.evento_id', $request->evento);
		}

		if($request->data_inicial && $request->data_final){
			$data_inicial = $this->parseDate($request->data_inicial);
			$data_final = $this->parseDate($request->data_final);
			$atividades->whereBetween('atividade_eventos.created_at', [$data_inicial . ' 00:00:00', 
				$data_final . ' 23:59:00']);
		}

		if($request->status != 'todos'){
			$atividades->where('atividade_eventos.status', $request->status);
		}
		
		$atividades = $atividades->paginate(40);

		return view('eventos/movimentacao')
		->with('atividades', $atividades)
		->with('funcionarios', $funcionarios)
		->with('eventos', $eventos)
		->with('data_inicial', $request->data_inicial)
		->with('data_final', $request->data_final)
		->with('evento', $request->evento)
		->with('funcionario', $request->funcionario)
		->with('status', $request->status)
		->with('filtro', true)
		->with('links', true)
		->with('title', 'Movimentação');
	}

	public function relatorioAtividadeFiltro(Request $request){

		$atividades = AtividadeEvento::
		select('atividade_eventos.*')
		->join('eventos', 'eventos.id' , '=', 'atividade_eventos.evento_id')
		->where('eventos.empresa_id', $this->empresa_id);

		if($request->funcionario != 'todos'){
			$atividades->where('atividade_eventos.funcionario_id', $request->funcionario);
			$funcionario = Funcionario::find($request->funcionario)->nome;
		}
		if($request->evento != 'todos'){
			$atividades->where('atividade_eventos.evento_id', $request->evento);
			$evento = Evento::find($request->evento)->nome;
		}

		if($request->data_inicial && $request->data_final){
			$data_inicial = $this->parseDate($request->data_inicial);
			$data_final = $this->parseDate($request->data_final);
			$atividades->whereBetween('atividade_eventos.created_at', [$data_inicial . ' 00:00:00', 
				$data_final . ' 23:59:00']);
		}

		if($request->status != 'todos'){
			$atividades->where('atividade_eventos.status', $request->status);
		}
		
		$atividades = $atividades->get();

		$p = view('eventos/relatorio')
		->with('atividades', $atividades)
		->with('data_inicial', $request->data_inicial)
		->with('evento', $request->evento)
		->with('status', $request->status)
		->with('funcionario', $funcionario)
		->with('data_final', $request->data_final);

		// return $p;

		$domPdf = new Dompdf(["enable_remote" => true]);
		$domPdf->loadHtml($p);

		$pdf = ob_get_clean();

		$domPdf->setPaper("A4", "landscape");
		$domPdf->render();
		$domPdf->stream("relatorio eventos.pdf");
	}

	public function relatorioAtividade(){
		$atividades = AtividadeEvento::
		select('atividade_eventos.*')
		->join('eventos', 'eventos.id' , '=', 'atividade_eventos.evento_id')
		->where('eventos.empresa_id', $this->empresa_id)
		->whereBetween('atividade_eventos.created_at', [date('Y-m-d') . ' 00:00:00', 
			date('Y-m-d') . ' 23:59:00'])
		->get();

		$p = view('eventos/relatorio')
		->with('atividades', $atividades);

		// return $p;

		$domPdf = new Dompdf(["enable_remote" => true]);
		$domPdf->loadHtml($p);

		$pdf = ob_get_clean();

		$domPdf->setPaper("A4", "landscape");
		$domPdf->render();
		$domPdf->stream("relatorio eventos.pdf");
	}

}
