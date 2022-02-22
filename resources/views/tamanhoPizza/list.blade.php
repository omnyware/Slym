@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="card-body">
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">
			<h4>Tamanhos de Pizza</h4>

			<label>Registros: <strong class="text-success">{{sizeof($tamanhos)}}</strong></label>
			<div class="row">
				<div class="form-group col-lg-3 col-md-4 col-sm-6">
					<a href="/tamanhosPizza/new" class="btn btn-success">
						<i class="la la-plus"></i>
						Novo Tamanho de Pizza
					</a>
				</div>
			</div>

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
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">#</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Nome</span></th>
												<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Pedaços</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Máximo de sabores</span></th>
												<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Ações</span></th>
											</tr>
										</thead>
										<tbody id="body" class="datatable-body">
											@foreach($tamanhos as $t)
											<tr class="datatable-row">
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ $t->id }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 200px;">
														{{ $t->nome }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ $t->pedacos }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ $t->maximo_sabores }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 150px;">
														<a class="btn btn-sm btn-danger" onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/tamanhosPizza/delete/{{ $t->id }}" }else{return false} })' href="#!">
															<i class="la la-trash"></i>				
														</a>

														<a class="btn btn-sm btn-primary" href="/tamanhosPizza/edit/{{ $t->id }}">
															<i class="la la-edit"></i>
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