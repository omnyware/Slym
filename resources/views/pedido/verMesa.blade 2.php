@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			<h2><strong class="red-text">{{$mesa->nome}}</strong></h2>
			<input type="hidden" id="_token" value="{{csrf_token()}}">

			@if(sizeof($pedidos) > 0)

			@foreach($pedidos as $p)
			<?php $pedido = $p; ?>

			<div class="row">
				<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
					<div class="card card-custom gutter-b">
						<div class="card-body">

							<h3>Comanda: <strong class="text-danger">{{$pedido->comanda != '' ? $pedido->comanda : '*'}}</strong></h3>

							<div class="row">


								@if(sizeof($pedido->itens) > 0)
								<div class="col s3">
									<a href="/pedidos/imprimirPedido/{{$pedido->id}}" target="_blank" class="btn btn-info" style="width: 100%">
										<i class="la la-print"></i>
									Imprimir pedido</a>
								</div>
								@endif
							</div>


							<div class="col-xl-12">

								<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

									<table class="datatable-table" style="max-width: 100%; overflow: scroll">
										<thead class="datatable-head">
											<tr class="datatable-row" style="left: 0px;">
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 180px;">Produto</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Tamanho de Pizza</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Sabores</span></th>
												<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Adicionais</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Status</span></th>

												<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>

												<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Quantidade</span></th>
												<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Subtotal+adicional</span></th>
												<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Observação</span></th>

											</tr>
										</thead>
										<tbody id="body" class="datatable-body">
											<?php $finalizado = 0; $pendente = 0; ?>
											@foreach($pedido->itens as $i)
											<?php $temp = $i; ?>

											<tr class="datatable-row">
												<td style="display: none" id="item_id">{{$i->id}}</td>
												<td class="datatable-cell"><span class="codigo" style="width: 180px;" id="estado_{{$i->id}}">{{ $i->produto->nome }}</span>
												</td>

												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														@if(!empty($i->tamanho))
														<label>{{$i->tamanho->nome}}</label>
														@else
														<label>--</label>
														@endif
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														@if(count($i->sabores) > 0)
														
														@foreach($i->sabores as $key => $s)
														{{$s->produto->produto->nome}}
														@if($key < count($i->sabores)-1)
														| 
														@endif
														@endforeach

														@else
														<label>--</label>
														@endif
													</span>
												</td>

												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														<?php $somaAdicionais = 0; ?>
														@if(count($i->itensAdicionais) > 0)
														<label>
															@foreach($i->itensAdicionais as $key => $a)
															{{$a->adicional->nome}}
															<?php $somaAdicionais += $a->adicional->valor * $i->quantidade?>
															@if($key < count($i->itensAdicionais)-1)
															| 
															@endif
															@endforeach
														</label>
														@else
														<label>--</label>
														@endif
													</span>
												</td>


												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">
														@if($i->status)
														<span class="label label-xl label-inline label-light-success">
															Feito
														</span>
														@else
														<span class="label label-xl label-inline label-light-danger">
															Pendente
														</span>
														@endif

													</span>
												</td>

												<?php 
												$valorVenda = 0;
												$valorVenda = $i->valor;
												?>

												<td class="datatable-cell">
													<span style="width: 100px;">
														{{number_format($valorVenda, 2, ',', '.')}}
													</span>
												</td>

												<td class="datatable-cell">
													<span style="width: 100px;">
														{{$temp->quantidade}}
													</span>
												</td>

												<td class="datatable-cell">
													<span style="width: 100px;">
														{{number_format((($valorVenda * $i->quantidade) + $somaAdicionais), 2, ',', '.')}}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;">

														<a href="#!" onclick='swal("", "{{$i->observacao}}", "info")' class="btn btn-light-info @if(!$i->observacao) disabled @endif">
															Ver
														</a>

													</span>
												</td>
												


											</tr>
											<?php 
											if($i->status) $finalizado++;
											else $pendente++;
											?>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<br>
									<h5>TOTAL PRODUTOS: <strong class="text-success">{{number_format($pedido->somaItems(), 2, ',', '.')}}</strong></h5>
									@if($pedido->bairro_id != null)
									<h5>ENTREGA: <strong class="text-success">{{number_format($pedido->bairro->valor_entrega, 2, ',', '.')}}</strong></h5>
									<h4>TOTAL GERAL: <strong class="text-success">{{number_format($pedido->somaItems() + $pedido->bairro->valor_entrega, 2, ',', '.')}}</strong></h4>
									@endif

									<h5>ITENS FINALIZADOS: <strong class="text-success">{{$finalizado}}</strong></h5>
									<h5>ITENS PENDENTES: <strong class="text-warning">{{$pendente}}</strong></h5>
								</div>
							</div>
							<div class="row">
								<br>
								<div class="col-lg-4 col-md-4 col-sm-4">
									<a style="width: 100%;" class="btn btn-ls btn-success @if($pendente > 0 || $pedido->status) disabled @endif green accent-4" href="/pedidos/finalizar/{{$pedido->id}}">
										<i class="la la-check"></i>
									Finalizar Pedido</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			@endforeach

			@else
			<hr>
			<h4 class="text-danger">Nada encontrado!!</h4>
			@endif

		</div>
	</div>
</div>





@endsection	