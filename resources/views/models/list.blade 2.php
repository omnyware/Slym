@extends('default.layout')
@section('content')

	<div class="row">
		<div class="col s12">

			<h4>Lista de Modelos</h4>

			@if(session()->has('message'))
			<div style="border-radius: 10px;" class="col s12 {{ session('color') }}">
				<h5 class="center-align white-text">{{ session()->get('message') }}</h5>
			</div>
			@endif

			<div class="row"></div>
			<div class="row">
				<a href="/modelos/new" class="btn blue">
			      	<i class="material-icons left">add</i>	
			      	Novo Modelo		
				</a>
			</div>

			

			<div class="row">
				<div class="col s12">
					<label>Numero de registros: {{count($models)}}</label>					
				</div>
				<table class="col s12">
					<thead>
						<tr>
							<th>Código</th>
							<th>Nome</th>
							<th>Descrição</th>
							<th>Marca</th>
							<th>Imagem</th>
							<th>Ações</th>
						</tr>
					</thead>

					<tbody>
						@foreach($models as $m)
						<tr>
							<th>{{ $m->id }}</th>
							<th>{{ $m->name }}</th>
							<th>{{ $m->description }}</th>
							<th>{{ $m->brand->name }}</th>
							<th>
								<img style="height: 80px; width: 100px;" src="{{ url("imagens/modelos/{$m->img}")}}" />
							</th>
							<th>
								<a href="/modelos/edit/{{ $m->id }}">
	      							<i class="material-icons left">edit</i>					
								</a>
								<a onclick = "if (! confirm('Deseja excluir este registro?')) { return false; }" href="/modelos/delete/{{ $m->id }}">
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