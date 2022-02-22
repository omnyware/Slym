@extends('default.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="{{{ isset($tamanho) ? '/tamanhosPizza/update': '/tamanhosPizza/save' }}}">
					<input type="hidden" name="id" value="{{{ isset($tamanho->id) ? $tamanho->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{isset($tamanho) ? 'Editar' : 'Novo'}} Tamanho de Pizza</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-8">
											<label class="col-form-label">Nome</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('nome')) is-invalid @endif" name="nome" value="{{{ isset($tamanho) ? $tamanho->nome : old('nome') }}}">
												@if($errors->has('nome'))
												<div class="invalid-feedback">
													{{ $errors->first('nome') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-4 col-lg-4 col-6">
											<label class="col-form-label">Pedaços</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('pedacos')) is-invalid @endif" name="pedacos" value="{{{ isset($tamanho) ? $tamanho->pedacos : old('pedacos') }}}">
												@if($errors->has('pedacos'))
												<div class="invalid-feedback">
													{{ $errors->first('pedacos') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-sm-4 col-lg-4 col-6">
											<label class="col-form-label">Maximo de sabores</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('maximo_sabores')) is-invalid @endif" name="maximo_sabores" value="{{{ isset($tamanho) ? $tamanho->maximo_sabores : old('maximo_sabores') }}}">
												@if($errors->has('maximo_sabores'))
												<div class="invalid-feedback">
													{{ $errors->first('maximo_sabores') }}
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
								<a style="width: 100%" class="btn btn-danger" href="/tamanhosPizza">
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