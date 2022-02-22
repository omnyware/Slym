@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			<h2><strong class="red-text">Itens Da Comanda</strong></h2>
			<input type="hidden" id="_token" value="{{csrf_token()}}">

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

			<hr><br><br>
			<h2><strong class="red-text">Itens Removidos</strong></h2>

			<div class="col-xl-12">

				<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

					<table class="datatable-table" style="max-width: 100%; overflow: scroll">
						<thead class="datatable-head">
							<tr class="datatable-row" style="left: 0px;">
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Produto</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Quantidade</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>
								<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Data de inserção</span></th>
								<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Data de remoção</span></th>

							</tr>
						</thead>

						<tbody id="body" class="datatable-body">
							@foreach($removidos as $r)

							<tr class="datatable-row">
								<td class="datatable-cell">
									<span class="codigo" style="width: 200px;">
										{{$r->produto}}
									</span>
								</td>
								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										{{number_format($r->quantidade, 2)}}
									</span>
								</td>
								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										{{number_format($r->valor, 2)}}
									</span>
								</td>

								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										{{$r->data_insercao}}
									</span>
								</td>
								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										{{ \Carbon\Carbon::parse($r->updated_at)->format('d/m/Y H:i:s')}}
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

@endsection	