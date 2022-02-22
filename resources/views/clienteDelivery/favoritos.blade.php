@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="card-body">
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">
			
			<h4>Lista de Produtos Favoritos Cliente <strong>{{$cliente->nome}} {{$cliente->sobre_nome}}</strong></h4>

			<label>Registros: <strong class="text-success">{{sizeof($favoritos)}}</strong></label>
			

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
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Produto</span></th>
												<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Total de vezes que Comprou</span></th>
												<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Ações</span></th>
											</tr>
										</thead>
										<tbody id="body" class="datatable-body">
											@foreach($favoritos as $f)
											<tr class="datatable-row">
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														{{ $f->id }}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 200px;">
														{{ $f->produto->produto->nome }}
													</span>
												</td>

												<td class="datatable-cell">
													<span class="codigo" style="width: 200px;">
														{{ $f->totalCompras() }}
													</span>
												</td>

												<td class="datatable-cell">
													<span class="codigo" style="width: 240px;">

														@if(count($f->cliente->tokens) > 0)
														<a href="/clientesDelivery/push/{{ $f->id }}" class="btn btn-sm btn-info">				
															<i class="la la-bell"></i>
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