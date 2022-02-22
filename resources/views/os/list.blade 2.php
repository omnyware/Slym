@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">
		<div class="row">
			<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">

				<a href="/ordemServico/new" class="btn btn-lg btn-success">
					<i class="fa fa-plus"></i>Nova Ordem de Serviço
				</a>
			</div>
			
		</div>
		<br>

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">


			<form method="get" action="/ordemServico/filtro">
				<div class="row align-items-center">

					<div class="form-group col-lg-4 col-xl-4">
						<div class="row align-items-center">

							<div class="col-md-12 my-2 my-md-0">
								<label class="col-form-label">Cliente</label>

								<div class="input-icon">
									<input type="text" name="cliente" value="{{{ isset($cliente) ? $cliente : '' }}}" class="form-control" placeholder="Cliente" id="kt_datatable_search_query">
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
								<input type="text" name="data_inicio" class="form-control" readonly value="{{{ isset($data_inicio) ? $data_inicio : '' }}}" id="kt_datepicker_3" />
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
								<input type="text" name="data_fim" class="form-control" readonly value="{{{ isset($data_fim) ? $data_fim : '' }}}" id="kt_datepicker_3" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group validated col-lg-2 col-md-2 col-sm-6">
						<label class="col-form-label text-left col-lg-12 col-sm-12">Estado</label>

						<select class="custom-select form-control" id="estado" name="estado">
							<option value="pd">PENDENTE</option>
							<option value="ap">APROVADO</option>
							<option value="rp">REPROVADO</option>
							<option value="fz">FINALIZADO</option>
						</select>

					</div>

					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button style="margin-top: 15px;" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
					</div>
				</div>
			</form>

			<br>
			<h4>Lista de Ordens de Serviço</h4>
			<label>Total de registros: {{count($orders)}}</label>


			<div class="row">
				@foreach($orders as $o)


				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-4">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<div class="card-title">
								<h3 style="width: 230px; font-size: 12px; height: 10px;" class="card-title">{{$o->id}} - {{substr($o->cliente->razao_social, 0, 30)}}
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
											@if(is_adm())
											<li class="navi-item">
												<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/ordemServico/delete/{{ $o->id }}" }else{return false} })' href="#!" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-danger">Delete</span>
													</span>
												</a>
											</li>
											
											@endif
											

											<li class="navi-item">
												<a href="/ordemServico/servicosordem/{{$o->id}}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-primary">Ver</span>
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
									<span class="kt-widget__label">Valor:</span>
									<a target="_blank" class="kt-widget__data text-success">{{ number_format($o->valor, 2)}}</a>
								</div>
								<div class="kt-widget__info">
									<span class="kt-widget__label">Data:</span>
									<a class="kt-widget__data text-success">{{ \Carbon\Carbon::parse($o->created_at)->format('d/m/Y H:i')}}</a>
								</div>
								<div class="kt-widget__info">
									<span class="kt-widget__label">Usuario:</span>
									<a class="kt-widget__data text-success">{{ $o->usuario->nome }}</a>
								</div>

								<div class="kt-widget__info">
									<span class="kt-widget__label">Estado</span>

									@if($o->estado == 'pd')
									<a class="kt-widget__data text-primary">PENDENTE</a>
									@elseif($o->estado == 'ap')
									<a class="kt-widget__data text-success">APROVADO</a>
									@elseif($o->estado == 'rp')
									<a class="kt-widget__data text-danger">REPROVADO</a>
									@else
									<a class="kt-widget__data text-info">FINALIZADO</a>
									@endif
								</div>


							</div>

						</div>

					</div>

				</div>

				@endforeach
			</div>

			<div class="d-flex justify-content-between align-items-center flex-wrap">
				<div class="d-flex flex-wrap py-2 mr-3">
					@if(isset($links))
					{{$orders->links()}}
					@endif
				</div>
			</div>
		</div>
	</div>
</div>


@endsection	