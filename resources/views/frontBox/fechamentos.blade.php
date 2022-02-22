@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">
			<div class="col-lg-12" id="content">

				<div class="row">
					<div class="col-xl-12">

						<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

							<table class="datatable-table" style="max-width: 100%; overflow: scroll">
								<thead class="datatable-head">
									<tr class="datatable-row" style="left: 0px;">
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">#</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Abertura</span></th>
										<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Finalização</span></th>
										<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Soma</span></th>

										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Ações</span></th>
									</tr>
								</thead>

								<tbody class="datatable-body">

									@foreach($fechamentos as $f)
									<tr class="datatable-row">
										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												{{$f['id']}}
											</span>
										</td>

										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												{{$f['inicio']}}
											</span>
										</td>
										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												{{$f['fim']}}
											</span>
										</td>
										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												{{number_format($f['total'], 2, ',', '.')}}
											</span>
										</td>
										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												<a target="_blank" href="/frenteCaixa/listaFechamento/{{$f['id']}}" class="btn btn-info">
													<i class="la la-list"></i>
												</a>
											</span>
										</td>
									</tr>

									@endforeach
								</table>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	@endsection	
