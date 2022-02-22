@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">
		<div class="">
			<div class="col-sm-12 col-lg-4 col-md-6 col-xl-4">

				<a href="/produtos/new" class="btn btn-lg btn-success">
					<i class="fa fa-plus"></i>Novo Produto
				</a>
			</div>
		</div>
		<br>


		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<form method="get" action="/produtos/filtroCategoria">
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

					
					<div class="col-lg-4 col-xl-4">
						<div class="row align-items-center">
							<label class="col-form-label">Categoria</label>
							<div class=" col-lg-9 col-md-9 col-sm-12">
								<select class="form-control select2" id="kt_select2_1" name="categoria">
									<option value="-">Todas</option>
									@foreach($categorias as $c)
									<option @if(isset($categoria)) @if($c->nome == $categoria)
										selected
										@endif
										@endif
										value="{{$c->id}}">{{$c->nome}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>


						<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
							<button type="submit" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
						</div>
					</div>

				</form>

				<br>
				<h4>Lista de Produtos</h4>
				<label>Total de registros: {{count($produtos)}}</label>
				<div class="row">

					@foreach($produtos as $p)


					<div class="col-sm-12 col-lg-6 col-md-6 col-xl-4">
						<div class="card card-custom gutter-b example example-compact">
							<div class="card-header">
								<div class="card-title">
									<div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
										<div class="symbol symbol-circle symbol-lg-75">
											@if($p->imagem != '')
											<img src="/imgs_produtos/{{$p->imagem}}" alt="image">
											@else
											<img src="/imgs/no_image.png" alt="image">
											@endif

										</div>
									</div>
									<h3 style="width: 230px; font-size: 12px; height: 10px;" class="card-title">{{substr($p->nome, 0, 30)}}
									</h3>
									
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
													<a href="/produtos/edit/{{$p->id}}" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-primary">Editar</span>
														</span>
													</a>
												</li>
												<li class="navi-item">
													<a onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/produtos/delete/{{ $p->id }}" }else{return false} })' href="#!" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-danger">Excluir</span>
														</span>
													</a>
												</li>

												@if($p->composto)
												<li class="navi-item">
													<a href="/produtos/receita/{{$p->id}}" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-warning">Receita/Composição</span>
														</span>
													</a>
												</li>
												@endif


											</ul>
											<!--end::Navigation-->
										</div>
									</div>
								<!-- <a href="/produtos/edit/{{$p->id}}" class="btn btn-icon btn-circle btn-sm btn-light-primary mr-1"><i class="la la-pencil"></i></a>
									<a href="/produtos/delete/{{$p->id}}" class="btn btn-icon btn-circle btn-sm btn-light-danger mr-1"><i class="la la-trash"></i></a> -->

								</div>

								<div class="card-body">

									<div class="kt-widget__info">
										<span class="kt-widget__label">Categoria:</span>
										<a target="_blank" href="/categorias/edit/{{ $p->categoria->id }}" class="kt-widget__data text-success">{{ $p->categoria->nome }}</a>
									</div>
									<div class="kt-widget__info">
										<span class="kt-widget__label">Valor:</span>
										<a class="kt-widget__data text-success">{{ number_format($p->valor_venda, 2, ',', '.') }}</a>
									</div>
									<div class="kt-widget__info">
										<span class="kt-widget__label">Unidade:</span>
										<a class="kt-widget__data text-success">{{$p->unidade_compra}}/{{$p->unidade_venda}}</a>
									</div>

									<div class="kt-widget__info">
										<span class="kt-widget__label">Ativo:</span>
										@if($p->ativo)
										<span class="label label-xl label-inline label-light-success">Sim</span>
										@else
										<span class="label label-xl label-inline label-light-warning">Não</span>
										@endif
										
									</div>

									<div class="kt-widget__info">
										<span class="kt-widget__label">Ger. estoque:</span>
										@if($p->gerenciar_estoque)
										<span class="label label-xl label-inline label-light-success">Sim</span>
										@else
										<span class="label label-xl label-inline label-light-warning">Não</span>
										@endif
										
									</div>

									<div class="kt-widget__info">
										<span class="kt-widget__label">Estoque:</span>
										<a class="kt-widget__data text-success">
											
											@if($p->estoque)
											@if($p->unidade_venda == 'UN' || $p->unidade_venda == 'UNID')
											{{number_format($p->estoque->quantidade)}}
											@else
											{{$p->estoque->quantidade}}
											@endif

											@else
											0
											@endif
										</a>
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
						{{$produtos->links()}}
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	@endsection