@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">
		<form class="row" action="/compras/salvarValidade" method="post">

			@csrf
			<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
				@if(session()->has('message'))
				<div class="row">
					<div style="border-radius: 10px;" class="col s12 {{ session('color') }}">
						<h5 class="center-align white-text">{{ session()->get('message') }}</h5>
					</div>
				</div>
				@endif
				<p class="red-text">*Datas com formato inválido serão desconsideradas</p>
				<input type="hidden" name="tamanho_array" value="{{sizeof($itens)}}">

				<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">
					<table class="datatable-table" style="max-width: 100%; overflow: scroll">
						<thead class="datatable-head">
							<tr class="datatable-row" style="left: 0px;">

								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 60px;">#</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Produto</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Fornececor</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Data da Compra</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor Unit.</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Quantidade</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 170px;">Validade</span></th>

							</tr>
						</thead>


						<tbody id="body" class="datatable-body">

							@foreach($itens as $key => $i)
							<tr class="datatable-row">

								<td class="datatable-cell"><span class="codigo" style="width: 60px;" id="id">{{$i->id}}</span>
								</td>

								<td class="datatable-cell"><span class="codigo" style="width: 120px;" id="id">{{$i->produto->nome}}</span>
								</td>

								<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{$i->compra->fornecedor->razao_social}}</span>
								</td>

								<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{ \Carbon\Carbon::parse($i->created_at)->format('d/m/Y H:i:s')}}</span>
								</td>

								<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{number_format($i->valor_unitario, 2)}}</span>
								</td>

								<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{number_format($i->quantidade, 2)}}</span>
								</td>

								<td class="datatable-cell"><span class="codigo" style="width: 170px;" id="id">
									<div class="input-field" style="margin-right: 10px;">
										<input value="" id="data" name="validade_{{$key}}" type="text" class="validate date-input form-control">
										<input value="{{$i->id}}" name="id_{{$key}}" type="hidden" class="validate">

									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>


				<button type="submit" class="btn btn-danger">SALVAR REGISTROS</button>

			</div>

		</form>
	</div>
</div>
@endsection	