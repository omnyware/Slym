@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="card-body">
		<div class="">

			<div class="col-sm-12 col-lg-4 col-md-6 col-xl-4">

				<a href="/push/new" class="btn btn-lg btn-success">
					<i class="fa fa-plus"></i>Novo Push
				</a>
			</div>
		</div>
		<br>
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">
			<br>
			<h4>Lista de Push</h4>
			<label>Numero de registros: <strong class="text-info">{{sizeof($pushes)}}</strong></label>					

			
			<div class="row">

				@foreach($pushes as $p)


				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
					<!--begin::Card-->
					<div class="card card-custom gutter-b card-stretch">
						<!--begin::Body-->
						<div class="card-body pt-4">
							<!--begin::Toolbar-->
							<div class="d-flex justify-content-end">
								<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" >
									<a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-ellipsis-h"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
										<!--begin::Navigation-->
										<ul class="navi navi-hover">
											<li class="navi-header font-weight-bold py-4">
												<span class="font-size-lg">Ações:</span>
												
											</li>
											<li class="navi-separator mb-3 opacity-70"></li>

											<li class="navi-item">
												<a href="/push/edit/{{ $p->id }}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-primary">Editar</span>
													</span>
												</a>
											</li>

											<li class="navi-item">
												<a href="/push/delete/{{ $p->id }}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-danger">Remover</span>
													</span>
												</a>
											</li>
											
										</ul>
										<!--end::Navigation-->
									</div>
								</div>
							</div>
							<!--end::Toolbar-->
							<!--begin::User-->
							<div class="d-flex align-items-end mb-7">
								<!--begin::Pic-->
								<div class="d-flex align-items-center">
									<!--begin::Pic-->
									
									<!--end::Pic-->
									<!--begin::Title-->
									<div class="d-flex flex-column">
										<a class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">{{$p->id}} - {{$p->titulo}}</a>

									</div>
									<!--end::Title-->
								</div>
								<!--end::Title-->
							</div>

							<div class="mb-7">
								<div class="d-flex justify-content-between align-items-center">
									<span class="text-dark-75 font-weight-bolder mr-2">Destino:</span>
									<a href="#" class="text-danger">
										@if($p->cliente_id)
										<label>{{$p->cliente->nome}}</label>
										@else
										<label>Todos</label>
										@endif
									</a>
								</div>

								<div class="d-flex justify-content-between align-items-center">
									<span class="text-dark-75 font-weight-bolder mr-2">Status:</span>
									<a href="#" class="text-danger">
										@if($p->status)
										<span class="label label-xl label-inline label-light-success">Enviado</span>
										@else
										<span class="label label-xl label-inline label-light-warning">Pendente</span>
										@endif
									</a>
								</div>
							</div>
							<!--end::Info-->
							<a onclick='swal("", "{{$p->texto}}", "info")' class="btn btn-block btn-sm btn-light-info font-weight-bolder text-uppercase py-4">Texto</a>
							<a href="/push/send/{{$p->id}}" class="btn btn-block btn-sm btn-light-success font-weight-bolder text-uppercase py-4">
								Enviar Push
							</a>

							<!--end::Body-->
						</div>
						<!--end::Card-->
					</div>
				</div>

				@endforeach
			</div>
		</div>
	</div>
</div>

@endsection	