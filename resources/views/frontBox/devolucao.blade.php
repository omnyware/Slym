@extends('default.layout')
@section('content')


<div class="card card-custom gutter-b">


	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<input type="hidden" id="_token" value="{{ csrf_token() }}">

			<div class="row">
				<div class="form-group col-lg-4 col-md-4 col-sm-4">
					<form method="get" action="/frenteCaixa/filtroCliente">

						<div class="input-group">
							<input type="text" placeholder="Nome" name="nome" class="form-control" value="{{$nome}}">
							<div class="input-group-append">
								<button class="btn btn-light-primary" type="button">Buscar</button>
							</div>
						</div>

					</form>
				</div>

				<div class="form-group col-lg-3 col-md-4 col-sm-4">
					<form method="get" action="/frenteCaixa/filtroNFCe">

						<div class="input-group">
							<input type="text" placeholder="NFCe" name="nfce" class="form-control" value="{{$nfce}}">
							<div class="input-group-append">
								<button class="btn btn-light-primary" type="button">Buscar</button>
							</div>
						</div>

					</form>
				</div>

				<div class="form-group col-lg-3 col-md-4 col-sm-4">
					<form method="get" action="/frenteCaixa/filtroValor">

						<div class="input-group">
							<input type="text" placeholder="Valor" id="numeros" name="valor" class="form-control" value="{{$valor}}">
							<div class="input-group-append">
								<button class="btn btn-light-primary" type="button">Buscar</button>
							</div>
						</div>

					</form>
				</div>
			</div>



			<br>
			<h4>Devolução</h4>
			<div class="row">
				<div class="col-lg-2 col-xl-2">
					<a style="width: 100%" href="/frenteCaixa" class="btn btn-light-primary">
						<i class="la la-box"></i>
						FRENTE DE CAIXA
					</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">

					<div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="between" data-wizard-clickable="true">
						<!--begin: Wizard Nav-->

						<div class="wizard-nav">
							<p class="text-danger" style="margin-top: 10px;">{{$info}}</p>

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
																<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Cliente</span></th>
																<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Data</span></th>
																<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Tipo de pagamento</span></th>

																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Estado</span></th>

																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">NFCe</span></th>
																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Usuário</span></th>
																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>

																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 220px;">Ações</span></th>
															</tr>
														</thead>

														<tbody class="datatable-body">
															<?php 
															$total = 0;
															?>
															@foreach($vendas as $v)

															<tr class="datatable-row" style="left: 0px; @if($v->estado == 'REJEITADO') background: #ffcdd2; @elseif($v->estado == 'APROVADO') background: #a7ffeb; @endif">
																<td class="datatable-cell"><span class="codigo" style="width: 70px;">{{$v->id}}</span>
																</td>
																<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ $v->cliente->razao_social ?? 'NAO IDENTIFCADO' }}</span>
																</td>
																<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ \Carbon\Carbon::parse($v->created_at)->format('d/m/Y H:i:s')}}</span>
																</td>
																<td class="datatable-cell">
																	<span class="codigo" style="width: 100px;">

																		@if($v->tipo_pagamento == '99')

																		<a href="#!" onclick='swal("", "{{$v->multiplo()}}", "success")' class="btn btn-light-info">
																			Ver
																		</a>
																		@else
																		{{$v->getTipoPagamento($v->tipo_pagamento)}}
																		@endif

																	</span>
																</td>
																<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ $v->estado }}</span>
																</td>
																<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ $v->NFcNumero > 0 ? $v->NFcNumero : '--' }}</span>
																</td>
																<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ $v->usuario->nome }}</span>
																</td>
																<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ number_format($v->valor_total, 2, ',', '.') }}</span>
																</td>
																<?php $total += $v->valor_total; ?>
																<td class="datatable-cell">
																	<span class="codigo" style="width: 220px;">

																		@if($v->estado == 'APROVADO')
																		<a href="#!" onclick="modalCancelar({{$v->id}})" class="btn btn-warning ">
																			<i class="la la-close"></i>
																		</a>
																		@else
																		<a class="btn btn-danger" onclick='swal("Atenção!", "Deseja remover esta venda?", "warning").then((sim) => {if(sim){ location.href="/frenteCaixa/deleteVenda/{{$v->id}}" }else{return false} })' href="#!">
																			<i class="la la-trash"></i>
																		</a>
																		@endif

																	</span>

																</td>
															</tr>

															@endforeach

														</tbody>
													</table>
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

											@foreach($vendas as $v)
											<div class="col-sm-6 col-lg-6 col-md-6 col-xl-6">

												<div class="card card-custom gutter-b example example-compact">
													<div class="card-header">
														<div class="card-title">
															<h3 style="width: 230px; font-size: 15px; height: 10px;" class="card-title">
																<strong class="text-success">R$ {{ number_format($v->valor_total, 2, ',', '.') }} </strong>- {{ \Carbon\Carbon::parse($v->created_at)->format('d/m/Y H:i:s')}}

															</h3>

														</div>
													</div>

													<div class="card-body">

														<div class="kt-widget__info">
															<span class="kt-widget__label">Cliente:</span>
															<a target="_blank" class="kt-widget__data text-success">
																{{ $v->cliente->razao_social ?? 'NAO IDENTIFCADO' }}
															</a>
														</div>

														<div class="kt-widget__info">
															<span class="kt-widget__label">NFCe:</span>
															<a target="_blank" class="kt-widget__data text-success">
																{{ $v->NFcNumero > 0 ? $v->NFcNumero : '--' }}
															</a>
														</div>

														<div class="kt-widget__info">
															<span class="kt-widget__label">Estado:</span>
															<a target="_blank" class="kt-widget__data text-success">
																{{ $v->estado }}
															</a>
														</div>

														<div class="kt-widget__info">
															<span class="kt-widget__label">Usuário:</span>
															<a target="_blank" class="kt-widget__data text-success">
																{{ $v->usuario->nome }}
															</a>
														</div>

														<div class="kt-widget__info">
															<span class="kt-widget__label">Tipo de pagamento:</span>
															<span class="codigo" style="width: 100px;">

																@if($v->tipo_pagamento == '99')

																<a href="#!" onclick='swal("", "{{$v->multiplo()}}", "info")' class="btn btn-light-info">
																	Ver
																</a>
																@else
																<span class="label label-xl label-inline label-light-success">
																	{{$v->getTipoPagamento($v->tipo_pagamento)}}
																</span>
																@endif

															</span>
														</div>

														<hr>

														<div class="row">

															@if($v->estado == 'APROVADO')
															<a href="#!" style="width: 100%; margin-top: 5px;" onclick="modalCancelar({{$v->id}})" class="btn btn-warning ">
																<i class="la la-close"></i>
																Cancelar NFCe
															</a>
															@else
															<a style="width: 100%; margin-top: 5px;" class="btn btn-danger" onclick='swal("Atenção!", "Deseja remover esta venda?", "warning").then((sim) => {if(sim){ location.href="/frenteCaixa/deleteVenda/{{$v->id}}" }else{return false} })' href="#!">
																<i class="la la-trash"></i>
																Remover
															</a>
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



							</form>

						</div>
					</div>
				</div>
			</div>

			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
						<div class="card card-custom gutter-b example example-compact">
							<div class="card-header">

								<div class="card-body">

									<h3>Total: <strong class="text-success">R$ {{number_format($total, 2)}}</strong></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">CANCELAMENTO DE NFCe</h5>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<input type="hidden" id="venda_id" name="">

			<div class="modal-body">
				<div class="row">
					<div class="form-group validated col-sm-12 col-lg-12 col-12">
						<label class="col-form-label" id="">Justificativa</label>
						<input type="text" placeholder="Justificativa" id="justificativa" name="justificativa" class="form-control" value="">
					</div>
				</div>
			</div>
			<div class="modal-footer">

				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="button" id="btn_cancelar_nfce" onclick="cancelar()" class="btn btn-light-info font-weight-bold spinner-white spinner-right">Cancelar</button>
			</div>
		</div>
	</div>
</div>



@endsection	