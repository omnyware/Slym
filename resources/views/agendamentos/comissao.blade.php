@extends('default.layout')
@section('content')
<style type="text/css">
	#calendar{
		margin-top: 10px;
	}

	.categorias{
		overflow: auto;
		white-space: nowrap;
		height: 100px;
	}
	.categorias button{
		width: 200px;
		display: inline-block;
	}
	.servico{
		margin-left: 5px;
	}
</style>
<div class="card card-custom gutter-b">
	<div class="card-body">
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<form method="get" action="/agendamentos/filtrarComissao">

				<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">


					<div class="row align-items-center">

						<div class="form-group col-lg-4 col-xl-4">
							<div class="row align-items-center">

								<div class="col-md-12 my-2 my-md-0">
									<label class="col-form-label">Atendente</label>


									<select required class="form-control select2" style="width: 100%" id="kt_select2_1" name="funcionario">
										<option value="null">Selecione o atendente</option>
										@foreach($funcionarios as $f)
										<option @isset($funcionario) @if($f->id == $funcionario) selected @endif @endisset value="{{$f->id}}">{{$f->id}} - {{$f->nome}}</option>
										@endforeach
									</select>

								</div>

							</div>
						</div>

						<div class="form-group col-lg-2 col-md-4 col-sm-6">
							<label class="col-form-label">Data Inicial</label>
							<div class="">
								<div class="input-group date">
									<input name="data_inicial" type="text" class="form-control data_inicial" readonly value="{{{ isset($dataInicial) ? $dataInicial : '' }}}" id="kt_datepicker_3" />
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
									<input name="data_final" type="text" class="form-control data_final" readonly value="{{{ isset($dataFinal) ? $dataFinal : '' }}}" id="kt_datepicker_3" />
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-calendar"></i>
										</span>
									</div>
								</div>
							</div>
						</div>

						

						<div class="col-lg-2 col-xl-2 mt-4 mt-lg-0">
							<button id="filtrar" style="margin-top: 14px;" class="btn btn-light-primary spinner-white spinner-right">Pesquisa</button>
						</div>

					</div>

				</div>
			</form>



			@isset($agendamentos)

			@if($arrAgrupado == null)

			<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
				<div class="row">
					<div class="col-xl-12">

						<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

							<table class="datatable-table" style="max-width: 100%; overflow: scroll">
								<thead class="datatable-head">
									<tr class="datatable-row" style="left: 0px;">
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 60px;">#</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Cliente</span></th>

										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Atendente</span></th>
										<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Data</span></th>
										<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Horário</span></th>
										<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 140px;">Valor do agendamento</span></th>

										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 140px;">Valor de comissão</span></th>

									</tr>
								</thead>

								<tbody id="body" class="datatable-body">
									<?php 
									$somaValor = 0; 
									$somaComissao = 0; 
									?>
									@foreach($agendamentos as $a)

									<tr class="datatable-row">
										<td class="datatable-cell"><span class="codigo" style="width: 70px;" id="id">{{$a->id}}</span>
										</td>
										<td class="datatable-cell"><span class="codigo" style="width: 200px;" id="id">{{$a->cliente->razao_social}}</span>
										</td>
										<td class="datatable-cell"><span class="codigo" style="width: 200px;" id="id">{{$a->funcionario->nome}}</span>
										</td>

										<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">
											{{ \Carbon\Carbon::parse($a->data)->format('d/m/Y')}}</span>
										</td>

										<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">
											<strong class="text-success">{{ \Carbon\Carbon::parse($a->inicio)->format('H:i')}}</strong>/<strong class="text-info">{{ \Carbon\Carbon::parse($a->termino)->format('H:i')}}
											</strong></span>
										</td>

										<td class="datatable-cell"><span class="codigo" style="width: 140px;" id="id">R$ {{$a->total}}</span>
										</td>
										<td class="datatable-cell"><span class="codigo" style="width: 140px;" id="id">R$ {{$a->valor_comissao}}</span>
										</td>

										<?php 
										$somaValor += $a->total;
										$somaComissao += $a->valor_comissao;
										?>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>

			<br>
			<div class="card card-custom gutter-b example example-compact">
				<div class="card-body">
					<h4>Valor total em agendamento: <strong class="text-success">R$ {{number_format($somaValor, 2)}}</strong></h4>
					<h4>Valor total em comissão: <strong class="text-info">R$ {{number_format($somaComissao, 2)}}</strong></h4>
				</div>
			</div>

			@else
			<br>
			<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
				<div class="row">
					@foreach($arrAgrupado as $arr)

					<div class="col-sm-4 col-lg-4 col-md-6">

						<div class="card card-custom gutter-b">
							<div class="card-body" style="height: 100px;">
								<h4>{{$arr['id']}} - {{$arr['nome']}}</h4>
								<h5>Total de agendamentos: <strong class="text-success">R$ {{number_format($arr['valor_agendamento'], 2)}}</strong></h5>
								<h5>Total de comissão: <strong class="text-danger">R$ {{number_format($arr['valor_comissao'], 2)}}</strong></h5>
								<h5>Total de servicos: <strong class="text-info">{{number_format($arr['total_de_servicos'])}}</strong></h5>
							</div>
						</div>
					</div>

					@endforeach
				</div>
			</div>

			@endif

			@endisset
			


		</div>
	</div>
</div>


@endsection	