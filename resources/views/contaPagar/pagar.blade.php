@extends('default.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/contasPagar/pagar" enctype="multipart/form-data">


					<input type="hidden" name="id" value="{{$conta->id}}">

					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">Pagar Conta</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">

							<div class="row">
								<div class="col s12">
									@if($conta->compra_id != null)
									<h5>Fornecedor: <strong>{{$conta->compra->fornecedor->razao_social}}</strong></h5>
									@endif

									<h5>Data de registro: <strong>{{ \Carbon\Carbon::parse($conta->data_registro)->format('d/m/Y')}}</strong></h5>
									<h5>Data de vencimento: <strong>{{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y')}}</strong></h5>
									<h5>Valor: <strong>{{ number_format($conta->valor_integral, 2, ',', '.') }}</strong></h5>
									<h5>Categoria: <strong>{{$conta->categoria->nome}}</strong></h5>
									<h5>Referencia: <strong>{{$conta->referencia}}</strong></h5>
								</div>
							</div>

							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">
										<div class="form-group validated col-sm-6 col-lg-6">
											<label class="col-form-label">Valor Pago</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('valor')) is-invalid @endif money" name="valor" value="">
												@if($errors->has('valor'))
												<div class="invalid-feedback">
													{{ $errors->first('valor') }}
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
								<a style="width: 100%" class="btn btn-danger" href="/contasPagar">
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