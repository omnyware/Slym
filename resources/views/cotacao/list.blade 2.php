@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">
		<div class="row">
			<div class="col-sm-12 col-lg-4 col-md-3 col-xl-3">

				<a style="width: 100%;" href="/cotacao/new" class="btn btn-lg btn-success">
					<i class="fa fa-plus"></i>Nova Cotação
				</a>
			</div>
			<div class="col-sm-12 col-lg-4 col-md-6 col-xl-4">

				<a href="/cotacao/listaPorReferencia" class="btn btn-lg btn-primary">
					<i class="fa fa-plus"></i>Cotações por referencia
				</a>

			</div>
		</div>
		<br>

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">


			<form method="get" action="/cotacao/filtro">
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
						<label class="col-form-label">Data Final</label>
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

			<br>
			<h4>Lista de Cotações</h4>
			<label>Total de registros: {{count($cotacoes)}}</label>
			<div class="row">
				@foreach($cotacoes as $c)


				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-4">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<div class="card-title">
								<h3 style="width: 230px; font-size: 12px; height: 10px;" class="card-title">{{$c->id}} - {{substr($c->fornecedor->razao_social, 0, 30)}}
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
												<a href="/cotacao/view/{{ $c->id }}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-primary">Ver</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/cotacao/delete/{{ $c->id }}" }else{return false} })' href="#!" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-danger">Excluir</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="/cotacao/sendMail/{{ $c->id }}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-question">Enviar Email</span>
													</span>
												</a>
											</li>

											<li class="navi-item">
												<a href="/response/{{ $c->link }}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-info">Link</span>
													</span>
												</a>
											</li>

											@if($c->ativa == true)

											<li class="navi-item">
												<a href="/cotacao/alterarStatus/{{$c->id}}/0" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-danger">Desativar</span>
													</span>
												</a>
											</li>

											@else

											<li class="navi-item">
												<a href="/cotacao/alterarStatus/{{$c->id}}/1" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-success">ativar</span>
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
									<span class="kt-widget__label">Referencia:</span>
									<a target="_blank" class="kt-widget__data text-success">{{ $c->referencia}}</a>
								</div>
								<div class="kt-widget__info">
									<span class="kt-widget__label">Data de criação:</span>
									<a class="kt-widget__data text-success">{{ \Carbon\Carbon::parse($c->data_registro)->format('d/m/Y H:i')}}</a>
								</div>

								<div class="kt-widget__info">
									<span class="kt-widget__label">Respondida</span>
									@if($c->resposta)
									<a class="kt-widget__data text-success">Sim</a>
									@else
									<a class="kt-widget__data text-danger">Não</a>
									@endif
								</div>

								<div class="kt-widget__info">
									<span class="kt-widget__label">Ativa</span>
									@if($c->ativa)
									<a class="kt-widget__data text-success">Sim</a>
									@else
									<a class="kt-widget__data text-danger">Não</a>
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
</div>

@endsection