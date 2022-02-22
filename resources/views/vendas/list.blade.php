@extends('default.layout')
@section('content')
<div class="card card-custom gutter-b">
	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<input type="hidden" id="_token" value="{{ csrf_token() }}">
			<form method="get" action="/vendas/filtro">
				<div class="row align-items-center">

					<div class="form-group col-lg-3 col-md-4 col-sm-6">
						<label class="col-form-label">Cliente</label>
						<div class="">
							<div class="input-group">
								<input type="text" name="cliente" class="form-control" value="{{{isset($cliente) ? $cliente : ''}}}" />
							</div>
						</div>
					</div>

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
			<h4>Lista de Vendas</h4>

			<label>Registros: <strong class="text-success">{{sizeof($vendas)}}</strong></label>
			<div class="row">
				<div class="form-group col-lg-3 col-md-4 col-sm-6">
					<a href="/vendas/nova" class="btn btn-success">
						<i class="la la-plus"></i>
						Nova Venda
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
															<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 60px;">#</span></th>
															<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 70px;">ID</span></th>
															<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Cliente</span></th>
															<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Data</span></th>
															<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Tipo de pagamento</span></th>

															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Estado</span></th>

															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">NFe</span></th>
															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Série</span></th>
															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Usuário</span></th>
															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>
															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 320px;">Ações</span></th>
														</tr>
													</thead>

													<tbody id="body" class="datatable-body">
														<?php $total = 0; ?>
														@foreach($vendas as $v)

														<tr class="datatable-row">
															<td id="checkbox">

																@if(!$v->status)
																<p style="width: 70px;">
																	<input type="checkbox" class="check" id="test_{{$v->id}}" />
																	<label for="test_{{$v->id}}"></label>
																</p>
																@endif

															</td>
															<td class="datatable-cell"><span class="codigo" style="width: 70px;" id="id">{{$v->id}}</span>
															</td>
															<td class="datatable-cell"><span class="codigo" style="width: 200px;">{{ $v->cliente->razao_social ?? 'NAO IDENTIFCADO' }}</span>
															</td>
															<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ \Carbon\Carbon::parse($v->created_at)->format('d/m/Y H:i:s')}}</span>
															</td>
															<td class="datatable-cell">
																<span class="codigo" style="width: 100px;">

																	@if($v->tipo_pagamento == '99')

																	<a href="#!" onclick='swal("", "{{$v->multiplo()}}", "info")' class="btn btn-light-info">
																		Ver
																	</a>
																	@else
																	{{$v->getTipoPagamento($v->tipo_pagamento)}}
																	@endif

																</span>
															</td>
															<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="estado_{{$v->id}}">{{ $v->estado }}</span>
															</td>
															<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="numeroNf">{{ $v->NfNumero > 0 ? $v->NfNumero : '--' }}</span>
															</td>
															<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="serieNf">{{ $v->serie > 0 ? $v->serie : '--' }}</span>
															</td>
															<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ $v->usuario->nome }}</span>
															</td>
															<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ number_format($v->valor_total, 2, ',', '.') }}</span>
															</td>


															<td>
																<div class="row">
																	<span style="width: 320px;">
																		<!--@if($v->estado == 'DISPONIVEL')
																			<a class="btn btn-danger" onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/vendas/delete/{{ $v->id }}" }else{return false} })' title="Excluir venda" href="#!">
																				<i class="la la-trash"></i>				
																			</a>
																		@endif-->
																		@if($v->estado == 'DISPONIVEL' || $v->estado == 'REJEITADO')

																			<a class="btn btn-danger" onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/vendas/delete/{{ $v->id }}" }else{return false} })' title="Excluir venda" href="#!">
																				<i class="la la-trash"></i>				
																			</a>
																			<a class="btn btn-warning" onclick='swal("Atenção!", "Deseja editar este registro?", "warning").then((sim) => {if(sim){ location.href="/vendas/edit/{{ $v->id }}" }else{return false} })' title="Editar venda" href="#!">
																				<i class="la la-edit"></i>				
																			</a>
																			
																		@endif
																		<a class="btn btn-info" title="Detalhar venda" href="/vendas/detalhar/{{ $v->id }}">
																			<i class="la la-file"></i>
																		</a>

																		<a class="btn btn-primary" title="Clonar venda" href="/vendas/clone/{{ $v->id }}">
																			<i class="la la-copy"></i>
																		</a>

																		<a class="btn btn-light" target="_blank" title="Ver XML" href="/vendas/gerarXml/{{ $v->id }}">
																			<i class="las la-file-excel"></i>
																		</a>
																	</span>
																</div>
															</td>

														</tr>
														<?php 
														$total += $v->valor_total;
														?>
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
													<a id="btn-danfe" target="_blank" style="width: 100%" class="btn btn-primary">Gerar Danfe</a>
												</div>

												<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
													<a id="btn-baixar-xml" onclick="baixarXml()" target="_blank" style="width: 100%" class="btn btn-success">Baixar XML</a>
												</div>

												<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
													<a id="btn-xml" onclick="setarNumero(true)" style="width: 100%" class="btn btn-info" data-toggle="modal" data-target="#modal5">Enviar XML</a>
												</div>

												<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
													<a onclick="modalWhatsApp()" style="width: 100%" class="btn btn-success" href="#!">WhatsApp</a>
												</div>

												<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
													<a id="btn-imprimir-cce" onclick="imprimirCCe()" style="width: 100%" class="btn btn-warning" href="#!">Imprimir CC-e</a>
												</div>

												<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
													<a id="btn-imprimir-cancelar" onclick="imprimirCancela()" style="width: 100%" class="btn btn-danger" href="#!">Imprimir Cancela</a>
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

										@foreach($vendas as $v)
										<div class="col-sm-6 col-lg-6 col-md-6 col-xl-6">

											<div class="card card-custom gutter-b example example-compact">
												<div class="card-header">
													<div class="card-title">
														<h3 style="width: 230px; font-size: 15px; height: 10px;" class="card-title">
															<strong class="text-success"> </strong>

															{{$v->cliente->razao_social}}

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

																	@if($v->estado == 'DISPONIVEL' || $v->estado == 'REJEITADO')
																	<li class="navi-item">
																		<a onclick='swal("Atenção!", "Deseja editar este registro?", "warning").then((sim) => {if(sim){ location.href="/vendas/edit/{{ $v->id }}" }else{return false} })' href="#!" class="navi-link">
																			<span class="navi-text">
																				<span class="label label-xl label-inline label-light-primary">Editar</span>
																			</span>
																		</a>
																	</li>

																	<li class="navi-item">
																		<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/vendas/delete/{{ $v->id }}" }else{return false} })' href="#!" class="navi-link">
																			<span class="navi-text">
																				<span class="label label-xl label-inline label-light-danger">Remover</span>
																			</span>
																		</a>
																	</li>
																	@endif

																	<li class="navi-item">
																		<a href="/vendas/detalhar/{{ $v->id }}" class="navi-link">
																			<span class="navi-text">
																				<span class="label label-xl label-inline label-light-info">
																					Detalhar
																				</span>
																			</span>
																		</a>
																	</li>

																	<li class="navi-item">
																		<a href="/vendas/clone/{{ $v->id }}" class="navi-link">
																			<span class="navi-text">
																				<span class="label label-xl label-inline label-light-warning">
																					Copiar
																				</span>
																			</span>
																		</a>
																	</li>

																	<li class="navi-item">
																		<a target="_blank" href="/vendas/gerarXml/{{ $v->id }}" class="navi-link">
																			<span class="navi-text">
																				<span class="label label-xl label-inline label-light">
																					Ver Xml
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
														<span class="kt-widget__label">Valor:</span>
														<a target="_blank" class="kt-widget__data text-success">
															R$ {{ number_format($v->valor_total, 2, ',', '.') }}
														</a>
													</div>

													<div class="kt-widget__info">
														<span class="kt-widget__label">Data:</span>
														<a target="_blank" class="kt-widget__data text-success">
															{{ \Carbon\Carbon::parse($v->created_at)->format('d/m/Y H:i:s')}}
														</a>
													</div>

													<div class="kt-widget__info">
														<span class="kt-widget__label">NFe:</span>
														<a target="_blank" class="kt-widget__data text-success">
															{{ $v->NfNumero > 0 ? $v->NfNumero: '--' }}
														</a>
													</div>

													<div class="kt-widget__info">
														<span class="kt-widget__label">Série:</span>
														<a target="_blank" class="kt-widget__data text-success">
															{{ $v->serie > 0 ? $v->serie : '--' }}
														</a>
													</div>

													<div class="kt-widget__info">
														<span class="kt-widget__label">Estado:</span>
														<a target="_blank" class="kt-widget__data text-success">

															@if($v->estado == 'DISPONIVEL')
															<span class="label label-xl label-inline label-light-primary">Disponível</span>

															@elseif($v->estado == 'APROVADO')
															<span class="label label-xl label-inline label-light-success">Aprovado</span>
															@elseif($v->estado == 'CANCELADO')
															<span class="label label-xl label-inline label-light-danger">Cancelado</span>
															@else
															<span class="label label-xl label-inline label-light-warning">Rejeitado</span>
															@endif
														</a>
													</div>

													<div class="kt-widget__info">
														<span class="kt-widget__label">Usuário:</span>
														<a target="_blank" class="kt-widget__data text-success">
															{{ $v->usuario->nome }}
														</a>
													</div>

													<hr>

													<div class="row">


														@if($v->estado == 'APROVADO')

														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
															<a style="width: 100%; margin-top: 5px;" target="_blank" href="/nf/imprimir/{{$v->id}}" class="btn btn-success">
																<i class="la la-print"></i>
																Imprimir 
															</a>
														</div>

														@if($v->sequencia_cce > 0)
														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
															<a style="width: 100%; margin-top: 5px;" target="_blank" href="/nf/imprimirCce/{{$v->id}}" class="btn btn-warning">
																<i class="la la-print"></i>
																Imprimir CC-e
															</a>
														</div>
														@endif

														<div class="col-sm-12 col-lg-12 col-md-6 col-xl-6">
															<a id="btn_consulta_grid_{{$v->id}}" style="width: 100%; margin-top: 5px;" href="#!" onclick="consultarNFe('{{$v->id}}')" class="btn btn-info spinner-white spinner-right">
																<i class="la la-check"></i>
																Consultar NFe
															</a>
														</div>


														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
															<a id="btn_consulta_grid_{{$v->id}}" style="width: 100%; margin-top: 5px;" href="#!" onclick="cancelarNFe('{{$v->id}}', '{{$v->NfNumero}}')" class="btn btn-danger spinner-white spinner-right">
																<i class="la la-check"></i>
																Cancelar NFe
															</a>
														</div>

														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
															<a style="width: 100%; margin-top: 5px;" href="#!" onclick="corrigirrNFe('{{$v->id}}', '{{$v->NfNumero}}')" class="btn btn-warning spinner-white spinner-right">
																<i class="la la-check"></i>
																Corrigir NFe
															</a>
														</div>

														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
															<a style="width: 100%; margin-top: 5px;" target="_blank" href="/vendas/baixarXml/{{$v->id}}" class="btn btn-danger">
																<i class="la la-download"></i>
																Baixar XML
															</a>
														</div>

														@endif

														@if($v->estado == 'REJEITADO')

														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
															<a id="btn_trnasmitir_grid_{{$v->id}}" style="width: 100%; margin-top: 5px;" href="#!" onclick="transmitirNFe('{{$v->id}}')" class="btn btn-success spinner-white spinner-right">
																<i class="la la-check"></i>
																Transmitir NFe
															</a>
														</div>


														
														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
															<a style="width: 100%; margin-top: 5px;" onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/vendas/delete/{{ $v->id }}" }else{return false} })' href="#!" class="btn btn-danger spinner-white spinner-right">
																<i class="la la-check"></i>
																Remover 
															</a>
														</div>

														@endif

														@if($v->estado == 'DISPONIVEL')

														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
															<a id="btn_trnasmitir_grid_{{$v->id}}" style="width: 100%; margin-top: 5px;" href="#!" onclick="transmitirNFe('{{$v->id}}')" class="btn btn-success spinner-white spinner-right">
																<i class="la la-check"></i>
																Transmitir NFe 
															</a>
														</div>

														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
															<a style="width: 100%; margin-top: 5px;" href="/vendas/rederizarDanfe/{{$v->id}}" class="btn btn-primary" target="_blank">
																<i class="la la-file"></i>
																Renderizar DANFE 
															</a>
														</div>
														
														@endif


														@if($v->estado == 'CANCELADO')
														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
															<a style="width: 100%; margin-top: 5px;" target="_blank" href="/nf/imprimirCancela/{{$v->id}}" class="btn btn-danger">
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
									{{$vendas->links()}}
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


<div class="modal fade" id="modal1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">CANCELAR NFe <strong class="text-danger" id="numero_cancelamento"></strong></h5>
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
				<button type="button" id="btn-cancelar-2" onclick="cancelar()" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Cancelar NFe</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal1_aux" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">CANCELAR NFe <strong class="text-danger" id="numero_cancelamento2"></strong></h5>
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
				<button type="button" id="btn-cancelar-3" onclick="cancelar2()" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Cancelar NFe</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-whatsApp" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" id="id_cancela" name="">
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label" id="">Celular</label>
						<div class="">
							<input type="text" id="celular" name="celular" class="form-control" value="">
						</div>
					</div>

					<div class="form-group validated col-sm-12 col-lg-12">
						<label class="col-form-label" id="">Texto</label>
						<div class="">
							<input type="text" id="texto" name="texto" class="form-control" value="">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="button" id="btn-cancelar-3" onclick="enviarWhatsApp()" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Ok</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal2" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">CONSULTA DE NFe</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">
				<h5>Chave: <strong id="chave"></strong></h5>
				<h5>Motivo: <strong id="motivo"></strong></h5>
				<h5>Protocolo: <strong id="protocolo"></strong></h5>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal3" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">INUTILIZAÇÃO DE NÚMERO(s) DE NFe </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group validated col-sm-6 col-Numero NF Inicial-6">
						<label class="col-form-label" id="">Numero NFe Inicial</label>
						<div class="">
							<input type="text" id="nInicio" placeholder="" name="nInicio" class="form-control" value="">
						</div>
					</div>
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label" id="">Numero NFe Final</label>
						<div class="">
							<input type="text" id="nFinal" placeholder="" name="nFianal" class="form-control" value="">
						</div>
					</div>
					<div class="form-group validated col-sm-12 col-lg-12">
						<label class="col-form-label" id="">Justificativa</label>
						<div class="">
							<input type="text" id="justificativa" placeholder="" name="justificativa" class="form-control" value="">
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
				<h5 class="modal-title">CARTA DE CORREÇÃO NFe <strong class="text-danger" id="numero_correcao"></strong></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
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
				<button type="button" id="btn-corrigir-2" onclick="cartaCorrecao()" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Corrigir NFe</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal4_aux" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">CARTA DE CORREÇÃO NFe <strong class="text-danger" id="numero_correcao_aux"></strong></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group validated col-sm-12 col-lg-12">
						<label class="col-form-label" id="">Correção</label>
						<input type="hidden" id="id_correcao" name="">
						<div class="">
							<input type="text" id="correcao_aux" placeholder="Correção minimo de 15 caracteres" name="correcao" class="form-control" value="">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="button" id="btn-corrigir-2-aux" onclick="cartaCorrecaoAux()" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Corrigir NFe</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal5" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">ENVIAR XML DA NFe <strong class="text-danger" id="numero_nf"></strong></h5>
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
				<input type="hidden" id="venda_id">


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="button" id="btn-send" onclick="enviarEmailXMl()" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Enviar</button>
			</div>
		</div>
	</div>
</div>


@endsection	