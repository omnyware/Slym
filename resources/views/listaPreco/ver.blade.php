@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			<h4>Lista de Preço <strong class="text-primary">{{$lista->nome}}</strong></h4>
			<h4>Percentual de alteração: <strong class="text-danger">{{$lista->percentual_alteracao}}%</strong></h4>

			<h5>Total de produtos cadastrados no sistema: <strong class="text-danger">{{sizeof($produtos)}}</strong></h5>

			@if(sizeof($lista->itens) > 0)
			<div class="row">
				<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
					<div class="row">
						<div class="col-xl-12">

							<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

								<table class="datatable-table" style="max-width: 100%; overflow: scroll">
									<thead class="datatable-head">
										<tr class="datatable-row" style="left: 0px;">
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 300px;">Produto</span></th>
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor venda padrão</span></th>
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor de compra</span></th>
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor venda da lista</span></th>
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Percentual de lucro</span></th>
											<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Ações</span></th>
										</tr>
									</thead>

									<tbody id="body" class="datatable-body">
										@foreach($lista->itens as $i)
										<tr class="datatable-row">
											<td class="datatable-cell"><span class="codigo" style="width: 300px;" id="id">{{$i->produto->nome}}</span>
											</td>
											<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{number_format($i->produto->valor_venda, 2)}}</span>
											</td>
											<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{number_format($i->produto->valor_compra, 2)}}</span>
											</td>
											<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{number_format($i->valor, 2)}}</span>
											</td>
											<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">{{number_format($i->percentual_lucro, 2)}}</span>
											</td>
											<td class="datatable-cell">
												<span class="codigo" style="width: 120px;" id="id">
													<a class="btn btn-light-primary" href="/listaDePrecos/editValor/{{ $i->id }}">
														<i class="la la-edit"></i>				
													</a>
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

			@else
			<h5 class="center-align text-danger">Esta lista ainda não tem produtos cadastrados <a class="btn btn-light-success" href="/listaDePrecos/gerar/{{$lista->id}}">Gerar Lista de Produtos</a></h5>

			@endif
		</div>

	</div>
</div>


@endsection	