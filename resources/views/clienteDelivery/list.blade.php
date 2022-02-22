@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="card-body">
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">
			<form method="get" action="/clientesDelivery/pesquisa">
				<div class="row align-items-center">

					<div class="form-group col-lg-4 col-md-6 col-sm-6">
						<label class="col-form-label">Cliente</label>
						<div class="">
							<div class="input-group">
								<input type="text" name="pesquisa" class="form-control" value="{{{isset($pesquisa) ? $pesquisa : ''}}}" />
							</div>
						</div>
					</div>
					

					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button style="margin-top: 15px;" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
					</div>
				</div>
			</form>
			<h4>Clientes Delivery</h4>

			<label>Registros: <strong class="text-success">{{sizeof($clientes)}}</strong></label>
			

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
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">#</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Nome</span></th>
												<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Celular</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Email</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Produtos favoritos</span></th>
												<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Ações</span></th>
											</tr>
										</thead>
										<tbody id="body" class="datatable-body">
											@foreach($clientes as $c)
											<tr class="datatable-row">
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ $c->id }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 200px;">
														{{ $c->nome }} {{ $c->sobre_nome }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ $c->celular }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ $c->email }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ count($c->favoritos) }}
													</span>
												</td>

												<td class="datatable-cell">
													<span class="codigo" style="width: 240px;">

														<a class="btn btn-sm btn-danger" onclick='swal("Atenção!", "Deseja remover este cliente?", "warning").then((sim) => {if(sim){ location.href="/clientesDelivery/delete/{{ $c->id }}" }else{return false} })' href="#!">
															<i class="la la-trash"></i>				
														</a>
														
														<a class="btn btn-sm btn-primary" href="/clientesDelivery/edit/{{ $c->id }}">
															<i class="la la-edit"></i>				
														</a>

														<a class="btn btn-sm btn-success" title="Pedidos" href="/clientesDelivery/pedidos/{{ $c->id }}">
															<i class="la la-shopping-cart"></i>					
														</a>

														<a class="btn btn-sm btn-info" title="Enderecos" href="/clientesDelivery/enderecos/{{ $c->id }}">
															<i class="la la-map"></i>
														</a>


														<a class="btn btn-sm btn-warning" title="Favoritos" href="/clientesDelivery/favoritos/{{ $c->id }}">
															<i class="las la-star"></i>				
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

@endsection	