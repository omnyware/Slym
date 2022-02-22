@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">
		<div class="">
			<div class="col-sm-12 col-lg-4 col-md-6 col-xl-4">

				<a href="/eventos/novo" class="btn btn-lg btn-success">
					<i class="fa fa-plus"></i>Novo Evento
				</a>
			</div>
		</div>
		<br>


		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<form method="get" action="/eventos/pesquisa">
				<div class="row align-items-center">
					<div class="col-lg-5 col-xl-5">
						<div class="row align-items-center">
							<div class="col-md-12 my-2 my-md-0">
								<div class="input-icon">
									<input type="text" name="pesquisa" class="form-control" placeholder="Nome..." id="kt_datatable_search_query">
									<span>
										<i class="fa fa-search"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
					</div>
				</div>

			</form>
			<br>
			<h4>Lista de Eventos</h4>
			<label>Total de registros: {{count($eventos)}}</label>

			<div class="row">

				@foreach($eventos as $e)

				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-6">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<div class="card-title">
								<h3 style="width: 230px; font-size: 12px; height: 10px;" class="card-title">{{substr($e->nome, 0, 40)}}
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
												<a href="/eventos/edit/{{$e->id}}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-primary">Editar</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/eventos/delete/{{ $e->id }}" }else{return false} })' href="#!" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-danger">Excluir</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="/eventos/funcionarios/{{$e->id}}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-info">Funcionarios</span>
													</span>
												</a>
											</li>

										</ul>
										<!--end::Navigation-->
									</div>
								</div>

							</div>
						</div>

						<div class="card-body">

							<div class="kt-widget__info">
								<span class="kt-widget__label">Descrição:</span>
								<a target="_blank" class="kt-widget__data text-success">
									{{$e->descricao}}
								</a>
							</div>
							<div class="kt-widget__info">
								<span class="kt-widget__label">Status:</span>
								<a target="_blank" class="kt-widget__data text-success">
									@if($e->status)
									<span class="label label-xl label-inline label-light-success">ATIVO</span>
									@else
									<span class="label label-xl label-inline label-light-danger">DESATIVADO</span>
									@endif
								</a>
							</div>
							<div class="kt-widget__info">
								<span class="kt-widget__label">Início:</span>
								<a target="_blank" class="kt-widget__data text-success">
									{{ \Carbon\Carbon::parse($e->inicio)->format('d/m/Y')}}
								</a>
							</div>
							<div class="kt-widget__info">
								<span class="kt-widget__label">Fim:</span>
								<a target="_blank" class="kt-widget__data text-danger">
									{{ \Carbon\Carbon::parse($e->fim)->format('d/m/Y')}}
								</a>
							</div>

						</div>

						<div class="card-footer">
							<a style="width: 100%;" href="/eventos/atividades/{{$e->id}}" class="btn btn-light-primary">
								Atividades
							</a>
						</div>
					</div>
				</div>

				@endforeach

			</div>

			<div class="d-flex justify-content-between align-items-center flex-wrap">
				<div class="d-flex flex-wrap py-2 mr-3">
					@if(isset($links))
					{{$eventos->links()}}
					@endif
				</div>
			</div>
		</div>

	</div>
</div>

@endsection