@extends('default.layout')
@section('content')

<div class="row">
	<div class="col s12">

		<h4>Lista de Banners do Topo</h4>

		@if(session()->has('message'))
		<div style="border-radius: 10px;" class="col s12 {{ session('color') }}">
			<h5 class="center-align white-text">{{ session()->get('message') }}</h5>
		</div>
		@endif

		

		<div class="row"></div>
		<div class="row">

			<a href="/bannerTopo/new" class="btn green accent-3">
				<i class="material-icons left">add</i>	
				Novo Banner	
			</a>
		</div>



		<div class="row">
			<div class="col s12">
				<label>Numero de registros: {{count($banners)}}</label>					
			</div>
			<table class="col s12">
				<thead>
					<tr>
						<th>#</th>
						<th>Titulo</th>
						<th>Descrição</th>
						<th>Imagem</th>
						<th>Ativo</th>
						<th>Ações</th>
					</tr>
				</thead>

				<tbody>
					@foreach($banners as $b)
					<tr>
						<th>{{ $b->id }}</th>
						<th>{{ $b->titulo }}</th>
						<th>{{ $b->descricao }}</th>

						<th>
							<img style="width: 80px;" src="/banner_topo/{{$b->path}}">
						</th>
						<th>
							@if($b->ativo)
							<i class="material-icons green-text">brightness_1</i>
							@else
							<i class="material-icons red-text">brightness_1</i>
							@endif
						</th>

						<th>
							<a href="/bannerTopo/edit/{{ $b->id }}">
								<i class="material-icons left">edit</i>					
							</a>


							<a onclick = "if (! confirm('Deseja excluir este registro?')) { return false; }" href="/bannerTopo/delete/{{ $b->id }}">
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