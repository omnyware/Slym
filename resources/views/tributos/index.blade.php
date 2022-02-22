@extends('default.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/tributos/save">

					<input type="hidden" name="id" value="{{{ isset($tributo->id) ? $tributo->id : 0 }}}">

					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{{ isset($tributo) ? "Editar": "Cadastrar" }}} Tributações</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">


									<div class="row">
										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">ICMS</label>
											<div class="">
												<input id="icms" type="text" class="form-control @if($errors->has('icms')) is-invalid @endif" name="icms" value="{{{ isset($tributo) ? $tributo->icms : old('icms') }}}">
												@if($errors->has('icms'))
												<div class="invalid-feedback">
													{{ $errors->first('icms') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">PIS</label>
											<div class="">
												<input id="pis" type="text" class="form-control @if($errors->has('pis')) is-invalid @endif" name="pis" value="{{{ isset($tributo) ? $tributo->pis : old('pis') }}}">
												@if($errors->has('pis'))
												<div class="invalid-feedback">
													{{ $errors->first('pis') }}
												</div>
												@endif
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">COFINS</label>
											<div class="">
												<input id="cofins" type="text" class="form-control @if($errors->has('cofins')) is-invalid @endif" name="cofins" value="{{{ isset($tributo) ? $tributo->cofins : old('cofins') }}}">
												@if($errors->has('cofins'))
												<div class="invalid-feedback">
													{{ $errors->first('cofins') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">IPI</label>
											<div class="">
												<input id="ipi" type="text" class="form-control @if($errors->has('ipi')) is-invalid @endif" name="ipi" value="{{{ isset($tributo) ? $tributo->ipi : old('ipi') }}}">
												@if($errors->has('ipi'))
												<div class="invalid-feedback">
													{{ $errors->first('ipi') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">NCM Padrão</label>
											<div class="">
												<input id="ncm_padrao" type="text" class="form-control @if($errors->has('ncm_padrao')) is-invalid @endif" name="ncm_padrao" value="{{{ isset($tributo) ? $tributo->ncm_padrao : old('ncm_padrao') }}}">
												@if($errors->has('ncm_padrao'))
												<div class="invalid-feedback">
													{{ $errors->first('ncm_padrao') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-lg-4 col-md-4 col-sm-4">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Regime</label>

											<select class="custom-select form-control" id="regime" name="regime">
												@foreach($regimes as $key => $r)
												<option value="{{$key}}"
												@isset($tributo->regime)
												@if($tributo->regime == $key)
												selected=""
												@endif
												@endisset
												>{{$key}} - {{$r}}</option>
												@endforeach
											</select>

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
								<a style="width: 100%" class="btn btn-danger" href="/tributos">
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