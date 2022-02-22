@extends('default.layout')
@section('content')
<div class="card card-custom gutter-b">


	<div class="card-body">

		<h4>Lista de Cotações Por Referência</h4>

		<form method="get" action="/cotacao/listaPorReferencia/filtro">
			<div class="row align-items-center">

				<div class="form-group col-lg-4 col-xl-4">
					<div class="row align-items-center">

						<div class="col-md-12 my-2 my-md-0">
							<label class="col-form-label">Fornecedor</label>

							<div class="input-icon">
								<input type="text" name="fornecedor" value="{{{ isset($fornecedor) ? $fornecedor : '' }}}" class="form-control" placeholder="Fornecedor" id="kt_datatable_search_query">
								<span>
									<i class="fa fa-search"></i>
								</span>
							</div>
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
					<label class="col-form-label">Data de Final</label>
					<div class="">
						<div class="input-group date">
							<input type="text" name="data_final" class="form-control" readonly value="{{{ isset($dataFinal) ? $dataFinal : '' }}}" id="kt_datepicker_3" />
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

		<label>Total de registros: {{count($cotacoes)}}</label>
		<div class="row">


			@foreach($cotacoes as $c)


			<div class="col-sm-12 col-lg-6 col-md-6 col-xl-4">
				<div class="card card-custom gutter-b example example-compact">
					<div class="card-header">
						<div class="card-title">
							<h3 style="width: 230px; font-size: 12px; height: 10px;" class="card-title">{{$c->referencia}}
							</h3>
						</div>

						<div class="card-toolbar">
							<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Ações">
								<a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-ellipsis-h"></i>
								</a>
								<div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
									<!--begin::Navigation-->
									<ul class="navi navi-hover">
										<li class="navi-header font-weight-bold py-4">
											<span class="font-size-lg">Ações:</span>
										</li>
										<li class="navi-separator mb-3 opacity-70"></li>
										<li class="navi-item">
											<a href="/cotacao/referenciaView/{{ $c->referencia }}" class="navi-link">
												<span class="navi-text">
													<span class="label label-xl label-inline label-light-primary">Ver cotaçoões</span>
												</span>
											</a>
										</li>


									</ul>
									<!--end::Navigation-->
								</div>
							</div>

						</div>

						<div class="card-body">


							<div class="kt-widget__info">
								<span class="kt-widget__label">Total de itens:</span>
								<a class="kt-widget__data text-success">{{$c->contaItens()}}</a>
							</div>
							<div class="kt-widget__info">
								<span class="kt-widget__label">Total de fornecedores:</span>
								<a class="kt-widget__data text-success">{{$c->contaFornecedores()}}</a>
							</div>
							<div class="kt-widget__info">
								<span class="kt-widget__label">Maior valor:</span>
								<a class="kt-widget__data text-success">{{number_format($c->getValores(true), 2)}}</a>
							</div>
							<div class="kt-widget__info">
								<span class="kt-widget__label">Menor valor:</span>
								<a class="kt-widget__data text-success">{{number_format($c->getValores(), 2)}}</a>
							</div>
							<div class="kt-widget__info">
								<span class="kt-widget__label">Data de criação:</span>
								<a class="kt-widget__data text-success">{{ \Carbon\Carbon::parse($c->created_at)->format('d/m/Y H:i:s')}}</a>
							</div>

							<div class="kt-widget__info">
								<span class="kt-widget__label">Escolhida:</span>

								@if(!$c->escolhida())
								<a class="kt-widget__data text-danger">Não</a>
								@else
								<a class="kt-widget__data text-success">Sim</a>
								@endif
							</div>

						</div>

					</div>

				</div>

			</div>

			@endforeach


		</div>
	</div>
</div>

@endsection