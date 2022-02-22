@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="content d-flex flex-column flex-column-fluid" id="kt_content" >

			<div class="row" id="anime" style="display: none">
				<div class="col s8 offset-s2">
					<lottie-player src="/anime/success.json" background="transparent" speed="0.8" style="width: 100%; height: 300px;" autoplay >
					</lottie-player>
				</div>
			</div>

			<div class="col-lg-12" id="content">
				<!--begin::Portlet-->

				<h3 class="card-title">Venda código: <strong>{{$venda->id}}</strong></h3>

				<div class="row">
					<div class="col-xl-12">

						<div class="kt-section kt-section--first">
							<div class="kt-section__body">

								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-12">
										<h4>Cliente: <strong class="text-success">{{$venda->cliente->razao_social}}</strong></h4>
										<h5>CNPJ: <strong class="text-success">{{$venda->cliente->cpf_cnpj}}</strong></h5>
										<h5>Data: <strong class="text-success">{{ \Carbon\Carbon::parse($venda->data_registro)->format('d/m/Y H:i:s')}}</strong></h5>
										<h5>Valor Total: <strong class="text-success">{{ number_format($venda->valor_total, 2, ',', '.') }}</strong></h5>
										<h5>Cidade: <strong class="text-success">{{ $venda->cliente->cidade->nome }} ({{ $venda->cliente->cidade->uf }})</strong></h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<hr>
				<div class="row">
					<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">
						<h3>Itens da Venda</h3>
						<table class="datatable-table" style="max-width: 100%; overflow: scroll;" id="prod">
							<thead class="datatable-head">
								<tr class="datatable-row" style="left: 0px;">
									<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">ID</span></th>
									<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 450px;">Produto</span></th>
									<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Quantidade</span></th>
									<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Valor</span></th>
									<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Subtotal</span></th>
								</tr>
							</thead>

							<tbody class="datatable-body">
								<?php $somaItens = 0; ?>
								@foreach($venda->itens as $i)
								<tr class="datatable-row" style="left: 0px;">

									<td class="datatable-cell"><span class="codigo" style="width: 120px;">{{$i->produto->id}}</span></td>
									<td class="datatable-cell"><span class="codigo" style="width: 450px;">{{$i->produto->nome}}</span></td>

									<td class="datatable-cell"><span class="codigo" style="width: 120px;">{{$i->quantidade}}</span></td>
									<td class="datatable-cell"><span class="codigo" style="width: 120px;">{{number_format($i->valor, 2, ',', '.')}}</span></td>

									<td class="datatable-cell"><span class="codigo" style="width: 120px;">{{number_format($i->valor*$i->quantidade, 2, ',', '.')}}</span></td>


								</tr>
								<?php $somaItens+=  $i->valor * $i->quantidade?>

								@endforeach
							</tbody>
						</table>
					</div>
					<h4>Soma: <strong class="text-info">R$ {{number_format($somaItens, 2, ',', '.')}}</strong></h4>
				</div>



				<hr>
				<div class="row">


					<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">
						<h3>Fatura</h3>
						<p>Forma de pagamento: <strong class="text-danger">{{$venda->forma_pagamento}}</strong></p>

						<table class="datatable-table" style="max-width: 100%; overflow: scroll;" id="prod">
							<thead class="datatable-head">
								<tr class="datatable-row" style="left: 0px;">
									<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Vencimento</span></th>
									<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Valor</span></th>
								</tr>
							</thead>

							@if(sizeof($venda->duplicatas) > 0)
							<tbody class="datatable-body">
								@foreach($venda->duplicatas as $dp)
								<tr class="datatable-row" style="left: 0px;">

									<td class="datatable-cell"><span class="codigo" style="width: 200px;">
										{{ \Carbon\Carbon::parse($dp->data_vencimento)->format('d/m/Y')}}
									</span></td>
									<td class="datatable-cell"><span class="codigo" style="width: 200px;">
										{{number_format($dp->valor_integral, 2, ',', '.')}}
									</span></td>
								</tr>
								@endforeach
							</tbody>
							@else

							<tbody class="datatable-body">
								<tr class="datatable-row" style="left: 0px;">

									<td class="datatable-cell"><span class="codigo" style="width: 200px;">
										{{ \Carbon\Carbon::parse($venda->created_at)->format('d/m/Y')}}
									</span></td>
									<td class="datatable-cell"><span class="codigo" style="width: 200px;">
										{{number_format($venda->valor_total, 2, ',', '.')}}
									</span></td>
								</tr>
							</tbody>
							@endif
						</table>
					</div>
				</div>

				<div class="row">
					<a target="_blank" href="/vendas/imprimirPedido/{{$venda->id}}" class="btn btn-lg btn-light-success">
						<i class="la la-print"></i>
						Imprimir
					</a>
				</div>

			</div>
		</div>
	</div>
</div>




@endsection	