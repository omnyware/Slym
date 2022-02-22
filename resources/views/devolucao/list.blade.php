@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<input type="hidden" id="_token" value="{{ csrf_token() }}">
			<form method="get" action="/devolucao/filtro">
				<div class="row align-items-center">

					<div class="form-group col-lg-3 col-md-4 col-sm-6">
						<label class="col-form-label">Fornecedor</label>
						<div class="">
							<div class="input-group">
								<input type="text" name="fornecedor" class="form-control" value="{{{isset($fornecedor) ? $fornecedor : ''}}}" />
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


					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button style="margin-top: 15px;" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
					</div>
				</div>
			</form>
			<br>
			<h4>Lista de Devoluções</h4>

			<a href="/devolucao/nova" class="btn btn-light-danger">
				<i class="la la-plus"></i>
			Nova devolução</a>

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
															<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 70px;">#</span></th>
															<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 70px;">Código</span></th>
															<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Fornecedor</span></th>
															<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Usuário</span></th>
															<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor Integral</span></th>
															<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor Devolvido</span></th>

															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Estado</span></th>

															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Data</span></th>
															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Motivo</span></th>
															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">NFe entrada</span></th>
															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">NFe devolução</span></th>
															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Série</span></th>
															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 280px;">Ações</span></th>
														</tr>
													</thead>

													<tbody id="body" class="datatable-body">

														<?php 
														$total = 0;
														?>
														@foreach($devolucoes as $d)

														<tr class="datatable-row">
															<td id="checkbox">

																<p style="width: 80px;">
																	<input type="checkbox" class="check" id="test_{{$d->id}}" />
																	<label for="test_{{$d->id}}"></label>
																</p>

															</td>
															<td style="display: none" id="estado_{{$d->id}}">{{$d->estado}}</td>

															<td class="datatable-cell"><span class="codigo" style="width: 70px;" id="id">{{$d->id}}</span>
															</td>
															<td class="datatable-cell"><span class="codigo" style="width: 200px;">{{$d->fornecedor->razao_social}}</span>
															</td>
															<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{$d->usuario->nome}}</span>
															</td>
															<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ number_format($d->valor_integral, 2, ',', '.') }}</span>
															</td>
															<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ number_format($d->valor_devolvido, 2, ',', '.') }}</span>
															</td>

															<td class="datatable-cell">
																<span class="codigo" style="width: 100px;">

																	@if($d->estado == 1)
																	<span class="label label-xl label-inline label-light-success">Aprovado</span>
																	@elseif($d->estado == 2)
																	<span class="label label-xl label-inline label-light-warning">Rejeitado</span>
																	@elseif($d->estado == 3)
																	<span class="label label-xl label-inline label-light-danger">Cancelado</span>
																	@else
																	<span class="label label-xl label-inline label-light-primary">Disponivel</span>
																	@endif

																</span>
															</td>

															<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ \Carbon\Carbon::parse($d->created_at)->format('d/m/Y H:i:s')}}</span>
															</td>
															


															<td class="datatable-cell">
																<span class="codigo" style="width: 100px;">

																	<a href="#!" onclick='swal("", "{{$d->motivo}}", "info")' class="btn btn-light-info">
																		Ver
																	</a>

																</span>
															</td>
															
															<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="">{{$d->nNf}}</span>
															</td>
															<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="numeroNf">{{$d->numero_gerado ?? '--'}}</span>
															</td>
															<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="serieNf">{{$d->serie ?? '--'}}</span>
															</td>
															
															<td>
																<div class="row">
																	<span style="width: 280px;">

																		@if($d->estado != 1)	

																		<a class="btn btn-danger" onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/devolucao/delete/{{$d->id}}" }else{return false} })' 
																			title="Excluir devolução" href="#!">
																			<i class="la la-trash"></i>				
																		</a>

																		@else

																		<a class="btn btn-info" title="Ver devolução" href="/devolucao/ver/{{$d->id}}">
																			<i class="la la-file"></i>
																		</a>
																		@endif

																	</span>
																</div>
															</td>

														</tr>

														@endforeach

													</tbody>
												</table>
											</div>
										</div>

										<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
											<div class="row">

												<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
													<a id="btn-enviar" onclick="enviar()" style="width: 100%" class="btn btn-success spinner-white spinner-right" href="#!">Enviar</a>
												</div>

												<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
													<a id="btn-imprimir" onclick="imprimir()" style="width: 100%" class="btn btn-secondary" href="#!">Imprimir</a>
												</div>


												<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
													<a id="btn-cancelar" data-toggle="modal" data-target="#modal1" onclick="setarNumero()" style="width: 100%" class="btn btn-danger" href="#modal1">Cancelar</a>
												</div>

												<div class="col-sm-4 col-lg-4 col-md-4 col-xl-2 col-6">
													<a id="btn-xml" onclick="xmlTemp()" style="width: 100%" class="btn btn-info" href="#modal1">XML temporário</a>
												</div>


											</div>


										</div>

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

										@foreach($devolucoes as $d)
										<div class="col-sm-6 col-lg-6 col-md-6 col-xl-6">

											<div class="card card-custom gutter-b example example-compact">
												<div class="card-header">
													<div class="card-title">
														<h3 style="width: 230px; font-size: 15px; height: 10px;" class="card-title">
															<strong class="text-success"> </strong>

															{{$d->fornecedor->razao_social}}

														</h3>

													</div>
												</div>

												<div class="card-body">

													<div class="kt-widget__info">
														<span class="kt-widget__label">Valor integral:</span>
														<a target="_blank" class="kt-widget__data text-success">
															R$ {{ number_format($d->valor_integral, 2, ',', '.') }}
														</a>
													</div>

													<div class="kt-widget__info">
														<span class="kt-widget__label">Valor devolvido:</span>
														<a target="_blank" class="kt-widget__data text-success">
															R$ {{ number_format($d->valor_devolvido, 2, ',', '.') }}
														</a>
													</div>

													<div class="kt-widget__info">
														<span class="kt-widget__label">Data:</span>
														<a target="_blank" class="kt-widget__data text-success">
															{{ \Carbon\Carbon::parse($d->created_at)->format('d/m/Y H:i:s')}}
														</a>
													</div>

													<div class="kt-widget__info">
														<span class="kt-widget__label">NFe entrada:</span>
														<a target="_blank" class="kt-widget__data text-success">
															{{$d->nNf}}
														</a>
													</div>

													<div class="kt-widget__info">
														<span class="kt-widget__label">NFe gerada:</span>
														<a target="_blank" class="kt-widget__data text-success">
															{{$d->numero_gerado ?? '--'}}
														</a>
													</div>

													<div class="kt-widget__info">
														<span class="kt-widget__label">Série:</span>
														<a target="_blank" class="kt-widget__data text-success">
															{{$d->serie ?? '--'}}
														</a>
													</div>

													<div class="kt-widget__info">
														<span class="kt-widget__label">Estado:</span>
														<a target="_blank" class="kt-widget__data text-success">

															@if($d->estado == 1)
															<span class="label label-xl label-inline label-light-success">Aprovado</span>
															@elseif($d->estado == 2)
															<span class="label label-xl label-inline label-light-warning">Rejeitado</span>
															@elseif($d->estado == 3)
															<span class="label label-xl label-inline label-light-danger">Cancelado</span>
															@else
															<span class="label label-xl label-inline label-light-primary">Disponivel</span>
															@endif
														</a>
													</div>

													<div class="kt-widget__info">
														<span class="kt-widget__label">Usuário:</span>
														<a target="_blank" class="kt-widget__data text-success">
															{{ $d->usuario->nome }}
														</a>
													</div>

													<hr>

													<div class="row">

														@if($d->estado == 0)
														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
															<a id="btn_transmitir_grid_{{$d->id}}" style="width: 100%; margin-top: 5px;" href="#!" onclick="transmitir('{{$d->id}}')" class="btn btn-success spinner-white spinner-right">
																<i class="la la-check"></i>
																Transmitir NFe
															</a>
														</div>
														@endif

														@if($d->estado == 2)
														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
															<a id="btn_transmitir_grid_{{$d->id}}" style="width: 100%; margin-top: 5px;" href="#!" onclick="transmitir('{{$d->id}}')" class="btn btn-success spinner-white spinner-right">
																<i class="la la-check"></i>
																Transmitir NFe
															</a>
														</div>
														@endif

														@if($d->estado == 1)

														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
															<a target="_blank" style="width: 100%; margin-top: 5px;" href="/devolucao/imprimir/{{$d->id}}" class="btn btn-primary spinner-white spinner-right">
																<i class="la la-print"></i>
																Imprimir
															</a>
														</div>
														<div class="col-sm-12 col-lg-12 col-md-12 col-xl-6">
															<a id="btn_cancela_grid_{{$d->id}}" style="width: 100%; margin-top: 5px;" href="#!" onclick="cancelarNFe('{{$d->id}}', '{{$d->numero_gerado}}')" class="btn btn-danger spinner-white spinner-right">
																<i class="la la-check"></i>
																Cancelar NFe
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
									{{$devolucoes->links()}}
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
				<h5 class="modal-title">CANCELAR DEVOLUÇÃO NFe <strong class="text-danger" id="numero_cancelamento"></strong></h5>
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




@endsection	