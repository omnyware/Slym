@extends('default.layout')
@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/funcionarios/{{{ isset($funcionario) ? 'update' : 'save' }}}">

					<input type="hidden" name="id" value="{{{ isset($funcionario) ? $funcionario->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{isset($funcionarios) ? 'Editar' : 'Novo'}} Funcionário</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">


									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-10">
											<label class="col-form-label">Nome</label>
											<div class="">
												<input id="nome" type="text" class="form-control @if($errors->has('nome')) is-invalid @endif" name="nome" value="{{{ isset($funcionario) ? $funcionario->nome : old('nome') }}}">
												@if($errors->has('nome'))
												<div class="invalid-feedback">
													{{ $errors->first('nome') }}
												</div>
												@endif
											</div>
										</div>
									</div>




									<div class="row">

										<div class="form-group validated col-sm-3 col-lg-4">
											<label class="col-form-label" id="lbl_ie_rg">CPF</label>
											<div class="">
												<input type="text" id="cpf" class="form-control @if($errors->has('cpf')) is-invalid @endif" name="cpf" value="{{{ isset($funcionario) ? $funcionario->cpf : old('cpf') }}}">
												@if($errors->has('cpf'))
												<div class="invalid-feedback">
													{{ $errors->first('cpf') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-3 col-lg-4">
											<label class="col-form-label" id="lbl_ie_rg">RG</label>
											<div class="">
												<input type="text" id="rg" class="form-control @if($errors->has('rg')) is-invalid @endif" name="rg" value="{{{ isset($funcionario) ? $funcionario->rg : old('rg') }}}">
												@if($errors->has('rg'))
												<div class="invalid-feedback">
													{{ $errors->first('rg') }}
												</div>
												@endif
											</div>
										</div>


									</div>
									<hr>

									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-8">
											<label class="col-form-label">Rua</label>
											<div class="">
												<input id="rua" type="text" class="form-control @if($errors->has('rua')) is-invalid @endif" name="rua" value="{{{ isset($funcionario) ? $funcionario->rua : old('rua') }}}">
												@if($errors->has('rua'))
												<div class="invalid-feedback">
													{{ $errors->first('rua') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-2 col-lg-2">
											<label class="col-form-label">Número</label>
											<div class="">
												<input id="numero" type="text" class="form-control @if($errors->has('numero')) is-invalid @endif" name="numero" value="{{{ isset($funcionario) ? $funcionario->numero : old('numero') }}}">
												@if($errors->has('numero'))
												<div class="invalid-feedback">
													{{ $errors->first('numero') }}
												</div>
												@endif
											</div>
										</div>

									</div>
									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-5">
											<label class="col-form-label">Bairro</label>
											<div class="">
												<input id="bairro" type="text" class="form-control @if($errors->has('bairro')) is-invalid @endif" name="bairro" value="{{{ isset($funcionario) ? $funcionario->bairro : old('bairro') }}}">
												@if($errors->has('bairro'))
												<div class="invalid-feedback">
													{{ $errors->first('bairro') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-sm-8 col-lg-4">
											<label class="col-form-label">Email</label>
											<div class="">
												<input id="email" type="text" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{{ isset($funcionario) ? $funcionario->email : old('email') }}}">
												@if($errors->has('email'))
												<div class="invalid-feedback">
													{{ $errors->first('email') }}
												</div>
												@endif
											</div>
										</div>

									</div>

									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-3">
											<label class="col-form-label">Telefone</label>
											<div class="">
												<input id="telefone" type="text" class="form-control @if($errors->has('telefone')) is-invalid @endif" name="telefone" value="{{{ isset($funcionario) ? $funcionario->telefone : old('telefone') }}}">
												@if($errors->has('telefone'))
												<div class="invalid-feedback">
													{{ $errors->first('telefone') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-8 col-lg-3">
											<label class="col-form-label">Celular</label>
											<div class="">
												<input id="celular" type="text" class="form-control @if($errors->has('celular')) is-invalid @endif" name="celular" value="{{{ isset($funcionario) ? $funcionario->celular : old('celular') }}}">
												@if($errors->has('celular'))
												<div class="invalid-feedback">
													{{ $errors->first('celular') }}
												</div>
												@endif
											</div>
										</div>



										<div class="form-group col-lg-4 col-md-9 col-sm-12">
											<label class="col-form-label">Data de Registro</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="data_registro" class="form-control @if($errors->has('data_registro')) is-invalid @endif" readonly value="{{{ isset($funcionario->data_registro) ? \Carbon\Carbon::parse($funcionario->data_registro)->format('d/m/Y') : old('data_registro') }}}" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
												@if($errors->has('data_registro'))
												<div class="invalid-feedback">
													{{ $errors->first('data_registro') }}
												</div>
												@endif

											</div>
										</div>


									</div>



									<div class="row">
										@if(!isset($funcionario) || $funcionario->usuario_id == NULL)
										<div class="form-group validated col-sm-8 col-lg-5">
											<label class="col-form-label">Usuario (opcional)</label>
											<div class="">
												<select class="form-control custom-select" name="usuario_id">
													<option value="NULL">--</option>

													@foreach($usuarios as $u)
													<option 
													@if(isset($funcionario))
													@if($funcionario->usuario_id == $u->id)
													selected
													@endif
													@endif
													value="{{$u->id}}">{{$u->nome}}</option>
													@endforeach
												</select>
											</div>
										</div>
										@else
										<div class="form-group validated col-sm-8 col-lg-5">
											<label class="col-form-label">Usuario: 
												<strong class="text-info">{{$funcionario->usuario->nome}}</strong>
											</label>
										</div>
										@endif

										<div class="form-group validated col-sm-8 col-lg-3">
											<label class="col-form-label">Percentual de comissão</label>
											<div class="">
												<input id="percentual_comissao" type="text" class="form-control @if($errors->has('percentual_comissao')) is-invalid @endif money" name="percentual_comissao" value="{{{ isset($funcionario) ? $funcionario->percentual_comissao : old('percentual_comissao') }}}">
												@if($errors->has('percentual_comissao'))
												<div class="invalid-feedback">
													{{ $errors->first('percentual_comissao') }}
												</div>
												@endif
											</div>
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