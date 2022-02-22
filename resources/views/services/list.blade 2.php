@extends('default.layout')
@section('content')

	<div class="row">
		<div class="col s12">

			<h4>Lista de Serviços</h4>

			@if(session()->has('message'))
			<div style="border-radius: 10px;" class="col s12 {{ session('color') }}">
				<h5 class="center-align white-text">{{ session()->get('message') }}</h5>
			</div>
			@endif

			<div class="row"></div>
			<div class="row">
				<a href="/servicos/new" class="btn blue">
			      	<i class="material-icons left">add</i>	
			      	Novo Servico		
				</a>
			</div>

			

			<div class="row">
				<div class="col s12">
					<label>Numero de registros: {{count($services)}}</label>					
				</div>
				<table class="col s12">
					<thead>
						<tr>
							<th>Código</th>
							<th>Descrição</th>
							<th>Modelo</th>
							<th>Produto utilizado</th>
							<th>Valor</th>
							<th>Garantia</th>
							<th>Ações</th>
						</tr>
					</thead>

					<tbody>
						@foreach($services as $s)
						<tr>
							<th>{{ $s->id }}</th>
							<th>{{ $s->description }}</th>
							<th>{{ $s->model->name }}</th>
							<th>{{ $s->product->name }}</th>
							<th>{{ number_format($s->value, 2, ',', '.') }}</th>
							<th>{{ $s->warranty }}</th>

							<th>
								<a onclick = "if (! confirm('Deseja excluir este registro?')) { return false; }" href="/servicos/delete/{{ $s->id }}">
	      							<i class="material-icons left red-text">delete</i>					
								</a>
							</th>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection	