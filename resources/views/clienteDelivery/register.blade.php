@extends('default.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/clientesDelivery/update" enctype="multipart/form-data">
					<input type="hidden" name="id" value="{{$cliente->id}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">Editar cliente delivery</h3>
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
											<label class="col-form-label">Nome</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('nome')) is-invalid @endif" name="nome" value="{{$cliente->nome}}">
												@if($errors->has('nome'))
												<div class="invalid-feedback">
													{{ $errors->first('nome') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">Sobre nome</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('sobre_nome')) is-invalid @endif" name="sobre_nome" value="{{$cliente->sobre_nome}}">
												@if($errors->has('sobre_nome'))
												<div class="invalid-feedback">
													{{ $errors->first('sobre_nome') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">Email</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{$cliente->email}}">
												@if($errors->has('email'))
												<div class="invalid-feedback">
													{{ $errors->first('email') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">Celular</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('celular')) is-invalid @endif" name="celular" value="{{$cliente->celular}}">
												@if($errors->has('celular'))
												<div class="invalid-feedback">
													{{ $errors->first('celular') }}
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