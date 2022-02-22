

@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	
	<div class="card-body">

		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			<div class="card card-custom gutter-b example example-compact">
				<div class="card-header">

					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">
									<br>
									<h4>Estoque</h4>

									<table class="datatable-table" style="max-width: 100%; overflow: scroll">
										<thead class="datatable-head">
											<tr class="datatable-row" style="left: 0px;">
												
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Produto</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Categoria</span></th>
												<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Quanitdade</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Un. Compra</span></th>

												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Un. Venda</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Valor de Compra</span></th>

												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Subtotal</span></th>

											</tr>
										</thead>
										<tbody class="datatable-body">
											<?php 
											$subtotal = 0;
											?>
											@foreach($estoque as $e)
											<tr class="datatable-row" style="left: 0px;">
												<td class="datatable-cell"><span class="codigo" style="width: 150px;">
													{{$e->produto->nome}} | {{$e->produto->cor}}
												</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 80px;">{{$e->produto->categoria->nome}}</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 80px;">
													@if($e->produto->unidade_venda == 'UN' || $e->produto->unidade_venda == 'UNID')
													{{number_format($e->quantidade)}}
													@else
													{{number_format($e->quantidade, 3, ',', '.')}}
													@endif
												</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 80px;">
													{{$e->produto->unidade_compra}}
												</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 80px;">
													{{$e->produto->unidade_venda}}
												</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 80px;">
													{{ number_format($e->valor_compra, 2, ',', '.') }} {{$e->produto->unidade_compra}}
												</span></td>

												<td class="datatable-cell"><span class="codigo" style="width: 80px;">
													{{ number_format($e->valorCompra() * $e->quantidade, 2, ',', '.') }}
												</span></td>

												<?php 
												$subtotal += $e->quantidade * $e->valorCompra();
												?>

											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="d-flex justify-content-between align-items-center flex-wrap">
							<div class="d-flex flex-wrap py-2 mr-3">
								@if(isset($links))
								{{$estoque->links()}}
								@endif
							</div>
						</div>

						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
									<div class="card card-custom gutter-b example example-compact">
										<div class="card-header">

											<div class="card-body">
												<h3 class="card-title">Total em Estoque: R$ <strong class="red-text">{{ number_format($subtotal, 2, ',', '.') }}</strong></h3>

												<a target="_blank" class="navi-text" href="/estoque/apontamentoManual">
													<span class="label label-xl label-inline label-light-danger">Apontamento Manual</span>
												</a>

												<a target="_blank" class="navi-text" href="/estoque/listApontamentos">
													<span class="label label-xl label-inline label-light-primary">Listar Alterações</span>
												</a>
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

</div>

@endsection
