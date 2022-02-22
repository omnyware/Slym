@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<form method="get" action="/listaDePrecos/filtro">
				<div class="row align-items-center">

					<div class="form-group col-lg-3 col-md-4 col-sm-6">
						<label class="col-form-label">Produto</label>
						<div class="">
							<div class="input-group">
								<input type="text" name="produto" class="form-control"/>
							</div>
						</div>
					</div>

					<div class="form-group col-lg-2 col-md-4 col-sm-6">
						<label class="col-form-label">Lista</label>
						<div class="">
							<div class="input-group date">
								<select class="custom-select form-control" id="estado" name="estado">
									@foreach($listas as $l)
									<option value="{{$l->id}}">{{$l->nome}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button style="margin-top: 15px;" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
					</div>
				</div>
			</form>
			<br>
			<h4>Pesquisa de Preços</h4>
			<label>Numero de registros: {{sizeof($resultados)}}</label>	

			<div class="row">
				<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
					<div class="row">
						<div class="col-xl-12">

							<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

								<table class="datatable-table" style="max-width: 100%; overflow: scroll">
									<thead class="datatable-head">
										<tr class="datatable-row" style="left: 0px;">
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Produto</span></th>
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor venda padrão</span></th>
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor de compra</span></th>
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor venda da lista</span></th>
											
										</tr>
									</thead>
									<tbody id="body" class="datatable-body">
										@foreach($resultados as $r)
										<tr class="datatable-row">
											<td class="datatable-cell"><span class="codigo" style="width: 300px;" id="id">{{$r->nome}}</span>
											</td>
											<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{number_format($r->valor_venda, 2)}}</span>
											</td>
											<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{number_format($r->valor_compra, 2)}}</span>
											</td>
											<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{number_format($r->valor_lista, 2)}}</span>
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


@endsection	