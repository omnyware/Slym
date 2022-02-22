@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="">
			<div class="col-sm-12 col-lg-4 col-md-6 col-xl-4">

				@if(isset($filtro))
				<form method="post" action="/eventos/relatorioAtividadeFiltro">
					@csrf
					<input type="hidden" name="funcionario" value="{{{ isset($funcionario) ? $funcionario : '' }}}">
					<input type="hidden" name="evento" value="{{{ isset($evento) ? $evento : '' }}}">
					<input type="hidden" name="data_inicial" value="{{{ isset($data_inicial) ? $data_inicial : '' }}}">
					<input type="hidden" name="data_final" value="{{{ isset($data_final) ? $data_final : '' }}}">
					<input type="hidden" name="status" value="{{{ isset($status) ? $status : '' }}}">
					<button style="margin-left: 5px;" href="/contasPagar/new" class="btn btn-lg btn-info">
						<i class="fa fa-print"></i>Imprimir relatório
					</button>
				</form>
				@else
				<a style="margin-left: 5px;" href="/eventos/relatorioAtividade" class="btn btn-lg btn-info">
					<i class="fa fa-print"></i>Imprimir relatório
				</a>
				@endif
			</div>
		</div>
		<br>


		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<form method="get" action="/eventos/movimentacaoFiltro">
				<div class="row align-items-center">
					<div class="col-lg-4 col-xl-4">
						<div class="row align-items-center">
							<div class="col-md-12 my-2 my-md-0">
								<label class="col-form-label">Funcionário</label>

								<div class="input-icon">
									<select name="funcionario" class="custom-select">
										<option value="todos">Todos</option>
										@foreach($funcionarios as $f)
										<option 
										@isset($funcionario) 
										@if($funcionario == $f->id)
										selected
										@endif
										@endisset
										value="{{$f->id}}">{{$f->nome}}</option>
										@endforeach
									</select>

								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-4 col-xl-4">
						<div class="row align-items-center">
							<div class="col-md-12 my-2 my-md-0">
								<label class="col-form-label">Evento</label>
								<div class="input-icon">
									<select name="evento" class="custom-select">
										<option value="todos">Todos</option>
										@foreach($eventos as $e)
										<option 
										@isset($evento) 
										@if($evento == $e->id)
										selected
										@endif
										@endisset
										value="{{$e->id}}">{{$e->nome}}</option>
										@endforeach
									</select>

								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-xl-3">
						<div class="row align-items-center">
							<div class="col-md-12 my-2 my-md-0">
								<label class="col-form-label">Estado</label>
								<div class="input-icon">
									<select name="status" class="custom-select">
										<option value="todos">Todos</option>
										<option 
										@isset($status) 
										@if($status == 1)
										selected
										@endif
										@endisset
										value="1">Ativo</option>
										<option 
										@isset($status) 
										@if($status == 0)
										selected
										@endif
										@endisset
										value="0">Desativado</option>
									</select>

								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-2 col-xl-2">
						<div class="row align-items-center">
							<div class="col-md-12 my-2 my-md-0">
								<label class="col-form-label">Data início</label>
								<input type="text" name="data_inicial" class="form-control date-input" value="{{{isset($data_inicial) ? $data_inicial : ''}}}" />
							</div>
						</div>
					</div>

					<div class="col-lg-2 col-xl-2">
						<div class="row align-items-center">
							<div class="col-md-12 my-2 my-md-0">
								<label class="col-form-label">Data final</label>
								<input type="text" name="data_final" class="form-control date-input" value="{{{isset($data_final) ? $data_final : ''}}}" />
							</div>
						</div>
					</div>


					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button style="margin-top: 35px;" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
					</div>
				</div>

			</form>
			<br>

			@if(isset($filtro))
			<h4>Lista de atividades por filtro</h4>
			@else
			<h4>Lista de atividades de hoje</h4>
			@endif
			<label>Total de registros: {{count($atividades)}}</label>

			<div class="row">
				<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">

					<div class="pb-5" data-wizard-type="step-content">

						<!-- Inicio da tabela -->

						<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
							<div class="row">
								<div class="col-xl-12">

									<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

										<table class="datatable-table" style="max-width: 100%; overflow: scroll">
											<thead class="datatable-head">
												<tr class="datatable-row" style="left: 0px;">
													<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Responsável</span></th>
													<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Telefone</span></th>
													<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Criança</span></th>
													<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Data</span></th>
													<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Inicio</span></th>
													<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Fim</span></th>
													<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Estado</span></th>
													<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Valor</span></th>
												</tr>
											</thead>
											<tbody id="body" class="datatable-body">

												@php
												$soma = 0;
												@endphp
												@foreach($atividades as $e)

												<tr class="datatable-row">
													<td class="datatable-cell"><span class="codigo" style="width: 200px;" id="id">{{$e->responsavel_nome}}</span>
													</td>
													<td class="datatable-cell"><span class="codigo" style="width: 200px;" id="id">{{$e->responsavel_telefone}}</span>
													</td>
													<td class="datatable-cell"><span class="codigo" style="width: 200px;" id="id">{{$e->crianca_nome}}</span>
													</td>

													<td class="datatable-cell">
														<span class="codigo" style="width: 150px;" id="id">
															{{ \Carbon\Carbon::parse($e->created_at)->format('d/m/Y')}}
														</span>
													</td>
													<td class="datatable-cell">
														<span class="codigo" style="width: 150px;" id="id">
															{{ \Carbon\Carbon::parse($e->inicio)->format('H:i')}}
														</span>
													</td>
													<td class="datatable-cell">
														<span class="codigo" style="width: 150px;" id="id">
															{{ \Carbon\Carbon::parse($e->fim)->format('H:i')}}
														</span>
													</td>

													<td class="datatable-cell">
														<span class="codigo" style="width: 150px;" id="id">
															@if($e->status)
															<span class="label label-xl label-inline label-light-success">FINALIZADO</span>
															@else
															<span class="label label-xl label-inline label-light-danger">PENDENTE</span>
															@endif
														</span>
													</td>
													<td class="datatable-cell">
														<span class="codigo" style="width: 150px;" id="id">
															{{ number_format($e->total, 2, ',', '.')}}
														</span>
													</td>
												</tr>

												@php
												$soma += $e->total;
												@endphp
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card card-custom gutter-b">

						<div class="card-body">
							<h2>Soma: <strong class="text-info">{{number_format($soma, 2, ',', '.')}}</strong></h2>
						</div>
					</div>
				</div>

			</div>

			<div class="d-flex justify-content-between align-items-center flex-wrap">
				<div class="d-flex flex-wrap py-2 mr-3">
					@if(isset($links))
					{{$atividades->links()}}
					@endif
				</div>
			</div>
		</div>

	</div>
</div>

@endsection