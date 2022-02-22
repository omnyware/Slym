@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">
			<div class="col-lg-12" id="content">
				<!--begin::Portlet-->

				<h2 class="card-title">Total de vendas: <strong class="text-info">{{sizeof($vendas)}}</strong></h2>

				<h3>Inicio do caixa: <strong class="text-success">{{ \Carbon\Carbon::parse($abertura->created_at)->format('d/m/Y H:i:s')}}</strong></h3>
				<h3>Finalização do caixa: <strong class="text-danger">{{ \Carbon\Carbon::parse($abertura->updated_at)->format('d/m/Y H:i:s')}}</strong></h3>
				<div class="row">
					<div class="col-xl-12">
						<h3 class="text-info">Total por tipo de pagamento:</h3>
						<div class="kt-section kt-section--first">
							<div class="kt-section__body">
								<div class="row">

									@foreach($somaTiposPagamento as $key => $tp)
									@if($tp > 0)
									<div class="col-sm-4 col-lg-4 col-md-6">
										<div class="card card-custom gutter-b">
											<div class="card-header">
												<h3 class="card-title">
													{{App\VendaCaixa::getTipoPagamento($key)}}
												</h3>
											</div>
											<div class="card-body">
												<h4 class="text-success">R$ {{number_format($tp, 2, ',', '.')}}</h4>
											</div>

										</div>
									</div>
									@endif
									@endforeach

								</div>
							</div>
						</div>
					</div>
				</div>


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

										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>
									</tr>
								</thead>

								<tbody class="datatable-body">

									@foreach($vendas as $v)

									<tr class="datatable-row" >
										<td class="datatable-cell"><span class="codigo" style="width: 70px;">{{$v->id}}</span>
										</td>
										<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ $v->cliente->razao_social ?? 'NAO IDENTIFCADO' }}</span>
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
										<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ $v->estado }}</span>
										</td>
										<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ $v->NFcNumero > 0 ? $v->NFcNumero : '--' }}</span>
										</td>

										<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{ number_format($v->valor_total, 2, ',', '.') }}</span>
										</td>

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

@endsection	
