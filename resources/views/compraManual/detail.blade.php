
@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="col-xl-12">
		
		<div class="card-body">
			<h4>Código: <strong>{{$compra->id}}</strong></h4>

			@if($compra->nf > 0)
			<h4>NF-e: <strong>{{$compra->nf ?? '*'}}</strong></h4>
			@endif

			<h5>Usuário: <strong>{{$compra->usuario->nome}}</strong></h5>

			@if($compra->nf)
			<h5>Chave: <strong>{{$compra->chave}}</strong></h5>
			@endif

			<h5>Fornecedor: <strong>{{$compra->fornecedor->razao_social}}</strong></h5>
			<h5>Data: <strong>{{ \Carbon\Carbon::parse($compra->created_at)->format('d/m/Y H:i:s')}}</strong></h5>
			<h5>Oservação: <strong>{{$compra->observacao}}</strong></h5>

			
		</div>
	</div>

	<div class="card-body">

		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			<div class="card card-custom gutter-b example example-compact">
				<div class="card-header">

					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">
									<br>
									<h4>Itens da Compra</h4>

									<table class="datatable-table" style="max-width: 100%; overflow: scroll">
										<thead class="datatable-head">
											<tr class="datatable-row" style="left: 0px;">
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">#</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Produto</span></th>
												<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Validade</span></th>

												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Quantidade</span></th>

												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Subtotal</span></th>

											</tr>
										</thead>
										<tbody class="datatable-body">
											@foreach($compra->itens as $i)
											<tr class="datatable-row" style="left: 0px;">
												<td class="datatable-cell"><span class="codigo" style="width: 80px;">{{$i->produto_id}}</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 150px;">{{$i->produto->nome}}</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{number_format($i->valor_unitario, 2, ',', '.')}}</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 80px;">{{ \Carbon\Carbon::parse($i->validade)->format('d/m/Y')}}</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 80px;">{{$i->quantidade}}</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 80px;">{{number_format(($i->valor_unitario * $i->quantidade), 2, ',', '.')}}</span></td>

												
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>

						</div>

					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
								<div class="card card-custom gutter-b example example-compact">
									<div class="card-header">

										<div class="card-body">
											<h3 class="card-title">Total: R$ <strong class="red-text">{{number_format($compra->somaItems(), 2, ',', '.')}}</strong></h3>

											@if($compra->xml_path != '')
											<a target="_blank" class="navi-text" href="/compras/downloadXml/{{$compra->id}}">
												<span class="label label-xl label-inline label-light-success">
													Downlaod XML
												</span>
											</a>
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
	</div>

	

</div>



@endsection
