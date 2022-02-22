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

				@if($clienteDiferente == false)

				<h3 class="card-title">Receber Vendas</h3>
				<h5>Cliente: <strong class="red-text">{{$cliente}}</strong></h5>
				<p>Lista de Vendas a receber: <strong class="text-danger">{{count($vendas)}}</strong></p>


				<div class="row">
					<div class="col-xl-12">

						<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

							<table class="datatable-table" style="max-width: 100%; overflow: scroll">
								<thead class="datatable-head">
									<tr class="datatable-row" style="left: 0px;">
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">#</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Data</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Valor</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Usuário</span></th>
									</tr>
								</thead>
								<tbody class="datatable-body">
									<?php $t = 0; ?>
									@foreach($vendas as $v)
									<tr class="datatable-row" style="left: 0px;">

										<td class="datatable-cell"><span class="codigo" style="width: 120px;">{{$v['id']}}</span></td>
										<td class="datatable-cell"><span class="codigo" style="width: 150px;">{{ \Carbon\Carbon::parse($v['data'])->format('d/m/Y H:i:s')}}</span></td>

										<td class="datatable-cell"><span class="codigo" style="width: 120px;">{{number_format($v['valor'], 2)}}</span></td>

										<td class="datatable-cell"><span class="codigo" style="width: 120px;">{{$v['usuario']}}</span></td>


									</tr>
									<?php $t += $v['valor'] ?>

									@endforeach
								</tbody>
							</table>
						</div>

						<div class="row">
							<div class="col-xl-12">
								<h3>Soma: <strong class="text-success">R$ {{number_format($t, 2, ',', '.')}}</strong></h3>
							</div>
						</div>

						<div class="row">

							<div class="col-lg-4 col-md-4 col-sm-6">
								<a style="width: 100%" href="/vendasEmCredito/emitirNFe?arr={{$arr}}" class="btn btn-light-primary">
									Receber e Emitir NFe
								</a>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6">
								<a style="width: 100%" href="/vendasEmCredito/apenasReceber?arr={{$arr}}" class="btn btn-light-success">
									Receber sem Emitir NFe
								</a>
							</div>

						</div>
					</div>
				</div>


				@else
				<h4 class="center-align red-text">Nao é possível receber contas de multiplos clientes!</h4>
				<h5 class="center-align">Selecione novamente!</h5>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection	