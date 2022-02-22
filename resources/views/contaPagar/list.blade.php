
@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="">
			<div class="col-12">

				<div class="row">
					<a href="/contasPagar/new" class="btn btn-lg btn-success">
						<i class="fa fa-plus"></i>Novo Conta a Pagar
					</a>

					@isset($paraImprimir)
					<form method="post" action="/contasPagar/relatorio">
						@csrf
						<input type="hidden" name="fornecedor" value="{{{ isset($fornecedor) ? $fornecedor : '' }}}">
						<input type="hidden" name="data_inicial" value="{{{ isset($dataInicial) ? $dataInicial : '' }}}">
						<input type="hidden" name="data_final" value="{{{ isset($dataFinal) ? $dataFinal : '' }}}">
						<input type="hidden" name="status" value="{{{ isset($status) ? $status : '' }}}">
						<button style="margin-left: 5px;" href="/contasPagar/new" class="btn btn-lg btn-info">
							<i class="fa fa-print"></i>Imprimir relatório
						</button>
					</form>
					@endisset
				</div>
			</div>
		</div>
		<br>

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<form method="get" action="/contasPagar/filtro">
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
						<label class="col-form-label">Data de Registro</label>
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

					<div class="form-group col-lg-2 col-md-4 col-sm-6">
						<label class="col-form-label text-left col-lg-12 col-sm-12">Estado</label>

						<select class="custom-select form-control" id="status" name="status">
							<option @if(isset($stats) && $status == 'todos') selected @endif value="todos">TODOS</option>
							<option @if(isset($stats) && $status == 'pago') selected @endif value="pago">PAGO</option>
							<option @if(isset($stats) && $status == 'pendente') selected @endif value="pendente">PENDENTE</option>
						</select>
					</div>

					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button style="margin-top: 10px;" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
					</div>
				</div>

			</form>
			<br>
			<h4>Lista de Contas a Pagar</h4>
			<h6 style="color: red">*{{$infoDados}}</h6>
			<label>Total de registros: {{count($contas)}}</label>
			<div class="row">

				<?php 
				$somaValor = 0;
				$somaPago = 0;
				$somaPendente = 0;
				?>

				@foreach($contas as $c)

				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-4">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<div class="card-title">
								<h3 style="width: 230px; font-size: 20px; height: 10px;" class="card-title">
									R$ {{number_format($c->valor_integral, 2, ',', '.')}}
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
												<a href="/contasPagar/edit/{{$c->id}}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-primary">Editar</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/contasPagar/delete/{{ $c->id }}" }else{return false} })' href="#!" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-danger">Excluir</span>
													</span>
												</a>
											</li>

											@if($c->status == false)

											<li class="navi-item">
												<a href="/contasPagar/pagar/{{$c->id}}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-success">Pagar</span>
													</span>
												</a>
											</li>

											@endif


										</ul>
										<!--end::Navigation-->
									</div>
								</div>

							</div>

							<div class="card-body">

								<div class="kt-widget__info">
									<span class="kt-widget__label">Fornecedor:</span>
									<a target="_blank" class="kt-widget__data text-success">
										@if($c->compra_id != null)
										<th>{{ $c->compra->fornecedor->razao_social }}</th>
										@else
										<th> -- </th>
										@endif
									</a>
								</div>
								<div class="kt-widget__info">
									<span class="kt-widget__label">Categoria:</span>
									<a class="kt-widget__data text-success">
										{{$c->categoria->nome}}
									</a>
								</div>
								<div class="kt-widget__info">
									<span class="kt-widget__label">Valor pago:</span>
									<a class="kt-widget__data text-success">
										{{ number_format($c->valor_pago, 2, ',', '.') }}
									</a>
								</div>
								<div class="kt-widget__info">
									<span class="kt-widget__label">Data de registro:</span>
									<a class="kt-widget__data text-success">
										{{ \Carbon\Carbon::parse($c->data_registro)->format('d/m/Y')}}
									</a>
								</div>
								<div class="kt-widget__info">
									<span class="kt-widget__label">Data de vencimento:</span>
									<a class="kt-widget__data text-success">
										{{ \Carbon\Carbon::parse($c->data_vencimento)->format('d/m/Y')}}
									</a>
								</div>

								<div class="kt-widget__info">
									<span class="kt-widget__label">Estado:</span>
									@if($c->status == true)
									<span class="label label-xl label-inline label-light-success">Pago</span>
									@else
									<span class="label label-xl label-inline label-light-danger">Pendente</span>
									@endif
								</div>

								

							</div>

						</div>

					</div>

				</div>

				<?php
				$somaValor += $c->valor_integral;
				$somaPago += $c->valor_pago;

				if($c->status == false)
					$somaPendente += $c->valor_integral;
				?>
				@endforeach

			</div>

			<div class="d-flex justify-content-between align-items-center flex-wrap">
				<div class="d-flex flex-wrap py-2 mr-3">
					@if(isset($links))
					{{$contas->links()}}
					@endif
				</div>
			</div>

			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
						<div class="card card-custom gutter-b example example-compact">
							<div class="card-header">

								<div class="card-body">
									<h3 class="card-title">Valor a Pagar: <strong style="margin-left: 5px;"> R$ {{number_format($somaPendente, 2, ',', '.') }}</strong></h3>

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
