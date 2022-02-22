@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			<h4>Status: 
				@if($ordem->estado == 'pd')
				<span class="label label-xl label-inline label-light-warning">PENDENTE</span>
				@elseif($ordem->estado == 'ap')
				<span class="label label-xl label-inline label-light-success">APROVADO</span>
				@elseif($ordem->estado == 'rp')
				<span class="label label-xl label-inline label-light-danger">REPROVADO</span>
				@else
				<span class="label label-xl label-inline label-light-info">FINALIZADO</span>
				@endif

			</h4>
		</div>

		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			<a href="/ordemServico/alterarEstado/{{$ordem->id}}" class="btn btn-primary orange">
				<i class="la la-refresh"></i>
				Alterar estado
			</a>

			<a target="_blank" href="/ordemServico/imprimir/{{$ordem->id}}" class="btn btn-info">
				<i class="la la-print"></i> Imprimir
			</a>
		</div>

		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">

			<h5>NFSe: 
				@if($ordem->NfNumero)
				<strong>{{$ordem->NfNumero}}</strong>
				@else
				<strong> -- </strong>
				@endif
			</h5>
			<h5>Total <strong class="text-success">R$ {{number_format($ordem->valor, 2, ',', '.')}}</strong></h5>
			<h5>Usuario responsável: <strong class="text-success">{{$ordem->usuario->nome}}</strong></h5>
		</div>
	</div>

	<div class="row" id="content" style="display: block">
		<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

			<div class="container">
				<div class="card card-custom gutter-b example example-compact">
					<div class="col-lg-12">
						<!--begin::Portlet-->

						<form method="post" action="/ordemServico/addServico">
							@csrf

							<div class="row">
								<input type="hidden" id="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="ordem_servico_id" name="" value="{{$ordem->id}}">


								<div class="col-xl-12">

									<div class="form-group validated col-sm-12 col-lg-12">
										<h4>Serviços da OS</h4>

										<div class="kt-section kt-section--first">
											<div class="kt-section__body">

												<div class="row align-items-center">
													<div class="form-group validated col-sm-6 col-lg-6">
														<label class="col-form-label" id="lbl_cpf_cnpj">Serviço</label>
														<div class="">
															<select class="form-control select2 servico" id="kt_select2_1" name="servico">
																@foreach($servicos as $s)
																<option value="{{$s->id}}">{{$s->id}} - {{$s->nome}}</option>
																@endforeach
															</select>
														</div>
													</div>

													<div class="form-group validated col-sm-4 col-lg-3">
														<label class="col-form-label" id="">Quantidade</label>
														<div class="">
															<input type="text" id="quantidade" name="quantidade" class="form-control @if($errors->has('quantidade')) is-invalid @endif" value="">
															@if($errors->has('quantidade'))
															<div class="invalid-feedback">
																{{ $errors->first('quantidade') }}
															</div>
															@endif
														</div>
													</div>

													<div class="col-sm-3 col-lg-2">
														<button style="margin-top: 10px;" type="submit" class="btn btn-success">Adicionar</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-xl-12">
									<div class="row">
										<div class="col-xl-12">
											<div class="container">
												<label>Registros: <strong class="text-success">{{sizeof($ordem->servicos)}}</strong></label>
												<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

													<table class="datatable-table" style="max-width: 100%; overflow: scroll">
														<thead class="datatable-head">
															<tr class="datatable-row" style="left: 0px;">
																<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 300px;">Serviço</span></th>
																<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Quantidade</span></th>
																<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Status</span></th>
																<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Total</span></th>

																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Ações</span></th>
															</tr>
														</thead>

														<tbody class="datatable-body">

															<?php $total = 0; ?>
															@foreach($ordem->servicos as $s)
															<tr class="datatable-row" style="left: 0px;">

																<td class="datatable-cell"><span class="codigo" style="width: 300px;">{{$s->servico->nome}}</span></td>
																<td class="datatable-cell"><span class="codigo" style="width: 200px;">{{$s->quantidade}}</span></td>
																<td class="datatable-cell"><span class="codigo" style="width: 200px;">
																	@if($s->status == true)
																	<span class="label label-xl label-inline label-light-success">FINALIZADO
																	</span>
																	@else
																	<span class="label label-xl label-inline label-light-warning">PENDENTE
																	</span>
																	@endif
																</span></td>
																<?php 
																$total += $s->servico->valor * $s->quantidade;
																?>

																<td class="datatable-cell"><span class="codigo" style="width: 200px;">{{number_format(($total), 2, ',', '.')}}</span></td>

																<td class="datatable-cell"><span class="codigo" style="width: 120px;">
																	<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/ordemServico/deleteServico/{{ $s->id }}" }else{return false} })' href="#!" class="btn btn-danger">
																		<span class="la la-trash"></span>
																	</a>

																	@if($s->status)
																	<a class="btn btn-waning" href="/ordemServico/alterarStatusServico/{{ $s->id }}">
																		<span class="la la-trash"></span>
																	</a>
																	@else
																	<a class="btn btn-success" href="/ordemServico/alterarStatusServico/{{ $s->id }}">
																		<span class="la la-check"></span>
																	</a>
																	@endif
																</span></td>

															</tr>
															@endforeach

														</tbody>
													</table>
												</div>
											</div>

										</div>
									</div>
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<hr>
	<div class="row" id="content" style="display: block">
		<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

			<div class="container">
				<div class="card card-custom gutter-b example example-compact">
					<div class="col-lg-12">
						<!--begin::Portlet-->

						<form method="post" action="/ordemServico/saveFuncionario">
							@csrf

							<div class="row">
								<input type="hidden" id="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="ordem_servico_id" name="" value="{{$ordem->id}}">


								<div class="col-xl-12">

									<div class="form-group validated col-sm-12 col-lg-12">
										<h4>Funcionários da OS</h4>

										<div class="kt-section kt-section--first">
											<div class="kt-section__body">

												<div class="row align-items-center">
													<div class="form-group validated col-sm-4 col-lg-4">
														<label class="col-form-label" id="lbl_cpf_cnpj">Funcionário</label>
														<div class="">
															<select class="form-control select2 servico" id="kt_select2_2" name="funcionario">
																@foreach($funcionarios as $f)
																<option value="{{$f->id}}">{{$f->id}} - {{$f->nome}}</option>
																@endforeach
															</select>
														</div>
													</div>

													<div class="form-group validated col-sm-5 col-lg-5">
														<label class="col-form-label" id="">Função</label>
														<div class="">
															<input type="text" id="quantidade" name="funcao" class="form-control @if($errors->has('funcao')) is-invalid @endif" value="">
															@if($errors->has('funcao'))
															<div class="invalid-feedback">
																{{ $errors->first('funcao') }}
															</div>
															@endif
														</div>
													</div>

													<div class="col-sm-3 col-lg-2">
														<button style="margin-top: 10px;" type="submit" class="btn btn-success">Adicionar</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-xl-12">
									<div class="row">
										<div class="col-xl-12">
											<div class="container">
												<label>Registros: <strong class="text-success">{{sizeof($ordem->funcionarios)}}</strong></label>
												<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

													<table class="datatable-table" style="max-width: 100%; overflow: scroll">
														<thead class="datatable-head">
															<tr class="datatable-row" style="left: 0px;">
																<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 300px;">Nome</span></th>
																<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Função</span></th>
																<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Telefone</span></th>

																<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Ações</span></th>
															</tr>
														</thead>

														<tbody class="datatable-body">

															@foreach($ordem->funcionarios as $f)
															<tr class="datatable-row" style="left: 0px;">

																<td class="datatable-cell"><span class="codigo" style="width: 300px;">{{$f->funcionario->nome}}</span></td>
																<td class="datatable-cell"><span class="codigo" style="width: 200px;">{{$f->funcao}}</span></td>


																<td class="datatable-cell"><span class="codigo" style="width: 200px;">{{$f->funcionario->telefone}} / {{$f->funcionario->celular}}</span></td>

																<td class="datatable-cell"><span class="codigo" style="width: 120px;">
																	<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/ordemServico/deleteFuncionario/{{ $f->id }}" }else{return false} })' href="#!" class="btn btn-danger">
																		<span class="la la-trash"></span>
																	</a>

																</span></td>

															</tr>
															@endforeach

														</tbody>
													</table>
												</div>
											</div>

										</div>
									</div>
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<hr>
	<div class="row" id="content" style="display: block">
		<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

			<div class="container">
				<div class="card card-custom gutter-b example example-compact">
					<div class="col-lg-12">

						<div class="row">

							<div class="col-xl-12">

								<div class="form-group validated col-sm-12 col-lg-12">
									<h4>Relatórios da OS</h4>

								</div>

								<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
									<a href="/ordemServico/addRelatorio/{{$ordem->id}}" class="btn btn-success">
										<i class="la la-plus"></i>
										Adicionar Relatório
									</a>
								</div>
							</div>

							<div class="col-xl-12">
								<div class="row">
									<div class="col-xl-12">
										<div class="container">
											<label>Registros: <strong class="text-success">{{sizeof($ordem->relatorios)}}</strong></label>
											<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

												<table class="datatable-table" style="max-width: 100%; overflow: scroll">
													<thead class="datatable-head">
														<tr class="datatable-row" style="left: 0px;">
															<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">#</span></th>
															<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Data</span></th>
															<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Usuário</span></th>
															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Ações</span></th>
														</tr>
													</thead>

													<tbody class="datatable-body">

														@foreach($ordem->relatorios as $r)
														<tr class="datatable-row" style="left: 0px;">

															<td class="datatable-cell"><span class="codigo" style="width: 80px;">{{$r->id}}</span></td>
															<td class="datatable-cell"><span class="codigo" style="width: 200px;">{{ \Carbon\Carbon::parse($r->data_registro)->format('d/m/Y H:i:s')}}</span></td>


															<td class="datatable-cell"><span class="codigo" style="width: 200px;">{{$r->usuario->nome}}</span></td>

															<td class="datatable-cell"><span class="codigo" style="width: 150px;">
																<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/ordemServico/deleteRelatorio/{{ $r->id }}" }else{return false} })' href="#!" class="btn btn-danger">
																	<span class="la la-trash"></span>
																</a>

																<a class="btn btn-primary" href="/ordemServico/editRelatorio/{{ $r->id }}">
																	<span class="la la-edit"></span>					
																</a>

																<a class="btn btn-info" href="#!" onclick="modal('{{ \Carbon\Carbon::parse($r->data_registro)->format('d/m/Y H:i:s')}}', '{{$r->texto}}')">
																	<span class="la la-sticky-note"></span>					
																</a>

															</span></td>

														</tr>
														@endforeach

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
			</div>
		</div>

	</div>
</div>

<div class="modal fade" id="modal1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="data"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">
				<p id="texto"></p>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

@endsection
