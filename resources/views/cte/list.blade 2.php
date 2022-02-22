@extends('default.layout')
@section('content')
<div class="card card-custom gutter-b">
	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<input type="hidden" id="_token" value="{{ csrf_token() }}">
			<form method="get" action="/cte/filtro">
				<div class="row align-items-center">

					
					<div class="form-group col-lg-2 col-md-4 col-sm-6">
						<label class="col-form-label">Data Inicial</label>
						<div class="">
							<div class="input-group date">
								<input type="text" name="data_inicial" class="form-control" readonly value="{{{isset($dataInicial) ? $dataInicial : ''}}}" id="kt_datepicker_3" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group col-lg-2 col-md-4 col-sm-6">
						<label class="col-form-label">Data Final</label>
						<div class="">
							<div class="input-group date">
								<input type="text" name="data_final" class="form-control" readonly value="{{{isset($dataFinal) ? $dataFinal : ''}}}" id="kt_datepicker_3" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group col-lg-2 col-md-4 col-sm-6">
						<label class="col-form-label">Estado</label>
						<div class="">
							<div class="input-group date">
								<select class="custom-select form-control" id="estado" name="estado">
									<option @if(isset($estado) && $estado == 'DISPONIVEL') selected @endif value="DISPONIVEL">DISPONIVEIS</option>
									<option @if(isset($estado) && $estado == 'REJEITADO') selected @endif value="REJEITADO">REJEITADAS</option>
									<option @if(isset($estado) && $estado == 'CANCELADO') selected @endif value="CANCELADO">CANCELADAS</option>
									<option @if(isset($estado) && $estado == 'APROVADO') selected @endif value="APROVADO">APROVADAS</option>
									<option @if(isset($estado) && $estado == 'TODOS') selected @endif value="TODOS">TODOS</option>
								</select>
							</div>
						</div>
					</div>

					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button style="margin-top: 15px;" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
					</div>
				</div>
			</form>
			<br>
			<h4>Lista de CT-e</h4>

			<label>Registros: <strong class="text-success">{{sizeof($ctes)}}</strong></label>
			<div class="row">
				<div class="form-group col-lg-3 col-md-4 col-sm-6">
					<a href="/cte/nova" class="btn btn-success">
						<i class="la la-plus"></i>
						Nova CT-e
					</a>
				</div>
			</div>


		</div>

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
										<span>
											<i style="font-size: 40px" class="la la-table"></i>
											Tabela
										</span>
									</h3>
									<div class="wizard-bar"></div>
								</div>
							</div>
							<!--end::Wizard Step 1 Nav-->
							<!--begin::Wizard Step 2 Nav-->
							<div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
								<div class="wizard-label" id="grade">
									<h3 class="wizard-title">
										<span>
											<i style="font-size: 40px" class="la la-tablet"></i>
											Grade
										</span>
									</h3>
									<div class="wizard-bar"></div>
								</div>
							</div>

						</div>

						<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">

							<!--begin: Wizard Form-->
							<form class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_form">
								<!--begin: Wizard Step 1-->
								<div class="pb-5" data-wizard-type="step-content">

									<!-- Inicio da tabela -->

									<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
										<div class="row">
											<div class="col-xl-12">

												<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

													<table class="datatable-table" style="max-width: 100%; overflow: scroll">
														<thead class="datatable-head">
															<tr class="datatable-row" style="left: 0px;">
																<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 70px;">#</span></th>
																<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Destinatário</span></th>
																<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Rementente</span></th>
																<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor serviço</span></th>
																<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor a receber</span></th>

																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Estado</span></th>

																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Data de cadastro</span></th>
																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Tomador</span></th>
																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Nº</span></th>
																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Saldo</span></th>
																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 280px;">Ações</span></th>
															</tr>
														</thead>

														<tbody id="body" class="datatable-body">

															@foreach($ctes as $c)

															<tr class="datatable-row">
																<td id="checkbox">

																	<p style="width: 80px;">
																		<input type="checkbox" class="check" id="test_{{$c->id}}" />
																		<label for="test_{{$c->id}}"></label>
																	</p>

																</td>
																<td style="display: none" id="id">{{$c->id}}</td>
																<td style="display: none" id="cte_numero">{{$c->cte_numero}}</td>

																<td style="display: none" id="estado_{{$c->id}}">{{$c->estado}}</td>
																
																<td class="datatable-cell">
																	<span class="codigo" style="width: 150px;">
																		{{$c->destinatario->razao_social}}
																	</span>
																</td>
																<td class="datatable-cell">
																	<span class="codigo" style="width: 150px;">
																		{{$c->remetente->razao_social}}
																	</span>
																</td>
																<td class="datatable-cell">
																	<span class="codigo" style="width: 100px;">
																		{{ number_format($c->valor_transporte, 2, ',', '.') }}
																	</span>
																</td>
																<td class="datatable-cell">
																	<span class="codigo" style="width: 100px;">
																		{{ number_format($c->valor_receber, 2, ',', '.') }}
																	</span>
																</td>
																<td class="datatable-cell">
																	<span class="codigo" style="width: 100px;">
																		@if($c->estado == 'DISPONIVEL')
																		<span class="label label-xl label-inline label-light-primary">Disponível</span>

																		@elseif($c->estado == 'APROVADO')
																		<span class="label label-xl label-inline label-light-success">Aprovado</span>
																		@elseif($c->estado == 'CANCELADO')
																		<span class="label label-xl label-inline label-light-danger">Cancelado</span>
																		@else
																		<span class="label label-xl label-inline label-light-warning">Rejeitado</span>
																		@endif
																	</span>
																</td>
																<td class="datatable-cell">
																	<span class="codigo" style="width: 100px;">
																		{{ \Carbon\Carbon::parse($c->created_at)->format('d/m/Y H:i:s')}}
																	</span>
																</td>
																<td class="datatable-cell">
																	<span class="codigo" style="width: 100px;">
																		{{$c->getTomador()}}
																	</span>
																</td>
																<td class="datatable-cell">
																	<span class="codigo" style="width: 100px;">
																		{{$c->cte_numero > 0 ? $c->cte_numero : '-' }}
																	</span>
																</td>
																<td class="datatable-cell">
																	<span class="codigo" style="width: 100px;">
																		{{number_format($c->somaReceita() - $c->somaDespesa(), 2)}}
																	</span>
																</td>

																<td>
																	<div class="row">
																		<span style="width: 280px;">

																			@if($c->estado == 'DISPONIVEL' || $c->estado == 'REJEITADO')

																			<a class="btn btn-danger" onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/cte/delete/{{ $c->id }}" }else{return false} })' href="#!">
																				<i class="la la-trash"></i>				
																			</a>

																			<a class="btn btn-primary" onclick='swal("Atenção!", "Deseja editar este registro?", "warning").then((sim) => {if(sim){ location.href="/cte/edit/{{ $c->id }}" }else{return false} })' href="#!">
																				<i class="la la-edit"></i>	
																			</a>
																			@endif

																			<a class="btn btn-info" href="/cte/detalhar/{{ $c->id }}">
																				<i class="la la-file"></i>
																			</a>

																			<a class="btn btn-warning" href="/cte/custos/{{ $c->id }}">
																				<i class="la la-money"></i>
																			</a>

																		</span>
																	</div>
																</td>

															</tr>
															
															@endforeach

														</tbody>
													</table>
												</div>
											</div>
											@if($certificado != null)
											<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
												<div class="row">

													<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
														<a id="btn-enviar" onclick="enviar()" style="width: 100%" class="btn btn-success spinner-white spinner-right" href="#!">Enviar</a>
													</div>

													<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
														<a id="btn-imprimir" onclick="imprimir()" style="width: 100%" class="btn btn-secondary" href="#!">Imprimir</a>
													</div>

													<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
														<a id="btn-consultar" onclick="consultar()" style="width: 100%" class="btn btn-info spinner-white spinner-right" href="#!">Consultar</a>
													</div>

													<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
														<a id="btn-cancelar" data-toggle="modal" data-target="#modal1" onclick="setarNumero()" style="width: 100%" class="btn btn-danger" href="#modal1">Cancelar</a>
													</div>

													<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
														<a id="btn-correcao" onclick="setarNumero()" style="width: 100%" class="btn btn-warning" data-toggle="modal" data-target="#modal4">CC-e</a>
													</div>

													<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
														<a id="btn-inutilizar" style="width: 100%" class="btn btn-secondary" data-toggle="modal" data-target="#modal3">Inutilizar</a>
													</div>
												</div>


												<div class="row" style="margin-top: 5px;">

													<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
														<a id="btn-xml" onclick="setarNumero(true)" style="width: 100%" class="btn btn-info" data-toggle="modal" data-target="#modal5">Enviar XML</a>
													</div>

													<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
														<a id="btn-imprimir-cce" onclick="imprimirCCe()" style="width: 100%" class="btn btn-warning" href="#!">Imprimir CC-e</a>
													</div>

													<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
														<a id="btn-imprimir-cancelar" onclick="imprimirCancela()" style="width: 100%" class="btn btn-danger" href="#!">Imprimir Cancela</a>
													</div>

													<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
														<a id="btn-imprimir-cancelar" onclick="xmlTemp()" style="width: 100%" class="btn btn-secondary" href="#!">Xml temporário</a>
													</div>
												</div>
											</div>
											@else
											<input type="hidden" id="semCertificado" value="true" name="">
											@endif
										</div>
									</div>
									<!-- Fim da tabela -->
								</div>

								<!--end: Wizard Step 1-->
								<!--begin: Wizard Step 2-->
								<div class="pb-5" data-wizard-type="step-content">

									<!-- Inicio do card -->

									<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
										<div class="row">

											@foreach($ctes as $c)
											<div class="col-sm-6 col-lg-6 col-md-6 col-xl-6">

												<div class="card card-custom gutter-b example example-compact">
													<div class="card-header">
														<div class="card-title">
															<h3 style="width: 230px; font-size: 15px; height: 10px;" class="card-title">
																<strong class="text-success"> </strong>

																{{$c->remetente->razao_social}}/{{$c->destinatario->razao_social}}

															</h3>

														</div>
														<div class="card-toolbar">
															<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Ações">
																<a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	<i class="fa fa-ellipsis-h"></i>
																</a>
																<div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
																	<!--begin::Navigation-->
																	<ul class="navi navi-hover">
																		<li class="navi-header font-weight-bold py-4">
																			<span class="font-size-lg">Ações:</span>
																		</li>
																		<li class="navi-separator mb-3 opacity-70"></li>

																		@if($c->estado == 'DISPONIVEL')


																		<li class="navi-item">
																			<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/cte/delete/{{ $c->id }}" }else{return false} })' href="#!" class="navi-link">
																				<span class="navi-text">
																					<span class="label label-xl label-inline label-light-danger">Remover</span>
																				</span>
																			</a>
																		</li>

																		<li class="navi-item">
																			<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/cte/edit/{{ $c->id }}" }else{return false} })' href="#!" class="navi-link">
																				<span class="navi-text">
																					<span class="label label-xl label-inline label-light-primary">Editar</span>
																				</span>
																			</a>
																		</li>


																		@endif

																		<li class="navi-item">
																			<a href="/cte/detalhar/{{ $c->id }}" class="navi-link">
																				<span class="navi-text">
																					<span class="label label-xl label-inline label-light-info">
																						Detalhar
																					</span>
																				</span>
																			</a>
																		</li>

																		<li class="navi-item">
																			<a href="/cte/custos/{{ $c->id }}" class="navi-link">
																				<span class="navi-text">
																					<span class="label label-xl label-inline label-light-warning">
																						Custos
																					</span>
																				</span>
																			</a>
																		</li>

																	</ul>
																	<!--end::Navigation-->
																</div>
															</div>

														</div>
													</div>

													<div class="card-body">

														<div class="kt-widget__info">
															<span class="kt-widget__label">Data:</span>
															<a target="_blank" class="kt-widget__data text-success">
																{{ \Carbon\Carbon::parse($c->created_at)->format('d/m/Y H:i:s')}}
															</a>
														</div>

														<div class="kt-widget__info">
															<span class="kt-widget__label">Valor a receber:</span>
															<a target="_blank" class="kt-widget__data text-success">
																{{ number_format($c->valor_receber, 2, ',', '.') }}
															</a>
														</div>

														<div class="kt-widget__info">
															<span class="kt-widget__label">Tomador:</span>
															<a target="_blank" class="kt-widget__data text-success">
																{{ $c->getTomador() }}
															</a>
														</div>

														<div class="kt-widget__info">
															<span class="kt-widget__label">Nº:</span>
															<a target="_blank" class="kt-widget__data text-success">
																{{$c->cte_numero > 0 ? $c->cte_numero : '-' }}
															</a>
														</div>

														<div class="kt-widget__info">
															<span class="kt-widget__label">Estado:</span>
															<a target="_blank" class="kt-widget__data text-success">

																@if($c->estado == 'DISPONIVEL')
																<span class="label label-xl label-inline label-light-primary">Disponível</span>

																@elseif($c->estado == 'APROVADO')
																<span class="label label-xl label-inline label-light-success">Aprovado</span>
																@elseif($c->estado == 'CANCELADO')
																<span class="label label-xl label-inline label-light-danger">Cancelado</span>
																@else
																<span class="label label-xl label-inline label-light-warning">Rejeitado</span>
																@endif
															</a>
														</div>


														<hr>

														<div class="row">


															@if($c->estado == 'APROVADO')

															<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
																<a style="width: 100%; margin-top: 5px;" target="_blank" href="/cteSefaz/imprimir/{{$c->id}}" class="btn btn-success">
																	<i class="la la-print"></i>
																	Imprimir 
																</a>
															</div>

															@if($c->sequencia_cce > 0)
															<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
																<a style="width: 100%; margin-top: 5px;" target="_blank" href="/cteSefaz/imprimirCCe/{{$c->id}}" class="btn btn-warning">
																	<i class="la la-print"></i>
																	Imprimir CC-e
																</a>
															</div>
															@endif

															<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
																<a id="btn_consulta_grid_{{$c->id}}" style="width: 100%; margin-top: 5px;" href="#!" onclick="consultarCTe('{{$c->id}}')" class="btn btn-info spinner-white spinner-right">
																	<i class="la la-check"></i>
																	Consultar CTe
																</a>
															</div>


															<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
																<a id="btn_consulta_grid_{{$c->id}}" style="width: 100%; margin-top: 5px;" href="#!" onclick="cancelarCTe('{{$c->id}}', '{{$c->cte_numero}}')" class="btn btn-danger spinner-white spinner-right">
																	<i class="la la-check"></i>
																	Cancelar CTe
																</a>
															</div>

															<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
																<a style="width: 100%; margin-top: 5px;" href="#!" onclick="corrigirCTe('{{$c->id}}', '{{$c->cte_numero}}')" class="btn btn-warning spinner-white spinner-right">
																	<i class="la la-check"></i>
																	Corrigir CTe
																</a>
															</div>

															<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
																<a style="width: 100%; margin-top: 5px;" target="_blank" href="/cteSefaz/baixarXml/{{$c->id}}" class="btn btn-danger">
																	<i class="la la-download"></i>
																	Baixar XML
																</a>
															</div>

															@endif

															@if($c->estado == 'REJEITADO')

															<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
																<a id="btn_transmitir_grid_{{$c->id}}" style="width: 100%; margin-top: 5px;" href="#!" onclick="transmitirCTe('{{$c->id}}')" class="btn btn-success spinner-white spinner-right">
																	<i class="la la-check"></i>
																	Transmitir CTe
																</a>
															</div>

															@endif

															@if($c->estado == 'DISPONIVEL')

															<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
																<a id="btn_transmitir_grid_{{$c->id}}" style="width: 100%; margin-top: 5px;" href="#!" onclick="transmitirCTe('{{$c->id}}')" class="btn btn-success spinner-white spinner-right">
																	<i class="la la-check"></i>
																	Transmitir CTe 
																</a>
															</div>

															@endif


															@if($c->estado == 'CANCELADO')
															<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
																<a style="width: 100%; margin-top: 5px;" target="_blank" href="/cteSefaz/imprimirCancela/{{$c->id}}" class="btn btn-danger">
																	<i class="la la-print"></i>
																	Imprimir Cancelamento
																</a>
															</div>
															@endif

														</div>
													</div>
												</div>

											</div>
											@endforeach

										</div>
									</div>
								</div>
								<!--end: Wizard Step 2-->
								<div class="d-flex justify-content-between align-items-center flex-wrap">
									<div class="d-flex flex-wrap py-2 mr-3">
										@if(isset($links))
										{{$ctes->links()}}
										@endif
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">CANCELAR CTe <strong class="text-danger" id="numero_cancelamento"></strong></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">
				<div class="row">

					<div class="form-group validated col-sm-12 col-lg-12">
						<label class="col-form-label" id="">Justificativa</label>
						<div class="">
							<input type="text" id="justificativa" placeholder="Justificativa minimo de 15 caracteres" name="justificativa" class="form-control" value="">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="button" id="btn-cancelar-2" onclick="cancelar()" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Cancelar CTe</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal1_aux" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">CANCELAR CTe <strong class="text-danger" id="numero_cancelamento2"></strong></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" id="id_cancela" name="">
					<div class="form-group validated col-sm-12 col-lg-12">
						<label class="col-form-label" id="">Justificativa</label>
						<div class="">
							<input type="text" id="justificativa2" placeholder="Justificativa minimo de 15 caracteres" name="justificativa" class="form-control" value="">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="button" id="btn-cancelar-3" onclick="cancelar2()" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Cancelar CTe</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal3" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">INUTILIZAÇÃO DE NÚMERO(s) DE CTe </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group validated col-sm-6 col-Numero NF Inicial-6">
						<label class="col-form-label" id="">Numero CTe Inicial</label>
						<div class="">
							<input type="text" id="nInicio" placeholder="" name="nInicio" class="form-control" value="">
						</div>
					</div>
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label" id="">Numero NF Final</label>
						<div class="">
							<input type="text" id="nFinal" placeholder="" name="nFinal" class="form-control" value="">
						</div>
					</div>
					<div class="form-group validated col-sm-12 col-lg-12">
						<label class="col-form-label" id="">Justificativa</label>
						<div class="">
							<input type="text" id="justificativa-inut" placeholder="Digite no minimo 15 caracteres" name="justificativa-inut" class="form-control" value="">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="button" id="btn-inut-2" onclick="inutilizar()" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Inutilizar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal4" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">CARTA DE CORREÇÃO CT-e <strong class="text-danger" id="numero_correcao"></strong></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">
				<div class="row">

					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label" id="">Grupo</label>
						<div class="">
							<select class="custom-select form-control" id="grupo" name="grupo">
								@foreach($grupos as $g)
								<option>{{$g}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label" id="">Campo</label>
						<div class="">
							<input type="text" id="campo" name="campo" class="form-control" value="">
						</div>
					</div>

					<div class="form-group validated col-sm-12 col-lg-12">
						<label class="col-form-label" id="">Correção</label>
						<div class="">
							<input type="text" id="correcao" placeholder="Correção minimo de 15 caracteres" name="correcao" class="form-control" value="">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="button" id="btn-corrigir-2" onclick="cartaCorrecao()" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Corrigir CTe</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal4_aux" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">CARTA DE CORREÇÃO CT-e <strong class="text-danger" id="numero_correcao_aux"></strong></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">
				<div class="row">

					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label" id="">Grupo</label>
						<div class="">
							<select class="custom-select form-control" id="grupo2" name="grupo">
								@foreach($grupos as $g)
								<option>{{$g}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<input type="hidden" id="id_correcao" name="">
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label" id="">Campo</label>
						<div class="">
							<input type="text" id="campo2" name="Campo" class="form-control" value="">
						</div>
					</div>

					<div class="form-group validated col-sm-12 col-lg-12">
						<label class="col-form-label" id="">Correção</label>
						<div class="">
							<input type="text" id="correcao2" placeholder="Correção minimo de 15 caracteres" name="correcao" class="form-control" value="">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="button" id="btn-corrigir-3" onclick="cartaCorrecaoAux()" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Corrigir CTe</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal5" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">ENVIAR XML DA CTe <strong class="text-danger" id="numero_email"></strong></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group validated col-sm-12 col-lg-12">
						<label class="col-form-label" id="">Email</label>
						<input type="hidden" id="id_correcao" name="">
						<div class="">
							<input type="text" id="email" placeholder="Email" name="email" class="form-control" value="">
						</div>
					</div>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="button" id="btn-send" onclick="enviarEmailXMl()" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Enviar</button>
			</div>
		</div>
	</div>
</div>


@endsection	