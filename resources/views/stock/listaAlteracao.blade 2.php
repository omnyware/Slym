

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
									<h4>Alterações</h4>

									<table class="datatable-table" style="max-width: 100%; overflow: scroll">
										<thead class="datatable-head">
											<tr class="datatable-row" style="left: 0px;">
												
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Produto</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Categoria</span></th>
												<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Quanitdade Alterada</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 90px;">Oservação</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Tipo</span></th>

												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Usuário</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Data</span></th>

												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Ações</span></th>

											</tr>
										</thead>
										<tbody class="datatable-body">
											
											@foreach($apontamentos as $a)

											<tr class="datatable-row" style="left: 0px;">
												<td class="datatable-cell"><span class="codigo" style="width: 150px;">
													{{$a->produto->nome}} 
												</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 80px;">{{$a->produto->categoria->nome}}</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 120px;">
													@if($a->produto->unidade_venda == 'UN' || $a->produto->unidade_venda == 'UNID')
													{{number_format($a->quantidade)}} 
													@else
													{{$a->quantidade}} 
													@endif
													{{$a->produto->unidade_venda}}
												</span></td>

												<td class="datatable-cell">
													
													<span class="codigo" style="width: 90px;">
														<button @if(strlen($a->observacao) == 0) disabled @endif type="button" class="btn btn-primary" data-toggle="popover" data-html="true" data-content="{{$a->observacao}}">
															<i class="fa fa-comment-alt"></i>
														</button>
													</span>


												</td>
												<td class="datatable-cell"><span class="codigo" style="width: 80px;">
													{{$a->tipo == 'reducao' ? 'Redução' : 'Incremento'}}
												</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 80px;">
													{{$a->usuario->nome}}
												</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 80px;">
													{{ \Carbon\Carbon::parse($a->created_at)->format('d/m/Y H:i:s')}}
												</span></td>

												<td class="datatable-cell"><span class="codigo" style="width: 80px;">

													<a target="_blank" class="navi-text" href="/estoque/listApontamentos/delete/{{$a->id}}">
														<span class="label label-xl label-inline label-light-danger">Remover</span>
													</a>
												</span></td>

												

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

						

					</div>
				</div>

			</div>
		</div>
	</div>

</div>

@endsection

