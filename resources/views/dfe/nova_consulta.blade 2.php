@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			<h4>Nova Consulta</h4>

			<p id="aguarde" class="text-info">
				<a id="btn-enviar" class="btn btn-success spinner-white spinner spinner-right">
					Consultado novos documentos, aguarde ...
				</a>
			</p>
			<p id="sem-resultado" style="display: none" class="center-align text-danger">Nenhum novo resultado...</p>

			<div class="col-xl-12" id="table" style="display: none">

				<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

					<table class="datatable-table" style="max-width: 100%; overflow: scroll">
						<thead class="datatable-head">
							<tr class="datatable-row" style="left: 0px;">
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 300px;">NOME</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">CNPJ</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">VALOR</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">CHAVE</span></th>
							</tr>
						</thead>

						<tbody id="body" class="datatable-body">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection	