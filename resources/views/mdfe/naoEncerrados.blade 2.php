@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">
			<div class="col-xl-12">
				<h4>{{$title}}</h4>

				<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

					<table class="datatable-table" style="max-width: 100%; overflow: scroll">
						<thead class="datatable-head">
							<tr class="datatable-row" style="left: 0px;">
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 70px;">#</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 250px;">Chave</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Protocolo</span></th>
								<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Número</span></th>
								<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Data</span></th>
							</tr>
						</thead>

						<input type="hidden" id="token" value="{{csrf_token()}}" name="">
						<tbody id="body" class="datatable-body">
							@if(count($mdfes) == 0)
							<tr>
								<td colspan="5" class="center-align"><h5 class="red-text">Nada Encontrado</h5></td>
							</tr>
							@endif
							@foreach($mdfes as $m)

							<tr class="datatable-row">
								<td id="checkbox">

									<p style="width: 80px;">
										<input type="checkbox" class="check" id="test_{{$m['chave']}}" />
										<label for="test_{{$m['chave']}}"></label>
									</p>

								</td>

								<td class="datatable-cell">
									<span class="codigo" style="width: 250px;" id="chave">
										{{$m['chave']}}
									</span>
								</td>
								<td class="datatable-cell">
									<span class="codigo" style="width: 150px;" id="protocolo">
										{{$m['protocolo']}}
									</span>
								</td>
								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										{{$m['numero'] > 0 ? $m['numero'] : '--'}}
									</span>
								</td>
								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										{{$m['data'] != '' ? \Carbon\Carbon::parse($m['data'])->format('d/m/Y') : '--'}}
									</span>
								</td>

							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col s3">
					<a id="btn-encerrar" onclick="encerrar()" class="btn btn-danger spinner-white spinner-right  @if(sizeof($mdfes) == 0) disabled @endif" href="#!">Encerrar Documentos</a>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection	