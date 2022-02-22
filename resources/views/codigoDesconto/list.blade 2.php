@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="card-body">
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">
			<div class="">
				<div class="col-sm-12 col-lg-4 col-md-6 col-xl-4">

					<a href="/codigoDesconto/new" class="btn btn-lg btn-success">
						<i class="fa fa-plus"></i>Novo Código de Desconto
					</a>
				</div>
			</div>
			<br>
			<h4>Códigos de Desconto</h4>


			<label>Registros: <strong class="text-success">{{sizeof($codigos)}}</strong></label>
			

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
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Cliente</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Código</span></th>
												<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Status</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">SMS</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">PUSH</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Tipo</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>
												<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Ações</span></th>
											</tr>
										</thead>
										<tbody id="body" class="datatable-body">
											@foreach($codigos as $c)
											<tr class="datatable-row">

												<td class="datatable-cell">
													<span class="codigo" style="width: 200px;">
														@if($c->cliente)
														<label>{{ $c->cliente->nome }}</label>
														@else
														<label>TODOS</label>
														@endif
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ $c->codigo }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														@if($c->ativo)
														<span class="label label-xl label-inline label-light-success">ATIVO</span>
														@else
														<span class="label label-xl label-inline label-light-danger">DESATIVADO</span>
														@endif
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														@if($c->sms)
														<span class="label label-xl label-inline label-light-success">OK</span>
														@else
														<span class="label label-xl label-inline label-light-danger">PENDENTE</span>
														@endif
													</span>
												</td>

												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														@if($c->push)
														<span class="label label-xl label-inline label-light-success">OK</span>
														@else
														<span class="label label-xl label-inline label-light-danger">PENDENTE</span>
														@endif
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ $c->tipo }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ number_format($c->valor, 2, ',', '.') }}
													</span>
												</td>

												<td class="datatable-cell">
													<span class="codigo" style="width: 240px;">

														<!-- aqui -->

														<a class="btn btn-sm btn-primary" href="/codigoDesconto/edit/{{ $c->id }}">
															<i class="la la-edit"></i>				
														</a>

														<a class="btn btn-sm btn-danger" onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/codigoDesconto/delete/{{ $c->id }}" }else{return false} })' href="#!">
															<i class="la la-trash"></i>				
														</a>
														@if($c->ativo)
														<a class="btn btn-sm btn-primary" href="/codigoDesconto/push/{{$c->id}}">
															<i class="la la-bell"></i>
														</a>

														<a class="btn btn-sm btn-dark" href="/codigoDesconto/sms/{{$c->id}}">
															<i class="la la-sms"></i>
														</a>

														<a class="btn btn-sm btn-warning" href="/codigoDesconto/alterarStatus/{{$c->id}}">
															<i class="la la-times"></i>
														</a>
														@else

														<a class="btn btn-sm btn-success" href="/codigoDesconto/alterarStatus/{{$c->id}}">
															<i class="la la-check"></i>
														</a>
														@endif

														<!-- adasd -->
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