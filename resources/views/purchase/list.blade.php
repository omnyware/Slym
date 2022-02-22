@extends('default.layout')
@section('content')

	<div class="row">
		<div class="col s12">

			<h4>Lista de Compras</h4>

			@if(session()->has('message'))
			<div style="border-radius: 10px;" class="col s12 {{ session('color') }}">
				<h5 class="center-align white-text">{{ session()->get('message') }}</h5>
			</div>
			@endif

			<div class="row"></div>
			<div class="row">
				<a href="/compras/new" class="btn blue">
			      	<i class="material-icons left">add</i>	
			      	Nova Compra		
				</a>
			</div>

			<form method="get" action="/compras/search" class="row col s5">
				<div class="input-field col s10">
			          <input id="pesquisa" name="pesquisa" type="text" class="validate">
			          <label for="pesquisa">Pesquisa por Fornecedor</label>

			          
			    </div>
			    <button class="btn black" type="submit">
			      <i class="material-icons">search</i>	
			    </button>
			</form>

			<div class="row">
				<div class="col s12">
					<label>Numero de registros: {{count($purchases)}}</label>					
				</div>
				<table class="col s12">
					<thead>
						<tr>
							<th>Código</th>
							<th>Fornecedor</th>
							<th>Total</th>
							<th>Data de Registro</th>
							<th>Observação</th>
							<th>Ações</th>
						</tr>
					</thead>

					<tbody>
						<?php 
						$total = 0;
						?>
						@foreach($purchases as $p)
						<tr>
							<th>{{ $p->id }}</th>
							<th>{{ $p->provider->name }}</th>
							<th>{{ number_format($p->value, 2, ',', '.') }}</th>
							<th>{{ \Carbon\Carbon::parse($p->date_register)->format('d/m/Y H:i:s')}}</th>
							<th>{{ !empty($p->note) ? $p->note : "--" }}</th>
							<th>
								@if(is_adm())
								<a onclick = "if (! confirm('Deseja excluir este registro, ira alterar o estoque?')) { return false; }" href="/compras/delete/{{ $p->id }}">
	      							<i class="material-icons left red-text">delete</i>					
								</a>
								@endif

								<a href="/compras/view/{{ $p->id }}">
	      							<i class="material-icons left green-text">visibility</i>					
								</a>

								<!-- <a href="/compras/view/{{ $p->id }}">
	      							<i class="material-icons green green-text">nfc</i>					
								</a>
								 -->
							</th>
							<?php $total += $p->value ?>
						</tr>
						@endforeach
						<tr class="green lighten-4">
							<th colspan="2">TOTAL</th>
							<th>{{number_format($total, 2, ',', '.')}}</th>
							<th colspan="3"></th>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection	