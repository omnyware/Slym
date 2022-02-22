@extends('default.layout')
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/clientesDelivery/updateEndereco" enctype="multipart/form-data">
					<input type="hidden" name="id" value="{{$endereco->id}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h4 class="card-title">Editar Endereço <strong>{{$endereco->id}}</strong></h4>

						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-8 col-10">
											<label class="col-form-label">Rua</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('rua')) is-invalid @endif" name="rua" value="{{$endereco->rua}}">
												@if($errors->has('rua'))
												<div class="invalid-feedback">
													{{ $errors->first('rua') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-sm-2 col-lg-2 col-2">
											<label class="col-form-label">Nº</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('numero')) is-invalid @endif" name="numero" value="{{$endereco->numero}}">
												@if($errors->has('numero'))
												<div class="invalid-feedback">
													{{ $errors->first('numero') }}
												</div>
												@endif
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group validated col-sm-5 col-lg-5 col-6">
											<label class="col-form-label">Bairro</label>
											@if($config->usar_bairros)
											<select class="custom-select form-control" id="bairro_id" name="bairro_id">
												@foreach($bairros as $b)
												<option value="{{$b->id}}" @if($b->id == $endereco->bairro_id) selected @endif>{{$b->nome}} R$ {{number_format($b->valor_entrega, 2)}}</option>
												@endforeach
											</select>
											@else
											<div class="">
												<input type="text" class="form-control @if($errors->has('bairro')) is-invalid @endif" name="bairro" value="{{$endereco->bairro()}}">
												@if($errors->has('bairro'))
												<div class="invalid-feedback">
													{{ $errors->first('bairro') }}
												</div>
												@endif
											</div>
											@endif

										</div>
										<div class="form-group validated col-sm-5 col-lg-5 col-6">
											<label class="col-form-label">Referência</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('referencia')) is-invalid @endif" name="referencia" value="{{$endereco->referencia}}">
												@if($errors->has('referencia'))
												<div class="invalid-feedback">
													{{ $errors->first('referencia') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-5 col-lg-5 col-6">
											<label class="col-form-label">Latitude</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('latitude')) is-invalid @endif" name="latitude" value="{{$endereco->latitude}}">
												@if($errors->has('latitude'))
												<div class="invalid-feedback">
													{{ $errors->first('latitude') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-sm-5 col-lg-5 col-6">
											<label class="col-form-label">Longitude</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('longitude')) is-invalid @endif" name="longitude" value="{{$endereco->longitude}}">
												@if($errors->has('longitude'))
												<div class="invalid-feedback">
													{{ $errors->first('longitude') }}
												</div>
												@endif
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">

						<div class="row">
							<div class="col-xl-2">

							</div>
							<div class="col-lg-3 col-sm-6 col-md-4">
								<a style="width: 100%" class="btn btn-danger" href="/clientesDelivery">
									<i class="la la-close"></i>
									<span class="">Cancelar</span>
								</a>
							</div>
							<div class="col-lg-3 col-sm-6 col-md-4">
								<button style="width: 100%" type="submit" class="btn btn-success">
									<i class="la la-check"></i>
									<span class="">Salvar</span>
								</button>
							</div>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection