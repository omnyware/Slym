@extends('default.layout')
@section('content')

	<div class="row">
		<div class="col s12">

			<h4>Lista de Tipos de Serviço</h4>

			@if(session()->has('message'))
			<div style="border-radius: 10px;" class="col s12 {{ session('color') }}">
				<h5 class="center-align white-text">{{ session()->get('message') }}</h5>
			</div>
			@endif

			<div class="row"></div>
			<div class="row">
				<a href="/tipoServico/new" class="btn blue">
			      	<i class="material-icons left">add</i>	
			      	Novo Tipo de Serviço		
				</a>
			</div>

			

			<div class="row">
				<div class="col s12">
					<label>Numero de registros: {{count($types)}}</label>					
				</div>
				<table class="col s12">
					<thead>
						<tr>
							<th>Código</th>
							<th>Nome</th>
							<th>Ações</th>
						</tr>
					</thead>

					<tbody>
						@foreach($types as $t)
						<tr>
							<th>{{ $t->id }}</th>
							<th>{{ $t->name }}</th>

							<th>
								<a href="/tipoServico/edit/{{ $t->id }}">
	      							<i class="material-icons left">edit</i>					
								</a>
								<a onclick = "if (! confirm('Deseja excluir este registro?')) { return false; }" href="/tipoServico/delete/{{ $t->id }}">
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