@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">
		<div class="">
			<div class="col-sm-12 col-lg-4 col-md-6 col-xl-4">

				<a href="/naturezaOperacao/new" class="btn btn-lg btn-success">
					<i class="fa fa-plus"></i>Nova Natureza de Operação
				</a>
			</div>
		</div>
		<br>


		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			
			<br>
			<h4>Lista de Naturezas de Operação</h4>
			<label>Total de registros: {{count($naturezas)}}</label>
			<div class="row">

				@foreach($naturezas as $n)
				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-4">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<div class="card-title">
								<h3 style="width: 230px; font-size: 12px; height: 10px;" class="card-title">{{$n->id}} - {{$n->natureza}}
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
												<a href="/naturezaOperacao/edit/{{$n->id}}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-primary">Editar</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/naturezaOperacao/delete/{{$n->id}}" }else{return false} })' href="#!" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-danger">Excluir</span>
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
									<span class="kt-widget__label">CFOP Saída Dentro do Estado:</span>
									<a class="kt-widget__data text-success">
										{{$n->CFOP_saida_estadual}}
									</a>
								</div>
								<div class="kt-widget__info">
									<span class="kt-widget__label">CFOP Entrada Dentro do Estado:</span>
									<a class="kt-widget__data text-success">
										{{$n->CFOP_entrada_estadual}}
									</a>
								</div>
								<div class="kt-widget__info">
									<span class="kt-widget__label">CFOP Saída Fora do Estado:</span>
									<a class="kt-widget__data text-success">
										{{$n->CFOP_saida_inter_estadual}}
									</a>
								</div>
								<div class="kt-widget__info">
									<span class="kt-widget__label">CFOP Entrada Fora do Estado:</span>
									<a class="kt-widget__data text-success">
										{{$n->CFOP_entrada_inter_estadual}}
									</a>
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