@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="content d-flex flex-column flex-column-fluid" id="kt_content" >

			<div class="col-lg-12" id="content">
				<!--begin::Portlet-->

				<div class="row">
					<div class="col-xl-12">

						<div class="kt-section kt-section--first">
							<div class="kt-section__body">

								<div class="row">
									<div class="col-lg-12 col-md-12 col-xl-12 col-12">
										<h4>Código: <strong class="text-info">{{$cte->id}}</strong></h4>
										<h4>Natureza de Operação: <strong class="text-info">{{$cte->natureza->natureza}}</strong></h4>
										<h4>Data de registro: <strong class="text-info">{{ \Carbon\Carbon::parse($cte->data_registro)->format('d/m/Y H:i:s')}}</strong></h4>
										<h4>Valor de transporte: R$ <strong class="text-info">{{ number_format($cte->valor_transporte, 2, ',', '.') }}</strong></h4>
										<h4>Valor a receber: R$ <strong class="text-info">{{ number_format($cte->valor_receber, 2, ',', '.') }}</strong></h4>
										<h4>Valor da carga: R$ <strong class="text-info">{{ number_format($cte->valor_carga, 2, ',', '.') }}</strong></h4>
										@if($cte->chave_nfe)
										<h4>Chave: <strong class="text-info">{{$cte->chave_nfe}}</strong></h4>
										@else
										<h5>Tipo referênciado: <strong class="text-info">{{$cte->tpDoc}}</strong></h5>
										<h5>Descrição: <strong class="text-info">{{$cte->descOutros}}</strong></h5>
										<h5>Nº Doc: <strong class="text-info">{{$cte->nDoc}}</strong></h5>
										<h5>Valor: <strong class="text-info">{{$cte->vDocFisc}}</strong></h5>

										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6 col-lg-6 col-md-6">

						<div class="card card-custom gutter-b">
							<div class="card-header">
								<h3 class="card-title">REMETENTE</h3>
							</div>
							<div class="card-body">
								<h5>Razao Social: <strong>{{$cte->remetente->razao_social}}</strong></h5>
								<h5>CNPJ: <strong>{{$cte->remetente->cpf_cnpj}}</strong></h5>
								<h5>Rua: <strong>{{$cte->remetente->rua}}, {{$cte->remetente->numero}}</strong></h5>
								<h5>Bairro: <strong>{{$cte->remetente->bairro}}</strong></h5>
								<h5>Cidade: <strong>{{$cte->remetente->cidade->nome}}</strong></h5>
							</div>
						</div>
					</div>

					<div class="col-sm-6 col-lg-6 col-md-6">

						<div class="card card-custom gutter-b">
							<div class="card-header">
								<h3 class="card-title">DESTINATÁRIO</h3>
							</div>
							<div class="card-body">
								<h5>Razao Social: <strong>{{$cte->destinatario->razao_social}}</strong></h5>
								<h5>CNPJ: <strong>{{$cte->destinatario->cpf_cnpj}}</strong></h5>
								<h5>Rua: <strong>{{$cte->destinatario->rua}}, {{$cte->destinatario->numero}}</strong></h5>
								<h5>Bairro: <strong>{{$cte->destinatario->bairro}}</strong></h5>
								<h5>Cidade: <strong>{{$cte->destinatario->cidade->nome}}</strong></h5>
							</div>
						</div>
					</div>

					<div class="col-sm-6 col-lg-6 col-md-6">

						<div class="card card-custom gutter-b">
							<div class="card-header">
								<h3 class="card-title">VEICULO</h3>
							</div>
							<div class="card-body">
								<h5>Marca: <strong>{{$cte->veiculo->marca}}</strong></h5>
								<h5>Modelo: <strong>{{$cte->veiculo->modelo}}</strong></h5>
								<h5>Placa: <strong>{{$cte->veiculo->placa}}</strong></h5>
								<h5>Cor: <strong>{{$cte->veiculo->cor}}</strong></h5>
								<h5>RNTRC: <strong>{{$cte->veiculo->cor}}</strong></h5>
							</div>
						</div>
					</div>

					<div class="col-sm-6 col-lg-6 col-md-6">

						<div class="card card-custom gutter-b">
							<div class="card-header">
								<h3 class="card-title">TOMADOR</h3>
							</div>
							<div class="card-body">
								<h5>Rua: <strong>{{$cte->logradouro_tomador}}</strong></h5>
								<h5>Numero: <strong> {{$cte->numero_tomador}}</strong></h5>
								<h5>Bairro: <strong>{{$cte->bairro_tomador}}</strong></h5>
								<h5>CEP: <strong>{{$cte->cep_tomador}}</strong></h5>
								<h5>Cidade: <strong>{{$cte->municipio_tomador}}</strong></h5>
								<h5></h5>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6 col-xl-4 col-lg-6 col-md-6">
						<div class="card card-custom gutter-b">
							<div class="card-header">
								<h3 class="card-title">Componentes da CT-e</h3>
							</div>
							<div class="card-body">
								<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

									<table class="datatable-table" style="max-width: 100%; overflow: scroll">
										<thead class="datatable-head">
											<tr class="datatable-row" style="left: 0px;">
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Nome</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Valor</span></th>

											</tr>
										</thead>
										<tbody id="body" class="datatable-body">
											@foreach($cte->componentes as $c)
											<tr class="datatable-row">
												<td class="datatable-cell">
													<span class="codigo" style="width: 120px;" id="id">
														{{$c->nome}}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 90px;" id="id">
														{{number_format($c->valor, 2)}}
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

					<div class="col-sm-6 col-xl-8 col-lg-6 col-md-6">
						<div class="card card-custom gutter-b">
							<div class="card-header">
								<h3 class="card-title">Medidas da CT-e</h3>
							</div>
							<div class="card-body">
								<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

									<table class="datatable-table" style="max-width: 100%; overflow: scroll">
										<thead class="datatable-head">
											<tr class="datatable-row" style="left: 0px;">
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Tipo</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Quantidade</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Código</span></th>

											</tr>
										</thead>
										<tbody id="body" class="datatable-body">
											@foreach($cte->medidas as $m)
											<tr class="datatable-row">
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;" id="id">
														{{$m->tipo_medida}}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;" id="id">
														{{$m->quantidade_carga}}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;" id="id">
														{{$m->cod_unidade}}
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
	</div>
</div>


@endsection	