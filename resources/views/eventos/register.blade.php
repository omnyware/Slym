@extends('default.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="{{{ isset($evento) ? '/eventos/update': '/eventos/save' }}}" enctype="multipart/form-data">


					<input type="hidden" name="id" value="{{{ isset($evento) ? $evento->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{isset($evento) ? 'Editar' : 'Novo'}} Evento</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">
										<div class="form-group validated col-sm-6 col-lg-6">
											<label class="col-form-label">Nome</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('nome')) is-invalid @endif" name="nome" value="{{{ isset($evento) ? $evento->nome : old('nome') }}}">
												@if($errors->has('nome'))
												<div class="invalid-feedback">
													{{ $errors->first('nome') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-12 col-lg-12">
											<label class="col-form-label">Descrição</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('descricao')) is-invalid @endif" name="descricao" value="{{{ isset($evento) ? $evento->descricao : old('descricao') }}}">
												@if($errors->has('descricao'))
												<div class="invalid-feedback">
													{{ $errors->first('descricao') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-8">
											<label class="col-form-label">Logradouro</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('logradouro')) is-invalid @endif" name="logradouro" value="{{{ isset($evento) ? $evento->logradouro : old('logradouro') }}}">
												@if($errors->has('logradouro'))
												<div class="invalid-feedback">
													{{ $errors->first('logradouro') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-2 col-lg-2">
											<label class="col-form-label">Nº</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('numero')) is-invalid @endif" name="numero" value="{{{ isset($evento) ? $evento->numero : old('numero') }}}">
												@if($errors->has('numero'))
												<div class="invalid-feedback">
													{{ $errors->first('numero') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-6 col-lg-6">
											<label class="col-form-label">Bairro</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('bairro')) is-invalid @endif" name="bairro" value="{{{ isset($evento) ? $evento->bairro : old('bairro') }}}">
												@if($errors->has('bairro'))
												<div class="invalid-feedback">
													{{ $errors->first('bairro') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">Cidade</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('cidade')) is-invalid @endif" name="cidade" value="{{{ isset($evento) ? $evento->cidade : old('cidade') }}}">
												@if($errors->has('cidade'))
												<div class="invalid-feedback">
													{{ $errors->first('cidade') }}
												</div>
												@endif
											</div>
										</div>

										<div style="margin-top: 15px;" class="form-group validated col-sm-2 col-lg-2">
											<label>Ativo:</label>

											<div class="switch switch-outline switch-info">
												<label class="">
													<input @if(isset($evento->status) && $evento->status) checked @endisset value="true" name="status" class="red-text" type="checkbox">
													<span class="lever"></span>
												</label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-lg-3 col-md-4 col-sm-6">
											<label class="col-form-label">Data início</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="inicio" class="form-control @if($errors->has('inicio')) is-invalid @endif" readonly value="{{{ isset($evento) ? \Carbon\Carbon::parse($evento->inicio)->format('d/m/Y') : old('inicio') }}}" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
												@if($errors->has('inicio'))
												<div class="invalid-feedback">
													{{ $errors->first('inicio') }}
												</div>
												@endif

											</div>
										</div>
										
										<div class="form-group validated col-lg-3 col-md-4 col-sm-6">
											<label class="col-form-label">Data fim</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="fim" class="form-control @if($errors->has('fim')) is-invalid @endif" readonly value="{{{ isset($evento) ? \Carbon\Carbon::parse($evento->fim)->format('d/m/Y') : old('fim') }}}" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
												@if($errors->has('fim'))
												<div class="invalid-feedback">
													{{ $errors->first('fim') }}
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
								<a style="width: 100%" class="btn btn-danger" href="">
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