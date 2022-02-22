@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="card-body">


		<h3>Cliente: <strong class="text-info">{{$pedido->cliente->nome}}</strong></h3>
		<h3>Soma: <strong class="text-info">{{number_format($pedido->somaItens(), 2)}}</strong></h3>
		<h4>Abertura do carrinho: <strong class="text-info">{{\Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y H:i:s')}}</strong></h4>

		@if(count($pedido->cliente->tokens) == 0)
		<a class="btn btn-info" href="/pedidosDelivery/push/{{$pedido->id}}">
			<i class="la la-bell"></i>
			Enviar push
		</a>
		@endif

		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			<div class="row">
				<div class="col-xl-12">

					<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

						<table class="datatable-table" style="max-width: 100%; overflow: scroll">
							<thead class="datatable-head">
								<tr class="datatable-row" style="left: 0px;">

									<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Produto</span></th>
									<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Quantidade</span></th>
									<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor unitário</span></th>

									<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Subtotal</span></th>

									<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Adicionais</span></th>
								</tr>
							</thead>
							<tbody id="body" class="datatable-body">
								@foreach($pedido->itens as $i)
								<tr class="datatable-row">
									<td class="datatable-cell">
										<span class="codigo" style="width: 200px;">
											@if(count($i->sabores) > 0)
											@foreach($i->sabores as $key => $sb)
											<label>{{$sb->produto->produto->nome}}</label>
											@if($key < count($i->sabores)-1) | @endif
											@endforeach
											@else
											<label>{{$i->produto->produto->nome}}</label>
											@endif
										</span>
									</td>
									<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{$i->quantidade}}</span>
									</td>

									<?php 
									$valor = 0; 
									$valorMaisAdd = 0;
									if(count($i->sabores) > 0){
										foreach($i->sabores as $it){
											$v = $it->maiorValor($it->produto->id, $i->tamanho_id);
											if($v > $valor) $valor = $v;
										}
									}else{
										$valor = $i->produto->valor;
									}

									if(count($i->itensAdicionais) > 0){
										foreach($i->itensAdicionais as $it){
											$valorMaisAdd = $valor + ($i->quantidade * $it->adicional->valor);
										}
									}else{
										$valorMaisAdd = $valor;
									}

									?>

									<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{number_format($valor,2)}}</span>
									</td>
									<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{number_format($valorMaisAdd,2)}}</span>
									</td>
									<td class="datatable-cell">
										<span class="codigo" style="width: 100px;" id="id">
											@if(count($i->itensAdicionais)>0)
											@foreach($i->itensAdicionais as $a)
											<label>{{$a->adicional->nome}}</label>

											@endforeach
											@else
											--
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

@endsection	