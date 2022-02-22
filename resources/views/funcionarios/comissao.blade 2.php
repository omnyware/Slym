@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<input type="hidden" id="_token" value="{{ csrf_token() }}">
			<form method="get" action="/funcionarios/comissaoFiltro">
				<div class="row align-items-center">

					<div class="form-group col-lg-3 col-md-4 col-sm-6">
						<label class="col-form-label">Vendedor</label>
						<div class="">
							<div class="input-group">
								<select class="form-control custom-select" name="funcionario_id">
									<option value="--">Todos</option>

									@foreach($funcionarios as $f)
									<option value="{{$f->id}}">{{$f->nome}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					<div class="form-group col-lg-2 col-md-4 col-sm-6">
						<label class="col-form-label">Data Inicial</label>
						<div class="">
							<div class="input-group date">
								<input type="text" name="data_inicial" class="form-control" readonly value="{{{ isset($dataInicial) ? $dataInicial : '' }}}" id="kt_datepicker_3" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group col-lg-2 col-md-4 col-sm-6">
						<label class="col-form-label">Data Final</label>
						<div class="">
							<div class="input-group date">
								<input type="text" name="data_final" class="form-control" readonly value="{{{isset($dataFinal) ? $dataFinal : ''}}}" id="kt_datepicker_3" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group col-lg-2 col-md-4 col-sm-6">
						<label class="col-form-label">Estado</label>
						<div class="">
							<div class="input-group date">
								<select class="custom-select form-control" id="estado" name="status">
									<option @if(isset($status) && $status == 'todos') selected @endif value="--">TODOS</option>
									<option @if(isset($status) && $status == 'pago') selected @endif value="1">PAGO</option>
									<option @if(isset($status) && $status == 'pendente') selected @endif value="0">PENDENTE</option>
								</select>
							</div>
						</div>
					</div>

					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button style="margin-top: 15px;" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
					</div>
				</div>
			</form>
			<br>


			<div class="row">
				<div class="col-lg-3 col-xl-3 col-6">
					<button style="width: 100%" class="btn btn-success" disabled id="btn-pagar" onclick="pagar()">
						<i class="la la-money"></i>
						Pagar Comissão(s) <strong id="total-select">R$ 0,00</strong></button>
					</div>
				</div>

				<div class="row">
					<div class="col-xl-12">

						<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

							<table class="datatable-table" style="max-width: 100%; overflow: scroll">
								<thead class="datatable-head">
									<tr class="datatable-row" style="left: 0px;">
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 70px;"></span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Vendedor</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">% Comissão</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor da venda</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor da comissão</span></th>
										<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Tipo</span></th>
										<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Estado</span></th>

										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Data</span></th>

										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Data de pagamento</span></th>
										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Ações</span></th>
									</tr>
								</thead>

								<tbody id="body" class="datatable-body">

									<?php 
									$soma = 0;
									$somaVendas = 0;
									?>
									@foreach($comissoes as $e)
									<tr class="datatable-row">
										<td id="checkbox">

											@if(!$e->status)
											<p style="width: 80px;">
												<input type="checkbox" class="check" id="test_{{$e->id}}" />
												<label for="test_{{$e->id}}"></label>
											</p>
											@else

											<p style="width: 80px;">

											</p>

											@endif

										</td>

										<td class="datatable-cell" style="display: none">
											<span class="codigo" id="id">
												{{ $e->id }}
											</span>
										</td>
										<td class="datatable-cell">
											<span class="codigo" style="width: 200px;">
												{{ $e->funcionario->nome }}
											</span>
										</td>

										<td class="datatable-cell"><span class="codigo" style="width: 100px;" >{{ number_format($e->valodDaVenda->valor_total, 2) }}</span>
										</td>

										<?php 
										$somaVendas += $e->valodDaVenda->valor_total;
										?>

										<td class="datatable-cell"><span class="codigo" style="width: 100px;" >{{ number_format($e->funcionario->percentual_comissao, 2) }}</span>
										</td>

										<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="valor">{{ number_format($e->valor, 2) }}</span>
										</td>

										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;" id="valor">
												{{$e->tipo()}}
											</span>
										</td>

										
										
										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												@if($e->status == true)
												<span class="label label-xl label-inline label-light-success">Pago</span>

												@else
												<span class="label label-xl label-inline label-light-danger">Pendente</span>

												@endif
											</span>
										</td>

										<td class="datatable-cell"><span class="codigo" style="width: 120px;">{{ \Carbon\Carbon::parse($e->created_at)->format('d/m/Y H:i')}}</span>
										</td>
										<td class="datatable-cell">
											<span class="codigo" style="width: 120px;">
												@if($e->status == true)
												{{ \Carbon\Carbon::parse($e->updated_at)->format('d/m/Y H:i')}}
												@else
												--
												@endif
											</span>
										</td>
										<td class="datatable-cell"><span class="codigo" style="width: 150px;">
											

											<a class="btn btn-danger" title="REMOVER" onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/funcionarios/comissaoDelte/{{$e->id}}" }else{return false} })' href="#!">
												<i class="la la-trash"></i>
											</a>
										</td>


									</tr>
									<?php 
									$soma += $e->valor;
									?>
									@endforeach

								</tbody>
							</table>
						</div>
						<div class="row">
							<h3>Soma Comissão: <strong class="text-info">R$ {{number_format($soma, 2)}}</strong></h3>
							
						</div>

						<div class="row">
							<h3>Soma das vendas: <strong class="text-success">R$ {{number_format($somaVendas, 2)}}</strong></h3>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection	