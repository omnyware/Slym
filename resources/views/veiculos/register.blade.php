@extends('default.layout')
@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/veiculos/{{{ isset($veiculo) ? 'update' : 'save' }}}">

					<input type="hidden" name="id" value="{{{ isset($veiculo) ? $veiculo->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{isset($veiculo) ? 'Editar' : 'Nova'}} Veiculo</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-4">
											<label class="col-form-label">Placa</label>
											<div class="">
												<input id="placa" type="text" class="form-control @if($errors->has('placa')) is-invalid @endif" name="placa" value="{{{ isset($veiculo) ? $veiculo->placa : old('placa') }}}">
												@if($errors->has('placa'))
												<div class="invalid-feedback">
													{{ $errors->first('placa') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-lg-2 col-md-2 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">UF</label>

											<select class="custom-select form-control" id="sigla_uf" name="uf">
												@foreach($ufs as $u)
												<option @if(isset($veiculo)) @if($u==$veiculo->uf)
													selected
													@endif
													@endisset
													value="{{$u}}">{{$u}}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group validated col-sm-10 col-lg-3">
											<label class="col-form-label">Cor</label>
											<div class="">
												<input id="cor" type="text" class="form-control @if($errors->has('cor')) is-invalid @endif" name="cor" value="{{{ isset($veiculo) ? $veiculo->cor : old('cor') }}}">
												@if($errors->has('cor'))
												<div class="invalid-feedback">
													{{ $errors->first('cor') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-3">
											<label class="col-form-label">Marca</label>
											<div class="">
												<input id="cor" type="text" class="form-control @if($errors->has('marca')) is-invalid @endif" name="marca" value="{{{ isset($veiculo) ? $veiculo->marca : old('marca') }}}">
												@if($errors->has('marca'))
												<div class="invalid-feedback">
													{{ $errors->first('marca') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-sm-10 col-lg-4">
											<label class="col-form-label">Modelo</label>
											<div class="">
												<input id="cor" type="text" class="form-control @if($errors->has('modelo')) is-invalid @endif" name="modelo" value="{{{ isset($veiculo) ? $veiculo->modelo : old('modelo') }}}">
												@if($errors->has('modelo'))
												<div class="invalid-feedback">
													{{ $errors->first('modelo') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-10 col-lg-3">
											<label class="col-form-label">RNTRC</label>
											<div class="">
												<input id="cor" type="text" class="form-control @if($errors->has('rntrc')) is-invalid @endif" name="rntrc" value="{{{ isset($veiculo) ? $veiculo->rntrc : old('rntrc') }}}">
												@if($errors->has('rntrc'))
												<div class="invalid-feedback">
													{{ $errors->first('rntrc') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-lg-4 col-md-6 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Tipo</label>

											<select class="custom-select form-control" id="tipo" name="tipo">
												@foreach($tipos as $key => $t)
												<option @isset($veiculo) @if($key==$veiculo->tipo)
													selected
													@endif
													@endisset
													value="{{$key}}">{{$key}} - {{$t}}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group validated col-lg-4 col-md-6 col-sm-6">
											<label class="col-form-label">Tipo de Carroceria</label>

											<select class="custom-select form-control" id="tipo_carroceira" name="tipo_carroceira">
												@foreach($tiposCarroceria as $key => $t)
												<option @isset($veiculo) @if($key==$veiculo->tipo_carroceira)
													selected
													@endif
													@endisset
													value="{{$key}}">{{$key}} - {{$t}}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group validated col-lg-4 col-md-6 col-sm-6">
											<label class="col-form-label">Tipo de Rodado</label>

											<select class="custom-select form-control" id="tipo_rodado" name="tipo_rodado">
												@foreach($tiposRodado as $key => $t)
												<option @isset($veiculo) @if($key==$veiculo->tipo_rodado)
													selected
													@endif
													@endisset
													value="{{$key}}">{{$key}} - {{$t}}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-3">
											<label class="col-form-label">Tara</label>
											<div class="">
												<input id="tara" type="text" class="form-control @if($errors->has('tara')) is-invalid @endif" name="tara" value="{{{ isset($veiculo) ? $veiculo->tara : old('tara') }}}">
												@if($errors->has('tara'))
												<div class="invalid-feedback">
													{{ $errors->first('tara') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-sm-10 col-lg-3">
											<label class="col-form-label">Capacidade</label>
											<div class="">
												<input id="capacidade" type="text" class="form-control @if($errors->has('capacidade')) is-invalid @endif" name="capacidade" value="{{{ isset($veiculo) ? $veiculo->capacidade : old('capacidade') }}}">
												@if($errors->has('capacidade'))
												<div class="invalid-feedback">
													{{ $errors->first('capacidade') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-6">
											<label class="col-form-label">Nome Proprietário</label>
											<div class="">
												<input id="proprietario_nome" type="text" class="form-control @if($errors->has('proprietario_nome')) is-invalid @endif" name="proprietario_nome" value="{{{ isset($veiculo) ? $veiculo->proprietario_nome : old('proprietario_nome') }}}">
												@if($errors->has('proprietario_nome'))
												<div class="invalid-feedback">
													{{ $errors->first('proprietario_nome') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-lg-2 col-md-2 col-sm-2">
											<label class="col-form-label">Tipo</label>

											<select class="custom-select form-control" id="tipo-prop" name="prop">
												<option value="j">Juridica</option>
												<option value="f">Fisica</option>
											</select>
										</div>
										<div class="form-group validated col-sm-10 col-lg-4">
											<label class="col-form-label tipo-doc">CNPJ Proprietário</label>
											<div class="">
												<input id="proprietario_documento" type="text" class="form-control @if($errors->has('proprietario_documento')) is-invalid @endif" name="proprietario_documento" value="{{{ isset($veiculo) ? $veiculo->proprietario_documento : old('proprietario_documento') }}}">
												@if($errors->has('proprietario_documento'))
												<div class="invalid-feedback">
													{{ $errors->first('proprietario_documento') }}
												</div>
												@endif
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-4">
											<label class="col-form-label tipo-ie">I.E Proprietário</label>
											<div class="">
												<input id="proprietario_ie" type="text" class="form-control @if($errors->has('proprietario_ie')) is-invalid @endif" name="proprietario_ie" value="{{{ isset($veiculo) ? $veiculo->proprietario_ie : old('proprietario_ie') }}}">
												@if($errors->has('proprietario_ie'))
												<div class="invalid-feedback">
													{{ $errors->first('proprietario_ie') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-lg-2 col-md-6 col-sm-6">
											<label class="col-form-label">UF Proprietário</label>

											<select class="custom-select form-control" id="proprietario_uf" name="proprietario_uf">
												@foreach($ufs as $key => $u)
												<option @isset($veiculo) @if($key==$veiculo->proprietario_uf)
													selected
													@endif
													@endisset
													value="{{$key}}">{{$key}} - {{$u}}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group validated col-lg-3 col-md-6 col-sm-6">
											<label class="col-form-label">Tipo do Proprietário</label>

											<select class="custom-select form-control" id="proprietario_tp" name="proprietario_tp">
												@foreach($tiposProprietario as $key => $t)
												<option @isset($veiculo) @if($key==$veiculo->proprietario_tp)
													selected
													@endif
													@endisset
													value="{{$key}}">{{$key}} - {{$t}}</option>
												@endforeach
											</select>
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
						<a style="width: 100%" class="btn btn-danger" href="/veiculos">
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