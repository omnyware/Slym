@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">
		<div class="content d-flex flex-column flex-column-fluid" id="kt_content" >

			<div class="row" id="anime" style="display: none">
				<div class="col s8 offset-s2">
					<lottie-player src="/anime/success.json" background="transparent" speed="0.8" style="width: 100%; height: 300px;" autoplay >
					</lottie-player>
				</div>
			</div>

			<div class="col-lg-12" id="content">
				@if(!isset($mdfe))
				<h1 class="text-success">EMISSÃO DE MDFe</h1>
				@else
				<h1 class="text-success">ALTERAÇÃO DE MDFe</h1>
				@endif

				<h3 class="card-title">DADOS INICIAIS</h3>

				<input type="hidden" id="_token" value="{{csrf_token()}}" name="">
				<div class="row">
					<div class="col-xl-12">

						<div class="kt-section kt-section--first">
							<div class="kt-section__body">

								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-6">
										@if(!isset($mdfe))
										<h6>Ultima MDF-e: <strong>{{$lastMdfe}}</strong></h6>
										@endif
									</div>
									<div class="col-lg-4 col-md-4 col-sm-6">

										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<input type="hidden" value="{{json_encode($cidades)}}" id="cidades">

				<!--  -->
				@if(isset($mdfe))
				<input type="hidden" value="{{$mdfe->id}}" id="mdfe_id">
				<input type="hidden" value="{{$mdfe}}" id="mdfe_c">
				<input type="hidden" value="{{json_encode($municipiosDeCarregamento)}}" id="municipios_hidden">
				<input type="hidden" value="{{json_encode($percurso)}}" id="percurso_hidden">
				<input type="hidden" value="{{json_encode($ciots)}}" id="ciots_hidden">
				<input type="hidden" value="{{json_encode($valesPedagio)}}" id="vales_pedagio_hidden">
				<input type="hidden" value="{{json_encode($infoDescarga)}}" id="info_descarga_hidden">
				@endif
				<!--  -->

				<div class="row">
					<div class="form-group col-lg-2 col-md-2 col-sm-6 col-6">
						<label class="col-form-label">UF Inicial</label>
						<div class="">
							<div class="input-group date">
								<select class="custom-select form-control" id="uf_inicio" name="uf_inicio">
									@foreach($ufs as $key => $u)
									<option value="{{$u}}" @isset($mdfe) @if($mdfe->uf_inicio == $u) selected @endif @endisset>{{$u}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="form-group col-lg-2 col-md-2 col-sm-6 col-6">
						<label class="col-form-label">UF Final</label>
						<div class="">
							<div class="input-group date">
								<select class="custom-select form-control" id="uf_fim" name="uf_fim">
									@foreach($ufs as $key => $u)
									<option value="{{$u}}" @isset($mdfe) @if($mdfe->uf_fim == $u) selected @endif @endisset>{{$u}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					<div class="form-group col-lg-3 col-md-3 col-sm-6 col-6">
						<label class="col-form-label">Data inicio da viagem</label>
						<div class="">
							<div class="input-group date">
								<input type="text" name="data_inicio_viagem" class="form-control" value="@isset($mdfe) {{ \Carbon\Carbon::parse($mdfe->data_inicio_viagem)->format('d/m/Y')}} @endisset" readonly id="kt_datepicker_3" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group col-lg-3 col-md-3 col-sm-6 col-6">
						<label class="col-form-label">Carga Posterior</label>

						<span class="text-danger">
							<div class="switch switch-outline switch-success">
								<label class="">
									<input @isset($mdfe) @if($mdfe->carga_posterior) checked @endif @endisset value="true" name="status" class="red-text" type="checkbox" id="carga_posteior">
									<span class="lever"></span>
								</label>
							</div>
						</span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-lg-4 col-md-4 col-sm-6 col-6">
						<label class="col-form-label">Tipo do emitente</label>
						<div class="">
							<div class="input-group date">
								<select class="custom-select form-control" id="tpEmit" name="tpEmit">
									<option @isset($mdfe) @if($mdfe->tp_emit == 1) selected @endif @endisset value="1">1 - Prestador de serviço de transporte</option>
									<option @isset($mdfe) @if($mdfe->tp_emit == 2) selected @endif @endisset value="2">2 - Transportador de Carga Própria</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group col-lg-3 col-md-3 col-sm-6 col-6">
						<label class="col-form-label">Tipo do transportador</label>
						<div class="">
							<div class="input-group date">
								<select class="custom-select form-control" id="tpTransp" name="tpTransp">
									<option @isset($mdfe) @if($mdfe->tp_transp == 1) selected @endif @endisset value="1">1 - ETC</option>
									<option @isset($mdfe) @if($mdfe->tp_transp == 2) selected @endif @endisset value="2">2 - TAC</option>
									<option @isset($mdfe) @if($mdfe->tp_transp == 3) selected @endif @endisset value="3">3 - CTC</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group col-sm-4 col-lg-3 col-12">
						<label class="col-form-label">Lacre Rodoviário</label>
						<div class="">
							<div class="input-group">
								<input type="text" name="valor_transporte" class="form-control type-ref" value="{{{ isset($mdfe) ? $mdfe->lac_rodo : '' }}}" id="lacre_rodo"/>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-5 col-lg-4 col-12">
						<label class="col-form-label">CNPJ do contratante</label>
						<div class="">
							<div class="input-group">
								<input type="text" name="cnpj_contratante" class="form-control type-ref" value="{{{ isset($mdfe) ? $mdfe->cnpj_contratante : '' }}}" id="cnpj_contratante"/>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-3 col-lg-3 col-12">
						<label class="col-form-label">Quantidade da carga</label>
						<div class="">
							<div class="input-group">
								<input type="text" name="quantidade_carga" class="form-control type-ref" value="{{{ isset($mdfe) ? $mdfe->quantidade_carga : '' }}}" id="quantidade_carga"/>
							</div>
						</div>
					</div>
					<div class="form-group col-sm-3 col-lg-3 col-12">
						<label class="col-form-label">Valor da carga</label>
						<div class="">
							<div class="input-group">
								<input type="text" name="valor_carga" class="form-control type-ref" value="{{{ isset($mdfe) ? $mdfe->valor_carga : '' }}}" id="valor_carga"/>
							</div>
						</div>
					</div>

					<div class="col-12">
						<div class="row">
							<div class="form-group col-lg-4 col-md-4 col-sm-6 col-6">
								<label class="col-form-label">Veiculo de tração</label>
								<div class="">
									<div class="input-group date">
										<select class="custom-select form-control" id="veiculo_tracao" name="veiculo_tracao">
											<option value="null">--</option>
											@foreach($veiculos as $v)
											<option value="{{$v}}" @isset($mdfe) @if($v->id == $mdfe->veiculo_tracao_id) selected @endif @endisset>{{$v->marca}} {{$v->modelo}} - {{$v->placa}}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div id="display-tracao" class="row" style="display: none"><br>
									<div class="card card-custom gutter-b">
										<div class="card-body">

											<h4 class="center-align">Veiculo de Tração Selecionado</h4>

											<div class="card-content">
												<p>Marca: <strong id="tracao_marca"></strong></p>
												<p>Modelo: <strong id="tracao_modelo"></strong></p>
												<p>Placa: <strong id="tracao_placa"></strong></p>
												<p>Proprietário: <strong id="tracao_proprietario_nome"></strong></p>
												<p>Documento Proprietário: <strong id="tracao_proprietario_documento"></strong></p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group col-lg-4 col-md-4 col-sm-6 col-6">
								<label class="col-form-label">Veiculo de reboque</label>
								<div class="">
									<div class="input-group date">
										<select class="custom-select form-control" id="veiculo_reboque" name="veiculo_reboque">
											<option value="null">--</option>
											@foreach($veiculos as $v)
											<option value="{{$v}}" @isset($mdfe) @if($v->id == $mdfe->veiculo_reboque_id) selected @endif @endisset>{{$v->marca}} {{$v->modelo}} - {{$v->placa}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div id="display-reboque" class="row" style="display: none"><br>
									<div class="card card-custom gutter-b">
										<div class="card-body">

											<h4 class="center-align">Veiculo de Reboque Selecionado</h4>

											<div class="card-content">
												<p>Marca: <strong id="reboque_marca"></strong></p>
												<p>Modelo: <strong id="reboque_modelo"></strong></p>
												<p>Placa: <strong id="reboque_placa"></strong></p>
												<p>Proprietário: <strong id="reboque_proprietario_nome"></strong></p>
												<p>Documento Proprietário: <strong id="reboque_proprietario_documento"></strong></p>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>


				</div>

				<div class="row">
					<div class="form-group col-sm-12 col-lg-12 col-12">

						<div class="card card-custom gutter-b">
							<div class="card-body">
								<h3 class="card-title">Produto Predominante</h3>
								<div class="row">

									<div class="form-group col-sm-3 col-lg-6 col-12">
										<label class="col-form-label">Nome</label>
										<div class="">
											<div class="input-group">
												<input type="text" name="produto_pred_nome" class="form-control type-ref" value="{{{ isset($mdfe) ? $mdfe->produto_pred_nome : '' }}}" id="produto_pred_nome"/>
											</div>
										</div>
									</div>

									<div class="form-group col-sm-3 col-lg-2 col-6">
										<label class="col-form-label">NCM</label>
										<div class="">
											<div class="input-group">
												<input type="text" name="produto_pred_ncm" class="form-control ncm" value="{{{ isset($mdfe) ? $mdfe->produto_pred_ncm : '' }}}" id="produto_pred_ncm"/>
											</div>
										</div>
									</div>

									<div class="form-group col-sm-3 col-lg-3 col-6">
										<label class="col-form-label">Código de Barras</label>
										<div class="">
											<div class="input-group">
												<input type="text" name="produto_pred_cod_barras" class="form-control" value="{{{ isset($mdfe) ? $mdfe->produto_pred_cod_barras : '' }}}" id="produto_pred_cod_barras"/>
											</div>
										</div>
									</div>

									<div class="form-group col-sm-3 col-lg-3 col-6">
										<label class="col-form-label">CEP Carrega</label>
										<div class="">
											<div class="input-group">
												<input type="text" name="cep_carrega" class="form-control cep" value="{{{ isset($mdfe) ? $mdfe->cep_carrega : '' }}}" id="cep_carrega"/>
											</div>
										</div>
									</div>

									<div class="form-group col-sm-3 col-lg-3 col-6">
										<label class="col-form-label">CEP Descarrega</label>
										<div class="">
											<div class="input-group">
												<input type="text" name="cep_descarrega" class="form-control cep" value="{{{ isset($mdfe) ? $mdfe->cep_descarrega : '' }}}" id="cep_descarrega"/>
											</div>
										</div>
									</div>

									<div class="form-group col-sm-3 col-lg-3 col-6">
										<label class="col-form-label">Tipo da carga</label>
										<div class="">
											<div class="input-group">
												<select class="form-control custom-select" name="tp_carga" id="tp_carga">
													@foreach(App\Mdfe::tiposCarga() as $key => $t)
													<option value="{{$key}}">{{$key}} - {{$t}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				


				<!-- Wizard -->

				<div class="card card-custom gutter-b">

					<div class="card-body">

						<div class="row">
							<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">

								<div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="between" data-wizard-clickable="true">
									<!--begin: Wizard Nav-->

									<div class="wizard-nav">

										<div class="wizard-steps px-8 py-8 px-lg-15 py-lg-3">
											<!--begin::Wizard Step 1 Nav-->
											<div class="wizard-step" data-wizard-type="step" data-wizard-state="done">
												<div class="wizard-label">
													<h3 class="wizard-title">
														<span style="font-size: 15px;">
															INFORMAÇÕES GERAIS
														</span>
													</h3>
													<div class="wizard-bar"></div>
												</div>
											</div>
											<!--end::Wizard Step 1 Nav-->
											<!--begin::Wizard Step 2 Nav-->
											<div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
												<div class="wizard-label">
													<h3 class="wizard-title">
														<span style="font-size: 15px;">
															INFORMAÇÕES DE TRANSPORTE
														</span>
													</h3>
													<div class="wizard-bar"></div>
												</div>
											</div>

											<div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
												<div class="wizard-label">
													<h3 class="wizard-title">
														<span style="font-size: 15px;">
															INFORMAÇÕES DE DESCARREGAMENTO
														</span>
													</h3>
													<div class="wizard-bar"></div>
												</div>
											</div>

										</div>
									</div>

									<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">

										<!--begin: Wizard Form-->
										<form class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_form">
											<!--begin: Wizard Step 1-->

											<div class="pb-5" data-wizard-type="step-content">
												<div class="row">
													<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12 col-12">

														<!-- Inicio da tabela -->
														<div class="card card-custom gutter-b">

															<div class="card-body">
																<h4>Seguradora (Opcional)</h4>
																<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
																	<div class="row">
																		<div class="col-xl-12">
																			<div class="row align-items-center">
																				<div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
																					<label class="col-form-label">Nome da seguradora</label>
																					<div class="">
																						<div class="input-group">
																							<input type="text" name="seguradora_nome" class="form-control" value="{{{ isset($mdfe) ? $mdfe->seguradora_nome : '' }}}" id="seguradora_nome"/>
																						</div>
																					</div>
																				</div>

																				<div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
																					<label class="col-form-label">CNPJ da seguradora</label>
																					<div class="">
																						<div class="input-group">
																							<input type="text" name="seguradora_cnpj" class="form-control" value="{{{ isset($mdfe) ? $mdfe->seguradora_cnpj : '' }}}" id="seguradora_cnpj"/>
																						</div>
																					</div>
																				</div>

																				<div class="form-group col-lg-4 col-md-4 col-sm-4 col-12">
																					<label class="col-form-label">Número da Apolice</label>
																					<div class="">
																						<div class="input-group">
																							<input type="text" name="seguradora_numero_apolice" class="form-control" value="{{{ isset($mdfe) ? $mdfe->numero_apolice : '' }}}" id="seguradora_numero_apolice"/>
																						</div>
																					</div>
																				</div>

																				<div class="form-group col-lg-4 col-md-4 col-sm-4 col-12">
																					<label class="col-form-label">Número da Averbação</label>
																					<div class="">
																						<div class="input-group">
																							<input type="text" name="seguradora_numero_averbacao" class="form-control" value="{{{ isset($mdfe) ? $mdfe->numero_averbacao : '' }}}" id="seguradora_numero_averbacao"/>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="col-sm-8 col-lg-8 col-md-8 col-xl-8 col-12">
														<div class="card card-custom gutter-b">
															<div class="card-body">
																<h4>Municipio(s) de Carregamento</h4>

																<div class="row align-items-center">

																	<div class="form-group col-sm-8 col-lg-8 col-12">

																		<label class="col-form-label" id="">Municipio de envio</label><br>
																		<select class="form-control select2 select-mun" style="width: 100%" id="kt_select2_4">
																			<option value="null">Selecione</option>
																			@foreach($cidades as $c)
																			<option value="{{$c}}">{{$c->nome}} ({{$c->uf}})</option>
																			@endforeach
																		</select>
																	</div>

																	<div class="col-lg-1 col-md-4 col-sm-6 col-6">
																		<a href="#!" style="margin-top: 10px;" id="btn-add-municipio-carregamento" class="btn btn-light-info px-6 font-weight-bold">
																			<i class="la la-plus"></i>
																		</a>

																	</div>

																</div>

																<div class="row">
																	<div class="col-xl-12">
																		<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

																			<table class="datatable-table" style="max-width: 100%; overflow: scroll" id="prod">
																				<thead class="datatable-head">
																					<tr class="datatable-row" style="left: 0px;">
																						<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 60px;">#</span></th>
																						<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Cidade</span></th>
																						<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Ações</span></th>

																					</tr>
																				</thead>
																				<tbody class="datatable-body" id="tbody-municipio-carregamento">
																					<tr class="datatable-row">
																					</tr>
																				</tbody>
																			</table>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="col-sm-4 col-lg-4 col-md-4 col-xl-4 col-12">
														<div class="card card-custom gutter-b">
															<div class="card-body">
																<h4>Percurso</h4>

																<div class="row align-items-center">

																	<div class="form-group col-sm-8 col-lg-8 col-12">

																		<label class="col-form-label" id="">UF</label><br>
																		<select id="percurso" class="form-control custom-select">
																			@foreach($ufs as $u)
																			<option value="{{$u}}">{{$u}}</option>
																			@endforeach
																		</select>

																	</div>

																	<div class="col-lg-1 col-md-4 col-sm-6 col-6">
																		<a href="#!" style="margin-top: 10px;" id="btn-add-percurso" class="btn btn-light-info px-6 font-weight-bold">
																			<i class="la la-plus"></i>
																		</a>

																	</div>


																</div>
																<div class="row">
																	<div class="col-xl-12">
																		<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

																			<table class="datatable-table" style="max-width: 100%; overflow: scroll" id="prod">
																				<thead class="datatable-head">
																					<tr class="datatable-row" style="left: 0px;">
																						<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">UF</span></th>
																						<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Ações</span></th>

																					</tr>
																				</thead>
																				<tbody class="datatable-body" id="tbody-percurso">
																					<tr class="datatable-row">
																					</tr>
																				</tbody>
																			</table>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>


											<!--begin: Wizard Step 1-->
											<div class="pb-5" data-wizard-type="step-content">

												<!-- Inicio da tabela -->

												<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
													<div class="row">
														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12 col-12">

															<!-- Inicio da tabela -->
															<div class="card card-custom gutter-b">

																<div class="card-body">
																	<h4>CIOT (Opcional)</h4>
																	<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
																		<div class="row">
																			<div class="col-xl-12">
																				<div class="row align-items-center">
																					<div class="form-group col-lg-3 col-md-3 col-xl-3 col-12">
																						<label class="col-form-label">Código CIOT</label>
																						<div class="">
																							<div class="input-group">
																								<input type="text" name="ciot_codigo" class="form-control"  id="ciot_codigo"/>
																							</div>
																						</div>
																					</div>

																					<div class="form-group col-lg-3 col-md-3 col-xl-3 col-12">
																						<label class="col-form-label">CPF/CNPJ</label>
																						<div class="">
																							<div class="input-group">
																								<input type="text" name="ciot_cpf_cnpj" class="form-control" id="ciot_cpf_cnpj"/>
																							</div>
																						</div>
																					</div>
																					<div class="col-lg-1 col-md-4 col-sm-6 col-6">
																						<a href="#!" style="margin-top: 10px;" id="btn-add-ciot" class="btn btn-light-info px-6 font-weight-bold">
																							<i class="la la-plus"></i>
																						</a>

																					</div>


																				</div>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-xl-12">
																				<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

																					<table class="datatable-table" style="max-width: 100%; overflow: scroll" id="prod">
																						<thead class="datatable-head">
																							<tr class="datatable-row" style="left: 0px;">
																								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">#</span></th>
																								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">CPF/CNPJ</span></th>
																								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Ações</span></th>

																							</tr>
																						</thead>
																						<tbody class="datatable-body" id="tbody-ciot">
																							<tr class="datatable-row">
																							</tr>
																						</tbody>
																					</table>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>

														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12 col-12">

															<!-- Inicio da tabela -->
															<div class="card card-custom gutter-b">

																<div class="card-body">
																	<h4>Vale Pedagio (Opcional)</h4>
																	<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
																		<div class="row">
																			<div class="col-xl-12">
																				<div class="row align-items-center">
																					<div class="form-group col-lg-3 col-md-3 col-xl-3 col-12">
																						<label class="col-form-label">CNPJ Fornecedor</label>
																						<div class="">
																							<div class="input-group">
																								<input type="text" name="vale_cnpj_fornecedor" class="form-control"  id="vale_cnpj_fornecedor"/>
																							</div>
																						</div>
																					</div>

																					<div class="form-group col-lg-3 col-md-3 col-xl-3 col-12">
																						<label class="col-form-label">CPF/CNPJ do Pagador</label>
																						<div class="">
																							<div class="input-group">
																								<input type="text" name="vale_cpf_cnpj_pagador" class="form-control" id="vale_cpf_cnpj_pagador"/>
																							</div>
																						</div>
																					</div>

																					<div class="form-group col-lg-2 col-md-2 col-xl-2 col-12">
																						<label class="col-form-label">Número da compra</label>
																						<div class="">
																							<div class="input-group">
																								<input type="text" name="vale_numero_compra" class="form-control" id="vale_numero_compra"/>
																							</div>
																						</div>
																					</div>

																					<div class="form-group col-lg-2 col-md-2 col-xl-2 col-12">
																						<label class="col-form-label">Valor</label>
																						<div class="">
																							<div class="input-group">
																								<input type="text" name="vale_valor" class="form-control" id="vale_valor"/>
																							</div>
																						</div>
																					</div>
																					<div class="col-lg-1 col-md-4 col-sm-6 col-6">
																						<a href="#!" style="margin-top: 10px;" id="btn-add-vale" class="btn btn-light-info px-6 font-weight-bold">
																							<i class="la la-plus"></i>
																						</a>

																					</div>


																				</div>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-xl-12">
																				<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

																					<table class="datatable-table" style="max-width: 100%; overflow: scroll" id="prod">
																						<thead class="datatable-head">
																							<tr class="datatable-row" style="left: 0px;">
																								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">CNPJ Fornecedor</span></th>
																								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">CPF/CNPJ do Pagador</span></th>
																								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Número da compra</span></th>
																								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>
																								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Ações</span></th>

																							</tr>
																						</thead>
																						<tbody class="datatable-body" id="tbody-vale-pegadio">
																							<tr class="datatable-row">
																							</tr>
																						</tbody>
																					</table>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>

														<!-- condutor -->

														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12 col-12">

															<!-- Inicio da tabela -->
															<div class="card card-custom gutter-b">

																<div class="card-body">
																	<h4>Condutor</h4>
																	<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
																		<div class="row">
																			<div class="col-xl-12">
																				<div class="row align-items-center">
																					<div class="form-group col-lg-4 col-md-4 col-xl-4 col-12">
																						<label class="col-form-label">Nome</label>
																						<div class="">
																							<div class="input-group">
																								<input type="text" name="condutor_nome" class="form-control" value="{{{ isset($mdfe) ? 
																								$mdfe->condutor_nome : '' }}}" id="condutor_nome"/>
																							</div>
																						</div>
																					</div>

																					<div class="form-group col-lg-3 col-md-3 col-xl-3 col-12">
																						<label class="col-form-label">CPF</label>
																						<div class="">
																							<div class="input-group">
																								<input type="text" name="condutor_cpf" class="form-control" id="condutor_cpf"/>
																							</div>
																						</div>
																					</div>
																					
																				</div>
																			</div>
																		</div>
																		
																	</div>
																</div>
															</div>
														</div>
														<!-- fim condutor -->
													</div>
												</div>

											</div>

											<div class="pb-5" data-wizard-type="step-content">

												<!-- Inicio da tabela -->


												<div class="row">
													<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12 col-12">

														<!-- Inicio da tabela -->
														<div class="card card-custom gutter-b">

															<div class="card-body">
																<h3>Informações da Unidade de Transporte / Documentos Fiscais / Lacres</h3>

																<div class="row">
																	<div class="form-group col-lg-4 col-md-4 col-xl-4 col-12">
																		<label class="col-form-label">Tipo Unidade de Transporte</label>
																		<div class="">
																			<div class="input-group">

																				<select id="tp_unid_transp" class="form-control custom-select">
																					@foreach($tiposUnidadeTransporte as $key => $t)
																					<option value="{{$key}}">{{$key}} - {{$t}}</option>
																					@endforeach
																				</select>
																			</div>
																		</div>
																	</div>

																	<div class="form-group col-lg-6 col-md-6 col-xl-4 col-12">
																		<label class="col-form-label">ID da Unidade de Transporte (Placa)</label>
																		<div class="">
																			<div class="input-group">
																				<input type="text" name="id_unid_transp" class="form-control" id="id_unid_transp"/>
																			</div>
																		</div>
																	</div>

																	<div class="form-group col-lg-6 col-md-6 col-xl-4 col-12">
																		<label class="col-form-label">Quantidade de Rateio (Transporte)</label>
																		<div class="">
																			<div class="input-group">
																				<input type="text" name="qtd_rateio_transp" class="form-control" id="qtd_rateio_transp"/>
																			</div>
																		</div>
																	</div>

																	<div class="form-group col-lg-6 col-md-6 col-xl-4 col-12">
																		<label class="col-form-label">ID Unidade da Carga</label>
																		<div class="">
																			<div class="input-group">
																				<input type="text" name="id_unid_carga" class="form-control" id="id_unid_carga"/>
																			</div>
																		</div>
																	</div>

																	<div class="form-group col-lg-6 col-md-6 col-xl-4 col-12">
																		<label class="col-form-label">Quantidade de Rateio (Unidade Carga)</label>
																		<div class="">
																			<div class="input-group">
																				<input type="text" name="qtd_rateio_unid_carga" class="form-control" id="qtd_rateio_unid_carga"/>
																			</div>
																		</div>
																	</div>

																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12 col-12">

														<div class="card card-custom gutter-b">
															<div class="card-body">
																<h5>NFe Referência</h5>
																<div class="row">

																	<div class="form-group col-lg-6 col-md-12 col-xl-6 col-12">
																		<label class="col-form-label">NFe Referência</label>
																		<div class="">
																			<div class="input-group">
																				<input type="text" name="chave_nfe" class="form-control chave" id="chave_nfe"/>
																			</div>
																		</div>
																	</div>

																	<div class="form-group col-lg-6 col-md-12 col-xl-6 col-12">
																		<label class="col-form-label">Segundo Código de Barra NFe (Contigencia)</label>
																		<div class="">
																			<div class="input-group">
																				<input type="text" name="seg_cod_nfe" class="form-control chave" id="seg_cod_nfe"/>
																			</div>
																		</div>
																	</div>

																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12 col-12">

														<div class="card card-custom gutter-b">
															<div class="card-body">
																<h5>CTe Referência</h5>
																<div class="row">

																	<div class="form-group col-lg-6 col-md-12 col-xl-6 col-12">
																		<label class="col-form-label">CTe Referência</label>
																		<div class="">
																			<div class="input-group">
																				<input type="text" name="chave_cte" class="form-control chave" id="chave_cte"/>
																			</div>
																		</div>
																	</div>

																	<div class="form-group col-lg-6 col-md-12 col-xl-6 col-12">
																		<label class="col-form-label">Segundo Código de Barra CTe (Contigencia)</label>
																		<div class="">
																			<div class="input-group">
																				<input type="text" name="seg_cod_cte" class="form-control chave" id="seg_cod_cte"/>
																			</div>
																		</div>
																	</div>

																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-sm-6 col-lg-6 col-md-12 col-xl-6 col-12">

														<div class="card card-custom gutter-b">
															<div class="card-body">
																<h5>Lacres de Transporte</h5>

																<div class="row">
																	<div class="col-xl-12">
																		<div class="row align-items-center">
																			<div class="form-group col-lg-8 col-md-8 col-xl-8 col-12">
																				<label class="col-form-label">Número Lacre</label>
																				<div class="">
																					<div class="input-group">
																						<input type="text" name="lacre_transp" class="form-control"  id="lacre_transp"/>
																					</div>
																				</div>
																			</div>


																			<div class="col-lg-1 col-md-4 col-sm-6 col-6">
																				<a href="#!" style="margin-top: 10px;" id="btn-add-lacre-transp" class="btn btn-light-info px-6 font-weight-bold">
																					<i class="la la-plus"></i>
																				</a>
																			</div>

																		</div>
																	</div>
																</div>

																<div class="row">
																	<div class="col-xl-12">
																		<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

																			<table class="datatable-table" style="max-width: 100%; overflow: scroll" id="prod">
																				<thead class="datatable-head">
																					<tr class="datatable-row" style="left: 0px;">
																						<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Número Lacre</span></th>
																						<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Ações</span></th>

																					</tr>
																				</thead>
																				<tbody class="datatable-body" id="tbody-lacre-transp">
																					<tr class="datatable-row">
																					</tr>
																				</tbody>
																			</table>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="col-sm-6 col-lg-6 col-md-12 col-xl-6 col-12">

														<div class="card card-custom gutter-b">
															<div class="card-body">
																<h5>Lacres da Unidade da Carga</h5>
																<div class="row">
																	<div class="col-xl-12">
																		<div class="row align-items-center">
																			<div class="form-group col-lg-8 col-md-8 col-xl-8 col-12">
																				<label class="col-form-label">Número Lacre</label>
																				<div class="">
																					<div class="input-group">
																						<input type="text" name="lacre_unidade" class="form-control"  id="lacre_unidade"/>
																					</div>
																				</div>
																			</div>


																			<div class="col-lg-1 col-md-4 col-sm-6 col-6">
																				<a href="#!" style="margin-top: 10px;" id="btn-add-larcre-unidade" class="btn btn-light-info px-6 font-weight-bold">
																					<i class="la la-plus"></i>
																				</a>
																			</div>

																		</div>
																	</div>
																</div>

																<div class="row">
																	<div class="col-xl-12">
																		<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

																			<table class="datatable-table" style="max-width: 100%; overflow: scroll" id="prod">
																				<thead class="datatable-head">
																					<tr class="datatable-row" style="left: 0px;">
																						<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Número Lacre</span></th>
																						<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Ações</span></th>

																					</tr>
																				</thead>
																				<tbody class="datatable-body" id="tbody-lacre-unid">
																					<tr class="datatable-row">
																					</tr>
																				</tbody>
																			</table>
																		</div>
																	</div>
																</div>

															</div>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12 col-12">

														<div class="card card-custom gutter-b">
															<div class="card-body">
																<h5>Municipio de Descarregamento</h5>

																<div class="row align-items-center">

																	<div class="form-group col-sm-8 col-lg-8 col-12">

																		<label class="col-form-label" id="">Municipio</label><br>
																		<select class="form-control select2 select-mun" style="width: 100%" id="kt_select2_5">
																			<option value="null">Selecione</option>
																			@foreach($cidades as $c)
																			<option value="{{$c->id}} - {{$c->nome}}">{{$c->nome}} ({{$c->uf}})</option>
																			@endforeach
																		</select>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12 col-12">
														<a id="btn-add-info-desc" style="width: 100%" class="btn btn-xl btn-success"> Adicionar Informação de Descarregamento</a>
													</div>
												</div>

												<div class="row">
													<div class="col-xl-12">
														<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

															<table class="datatable-table" style="max-width: 100%; overflow: scroll" id="prod">
																<thead class="datatable-head">
																	<tr class="datatable-row" style="left: 0px;">
																		<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Tipo Transp</span></th>
																		<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">ID Unid Transp</span></th>
																		<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Quantidade rateio</span></th>
																		<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">NFe Referência</span></th>

																		<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">CTe Referência</span></th>
																		<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Mun. Decarrega</span></th>

																		<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Lacres de Transp</span></th>
																		<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Lacres Unidade Carga</span></th>
																		<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Ações</span></th>

																	</tr>
																</thead>
																<tbody class="datatable-body" id="tbody-info-descarga">
																	<tr class="datatable-row">
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>

											</div>
										</form>
									</div>

									<div class="row align-items-center">
										<div class="form-group col-lg-4 col-md-6 col-xl-4 col-12">
											<label class="col-form-label">Informação complementar</label>
											<div class="">
												<div class="input-group">
													<input type="text" name="info_complementar" class="form-control"  id="info_complementar"/>
												</div>
											</div>
										</div>

										<div class="form-group col-lg-4 col-md-6 col-xl-4 col-12">
											<label class="col-form-label">Informação fiscal</label>
											<div class="">
												<div class="input-group">
													<input type="text" name="info_fisco" class="form-control"  id="info_fisco"/>
												</div>
											</div>
										</div>

										<div class="col-lg-4 col-md-6 col-xl-4 col-12">
											<a id="finalizar" style="width: 100%; margin-top: 12px;" href="#" onclick="salvarMDFe()" class="btn btn-xl btn-light-info disabled">
												<i class="la la-check"></i>
												Finalizar
											</a>
										</div>
									</div>

								</div>
							</div>

						</div>
					</div>

				</div>
				<!-- Fim Wizard -->
			</div>
		</div>
	</div>
</div>

@endsection