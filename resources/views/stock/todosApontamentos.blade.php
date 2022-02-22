@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<br>
			<form method="get" action="/estoque/filtroApontamentos">
				<div class="row align-items-center">

					<div class="form-group col-lg-3 col-md-4 col-sm-6">
						<label class="col-form-label">Data Inicial</label>
						<div class="">
							<div class="input-group date">
								<input type="text" name="dataInicial" class="form-control" readonly value="{{isset($dataInicial) ? $dataInicial : ''}}" id="kt_datepicker_3" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group col-lg-3 col-md-4 col-sm-6">
						<label class="col-form-label">Data de Final</label>
						<div class="">
							<div class="input-group date">
								<input type="text" name="dataFinal" class="form-control" readonly value="{{isset($dataFinal) ? $dataFinal : ''}}" id="kt_datepicker_3" />
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
			<h4>Todos os Apontamentos</h4>
			<label>Total de registros: {{count($apontamentos)}}</label>
			<div class="row">


				<div class="col-xl-12">
					<div class="row">
						<div class="col-xl-12">
							<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">
								<br>

								<table class="datatable-table" style="max-width: 100%; overflow: scroll">
									<thead class="datatable-head">
										<tr class="datatable-row" style="left: 0px;">

											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Produto</span></th>
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Quantidade</span></th>
											<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Data de registro</span></th>
											<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Un. Compra</span></th>

											<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Un. Venda</span></th>
											<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Valor de venda</span></th>


										</tr>
									</thead>
									<tbody class="datatable-body">
										<?php 
										$somaQuatidade = 0;
										?>
										@foreach($apontamentos as $a)
										<tr class="datatable-row" style="left: 0px;">
											<td class="datatable-cell"><span class="codigo" style="width: 150px;">
												{{$a->produto->nome}}
											</span></td>
											<td class="datatable-cell"><span class="codigo" style="width: 80px;">
												{{$a->quantidade}}
											</span></td>
											<td class="datatable-cell"><span class="codigo" style="width: 80px;">
												{{ \Carbon\Carbon::parse($a->data_registro)->format('d/m/Y H:i:s')}}
											</span></td>
											<td class="datatable-cell"><span class="codigo" style="width: 80px;">
												{{$a->produto->unidade_compra}}
											</span></td>
											<td class="datatable-cell"><span class="codigo" style="width: 80px;">
												{{$a->produto->unidade_venda}}
											</span></td>
											

											<td class="datatable-cell"><span class="codigo" style="width: 80px;">
												{{number_format($a->produto->valor_venda, 2, ',', '.') }}
											</span></td>

											<?php 
											$somaQuatidade += $a->quantidade;
											?>

										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="d-flex justify-content-between align-items-center flex-wrap">
						<div class="d-flex flex-wrap py-2 mr-3">
							@if(isset($links))
							{{$apontamentos->links()}}
							@endif
						</div>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
								<div class="card card-custom gutter-b example example-compact">
									<div class="card-header">

										<div class="card-body">
											<h3 class="card-title">Quantidade Total: <strong style="margin-left: 5px;"> {{ number_format($somaQuatidade, 3) }}</strong></h3>

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

@endsection
