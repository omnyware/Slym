@extends('default.layout')
@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/clientes/{{{ isset($cliente) ? 'update' : 'save' }}}">

					<input type="hidden" name="id" value="{{{ isset($cliente) ? $cliente->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{isset($cliente) ? 'Editar' : 'Novo'}} Cliente</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">
										<div class="form-group col-sm-12 col-lg-12">
											<label>Pessoa:</label>
											<div class="radio-inline">
												<label class="radio radio-success">
													<input name="group1" type="radio" id="pessoaFisica" @if(isset($cliente)) @if(strlen($cliente->cpf_cnpj)
													< 15) checked @endif @endif />
													<span></span>
													FISICA
												</label>
												<label class="radio radio-success">
													<input name="group1" type="radio" id="pessoaJuridica" @if(isset($cliente)) @if(strlen($cliente->cpf_cnpj) > 15) checked @endif @endif/>
													<span></span>
													JURIDICA
												</label>

											</div>

										</div>
									</div>
									<div class="row">

										<div class="form-group validated col-sm-3 col-lg-4">
											<label class="col-form-label" id="lbl_cpf_cnpj">CPF</label>
											<div class="">
												<input type="text" id="cpf_cnpj" class="form-control @if($errors->has('cpf_cnpj')) is-invalid @endif" name="cpf_cnpj" value="{{{ isset($cliente) ? $cliente->cpf_cnpj : old('cpf_cnpj') }}}">
												@if($errors->has('cpf_cnpj'))
												<div class="invalid-feedback">
													{{ $errors->first('cpf_cnpj') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-lg-2 col-md-2 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">UF</label>

											<select class="custom-select form-control" id="sigla_uf" name="sigla_uf">
												@foreach($estados as $c)
												<option @if(isset($cliente)) @if($cliente->cidade->uf == $c) selected @endif @endif value="{{$c}}">{{$c}}</option>
												@endforeach
											</select>

										</div>
										<div class="form-group validated col-lg-2 col-md-2 col-sm-6">
											<br><br>
											<a type="button" id="btn-consulta-cadastro" onclick="consultaCadastro()" class="btn btn-success spinner-white spinner-right">
												<span>
													<i class="fa fa-search"></i>
												</span>
											</a>
										</div>

									</div>

									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-10">
											<label class="col-form-label">Razao Social/Nome</label>
											<div class="">
												<input id="razao_social" type="text" class="form-control @if($errors->has('razao_social')) is-invalid @endif" name="razao_social" value="{{{ isset($cliente) ? $cliente->razao_social : old('razao_social') }}}">
												@if($errors->has('razao_social'))
												<div class="invalid-feedback">
													{{ $errors->first('razao_social') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-10">
											<label class="col-form-label">Nome Fantasia</label>
											<div class="">
												<input id="nome_fantasia" type="text" class="form-control @if($errors->has('nome_fantasia')) is-invalid @endif" name="nome_fantasia" value="{{{ isset($cliente) ? $cliente->nome_fantasia : old('nome_fantasia') }}}">
												@if($errors->has('nome_fantasia'))
												<div class="invalid-feedback">
													{{ $errors->first('nome_fantasia') }}
												</div>
												@endif
											</div>
										</div>
									</div>


									<div class="row">

										<div class="form-group validated col-sm-3 col-lg-4">
											<label class="col-form-label" id="lbl_ie_rg">RG</label>
											<div class="">
												<input type="text" id="ie_rg" class="form-control @if($errors->has('ie_rg')) is-invalid @endif" name="ie_rg" value="{{{ isset($cliente) ? $cliente->ie_rg : old('ie_rg') }}}">
												@if($errors->has('ie_rg'))
												<div class="invalid-feedback">
													{{ $errors->first('ie_rg') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-lg-3 col-md-3 col-sm-10">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Consumidor Final</label>

											<select class="custom-select form-control" id="consumidor_final" name="consumidor_final">
												<option value=""></option>
												<option @if(isset($cliente) && $cliente->consumidor_final == 1) selected @endif value="1" @if(old('consumidor_final') == 1) selected @endif selected>SIM</option>
												<option @if(isset($cliente) && $cliente->consumidor_final == 0)
													selected @endif value="0" @if(old('consumidor_final') == 0) @endif>NAO</option>
											</select>
											@if($errors->has('consumidor_final'))
											<div class="invalid-feedback">
												{{ $errors->first('consumidor_final') }}
											</div>
											@endif

										</div>

										<div class="form-group validated col-lg-3 col-md-3 col-sm-10">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Contribuinte</label>

											<select class="custom-select form-control" id="contribuinte" name="contribuinte">
												<option value=""></option>
												<option @if(isset($cliente) && $cliente->contribuinte == 1)
													selected @endif value="1" @if(old('contribuinte') == 1) selected @endif selected>SIM</option>
												<option @if(isset($cliente) && $cliente->contribuinte == 0)
													selected @endif value="0" @if(old('contribuinte') == 0) @endif>NAO</option>
											</select>
											@if($errors->has('contribuinte'))
											<div class="invalid-feedback">
												{{ $errors->first('contribuinte') }}
											</div>
											@endif

										</div>

										<div class="form-group validated col-sm-3 col-lg-4">
											<label class="col-form-label" id="lbl_ie_rg">Limite de Venda</label>
											<div class="">
												<input type="text" id="limite_venda" class="form-control @if($errors->has('limite_venda')) is-invalid @endif money" name="limite_venda" value="{{{ isset($cliente) ? $cliente->limite_venda : old('limite_venda') }}}">
												@if($errors->has('limite_venda'))
												<div class="invalid-feedback">
													{{ $errors->first('limite_venda') }}
												</div>
												@endif
											</div>
										</div>

									</div>
									<hr>
									<h5>Endereço de Faturamento</h5>
									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-8">
											<label class="col-form-label">Rua</label>
											<div class="">
												<input id="rua" type="text" class="form-control @if($errors->has('rua')) is-invalid @endif" name="rua" value="{{{ isset($cliente) ? $cliente->rua : old('rua') }}}">
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
												<input id="numero" type="text" class="form-control @if($errors->has('numero')) is-invalid @endif" name="numero" value="{{{ isset($cliente) ? $cliente->numero : old('numero') }}}">
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
												<input id="bairro" type="text" class="form-control @if($errors->has('bairro')) is-invalid @endif" name="bairro" value="{{{ isset($cliente) ? $cliente->bairro : old('bairro') }}}">
												@if($errors->has('bairro'))
												<div class="invalid-feedback">
													{{ $errors->first('bairro') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-8 col-lg-3">
											<label class="col-form-label">CEP</label>
											<div class="">
												<input id="cep" type="text" class="form-control @if($errors->has('cep')) is-invalid @endif" name="cep" value="{{{ isset($cliente) ? $cliente->cep : old('cep') }}}">
												@if($errors->has('cep'))
												<div class="invalid-feedback">
													{{ $errors->first('cep') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-4">
											<label class="col-form-label">Email</label>
											<div class="">
												<input id="email" type="text" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{{ isset($cliente) ? $cliente->email : old('email') }}}">
												@if($errors->has('email'))
												<div class="invalid-feedback">
													{{ $errors->first('email') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-lg-6 col-md-6 col-sm-10">
											<label class="col-form-label text-left col-lg-4 col-sm-12">Cidade</label>
											<select class="form-control select2" id="kt_select2_1" name="cidade">
												@foreach($cidades as $c)
												<option value="{{$c->id}}" @isset($cliente) @if($c->id == $cliente->cidade_id)
													selected
													@endif
													@endisset >{{$c->nome}} ({{$c->uf}})</option>
												@endforeach
											</select>
											@if($errors->has('cidade'))
											<div class="invalid-feedback">
												{{ $errors->first('cidade') }}
											</div>
											@endif
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-3">
											<label class="col-form-label">Telefone (Opcional)</label>
											<div class="">
												<input id="telefone" type="text" class="form-control @if($errors->has('telefone')) is-invalid @endif" name="telefone" value="{{{ isset($cliente) ? $cliente->telefone : old('telefone') }}}">
												@if($errors->has('telefone'))
												<div class="invalid-feedback">
													{{ $errors->first('telefone') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-8 col-lg-3">
											<label class="col-form-label">Celular (Opcional)</label>
											<div class="">
												<input id="celular" type="text" class="form-control @if($errors->has('celular')) is-invalid @endif" name="celular" value="{{{ isset($cliente) ? $cliente->celular : old('celular') }}}">
												@if($errors->has('celular'))
												<div class="invalid-feedback">
													{{ $errors->first('celular') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<hr>
									<h5>Endereço de Cobrança (Opcional)</h5>
									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-8">
											<label class="col-form-label">Rua</label>
											<div class="">
												<input id="rua_cobranca" type="text" class="form-control @if($errors->has('rua_cobranca')) is-invalid @endif" name="rua_cobranca" value="{{{ isset($cliente) ? $cliente->rua_cobranca : old('rua_cobranca') }}}">
												@if($errors->has('rua_cobranca'))
												<div class="invalid-feedback">
													{{ $errors->first('rua_cobranca') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-2 col-lg-2">
											<label class="col-form-label">Número</label>
											<div class="">
												<input id="numero_cobranca" type="text" class="form-control @if($errors->has('numero_cobranca')) is-invalid @endif" name="numero_cobranca" value="{{{ isset($cliente) ? $cliente->numero_cobranca : old('numero_cobranca') }}}">
												@if($errors->has('numero_cobranca'))
												<div class="invalid-feedback">
													{{ $errors->first('numero_cobranca') }}
												</div>
												@endif
											</div>
										</div>

									</div>
									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-5">
											<label class="col-form-label">Bairro</label>
											<div class="">
												<input id="bairro_cobranca" type="text" class="form-control @if($errors->has('bairro_cobranca')) is-invalid @endif" name="bairro_cobranca" value="{{{ isset($cliente) ? $cliente->bairro_cobranca : old('bairro_cobranca') }}}">
												@if($errors->has('bairro_cobranca'))
												<div class="invalid-feedback">
													{{ $errors->first('bairro_cobranca') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-8 col-lg-3">
											<label class="col-form-label">CEP</label>
											<div class="">
												<input id="cep_cobranca" type="text" class="form-control @if($errors->has('cep_cobranca')) is-invalid @endif" name="cep_cobranca" value="{{{ isset($cliente) ? $cliente->cep_cobranca : old('cep_cobranca') }}}">
												@if($errors->has('cep_cobranca'))
												<div class="invalid-feedback">
													{{ $errors->first('cep_cobranca') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-lg-6 col-md-6 col-sm-10">
											<label class="col-form-label text-left col-lg-4 col-sm-12">Cidade</label>

											<select class="form-control select2" id="kt_select2_2" name="cidade_cobranca">
												@foreach($cidades as $c)
												<option value="{{$c->id}}" @isset($cliente) @if($c->id == $cliente->cidade_cobranca_id)
													selected
													@endif
													@endisset >{{$c->nome}} ({{$c->uf}})</option>
												@endforeach
											</select>
											@if($errors->has('cidade_cobranca_id'))
											<div class="invalid-feedback">
												{{ $errors->first('cidade_cobranca_id') }}
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
						<a style="width: 100%" class="btn btn-danger" href="/clientes">
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