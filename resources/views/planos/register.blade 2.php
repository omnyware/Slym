@extends('default.layout')
@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="{{{ isset($plano) ? '/planos/update': '/planos/save' }}}">

					<input type="hidden" name="id" value="{{{ isset($plano) ? $plano->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{isset($plano) ? 'Editar' : 'Novo'}} Plano</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">


									<div class="row">
										<div class="form-group validated col-sm-5 col-lg-5">
											<label class="col-form-label">Nome</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('nome')) is-invalid @endif" name="nome" value="{{{ isset($plano) ? $plano->nome : old('nome') }}}">
												@if($errors->has('nome'))
												<div class="invalid-feedback">
													{{ $errors->first('nome') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">Valor</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('valor')) is-invalid @endif money" name="valor" value="{{{ isset($plano) ? $plano->valor : old('valor') }}}">
												@if($errors->has('valor'))
												<div class="invalid-feedback">
													{{ $errors->first('valor') }}
												</div>
												@endif
											</div>
										</div>
									</div>
									<p class="text-danger">-1 = Infinito</p>

									<div class="row">
										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">Max. Clientes</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('maximo_clientes')) is-invalid @endif" name="maximo_clientes" value="{{{ isset($plano) ? $plano->maximo_clientes : old('maximo_clientes') }}}">
												@if($errors->has('maximo_clientes'))
												<div class="invalid-feedback">
													{{ $errors->first('maximo_clientes') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">Max. Produtos</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('maximo_produtos')) is-invalid @endif" name="maximo_produtos" value="{{{ isset($plano) ? $plano->maximo_produtos : old('maximo_produtos') }}}">
												@if($errors->has('maximo_produtos'))
												<div class="invalid-feedback">
													{{ $errors->first('maximo_produtos') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">Max. Fornecedores</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('maximo_fornecedores')) is-invalid @endif" name="maximo_fornecedores" value="{{{ isset($plano) ? $plano->maximo_fornecedores : old('maximo_fornecedores') }}}">
												@if($errors->has('maximo_fornecedores'))
												<div class="invalid-feedback">
													{{ $errors->first('maximo_fornecedores') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">Max. NFe</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('maximo_nfes')) is-invalid @endif" name="maximo_nfes" value="{{{ isset($plano) ? $plano->maximo_nfes : old('maximo_nfes') }}}">
												@if($errors->has('maximo_nfes'))
												<div class="invalid-feedback">
													{{ $errors->first('maximo_nfes') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">Max. NFCe</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('maximo_nfces')) is-invalid @endif" name="maximo_nfces" value="{{{ isset($plano) ? $plano->maximo_nfces : old('maximo_nfces') }}}">
												@if($errors->has('maximo_nfces'))
												<div class="invalid-feedback">
													{{ $errors->first('maximo_nfces') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">Max. CTe</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('maximo_cte')) is-invalid @endif" name="maximo_cte" value="{{{ isset($plano) ? $plano->maximo_cte : old('maximo_cte') }}}">
												@if($errors->has('maximo_cte'))
												<div class="invalid-feedback">
													{{ $errors->first('maximo_cte') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">Max. MDFe</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('maximo_mdfe')) is-invalid @endif" name="maximo_mdfe" value="{{{ isset($plano) ? $plano->maximo_mdfe : old('maximo_mdfe') }}}">
												@if($errors->has('maximo_mdfe'))
												<div class="invalid-feedback">
													{{ $errors->first('maximo_mdfe') }}
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
								<a style="width: 100%" class="btn btn-danger" href="/funcionarios">
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