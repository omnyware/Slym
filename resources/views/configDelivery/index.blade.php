@extends('default.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/configDelivery/save" enctype="multipart/form-data">
					<input type="hidden" name="id" value="{{{ isset($config->id) ? $config->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{{ isset($config) ? "Editar": "Cadastrar" }}} Configuração de Delivery</h3>
						</div>

					</div>
					@csrf
					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-10 col-12">
											<label class="col-form-label">Link do Facebook</label>
											<div class="">
												<input id="link_face" type="text" class="form-control @if($errors->has('link_face')) is-invalid @endif" name="link_face" value="{{{ isset($config) ? $config->link_face : old('link_face') }}}">
												@if($errors->has('link_face'))
												<div class="invalid-feedback">
													{{ $errors->first('link_face') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-10 col-12">
											<label class="col-form-label">Link do Twiter</label>
											<div class="">
												<input id="link_twiteer" type="text" class="form-control @if($errors->has('link_twiteer')) is-invalid @endif" name="link_twiteer" value="{{{ isset($config) ? $config->link_twiteer : old('link_twiteer') }}}">
												@if($errors->has('link_twiteer'))
												<div class="invalid-feedback">
													{{ $errors->first('link_twiteer') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-10 col-12">
											<label class="col-form-label">Link do Google</label>
											<div class="">
												<input id="link_google" type="text" class="form-control @if($errors->has('link_google')) is-invalid @endif" name="link_google" value="{{{ isset($config) ? $config->link_google : old('link_google') }}}">
												@if($errors->has('link_google'))
												<div class="invalid-feedback">
													{{ $errors->first('link_google') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-10 col-12">
											<label class="col-form-label">Link do Instagram</label>
											<div class="">
												<input id="link_instagram" type="text" class="form-control @if($errors->has('link_instagram')) is-invalid @endif" name="link_instagram" value="{{{ isset($config) ? $config->link_instagram : old('link_instagram') }}}">
												@if($errors->has('link_instagram'))
												<div class="invalid-feedback">
													{{ $errors->first('link_instagram') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-10 col-12">
											<label class="col-form-label">Endereço</label>
											<div class="">
												<input id="endereco" type="text" class="form-control @if($errors->has('endereco')) is-invalid @endif" name="endereco" value="{{{ isset($config) ? $config->endereco : old('endereco') }}}">
												@if($errors->has('endereco'))
												<div class="invalid-feedback">
													{{ $errors->first('endereco') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-6 col-lg-6 col-12">
											<label class="col-form-label">Telefone</label>
											<div class="">
												<input id="telefone" type="text" class="form-control @if($errors->has('telefone')) is-invalid @endif" name="telefone" value="{{{ isset($config) ? $config->telefone : old('telefone') }}}">
												@if($errors->has('telefone'))
												<div class="invalid-feedback">
													{{ $errors->first('telefone') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-4 col-lg-4 col-6">
											<label class="col-form-label">Tempo Medio de Entrega</label>
											<div class="">
												<input id="tempo_medio_entrega" type="text" class="form-control @if($errors->has('tempo_medio_entrega')) is-invalid @endif" name="tempo_medio_entrega" value="{{{ isset($config) ? $config->tempo_medio_entrega : old('tempo_medio_entrega') }}}">
												@if($errors->has('tempo_medio_entrega'))
												<div class="invalid-feedback">
													{{ $errors->first('tempo_medio_entrega') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4 col-6">
											<label class="col-form-label">Valor de Entrega Padrão</label>
											<div class="">
												<input id="valor_entrega" type="text" class="form-control @if($errors->has('valor_entrega')) is-invalid @endif" name="valor_entrega" value="{{{ isset($config) ? $config->valor_entrega : old('valor_entrega') }}}">
												@if($errors->has('valor_entrega'))
												<div class="invalid-feedback">
													{{ $errors->first('valor_entrega') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-4 col-lg-4 col-6">
											<label class="col-form-label">Máximo de adicionais</label>
											<div class="">
												<input id="maximo_adicionais" type="text" class="form-control @if($errors->has('maximo_adicionais')) is-invalid @endif" name="maximo_adicionais" value="{{{ isset($config) ? $config->maximo_adicionais : old('maximo_adicionais') }}}">
												@if($errors->has('maximo_adicionais'))
												<div class="invalid-feedback">
													{{ $errors->first('maximo_adicionais') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-sm-4 col-lg-4 col-6">
											<label class="col-form-label">Máximo de adicionais pizza</label>
											<div class="">
												<input id="maximo_adicionais_pizza" type="text" class="form-control @if($errors->has('maximo_adicionais_pizza')) is-invalid @endif" name="maximo_adicionais_pizza" value="{{{ isset($config) ? $config->maximo_adicionais_pizza : old('maximo_adicionais_pizza') }}}">
												@if($errors->has('maximo_adicionais_pizza'))
												<div class="invalid-feedback">
													{{ $errors->first('maximo_adicionais_pizza') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-4 col-lg-4 col-6">
											<label class="col-form-label">Valor KM entrega</label>
											<div class="">
												<input id="valor_km" type="text" class="form-control @if($errors->has('valor_km')) is-invalid @endif" name="valor_km" value="{{{ isset($config) ? $config->valor_km : old('valor_km') }}}">
												@if($errors->has('valor_km'))
												<div class="invalid-feedback">
													{{ $errors->first('valor_km') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-sm-4 col-lg-4 col-6">
											<label class="col-form-label">Maximo KM entrega</label>
											<div class="">
												<input id="maximo_km_entrega" type="text" class="form-control @if($errors->has('maximo_km_entrega')) is-invalid @endif" name="maximo_km_entrega" value="{{{ isset($config) ? $config->maximo_km_entrega : old('maximo_km_entrega') }}}">
												@if($errors->has('maximo_km_entrega'))
												<div class="invalid-feedback">
													{{ $errors->first('maximo_km_entrega') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-sm-4 col-lg-4 col-6">
											<label class="col-form-label">Usar Bairros</label>
											<div class="">
												<span class="switch switch-outline switch-success">
													<label>
														<input @if(isset($config->usar_bairros) && $config->usar_bairros) checked @endisset value="true" name="usar_bairros" class="red-text" type="checkbox">
														<span></span>
													</label>
												</span>
											</div>
										</div>
									</div>
									<div class="row">

										<div class="form-group validated col-sm-6 col-lg-6 col-10">
											<label class="col-form-label">Tempo para Cancelamento HH:mm</label>
											<div class="">
												<input id="tempo_maximo_cancelamento" type="text" class="form-control @if($errors->has('tempo_maximo_cancelamento')) is-invalid @endif" name="tempo_maximo_cancelamento" value="{{{ isset($config) ? $config->tempo_maximo_cancelamento : old('tempo_maximo_cancelamento') }}}">
												@if($errors->has('tempo_maximo_cancelamento'))
												<div class="invalid-feedback">
													{{ $errors->first('tempo_maximo_cancelamento') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-6 col-lg-6 col-10">
											<label class="col-form-label">Nome exibição WEB</label>
											<div class="">
												<input id="nome_exibicao_web" type="text" class="form-control @if($errors->has('nome_exibicao_web')) is-invalid @endif" name="nome_exibicao_web" value="{{{ isset($config) ? $config->nome_exibicao_web : old('nome_exibicao_web') }}}">
												@if($errors->has('nome_exibicao_web'))
												<div class="invalid-feedback">
													{{ $errors->first('nome_exibicao_web') }}
												</div>
												@endif
												<p class="text-danger">Utilize duas palavras</p>

											</div>
										</div>

									</div>

									<div class="row">

										<div class="form-group validated col-sm-4 col-lg-4 col-6">
											<label class="col-form-label">Latitude</label>
											<div class="">
												<input id="latitude" type="text" class="form-control @if($errors->has('latitude')) is-invalid @endif" name="latitude" value="{{{ isset($config) ? $config->latitude : old('latitude') }}}">
												@if($errors->has('latitude'))
												<div class="invalid-feedback">
													{{ $errors->first('latitude') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4 col-6">
											<label class="col-form-label">Longitude</label>
											<div class="">
												<input id="longitude" type="text" class="form-control @if($errors->has('longitude')) is-invalid @endif" name="longitude" value="{{{ isset($config) ? $config->longitude : old('longitude') }}}">
												@if($errors->has('longitude'))
												<div class="invalid-feedback">
													{{ $errors->first('longitude') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-12 col-lg-12 col-12">
											<label class="col-form-label">Politica de privacidade</label>
											<div class="">
												<textarea class="form-control" name="descricao" placeholder="Descrição" rows="3">{{{ isset($config->politica_privacidade) ? $config->politica_privacidade : old('politica_privacidade') }}}</textarea>
												@if($errors->has('politica_privacidade'))
												<div class="invalid-feedback">
													{{ $errors->first('politica_privacidade') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-4 col-lg-4 col-6">
											<label class="col-xl-12 col-lg-12 col-form-label text-left">Imagem 60x60</label>
											<div class="col-lg-10 col-xl-6">

												<div class="image-input image-input-outline" id="kt_image_1">
													<div class="image-input-wrapper"  style="background-image: url(/images/logo.png)" ></div>
													<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
														<i class="fa fa-pencil icon-sm text-muted"></i>
														<input type="file" name="file" accept=".png, .jpg, .jpeg">
														<input type="hidden" name="profile_avatar_remove">
													</label>
													<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel avatar">
														<i class="fa fa-close icon-xs text-muted"></i>
													</span>
												</div>


												<span class="form-text text-muted">.png, .jpg, .jpeg</span>
												@if($errors->has('file'))
												<div class="invalid-feedback">
													{{ $errors->first('file') }}
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