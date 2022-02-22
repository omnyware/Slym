@extends('default.layout')
@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/empresas/save">

					<input type="hidden" name="id" value="{{{ isset($funcionario) ? $funcionario->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">Cadastrar Empresa</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">


									<div class="row">

										<div class="form-group validated col-sm-3 col-lg-4">
											<label class="col-form-label" id="lbl_cpf_cnpj">CNPJ</label>
											<div class="">
												<input type="text" id="cnpj" class="form-control @if($errors->has('cnpj')) is-invalid @endif" name="cnpj" value="{{ old('cnpj') }}">
												@if($errors->has('cpf_cnpj'))
												<div class="invalid-feedback">
													{{ $errors->first('cpf_cnpj') }}
												</div>
												@endif
											</div>
										</div>
										
										<div class="form-group validated col-lg-2 col-md-2 col-sm-6">
											<br><br>
											<a type="button" id="consulta" class="btn btn-success spinner-white spinner-right">
												<span>
													<i class="fa fa-search"></i>
												</span>
											</a>
										</div>

									</div>
									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-10">
											<label class="col-form-label">Nome</label>
											<div class="">
												<input id="nome" type="text" class="form-control @if($errors->has('nome')) is-invalid @endif" name="nome" value="{{ old('nome') }}">
												@if($errors->has('nome'))
												<div class="invalid-feedback">
													{{ $errors->first('nome') }}
												</div>
												@endif
											</div>
										</div>
									</div>




									<div class="row">

										<div class="form-group validated col-sm-6 col-lg-6">
											<label class="col-form-label" id="lbl_ie_rg">Rua</label>
											<div class="">
												<input type="text" id="rua" class="form-control @if($errors->has('rua')) is-invalid @endif" name="rua" value="{{ old('rua') }}">
												@if($errors->has('rua'))
												<div class="invalid-feedback">
													{{ $errors->first('rua') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-3 col-lg-2">
											<label class="col-form-label" id="lbl_ie_rg">Nº</label>
											<div class="">
												<input type="text" id="numero" class="form-control @if($errors->has('numero')) is-invalid @endif" name="numero" value="{{ old('numero') }}">
												@if($errors->has('numero'))
												<div class="invalid-feedback">
													{{ $errors->first('numero') }}
												</div>
												@endif
											</div>
										</div>

									</div>

									<div class="row">
										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label" id="lbl_ie_rg">Bairro</label>
											<div class="">
												<input type="text" id="bairro" class="form-control @if($errors->has('bairro')) is-invalid @endif" name="bairro" value="{{ old('bairro') }}">
												@if($errors->has('bairro'))
												<div class="invalid-feedback">
													{{ $errors->first('bairro') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label" id="lbl_ie_rg">Cidade</label>
											<div class="">
												<input type="text" id="cidade" class="form-control @if($errors->has('cidade')) is-invalid @endif" name="cidade" value="{{ old('cidade') }}">
												@if($errors->has('cidade'))
												<div class="invalid-feedback">
													{{ $errors->first('cidade') }}
												</div>
												@endif
											</div>
										</div>

									</div>

									<div class="row">
										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label" id="lbl_ie_rg">Email</label>
											<div class="">
												<input type="text" id="email" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email') }}">
												@if($errors->has('email'))
												<div class="invalid-feedback">
													{{ $errors->first('email') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label" id="lbl_ie_rg">Telefone</label>
											<div class="">
												<input type="text" id="telefone" class="form-control @if($errors->has('telefone')) is-invalid @endif telefone" name="telefone" value="{{ old('telefone') }}">
												@if($errors->has('telefone'))
												<div class="invalid-feedback">
													{{ $errors->first('telefone') }}
												</div>
												@endif
											</div>
										</div>

									</div>

									<hr>

									<div class="row">
										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label" id="lbl_ie_rg">Login</label>
											<div class="">
												<input type="text" id="login" class="form-control @if($errors->has('login')) is-invalid @endif" name="login" value="{{ old('login') }}">
												@if($errors->has('login'))
												<div class="invalid-feedback">
													{{ $errors->first('login') }}
												</div>
												@endif
											</div>
										</div>


										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label" id="lbl_ie_rg">Senha</label>
											<div class="">
												<input type="password" id="senha" class="form-control @if($errors->has('senha')) is-invalid @endif" name="senha" value="{{old('senha')}}">
												@if($errors->has('senha'))
												<div class="invalid-feedback">
													{{ $errors->first('senha') }}
												</div>
												@endif
											</div>
										</div>



										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label" id="lbl_ie_rg">Nome usuário</label>
											<div class="">
												<input type="text" id="nome_usuario" class="form-control @if($errors->has('nome_usuario')) is-invalid @endif" name="nome_usuario" value="{{old('nome_usuario')}}">
												@if($errors->has('nome_usuario'))
												<div class="invalid-feedback">
													{{ $errors->first('nome_usuario') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-12">

											<label class="col-3 col-form-label">Permissão de Acesso:</label>
											<input type="hidden" id="menus" value="{{json_encode($menu)}}" name="">
											@foreach($menu as $m)
											
											<div class="col-12 col-form-label">
												<span>
													<label class="checkbox checkbox-info">
														<input id="todos_{{$m['titulo']}}" onclick="marcarTudo('{{$m['titulo']}}')" type="checkbox" >
														<span></span><strong class="text-info" style="margin-left: 5px; font-size: 16px;">{{strtoupper($m['titulo'])}} </strong>
													</label>
												</span>
												<div class="checkbox-inline" style="margin-top: 10px;">
													@foreach($m['subs'] as $s)
													<label class="checkbox checkbox-info check-sub">
														<input id="sub_{{str_replace('/', 	'', $s['rota'])}}" type="checkbox" name="{{$s['nome']}}">
														<span></span>{{$s['nome']}}
													</label>
													@endforeach
												</div>

											</div>

											@endforeach
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