@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="card-body">
		<div class="">

			<div class="col-sm-12 col-lg-4 col-md-6 col-xl-4">

				<a href="/deliveryProduto/new" class="btn btn-lg btn-success">
					<i class="fa fa-plus"></i>Nova Produto de Delivery
				</a>
			</div>
		</div>
		<br>
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">
			<br>
			<h4>Lista de Produtos de Delivery</h4>
			<label>Numero de registros: <strong class="text-info">{{sizeof($produtos)}}</strong></label>					

			<form method="get" action="/deliveryProduto/pesquisa">
				<div class="row align-items-center">
					<div class="col-lg-5 col-xl-5">
						<div class="row align-items-center">
							<div class="col-md-12 my-2 my-md-0">
								<div class="input-icon">
									<input type="text" name="pesquisa" class="form-control" value="{{{isset($pesquisa) ? $pesquisa : ''}}}"
									placeholder="Produto..." id="kt_datatable_search_query">
									<span>
										<i class="fa fa-search"></i>
									</span>
								</div>
							</div>

						</div>
					</div>
					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button type="submit" class="btn btn-light-primary px-6 font-weight-bold">Buscar</button>
					</div>
				</div>
				<br>
			</form>
			<div class="row">

				@foreach($produtos as $p)


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
												<a href="/deliveryProduto/edit/{{ $p->id }}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-primary">Editar</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/deliveryProduto/delete/{{ $p->id }}" }else{return false} })' href="#!" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-danger">Remover</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="/deliveryProduto/push/{{ $p->id }}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-info">Criar Push</span>
													</span>
												</a>
											</li>

											<li class="navi-item">
												<a href="/deliveryProduto/galeria/{{ $p->id }}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-success">Galeria</span>
													</span>
												</a>
											</li>

											@if($p->produto->composto)
											<li class="navi-item">
												<a href="/deliveryProduto/receita/{{ $p->id }}" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-warning">Receita</span>
													</span>
												</a>
											</li>
											
											@endif
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
									<div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
										<div class="symbol symbol-circle symbol-lg-75">
											@if(sizeof($p->galeria) > 0)
											<img src="/imagens_produtos/{{$p->galeria[0]->path}}" alt="image">
											@else
											<img src="imgs/no_image.png" alt="image">
											@endif
										</div>
										<div class="symbol symbol-lg-75 symbol-circle symbol-primary d-none">
											<span class="font-size-h3 font-weight-boldest">JM</span>
										</div>
									</div>
									<!--end::Pic-->
									<!--begin::Title-->
									<div class="d-flex flex-column">
										<a class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">{{$p->produto->nome}}</a>

									</div>
									<!--end::Title-->
								</div>
								<!--end::Title-->
							</div>
							<!--end::User-->
							<!--begin::Desc-->

							<div class="mb-7">
								<div class="d-flex justify-content-between align-items-center">
									<span class="text-dark-75 font-weight-bolder mr-2">Categoria:</span>
									<a href="#" class="text-danger">{{$p->categoria->nome}}</a>
								</div>
								<div class="d-flex justify-content-between align-items-cente my-1">
									<span class="text-dark-75 font-weight-bolder mr-2">Valor:</span>
									<a href="#" class="text-danger">
										@if(sizeof($p->pizza) > 0)
										<label>
											@foreach($p->pizza as $key => $pz)
											{{$pz->valor}} {{$key < count($p->pizza)-1 ? '|' : ''}}
											@endforeach
										</label>
										@else
										<label>R$ {{ $p->valor }}</label>
										@endif
									</a>
								</div>
								<div class="d-flex justify-content-between align-items-center">
									<span class="text-dark-75 font-weight-bolder mr-2">Limite diário:</span>
									<span class="text-danger">{{$p->limite_diario}}</span>
								</div>
								<div class="d-flex justify-content-between align-items-center">
									<span class="text-dark-75 font-weight-bolder mr-2">Total de imagens:</span>
									<span class="text-danger">{{count($p->galeria)}}</span>
								</div>
								<div class="d-flex justify-content-between align-items-center">
									<span class="text-dark-75 font-weight-bolder mr-2">Destaque:</span>
									<span class="text-danger">
										<div class="switch switch-outline switch-success">
											<label class="">
												<input onclick="alterarDestaque({{$p->id}})" @if($p->destaque) checked @endif value="true" name="status" class="red-text" type="checkbox">
												<span class="lever"></span>
											</label>
										</div>
									</span>
								</div>

								<div class="d-flex justify-content-between align-items-center">
									<span class="text-dark-75 font-weight-bolder mr-2">Ativo:</span>
									<span class="text-danger">
										<div class="switch switch-outline switch-info">
											<label class="">
												<input onclick="alterarStatus({{$p->id}})" @if($p->status) checked @endif value="true" name="status" class="red-text" type="checkbox">
												<span class="lever"></span>
											</label>
										</div>
									</span>
								</div>
							</div>

							<!--end::Info-->
							<a onclick='swal("", "{{$p->descricao}}", "info")' class="btn btn-block btn-sm btn-light-info font-weight-bolder text-uppercase py-4">Descrição</a>
							<a onclick='swal("", "{{$p->ingredientes}}", "info")' class="btn btn-block btn-sm btn-light-primary font-weight-bolder text-uppercase py-4">Ingredientes</a>
						</div>
						<!--end::Body-->
					</div>
					<!--end::Card-->
				</div>

				@endforeach
			</div>
		</div>
	</div>
</div>

@endsection	