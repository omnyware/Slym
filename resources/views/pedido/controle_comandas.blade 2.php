@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<input type="hidden" id="_token" value="{{ csrf_token() }}">
			<form method="get" action="/pedidos/filtroComanda">
				<div class="row align-items-center">

					<div class="form-group col-lg-3 col-md-4 col-sm-6">
						<label class="col-form-label">Comanda</label>
						<div class="">
							<div class="input-group">
								<input type="text" name="numero_comanda" class="form-control" value="{{{isset($comanda) ? $comanda : ''}}}" />
							</div>
						</div>
					</div>

					<div class="form-group col-lg-2 col-md-4 col-sm-6">
						<label class="col-form-label">Data Inicial</label>
						<div class="">
							<div class="input-group date">
								<input type="text" name="data_inicial" class="form-control" readonly value="{{{isset($comanda) ? $comanda : ''}}}" id="kt_datepicker_3" />
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

					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button style="margin-top: 15px;" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
					</div>
				</div>
			</form>
			<br>
			<h4>Controle de Comandas</h4>
			<label>Numero de registros: {{count($comandas)}}</label>	
			<p class="text-danger">{{$mensagem}}</p>				
			<p class="text-danger">*Comanda em vermelho contém produtos deletados</p>		

			<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
				<div class="row">
					<div class="col-xl-12">

						<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

							<table class="datatable-table" style="max-width: 100%; overflow: scroll">
								<thead class="datatable-head">
									<tr class="datatable-row" style="left: 0px;">
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 70px;">#</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Comanda</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Observação</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Data de Criação</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Data de Finalização</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Ações</span></th>
									</tr>
								</thead>
								<tbody id="body" class="datatable-body">
									@foreach($comandas as $v)
									<tr class="datatable-row @if($v->temItemDeletetado()) bg-danger @endif">
										<td class="datatable-cell">
											<span class="codigo" style="width: 70px;">
												{{$v->id}}
											</span>
										</td>
										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												{{$v->comanda}}
											</span>
										</td>
										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												<a href="#!" onclick='swal("", "{{$v->observacao}}", "info")' class="btn btn-light-info @if(!$v->observacao) disabled @endif">
													Ver
												</a>
											</span>
										</td>

										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												{{number_format($v->somaItems(), 2)}}
											</span>
										</td>

										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												{{ \Carbon\Carbon::parse($v->created_at)->format('d/m/Y H:i:s')}}
											</span>
										</td>
										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												{{ \Carbon\Carbon::parse($v->updated_at)->format('d/m/Y H:i:s')}}
											</span>
										</td>

										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												<a target="_blank" href="/pedidos/verDetalhes/{{$v->id}}" class="btn btn-sm btn-info">
													<i class="la la-list"></i>
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
	</div>
</div>


@endsection	