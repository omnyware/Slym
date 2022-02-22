@extends('relatorios.cabecalho')
@section('content')

<div class="row">
	<div class="col s12">
		<h3 >Relátorio de Evento</h3>
	</div>

	@if(isset($data_inicial) && isset($data_final))
	<h3>Periodo: {{$data_inicial}} - {{$data_final}}</h3>
	@endif

	@if(isset($funcionario))
	<h3>Funcionário: {{$funcionario}}</h3>
	@endif

	@if(isset($evento))
	<h3>Evento: {{$evento}}</h3>
	@endif

	@if(isset($status))
	<h3>Estado: 
		@if($status == 1)
		CONCLUIDO
		@elseif($status == 0)
		PENDENTE
		@else
		TODOS
		@endif
	</h3>
	@endif

	<table class="pure-table">
		<thead>
			<tr>


				<th width="120">RESPONSÁVEL</th>
				<th width="80">TELEFONE</th>
				<th width="120">CRIANÇA</th>
				<th width="80">DATA</th>
				<th width="120">INICIO/FIM</th>
				<th width="100">VALOR</th>
			</tr>
		</thead>

		<tbody>
			<?php $soma = 0; ?>
			@foreach($atividades as $key => $e)
			<tr class="@if($key%2 == 0) pure-table-odd @endif">

				<td>{{$e->responsavel_nome}}</td>
				<td>{{$e->responsavel_telefone}}</td>
				<td>{{$e->crianca_nome}}</td>
				<td>{{ \Carbon\Carbon::parse($e->created_at)->format('d/m/Y')}}</td>
				<td>{{ \Carbon\Carbon::parse($e->inicio)->format('H:i')}}/{{ \Carbon\Carbon::parse($e->fim)->format('H:i')}}</td>
				<td>{{ \Carbon\Carbon::parse($e->fim)->format('H:i')}}</td>
				
			</tr>

			@endforeach
		</tbody>
	</table>
</div>
@endsection

