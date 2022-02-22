@extends('default.layout')
@section('content')


<div class="row" id="anime" style="display: none">
	<div class="col s8 offset-s2">
		<lottie-player src="/anime/success.json" background="transparent" speed="0.8" style="width: 100%; height: 300px;" autoplay >
		</lottie-player>
	</div>
</div>

<div class="card card-custom gutter-b">


	<div class="card-body">
		<div class="content d-flex flex-column flex-column-fluid" id="kt_content" >

			<div class="row" id="anime" style="display: none">
				<div class="col s8 offset-s2">
					<lottie-player src="/anime/success.json" background="transparent" speed="0.8" style="width: 100%; height: 300px;" autoplay >
					</lottie-player>
				</div>
			</div>

			<div class="col-lg-12" id="content">

				<form method="post" action="/vendas/clone">
					@csrf

					<div class="row">
						<div class="form-group validated col-sm-8 col-lg-8 col-8">

							@if($config->ambiente == 2)
							<h6>Ambiente: <strong class="text-primary">Homologação</strong></h6>
							@else
							<h6>Ambiente: <strong class="text-success">Produção</strong></h6>
							@endif

							<h6>Ultima NF-e: <strong class="text-danger">{{$lastNF}}</strong></h6>

						</div>
					</div>
					<input type="hidden" name="venda_id" value="{{$venda->id}}">

					<div class="row align-items-center">
						<div class="form-group validated col-sm-8 col-lg-8 col-8">
							<label class="col-form-label" id="">Cliente</label><br>
							<select class="form-control select2" style="width: 100%" id="kt_select2_3" name="cliente">
								<option value="null">Selecione o cliente</option>
								@foreach($clientes as $c)
								<option value="{{$c->id}}">{{$c->id}} - {{$c->razao_social}} ({{$c->cpf_cnpj}})</option>
								@endforeach
							</select>
						</div>

						<div class="col-sm-4 col-lg-4 col-4">
							<button style="margin-top: 15px;" class="btn btn-light-success">
								<i class="la la-check"></i>
								Clonar
							</button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>


@endsection