@extends('default.layout')
@section('content')
<div class="card card-custom gutter-b">


	<div class="card-body">
		<div class="">
			<div class="col-sm-12 col-lg-4 col-md-6 col-xl-4">

				<h3>IBPT 
					<strong style="margin-left: 5px;" class="text-info">{{$ibpt->uf}}</strong>
				</h3>
			</div>
		</div>
		<br>
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">
			<br>

			<div class="row">



				<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
					<div class="row">
						<div class="col-xl-12">

							<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

								<table class="datatable-table" style="max-width: 100%; overflow: scroll">
									<thead class="datatable-head">
										<tr class="datatable-row" style="left: 0px;">
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Código</span></th>
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Descrição</span></th>
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Nacional/Federal</span></th>
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Importado/Federal</span></th>
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Estadual</span></th>
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Municipal</span></th>
										</tr>
									</thead>
									<tbody id="body" class="datatable-body">
										<?php $total = 0; ?>
										@foreach($itens as $i)
										<tr class="datatable-row">
											<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{$i->codigo}}</span>
											</td>
											<td class="datatable-cell"><span class="codigo" style="width: 200px;" id="id">{{$i->descricao}}</span>
											</td>
											<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{$i->nacional_federal}}</span>
											</td>
											<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{$i->importado_federal}}</span>
											</td>
											<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{$i->estadual}}</span>
											</td>
											<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{$i->municipal}}</span>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							<div class="d-flex justify-content-between align-items-center flex-wrap">
								<div class="d-flex flex-wrap py-2 mr-3">
									@if(isset($links))
									{{$itens->links()}}
									@endif
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