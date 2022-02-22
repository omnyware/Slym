@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">


			<form method="get" action="/dfe/filtro">
				<div class="row align-items-center">

					<div class="form-group col-lg-3 col-md-4 col-sm-6">
						<label class="col-form-label">Data Inicial</label>
						<div class="">
							<div class="input-group date">
								<input type="text" name="data_inicial" class="form-control" readonly value="{{{isset($data_inicial) ? $data_inicial : ''}}}" id="kt_datepicker_3" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group col-lg-3 col-md-4 col-sm-6">
						<label class="col-form-label">Data Final</label>
						<div class="">
							<div class="input-group date">
								<input type="text" name="data_final" class="form-control" readonly value="{{{isset($data_final) ? $data_final : ''}}}" id="kt_datepicker_3" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group validated col-lg-2 col-md-2 col-sm-6">
						<label class="col-form-label text-left col-lg-12 col-sm-12">Tipo</label>

						<select class="custom-select form-control" id="tipo" name="tipo">
							<option value="--">TODOS</option>
							<option value="1">CIÊNCIA</option>
							<option value="2">CONFIRMADA</option>
							<option value="3">DESCONHECIDA</option>
							<option value="4">NÃO REALIZADA</option>
							<option value="0">SEM AÇÃO</option>
						</select>

					</div>

					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button style="margin-top: 15px;" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
					</div>
				</div>
			</form>
			<br>
			<h4>Manifesto</h4>

			<a target="_blank" href="/dfe/novaConsulta" class="btn btn-success">
				<i class="la la-refresh"></i>
				Nova Consulta de Documentos
			</a>

			<h5>Total de registros: <strong style="color: green">{{sizeof($docs)}}</strong></h5>

			<input type="hidden" value="{{json_encode($docs)}}" id="docs">

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
									<div class="wizard-label">
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
						<!--end: Wizard Nav-->
						<!--begin: Wizard Body-->
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
																<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Nome</span></th>
																<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Documento</span></th>
																<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Valor</span></th>
																<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Data Emissão</span></th>

																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Num. Protocolo</span></th>

																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Chave</span></th>
																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Estado</span></th>

																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Ações</span></th>
															</tr>
														</thead>

														<tbody class="datatable-body">

															@foreach($docs as $d)

															<tr class="datatable-row" style="left: 0px;">
																<td class="datatable-cell"><span class="codigo" style="width: 150px;">{{$d->nome}}</span>
																</td>
																<td class="datatable-cell"><span class="codigo" style="width: 150px;">{{$d->documento}}</span>
																</td>
																<td class="datatable-cell"><span class="codigo" style="width: 80px;">{{number_format($d->valor, 2)}}</span>
																</td>
																<td class="datatable-cell"><span class="codigo" style="width: 80px;">{{ \Carbon\Carbon::parse($d->data_emissao)->format('d/m/Y H:i:s')}}</span>
																</td>
																<td class="datatable-cell"><span class="codigo" style="width: 150px;">{{$d->num_prot}}</span>
																</td>
																<td class="datatable-cell"><span class="codigo" style="width: 200px;">{{$d->chave}}</span>
																</td>
																<td class="datatable-cell"><span class="codigo" style="width: 80px;">{{$d->estado()}}</span>
																</td>
																<td class="datatable-cell">
																	<span class="codigo" style="width: 120px;">
																		@if($d->tipo == 1 || $d->tipo == 2)
																		<a style="width: 100%;" target="_blank" href="/dfe/download/{{$d->chave}}" class="btn btn-success">Completa</a>
																		<a style="width: 100%;" target="_blank" href="/dfe/imprimirDanfe/{{$d->chave}}" class="btn btn-primary">Imprimir</a>
																		@elseif($d->tipo == 3)
																		<a style="width: 100%;" class="btn btn-danger">Desconhecida</a>
																		@elseif($d->tipo == 4)
																		<a style="width: 100%;" class="btn btn-warning">Não realizada</a>

																		@else
																		<a style="width: 100%;" class="btn btn-info" onclick="setarEvento('{{$d->chave}}')" data-toggle="modal" data-target="#modal1">Manifestar</a>
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

											@foreach($docs as $d)
											<div class="col-sm-6 col-lg-6 col-md-6 col-xl-6">

												<div class="card card-custom gutter-b example example-compact">
													<div class="card-header">
														<div class="card-title">
															<h3 style="width: 230px; font-size: 15px; height: 10px;" class="card-title">{{$d->nome}}
															</h3>

														</div>
													</div>

													<div class="card-body">

														<div class="kt-widget__info">
															<span class="kt-widget__label">Documento:</span>
															<a target="_blank" class="kt-widget__data text-success">
																{{ $d->documento }}
															</a>
														</div>
														<div class="kt-widget__info">
															<span class="kt-widget__label">Valor:</span>
															<a target="_blank" class="kt-widget__data text-success">
																{{number_format($d->valor, 2)}}
															</a>
														</div>
														<div class="kt-widget__info">
															<span class="kt-widget__label">Data:</span>
															<a target="_blank" class="kt-widget__data text-success">
																{{ \Carbon\Carbon::parse($d->data_emissao)->format('d/m/Y H:i:s')}}
															</a>
														</div>
														<div class="kt-widget__info">
															<span class="kt-widget__label">Chave:</span>
															<a target="_blank" class="kt-widget__data text-success">
																{{ $d->chave }}
															</a>
														</div>
														<div class="kt-widget__info">
															<span class="kt-widget__label">Estado:</span>
															<a target="_blank" class="kt-widget__data text-success">
																{{ $d->estado() }}
															</a>
														</div>

														@if($d->tipo == 1 || $d->tipo == 2)
														<a style="width: 100%;" target="_blank" href="/dfe/download/{{$d->chave}}" class="btn btn-success">Completa</a>
														<a style="width: 100%;" target="_blank" href="/dfe/imprimirDanfe/{{$d->chave}}" class="btn btn-primary">Imprimir</a>
														@elseif($d->tipo == 3)
														<a style="width: 100%;" class="btn btn-danger">Desconhecida</a>
														@elseif($d->tipo == 4)
														<a style="width: 100%;" class="btn btn-warning">Não realizada</a>

														@else
														<a style="width: 100%;" class="btn btn-info" onclick="setarEvento('{{$d->chave}}')" data-toggle="modal" data-target="#modal1">Manifestar</a>
														@endif
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
		</div>


	</div>
</div>

<!-- <div id="modal1" class="modal">
	<form method="get" action="/dfe/manifestar">


		<div class="modal-content">
			<h4>MANIFESTAÇÃO DE DESTINATÁRIO</h4>
			<div class="row">

				<div class="input-field col s10">
					<select name="evento" id="tipo_evento">
						<option value="1">Ciencia de operção</option>
						<option value="2">Confirmação</option>
						<option value="3">Desconhecimento</option>
						<option value="4">Operação não realizada</option>

					</select>
					<label>Evento</label>
				</div>
			</div>

			<input type="hidden" id="nome" name="nome" />
			<input type="hidden" id="cnpj" name="cnpj" />
			<input type="hidden" id="valor" name="valor" />
			<input type="hidden" id="data_emissao" name="data_emissao" />
			<input type="hidden" id="num_prot" name="num_prot" />
			<input type="hidden" id="chave" name="chave" />

			<div class="row">
				<div class="input-field col s12" style="display: none" id="div-just">
					<input type="text" name="justificativa" id="justificativa" data-length="100">

					<label>Justificativa</label>
				</div>
			</div>

		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close red white-text waves-effect waves-green btn-flat">Fechar</a>
			<button href="#!" class="modal-action waves green accent-3 btn">OK</button>
		</div>
	</form>
</div>
-->

<div class="modal fade" id="modal1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<form method="get" action="/dfe/manifestar">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Manifestação de Destinatário</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						x
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="nome" name="nome" />
					<input type="hidden" id="cnpj" name="cnpj" />
					<input type="hidden" id="valor" name="valor" />
					<input type="hidden" id="data_emissao" name="data_emissao" />
					<input type="hidden" id="num_prot" name="num_prot" />
					<input type="hidden" id="chave" name="chave" />

					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">Unidade de venda</label>
						<select class="custom-select form-control" name="evento" id="tipo_evento">
							<option value="1">Ciencia de operção</option>
							<option value="2">Confirmação</option>
							<option value="3">Desconhecimento</option>
							<option value="4">Operação não realizada</option>
						</select>
					</div>

					<div class="form-group validated col-sm-12 col-lg-12" id="div-just" style="display: none">
						<label class="col-form-label">Justificativa</label>
						<div class="">
							<input id="justificativa" type="text" class="form-control" name="justificativa" value="">

						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
					<button type="submit" id="salvarEdit" class="btn btn-success font-weight-bold spinner-white spinner-right">Manifestar</button>
				</div>
			</div>
		</div>
	</form>
</div>



@endsection	