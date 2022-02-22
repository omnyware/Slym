@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="card-body">
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">
			
			<h4>Lista de pedidos do cliente: <strong>{{$cliente->nome}}</strong></h4>


			<label>Registros: <strong class="text-success">{{count($cliente->pedidos)}}</strong></label>
			

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
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">#</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Valor</span></th>
												<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Data</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Forma de Pagamento</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Estado</span></th>
												<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Ações</span></th>
											</tr>
										</thead>

										<tbody id="body" class="datatable-body">
											@foreach($cliente->pedidos as $p)
											<tr class="datatable-row">
												<td class="datatable-cell">
													<span class="codigo" style="width: 120px;">
														{{ $p->id }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 120px;">
														{{ number_format($p->valor_total,2) }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 120px;">
														{{ \Carbon\Carbon::parse($p->data_registro)->format('d/m/Y H:i:s')}}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 120px;">
														@if($p->forma_pagamento == 'dinheiro')
														Dinheiro
														@elseif($p->forma_pagamento == 'credito')
														Cartão de crédito
														@else
														Cartão de débito
														@endif
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 120px;">
														@if($p->estado == 'nv')
														<span class="label label-xl label-inline label-light-primary">NOVO</span>
														@elseif($p->estado == 'rp')
														<span class="label label-xl label-inline label-light-warning">REPORVADO</span>
														@elseif($p->estado == 'rc')
														<span class="label label-xl label-inline label-light-danger">RECUSADO</span>
														@elseif($p->estado == 'ap')
														<span class="label label-xl label-inline label-light-success">APROVADO</span>
														@else
														<span class="label label-xl label-inline label-light-info">FINALIZADO</span>
														@endif
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 120px;">
														<a title="ver pedido" class="btn btn-info" href="/pedidosDelivery/verPedido/{{$p->id}}">
															<i class="la la-clipboard-list"></i>
														</a>
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

<div class="row">
	<div class="col s12">

		<h4>Lista de pedidos do cliente: <strong>{{$cliente->nome}}</strong></h4>

		<div class="row"></div>


		<div class="row">
			<div class="col s12">
				<label>Numero de registros: {{count($cliente->pedidos)}}</label>					
			</div>
			<table class="col s12">
				<thead>
					<tr>
						<th>#</th>
						<th>Valor</th>
						<th>Data</th>
						<th>Forma de Pagamento</th>
						<th>Estado</th>
						<th>Ações</th>
					</tr>
				</thead>

				<tbody>
					@foreach($cliente->pedidos as $p)
					<tr>
						<th>{{ $p->id }}</th>
						<th>{{ number_format($p->valor_total,2) }}</th>
						<th>{{ \Carbon\Carbon::parse($p->data_registro)->format('d/m/Y H:i:s')}}</th>
						<th>
							@if($p->forma_pagamento == 'dinheiro')
							Dinheiro
							@elseif($p->forma_pagamento == 'credito')
							Cartão de crédito
							@else
							Cartão de débito
							@endif

						</th>
						<th>
							@if($p->estado == 'nv')
							<strong class="blue-text">NOVO</strong>
							@elseif($p->estado == 'rp')
							<strong class="red-text">REPORVADO</strong>
							@elseif($p->estado == 'rc')
							<strong class="yellow-text">RECUSADO</strong>
							@elseif($p->estado == 'ap')
							<strong class="green-text">APROVADO</strong>
							@else
							<strong class="cyan-text">FINALIZADO</strong>
							@endif 
						</th>
						<th>
							<a title="ver pedido" href="/pedidosDelivery/verPedido/{{$p->id}}">
								<i class="material-icons">list</i>
							</a>

						</th>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection	