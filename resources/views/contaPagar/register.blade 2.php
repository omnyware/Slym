@extends('default.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="{{{ isset($conta) ? '/contasPagar/update': '/contasPagar/save' }}}" enctype="multipart/form-data">


					<input type="hidden" name="id" value="{{{ isset($conta) ? $conta->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{{ isset($conta) ? "Editar": "Cadastrar" }}} Conta a Pagar</h3>
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
											<label class="col-form-label">Referencia</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('referencia')) is-invalid @endif" name="referencia" value="{{{ isset($conta) ? $conta->referencia : old('referencia') }}}">
												@if($errors->has('referencia'))
												<div class="invalid-feedback">
													{{ $errors->first('referencia') }}
												</div>
												@endif
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group validated col-lg-4 col-md-4 col-sm-6">
											<label class="col-form-label">Categoria</label>

											<select class="custom-select form-control" id="categoria_id" name="categoria_id">
												@foreach($categorias as $cat)
												<option value="{{$cat->id}}" @isset($conta)
													@if($cat->id == $conta->categoria_id)
													selected
													@endif
													@endisset >{{$cat->nome}}
												</option>

												@endforeach

											</select>

										</div>

										<div class="form-group col-lg-4 col-md-9 col-sm-12">
											<label class="col-form-label">Data de vencimento</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="vencimento" class="form-control @if($errors->has('vencimento')) is-invalid @endif" readonly value="{{{ isset($conta) ? \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') : old('vencimento') }}}" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
												@if($errors->has('vencimento'))
												<div class="center-align red lighten-2">
													<span class="white-text">{{ $errors->first('vencimento') }}</span>
												</div>
												@endif

											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-lg-4 col-md-4 col-sm-6">
											<label class="col-form-label">Valor</label>

											<input type="text" class="form-control @if($errors->has('valor')) is-invalid @endif money" name="valor" value="{{{ isset($conta) ? $conta->valor_integral : old('valor') }}}">
											@if($errors->has('valor'))
											<div class="invalid-feedback">
												{{ $errors->first('valor') }}
											</div>
											@endif

										</div>

										@if(!isset($conta))
										<div class="form-group col-lg-4 col-md-9 col-sm-12">
											<label class="col-form-label">Conta Paga</label>
											
											<div class="col-lg-12 col-xl-12">
												<span class="switch switch-outline switch-success">
													<label>
														<input @if(isset($conta) && $conta->status) checked 
														@endif type="checkbox" id="pago" name="status" type="checkbox" id="status">
														<span></span>
													</label>
												</span>

											</div>

										</div>
										@endif
									</div>

									@if(!isset($conta))
									<div class="row">

										

										<div class="form-group validated col-lg-4 col-md-4 col-sm-6">
											<label class="col-form-label">Salvar até este mês (opcional) </label>

											<input placeholder="mm/aa" type="text" class="form-control @if($errors->has('recorrencia')) is-invalid @endif" id="recorrencia" name="recorrencia" >
											@if($errors->has('recorrencia'))
											<div class="invalid-feedback">
												{{ $errors->first('recorrencia') }}
											</div>
											@endif
											<p style="color: red; margin-top: 5px;"> *Este campo deve ser preenchido se ouver recorrência para este registro
										</p>
										</div>
										


									</div>

									@endif
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
