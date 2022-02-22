@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<h4>Fornecedor: <strong>{{$cotacao->fornecedor->razao_social}}</strong></h4>
		<h4>Data de registro: <strong>{{ \Carbon\Carbon::parse($cotacao->data_registro)->format('d/m/Y H:i')}}</strong></h4>

		<h5>Referencia: {{$cotacao->referencia}}</h5>
		<h5>Observação: {{$cotacao->observacao}}</h5>
		<h5>Link: <strong class="danger-text"> <a href="{{getenv('PATH_URL')}}/response/{{$cotacao->link}}" target="_blank">{{getenv('PATH_URL')}}/response/{{$cotacao->link}}</a></strong></h5>

		<h5>Ativa:
			@if($cotacao->ativa)
			<span class="label label-xl label-inline label-light-success">Sim</span>
			@else
			<span class="label label-xl label-inline label-light-danger">Não</span>
			@endif

		</h5>
		<h5>Respondida:
			@if($cotacao->resposta)
			<span class="label label-xl label-inline label-light-success">Sim</span>
			@else
			<span class="label label-xl label-inline label-light-danger">Não</span>
			@endif
		</h5>

	</div>

	<div class="card-body">
		<h4>Itens da Cotação</h4>

		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			<div class="card card-custom gutter-b example example-compact">
				<div class="card-header">

					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

									<table class="datatable-table" style="max-width: 100%; overflow: scroll">
										<thead class="datatable-head">
											<tr class="datatable-row" style="left: 0px;">
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">#</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Produto</span></th>
												<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Quantidade</span></th>
												<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Valor</span></th>

												<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Ações</span></th>
											</tr>
										</thead>
										<tbody class="datatable-body">
											@foreach($cotacao->itens as $i)
											<tr class="datatable-row" style="left: 0px;">
												<td class="datatable-cell"><span class="codigo" style="width: 80px;">{{$i->id}}</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 150px;">{{$i->produto->nome}}</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 100px;">{{$i->quantidade}}</span></td>
												<td class="datatable-cell"><span class="codigo" style="width: 120px;">{{number_format($i->valor, 2, ',', '.')}}</span></td>
												<th class="datatable-cell">
													<span style="width: 120px;">
														<a href="/cotacao/deleteItem/{{$i->id}}" class="btn btn-danger">
															<span class="la la-trash">
															</span>
														</a>
													</span>
												</th>
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
		</div>
	</div>

	<div class="card-body">
		<div class="row">
			<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
				<div class="card card-custom gutter-b example example-compact">
					<div class="card-header">

						<div class="card-body">
							<h3 class="card-title">Total: <strong class="red-text">R$
									{{number_format($cotacao->valor, 2, ',', '.')}}</strong></h3>

							<div class="kt-widget__info">

								<h5 class="kt-widget__label">Total de itens: <strong>{{count($cotacao->itens)}}</strong></h5>
								<h5 class="kt-widget__label">Forma de pagamento: <strong>{{$cotacao->forma_pagamento}}</strong></h5>
								<h5 class="kt-widget__label">Responsável: <strong>{{$cotacao->responsavel}}</strong></h5>

								<a target="_blank" class="navi-text" href="/cotacao/clonar/{{$cotacao->id}}">
									<span class="label label-xl label-inline label-light-warning">Clonar</span>
								</a>

								@if(!$cotacao->escolhida())
								<a onclick="if (! confirm('Deseja marcar como escolhida esta cotação?')) { return false; }" href="/cotacao/escolher/{{$cotacao->id}}" class="btn green">
								<span class="label label-xl label-inline label-light-success">Marcar como Escolhida</span>

								
								</a>
								@else
								@if($cotacao->escolhida()->id == $cotacao->id)
								<h5 class="text-danger">Essa cotação já foi escolhida!</h5>
								@else
								<br>
								<h5><a href="/cotacao/view/{{$cotacao->escolhida()->id}}">
								<span class="label label-xl label-inline label-light-danger">
								Essa refernência já foi definida para cotação {{$cotacao->escolhida()->id}}
								</span>

								</a></h5>
								@endif

								@endif

							</div>
						</div>


					</div>
				</div>
			</div>


		</div>
	</div>

</div>

<div class="row">



</div>


@endsection