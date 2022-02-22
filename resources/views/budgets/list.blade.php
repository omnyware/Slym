@extends('default.layout')
@section('content')

	<div class="row">
		<div class="col s12">

			<h4>Lista de Orçamentos</h4>
			
			@isset($filtro)
			<h4>Data Filtro: {{ $filtro }}</h4>
			@endisset

			@if(session()->has('message'))
			<div style="border-radius: 10px;" class="col s12 {{ session('color') }}">
				<h5 class="center-align white-text">{{ session()->get('message') }}</h5>
			</div>
			@endif

			<div class="row"></div>
			<div class="row">
				<a href="/orcamento/new" class="btn blue">
			      	<i class="material-icons left">add</i>	
			      	Novo Orçamento		
				</a>
			</div>

			<form method="get" action="/orcamento/searchClient" class="row col s5">
				<div class="input-field col s10">
			          <input id="pesquisa" name="pesquisa" type="text" class="validate">
			          <label for="pesquisa">Pesquisa por Cliente</label>
			          
			    </div>
			    <button class="btn black" type="submit">
			      <i class="material-icons">search</i>	
			    </button>
			</form>

			<div class="col s1"></div>

			<form method="get" action="/orcamento/searchDate" class="row col s6">
				<div class="input-field col s4">
			          <input id="date_start" name="date_start" type="text" class="datepicker">
			          <label for="date_start">Data Inicio</label>
			    </div>
			    <div class="input-field col s4">
			          <input id="date_last" name="date_last" type="text" class="datepicker">
			          <label for="date_last">Data Final</label>
			    </div>
			    <button class="btn black col s2" type="submit">
			      <i class="material-icons">date_range</i>	
			    </button>
			</form>

			<div class="row">
				<div class="col s12">
					<label>Numero de registros: {{count($budgets)}}</label>					
				</div>
				<table class="col s12">
					<thead>
						<tr>
							<th>Código</th>
							<th>Descrição</th>
							<th>Cliente</th>
							<th>Valor</th>
							<th>Data de Registro</th>
							<th>Ações</th>
						</tr>
					</thead>

					<tbody>
						<?php 
							$total = 0;
						?>
						@foreach($budgets as $b)
						<tr>
							<td>{{ $b->id }}</td>
							<td>{{ $b->description }}</td>
							<td>{{ $b->client->name }}</td>
							<td>{{ number_format($b->value, 2, ',', '.') }}</td>
							<td>{{ \Carbon\Carbon::parse($b->date_register)->format('d/m/Y H:i:s')}}</td>
							
							<td>
								@if(is_adm())
								<a onclick = "if (! confirm('Deseja excluir este registro, ira excluir também a OS?')) { return false; }" href="/orcamento/delete/{{ $b->id }}">
	      							<i class="material-icons left red-text">delete</i>					
								</a>
								@endif
								@if(count($b->order) == 0)
								<a title="Gerar OS" href="/orcamento/os/{{ $b->id }}">
	      							<i class="material-icons left green-text">assignment</i>				
								</a>
								@else
		      						<i class="material-icons left teal-text">done</i>			
								@endif
							</td>
							<?php 
							$total += $b->value;
							?>
						</tr>
						@endforeach
						<tr class="red lighten-5">
							<td colspan="3"></td>
							<td>{{number_format($total, 2, ',', '.')}}</td>
							<td colspan="2"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection	