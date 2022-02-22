@extends('default.layout')
@section('content')

	<div class="row">
		<div class="col s12">

			<h4>Lista de Aparelhos Sem Registro</h4>

			@if(session()->has('message'))
			<div style="border-radius: 10px;" class="col s12 {{ session('color') }}">
				<h5 class="center-align white-text">{{ session()->get('message') }}</h5>
			</div>
			@endif			

			<div class="row">
				<div class="col s12">
					<label>Numero de registros: {{count($registers)}}</label>					
				</div>
				<table class="col s12">
					<thead>
						<tr>
							<th>Código</th>
							<th>Nome</th>
							<th>Telefone</th>
							<th>Marca</th>
							<th>Modelo</th>
							<th>Ações</th>
						</tr>
					</thead>

					<tbody>
						@foreach($registers as $r)
						<tr>
							<th>{{ $r->id }}</th>
							<th>{{ $r->name }}</th>
							<th>{{ $r->phone }}</th>
							<th>{{ $r->brand }}</th>
							<th>{{ $r->model }}</th>
							<th>
								
								<a onclick = "if (! confirm('Deseja excluir este registro?')) { return false; }" href="/semRegistro/delete/{{ $r->id }}">
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