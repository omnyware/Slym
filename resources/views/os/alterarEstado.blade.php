@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			<h3 style="font-weight: bold;">Alterar Estado da OS 
				<strong style="font-weight: bold;" class="text-success">{{$ordem->id}}</strong>
			</h3>
			<h4>Estado Atual: 
				@if($ordem->estado == 'pd') 
				<span class="label label-xl label-inline label-light-warning">PENDENTE</span>
				@elseif($ordem->estado == 'ap')
				<span class="label label-xl label-inline label-light-success">APROVADO</span>
				@elseif($ordem->estado == 'rp')
				<span class="label label-xl label-inline label-light-danger">REPROVADO</span>
				@else
				<span class="label label-xl label-inline label-light-info">FINALIZADO</span>
				@endif

			</h4>

			@if($ordem->estado != 'fz' && $ordem->estado != 'rp')

			<form method="post" action="/ordemServico/alterarEstado">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="id" value="{{$ordem->id}}">
				<div class="row">
					<div class="form-group validated col-sm-4 col-lg-4">

						@if($ordem->estado == 'pd')
						<select class="custom-select form-control" id="sigla_uf" name="novo_estado">
							<option value="ap">APROVADO</option>
							<option value="rp">REPROVADO</option>
						</select>

						@elseif($ordem->estado == 'ap')
						<select class="custom-select form-control" id="sigla_uf" name="novo_estado">
							<option value="fz">FINALIZADO</option>
						</select>
						@endif
					</div>

					<div class="form-group validated col-sm-4 col-lg-4">
						<button type="submit" class="btn btn-success">Alterar</button>
					</div>
				</div>

			</form>
			@elseif($ordem->estado == 'fz')
			<h5 class="text-success">Ordem de Serviço finalizada!</h5>

			<a href="/ordemServico" class="btn btn-info">Voltar</a>

			@else
			<h5 class="text-danger">Ordem de Serviço reprovada!</h5>

			<a href="/ordemServico" class="btn btn-danger">Voltar</a>

			@endif
		</div>

	</div>
</div>

@endsection	