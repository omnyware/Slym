@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="card-body">
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">
			
			<h4>Lista de endereços do cliente: <strong>{{$cliente->nome}}</strong></h4>

			<label>Registros: <strong class="text-success">{{count($cliente->enderecos)}}</strong></label>

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
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 250px;">Rua</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Bairro</span></th>
												<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Referência</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Latitude</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Longitude</span></th>
												<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Ações</span></th>
											</tr>
										</thead>
										<tbody id="body" class="datatable-body">
											@foreach($cliente->enderecos as $e)
											<tr class="datatable-row">
												<td class="datatable-cell">
													<span class="codigo" style="width: 250px;">
														{{ $e->rua }}, {{$e->numero}}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ $e->bairro() }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ $e->referencia }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ $e->latitude }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ $e->longitude }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 200px;">
														<a class="btn btn-sm btn-primary" href="/clientesDelivery/enderecosEdit/{{$e->id}}">
															<i class="la la-edit"></i>
														</a>

														@if($e->longitude != '' && $e->latitude != '')
														<a class="btn btn-sm btn-info" href="/clientesDelivery/enderecosMap/{{$e->id}}">
															<i class="la la-map-marked"></i>
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
				</div>
			</div>
		</div>
	</div>
</div>

@endsection	