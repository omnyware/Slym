@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<input type="hidden" id="_token" value="{{ csrf_token() }}">
			<form method="get" action="/vendasEmCredito/filtro">
				<div class="row align-items-center">

					<div class="form-group col-lg-3 col-md-4 col-sm-6">
						<label class="col-form-label">Cliente</label>
						<div class="">
							<div class="input-group">
								<input type="text" name="cliente" class="form-control" value="{{{ isset($cliente) ? $cliente : '' }}}" />
							</div>
						</div>
					</div>

					<div class="form-group col-lg-2 col-md-4 col-sm-6">
						<label class="col-form-label">Data Inicial</label>
						<div class="">
							<div class="input-group date">
								<input type="text" name="data_inicial" class="form-control" readonly value="{{{ isset($dataInicial) ? $dataInicial : '' }}}" id="kt_datepicker_3" />
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
								<select class="custom-select form-control" id="estado" name="status">
									<option @if(isset($status) && $status == 'todos') selected @endif value="todos">TODOS</option>
									<option @if(isset($status) && $status == 'pago') selected @endif value="pago">PAGO</option>
									<option @if(isset($status) && $status == 'pendente') selected @endif value="pendente">PENDENTE</option>
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
			<h4>Conta Crédito</h4>

			<div class="row">
				<div class="col-lg-3 col-xl-3 col-6">
					<button style="width: 100%" class="btn btn-success disabled" id="btn-receber" onclick="receber()">
						<i class="la la-money"></i>
					Receber Conta(s) <strong id="total-select">R$ 0,00</strong></button>
				</div>
			</div>

			<div class="row">
				<div class="col-xl-12">

					<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

						<table class="datatable-table" style="max-width: 100%; overflow: scroll">
							<thead class="datatable-head">
								<tr class="datatable-row" style="left: 0px;">
									<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 70px;"></span></th>
									<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 70px;">Código</span></th>
									<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 300px;">Cliente</span></th>
									<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Venda</span></th>
									<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>

									<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Data de cadastro</span></th>

									<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Data de recebimento</span></th>

									<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Status</span></th>

									<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Ações</span></th>
								</tr>
							</thead>

							<tbody id="body" class="datatable-body">

								<?php 
								$soma = 0;
								?>
								@foreach($vendas as $v)
								<tr class="datatable-row">
									<td id="checkbox">

										@if(!$v->status)
										<p style="width: 80px;">
											<input type="checkbox" class="check" id="test_{{$v->venda_id}}" />
											<label for="test_{{$v->venda_id}}"></label>
										</p>
										@else

										<p style="width: 80px;">

										</p>

										@endif

									</td>
									<td class="datatable-cell">
										<span class="codigo" style="width: 70px;" id="id">
											{{ $v->venda_id }}
										</span>
									</td>
									<td class="datatable-cell">
										<span class="codigo" style="width: 300px;">
											{{ $v->cliente->razao_social }}
										</span>
									</td>
									<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ $v->venda->id }}</span>
									</td>

									<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="valor">{{ number_format($v->venda->valor_total, 2) }}</span>
									</td>
									<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ \Carbon\Carbon::parse($v->created_at)->format('d/m/Y H:m')}}</span>
									</td>
									<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ \Carbon\Carbon::parse($v->updated_at)->format('d/m/Y H:m')}}</span>
									</td>
									<td class="datatable-cell">
										<span class="codigo" style="width: 100px;">
											@if($v->status == true)
											<span class="label label-xl label-inline label-light-success">Pago</span>

											@else
											<span class="label label-xl label-inline label-light-danger">Pendente</span>

											@endif
										</span>
									</td>
									<td class="datatable-cell"><span class="codigo" style="width: 150px;">
										<a target="_blank" class="btn btn-info" title="CUPOM NAO FISCAL" href="/nfce/imprimirNaoFiscalCredito/{{$v->id}}">
											<i class="la la-print"></i>
										</a>

										<a class="btn btn-danger" title="REMOVER" onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/vendasEmCredito/delete/{{$v->id}}" }else{return false} })' href="#!">
											<i class="la la-trash"></i>
										</a>
									</td>


								</tr>
								<?php 
								$soma += $v->venda->valor_total;
								?>
								@endforeach

							</tbody>
						</table>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>

@endsection	