@extends('default.layout')
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="{{{ isset($codigo) ? '/codigoDesconto/update': '/codigoDesconto/save' }}}">
					<input type="hidden" name="id" value="{{{isset($codigo) ? $codigo->id : 0}}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{{ isset($codigo) ? "Editar": "Cadastrar" }}} Código de Descotno</h3>
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
											<label class="col-form-label">Código</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('codigo')) is-invalid @endif" id="codigoPromocional" name="codigo" value="{{{ isset($codigo) ? $codigo->codigo : old('codigo') }}}">
												@if($errors->has('codigo'))
												<div class="invalid-feedback">
													{{ $errors->first('codigo') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-lg-2 col-md-2 col-sm-6">
											<br><br>
											<a type="button" id="gerar-codigo" class="btn btn-success spinner-white spinner-right">
												<span>
													<i class="fa fa-key"></i>
												</span>
											</a>
										</div>

									</div>

									

									<div class="row">
										<div class="form-group validated col-sm-3 col-lg-3 col-6">
											<label class="col-form-label">Tipo</label>
											<div class="">
												<select class="custom-select form-control" id="tipo" name="tipo">
													<option value="valor">Valor R$</option>
													<option value="percentual">Percentual %</option>
												</select>
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">Valor</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('referencia')) is-invalid @endif money" name="valor" value="{{{ isset($codigo) ? number_format($codigo->valor, 2) : old('valor') }}}" >
												@if($errors->has('valor'))
												<div class="invalid-feedback">
													{{ $errors->first('valor') }}
												</div>
												@endif
											</div>
										</div>
									</div>


									<div class="row">

										@isset($codigo)
										@if($codigo->cliente)
										<p class="text-danger">Notificaçao para cliente 
											<strong>{{$codigo->cliente->nome}}</strong>
										</p><br>

										@else
										<p class="red-text">Notificaçao para todos os clientes</p><br>
										@endif
										@endisset

										@if(!isset($codigo))
										<div class="form-group validated col-12 col-lg-3 col-md-6">
											Todos os Clientes
											<div class="switch switch-outline switch-success">
												<label class="">

													<input id="todos" name="todos" class="red-text" type="checkbox">
													<span class="lever"></span>

												</label>
											</div>
										</div>

										<div class="form-group validated col-12 col-lg-6 col-md-6">
											<label class="col-form-label" id="">Cliente</label><br>
											<select class="form-control select2" style="width: 100%" id="kt_select2_1" name="cli">
												<option value="null">Selecione o cliente</option>
												@foreach($clientes as $c)
												<option 
												value="{{$c->id}}">{{$c->id}} - {{$c->nome}}</option>
												@endforeach
											</select>

										</div>

										@endisset


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
								<a style="width: 100%" class="btn btn-danger" href="/codigoDesconto">
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