<!DOCTYPE html>

<html lang="br">
<!-- begin::Head -->

<head>
	<meta charset="utf-8" />

	<title>{{$title}}</title>
	<meta name="description" content="Updates and statistics">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!--begin::Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

	<link href="/metronic/css/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
	<!-- <link href="/metronic/css/uppy.bundle.css" rel="stylesheet" type="text/css" /> -->
	<link href="/metronic/css/wizard.css" rel="stylesheet" type="text/css" />

	<link href="/css/style.css" rel="stylesheet" type="text/css" />

	<!--end::Page Vendors Styles -->


	<!--begin::Global Theme Styles(used by all pages) -->
	<link href="/metronic/css/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="/metronic/css/prismjs.bundle.css" rel="stylesheet" type="text/css" />
	<link href="/metronic/css/style.bundle.css" rel="stylesheet" type="text/css" />

	<link href="/metronic/css/pricing.css" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles -->

	<!--begin::Layout Skins(used by all pages) -->

	<link href="/metronic/css/light.css" rel="stylesheet" type="text/css" />
	<link href="/metronic/css/light-menu.css" rel="stylesheet" type="text/css" />
	<link href="/metronic/css/dark-brand.css" rel="stylesheet" type="text/css" />
	<link href="/metronic/css/dark-aside.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	
	<script>
		(function(h, o, t, j, a, r) {
			h.hj = h.hj || function() {
				(h.hj.q = h.hj.q || []).push(arguments)
			};
			h._hjSettings = {
				hjid: 1070954,
				hjsv: 6
			};
			a = o.getElementsByTagName('head')[0];
			r = o.createElement('script');
			r.async = 1;
			r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
			a.appendChild(r);
		})(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
	</script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async="async" src="https://www.googletagmanager.com/gtag/js?id=UA-37564768-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());
		gtag('config', 'UA-37564768-1');
	</script>


	<style type="text/css">
		.select2-selection__arrow:before {
			content: "";
			position: absolute;
			right: 7px;
			top: 42%;
			border-top: 5px solid #888;
			border-left: 4px solid transparent;
			border-right: 4px solid transparent;
		}
		.no-padding{
			padding-left: 0 !important;
			padding-right: 0 !important;
		}
		.ativo{
			background-color: #55C6BD;
			color: #fff;
		}
		.desativo{
			background-color: #EBEDF3;
			color: #000;
		}
		.img-prod{
			/*height: 100px;*/
			margin-top: 10px;

		}
		@media only screen and (max-width: 1000px) {
			#div-categorias{
				display: none;
			}
		}
		@media only screen and (min-width: 1001px) and (max-width: 3000px){
			#div-categorias{
				display: inline
			}
		}
		#atalho_add:hover{
			cursor: pointer;
		}

		.money-cel{
			width: 120px;
			height: 50px;
		}

		.money-moeda{
			width: 80px;
		}

		#focus-codigo:hover{
			cursor: pointer
		}

	</style>
	<style type="text/css">
		.select2-selection__arroww:before {
			content: "";
			position: absolute;
			right: 7px;
			top: 42%;
			border-top: 5px solid #888;
			border-left: 4px solid transparent;
			border-right: 4px solid transparent;
		}
	</style>
</head>


<!-- end::Head -->

<!-- begin::Body -->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

	<input type="hidden" id="produtos" value="{{json_encode($produtos)}}" name="">
	<input type="hidden" id="categorias" value="{{json_encode($categorias)}}" name="">
	<input type="hidden" id="clientes" value="{{json_encode($clientes)}}" name="">
	<input type="hidden" id="agendamento_id" value="{{$agendamento_id ?? 0}}" name="">
	
	<input type="hidden" id="_token" value="{{ csrf_token() }}">

	<input type="hidden" id="valor_entrega" @if(isset($valor_entrega)) value="{{$valor_entrega}}" @else value='0' @endif>
	
	@if(isset($itens))
	<input type="hidden" id="itens_pedido" value="{{json_encode($itens)}}">
	<input type="hidden" id="valor_total" @if(isset($valor_total)) value="{{$valor_total}}" @else value='0' @endif>
	<input type="hidden" id="delivery_id" @if(isset($delivery_id)) value="{{$delivery_id}}" @else value='0' @endif>
	<input type="hidden" id="bairro" @if(isset($bairro)) value="{{$bairro}}" @else value='0' @endif>
	
	<input type="hidden" id="codigo_comanda_hidden" @if(isset($cod_comanda)) value="{{$cod_comanda}}" @else value='0' @endif name="">
	@endif

	<input type="hidden" id="PDV_VALOR_RECEBIDO" value="{{ getenv('PDV_VALOR_RECEBIDO') }}">

	<div class="card card-custom gutter-b example example-compact">
		<div class="col-lg-12">
			<div class="container">
				<div class="row" style="margin-top: 10px;">

					<div class="col-sm-2 col-lg-2 col-xl-4 col-md-6 col-6">

						<h4><strong id="timer">00:00:00</strong></h4>
					</div>

					<div class="col-sm-4 col-lg-4 col-md-6 col-xl-6 col-6">
						<h4>Ambiente: <strong class="text-success">{{session('user_logged')['ambiente']}}</strong>
						</h4>
					</div>

					<div class="col-sm-6 col-lg-6 col-xl-2 col-md-12 col-12">

						<div class="dropdown dropdown-inline show" data-toggle="tooltip" title="" data-placement="left" data-original-title="Ações para PDV">
							<a href="#" class="btn btn-light-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								Açoes
								<i class="la la-down"></i>
								<!--end::Svg Icon-->

							</a>
							<div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 m-0 " style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-211px, 39px, 0px);" x-placement="bottom-end">
								<!--begin::Navigation-->
								<ul class="navi navi-hover">
									<li class="navi-header font-weight-bold py-4">
										<span class="font-size-lg">Selecione:</span>
									</li>
									<li class="navi-separator mb-3 opacity-70"></li>

									<li class="navi-item">
										<a href="/frenteCaixa/list" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-success">Lista de vendas</span>
											</span>
										</a>
									</li>
									<li class="navi-item">
										<a href="/frenteCaixa/devolucao" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-danger">Devolução</span>
											</span>
										</a>
									</li>
									<li class="navi-item">
										<a data-toggle="modal" href="#!" data-target="#modal2" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-dark">Sangria</span>
											</span>
										</a>
									</li>

									<li class="navi-item">
										<a data-toggle="modal" href="#!" data-target="#modal-supri" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-warning">Suprimento de Caixa</span>
											</span>
										</a>
									</li>
									<li class="navi-item">
										<a data-toggle="modal" href="#!" data-target="#modal3" onclick="fluxoDiario()" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-primary">
													Fluxo Diário
												</span>
											</span>
										</a>
									</li>
									<li class="navi-item">
										<a data-toggle="modal" href="#!" data-target="#modal-comanda" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-success">Apontar Comanda</span>
											</span>
										</a>
									</li>

									<li class="navi-item">
										<a href="/frenteCaixa/fechar" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-danger">
													Fechar Caixa
												</span>
											</span>
										</a>
									</li>

									<li class="navi-item">
										<a href="/frenteCaixa/list" class="navi-link">
											<span class="navi-text">
												<span class="label label-xl label-inline label-light-info">
													Sair
												</span>
											</span>
										</a>
									</li>
								</ul>

							</div>
						</div>
					</div>




				</div>


			</div>
			<input type="" autofocus="" style="border: none; width: 0px; height: 0px; " id="codBarras" name="">

			<hr>
			<div class="row">

				<div class="col-sm-12 col-lg-7 col-md-12 col-12">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<div class="row align-items-center" style="margin-top: 10px;">
								<div class="form-group validated col-sm-6 col-lg-6 col-12 col-sm-12">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="focus-codigo">
												<li class="la la-barcode"></li>
											</span>
										</div>
										<select class="form-control select2" id="kt_select2_1" name="produto">
											<option>Selecione um produto, ou use código de barra</option>
											@foreach($produtos as $p)
											<option value="{{$p->id}}">{{$p->id}} - {{$p->nome}}</option>
											@endforeach
										</select>

									</div>
								</div>

								<div class="form-group validated col-sm-2 col-lg-2 col-5 col-sm-5">
									<div class="">
										<input id="valor_item" placeholder="Valor" type="text" class="form-control" name="valor" value="0.00">

									</div>
								</div>

								<div class="form-group validated col-sm-2 col-lg-2 col-5 col-sm-5">
									<div class="">
										<input id="quantidade" placeholder="QTD" type="text" class="form-control" name="quantidade" value="1">

									</div>
								</div>

								<div class="form-group validated col-sm-2 col-lg-2 col-6 col-sm-6">
									<button id="adicionar-item" type="submit" class="btn btn-success">Adicionar</button>
								</div>
							</div>
						</div>
						<div class="card-body" style="height: 445px;">

							<div class="col-xl-12">
								<div class="row">
									<div class="col-xl-12">
										<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" >

											<table class="datatable-table" style="max-width: 100%; overflow: scroll; max-height: 420px;">
												<thead class="datatable-head">
													<tr class="datatable-row" style="left: 0px;">
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 50px;">ITEM</span></th>
														<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 50px;">ID</span></th>
														<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">PRODUTO</span></th>
														<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">QTD</span></th>
														<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">VALOR</span></th>
														<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">SUBTOTAL</span></th>
													</tr>
												</thead>
												<tbody class="datatable-body" id="body">


												</tbody>

											</table>

										</div>
									</div>
								</div>

							</div>
						</div>

					</div>

					<div class="card card-custom gutter-b example example-compact" style="margin-top: -20px; height: auto;">
						<div class="card-body">
							<div class="row align-items-center">

								<div class="col-sm-3 col-lg-3 col-6">
									<label>Desconto: R$ <strong id="valor_desconto">0,00</strong></label>
									<button onclick="setaDesconto()" style="margin-left: 4px; margin-top: -10px;" class="btn btn-link-primary">
										<i class="la la-edit"></i>
									</button>
								</div>
								<div class="col-sm-3 col-lg-3 col-6">

									<label>Acrescimo: R$ <strong id="valor_acrescimo">0,00</strong></label>
									<button onclick="setaAcresicmo()" style="margin-left: 4px; margin-top: -10px;" class="btn btn-link-primary">
										<i class="la la-edit"></i>
									</button>
								</div>
								<div class="col-sm-2 col-lg-2 col-3">
									<label>Lista de Preços</label>
								</div>

								<div class="col-sm-4 col-lg-4 col-6" style="margin-top: -8px;">
									@if(isset($listaPreco))

									<select class="custom-select form-control" id="lista_id" name="lista_id">

										<option value="0">Padrão</option>
										@foreach($listaPreco as $l)
										<option value="{{$l->id}}">{{$l->nome}} - {{$l->percentual_alteracao}}%
										</option>
										@endforeach
									</select>

									@else


									<select class="custom-select form-control" id="lista_id" name="lista_id">

										<option value="0">Padrão</option>
									</select>


									@endif
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-5 col-lg-5 col-md-12 col-12" id="div-categorias">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<div class="row" style="height: 72px; overflow-x: auto; width: auto; white-space: nowrap">
								<div class="form-group validated col-sm-12 col-lg-12 col-12 col-sm-12" style="margin-top: 10px;">
									<a href="#!" id="cat_todos" onclick="categoria('todos')" style="height: 40px; min-width: 80px;" class="label label-xl label-inline label-light-muted ativo">Todos</a>
									@foreach($categorias as $c)
									<a href="#!" id="cat_{{$c->id}}" onclick="categoria('{{$c->id}}')" style="height: 40px; min-width: 80px;" class="label label-xl label-inline desativo">{{$c->nome}}</a>
									@endforeach

								</div>

							</div>
						</div>
						<div class="card-body" style="height: 533px; overflow-y: auto; ">
							<div class="row" id="prods">
								@foreach($produtos as $p)
								<div class="col-sm-12 col-lg-6 col-md-6 col-xl-4" id="atalho_add" onclick="adicionarProdutoRapido('{{$p}}')">
									<div class="card card-custom gutter-b example example-compact">
										<div class="card-header" style="height: 180px;">
											<div class="symbol symbol-circle symbol-lg-100">
												@if($p->imagem)
												<img class="img-prod" src="/imgs_produtos/{{$p->imagem}}">
												@else
												<img class="img-prod" src="/imgs/no_image.png">
												@endif
											</div>

											<h6 style="font-size: 12px; width: 100%" class="kt-widget__label">
												{{$p->nome}}
											</h6>
											<h6 style="font-size: 12px;" class="text-danger" class="kt-widget__label">
												R$ {{number_format($p->valor_venda, 2)}}
											</h6>

											<h6 style="font-size: 10px; margin-right: -15px;" class="text-info" class="kt-widget__label">
												Estoque: {{$p->estoqueAtual()}}
											</h6>

										</div>

									</div>
								</div>
								@endforeach

							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="row">
				<div class="col-sm-12 col-lg-12 col-md-12 col-12">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-body">

							<div class="row">
								<div class="form-group validated col-sm-2 col-lg-2 col-6 col-md-6" style="margin-top: 5px;">
									<div class="">
										<input type="text" placeholder="Valor recebido" id="valor_recebido" name="valor_recebido" class="form-control money" value="">
									</div>
								</div>
								<div class="form-group validated col-sm-3 col-lg-3 col-6 col-md-6" style="margin-top: 5px;">
									<div class="">
										<select class="custom-select form-control" id="tipo-pagamento" name="tipo-pagamento">
											<option value="--">Selecione o Tipo de pagamento</option>
											@foreach($tiposPagamento as $key => $t)
											<option 
											@if($config->tipo_pagamento_padrao == $key)
											selected
											@endif
											value="{{$key}}">{{$key}} - {{$t}}</option>
											@endforeach
										</select>
									</div>


								</div>


								<div class="form-group validated col-sm-7 col-lg-3 col-12 col-md-12">
									<button id="click-client" class="btn btn-danger btn-lg">
										<i class="la la-user"></i>
									</button>
									<button id="click-multi" class="btn btn-info btn-lg">
										<i class="la la-list"></i>
									</button>
									<button onclick="setaObservacao()" class="btn btn-primary btn-lg">
										<i class="la la-marker"></i>
									</button>
								</div>

								

								<div class="form-group validated col-sm-6 col-lg-2 col-12 col-md-12">

									<span style="font-size: 25px; padding: 25px;" class="label label-xl label-inline label-light-info">Troco
										<strong style="margin-left: 5px;" id="valor-troco"> R$ 0,00</strong>
									</span>

								</div>
								<div class="form-group validated col-sm-6 col-lg-2 col-12 col-md-12">
									<div class="">

										<button id="finalizar-venda" style="width: 100%" class="btn btn-success btn-lg disabled">
											<i class="la la-check"></i>
											Finalizar
											<strong id="total-venda">R$ 0,00</strong>
										</button>
									</div>
								</div>


							</div>

						</div>
					</div>
				</div>
			</div>
		</div>


		<!-- Modals -->
		<input type="hidden" id="_token" value="{{csrf_token()}}" name="">

		<div class="modal fade" id="modal1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">É necessário abrir o caixa com um valor</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-12 col-lg-12">
								<label class="col-form-label" id="">Valor</label>
								<div class="">
									<input type="text" id="valor" name="valor" class="form-control money" value="">
								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
						<button type="button" onclick="abrirCaixa()" class="btn btn-light-success font-weight-bold">Abrir</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-pag-mult" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">PAGAMENTO MULTIPLO R$ <strong class="text-danger" id="v-multi"></strong></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-6 col-lg-6">
								<label class="col-form-label" id="">Tipo de pagamento 1</label>
								<select class="custom-select form-control" id="tipo_pagamento_1" name="tipo_pagamento_1">
									@foreach($tiposPagamentoMulti as $t)
									<option value="{{$t}}">{{$t}}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group validated col-sm-6 col-lg-6">
								<label class="col-form-label" id="">Valor de pagamento 1</label>
								<input type="text" placeholder="Valor" id="valor_pagamento_1" name="valor_pagamento_1" class="form-control money" value="">
							</div>
						</div>

						<div class="row">
							<div class="form-group validated col-sm-6 col-lg-6">
								<label class="col-form-label" id="">Tipo de pagamento 2</label>
								<select class="custom-select form-control" id="tipo_pagamento_2" name="tipo_pagamento_2">
									@foreach($tiposPagamentoMulti as $t)
									<option value="{{$t}}">{{$t}}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group validated col-sm-6 col-lg-6">
								<label class="col-form-label" id="">Valor de pagamento 2</label>
								<input type="text" placeholder="Valor" id="valor_pagamento_2" name="valor_pagamento_2" class="form-control money" value="">
							</div>
						</div>

						<div class="row">
							<div class="form-group validated col-sm-6 col-lg-6">
								<label class="col-form-label" id="">Tipo de pagamento 3</label>
								<select class="custom-select form-control" id="tipo_pagamento_3" name="tipo_pagamento_3">
									@foreach($tiposPagamentoMulti as $t)
									<option value="{{$t}}">{{$t}}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group validated col-sm-6 col-lg-6">
								<label class="col-form-label" id="">Valor de pagamento 3</label>
								<input type="text" placeholder="Valor" id="valor_pagamento_3" name="valor_pagamento_3" class="form-control money" value="">
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
						<button type="button" id="btn-ok-multi" class="btn btn-light-success font-weight-bold" disabled="true">OK</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-venda" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">FINALIZAR VENDA</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-4 col-lg-4 col-12 @if($certificado == null) disabled @endif">
								<button class="btn btn-success" onclick="verificaCliente()" style="height: 50px; width: 100%">
									CUPOM FISCAL
								</button>
							</div>
							
							<div class="form-group validated col-sm-4 col-lg-4 col-12">
								<button class="btn btn-info" id="btn_nao_fiscal" onclick="finalizarVenda('nao_fiscal')" style="height: 50px; width: 100%">
									CUPOM NÃO FISCAL
								</button>
							</div>

							<div class="form-group validated col-sm-4 col-lg-4 col-12">
								<button class="btn btn-warning disabled" id="conta_credito-btn" onclick="finalizarVenda('credito')" style="height: 50px; width: 100%">
									CONTA CRÉDITO
								</button>
							</div>


						</div>


					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-cpf-nota" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">CPF NA NOTA?</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<input type="hidden" id="nome" name="nome" class="form-control money" value="">
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-12 col-lg-12 col-12">
								<label class="col-form-label" id="">CPF</label>
								<input type="text" placeholder="CPF" id="cpf" name="cpf" class="form-control" value="">
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button style="width: 100%" id="btn-cpf" type="button" onclick="finalizarVenda('fiscal')" class="btn btn-success font-weight-bold spinner-white spinner-right">EMITIR</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-cliente" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">SELECIONAR CLIENTE</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<input type="hidden" id="nome" name="nome" class="form-control money" value="">
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-12 col-lg-12 col-12">
								<label class="col-form-label" id="">Cliente</label><br>
								<select class="form-control select2" style="width: 100%" id="kt_select2_3" name="cliente">
									<option value="null">Selecione o cliente</option>
									@foreach($clientes as $c)
									<option value="{{$c->id}}">{{$c->id}} - {{$c->razao_social}}</option>
									@endforeach
								</select>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
						<button type="button" onclick="selecionarCliente()" class="btn btn-light-success font-weight-bold">OK</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal2" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">SANGRIA DE CAIXA</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-12 col-lg-12 col-12">
								<label class="col-form-label" id="">Valor</label>
								<input type="text" placeholder="Valor" id="valor_sangria" name="valor_sangria" class="form-control" value="">
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button style="width: 100%" type="button" onclick="sangriaCaixa()" class="btn btn-success font-weight-bold">OK</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-supri" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">SUPRIMENTO DE CAIXA</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-6 col-lg-6 col-6">
								<label class="col-form-label" id="">Valor</label>
								<input type="text" placeholder="Valor" id="valor_suprimento" name="valor_sangria" class="form-control money" value="">
							</div>
						</div>

						<div class="row">
							<div class="form-group validated col-sm-12 col-lg-12 col-12">
								<label class="col-form-label" id="">Observação</label>
								<input type="text" placeholder="Observação" id="obs_suprimento" name="obs" class="form-control" value="">
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button style="width: 100%" type="button" onclick="suprimentoCaixa()" class="btn btn-success font-weight-bold">OK</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal3" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">FLUXO DIÁRIO</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>

					<div class="modal-body">

						<div class="row" style="height: 350px; overflow-y: auto;">
							<div class="col-sm-12 col-lg-12 col-12">
								<h5>Abertura de Caixa:</h5>
								<div id="fluxo_abertura_caixa"></div>
							</div>

							<div class="col-sm-12 col-lg-12 col-12">
								<h5>Sangrias:</h5>
								<div id="fluxo_sangrias"></div>
							</div>

							<div class="col-sm-12 col-lg-12 col-12">
								<h5>Suprimentos:</h5>
								<div id="fluxo_suprimentos"></div>
							</div>

							<div class="col-sm-12 col-lg-12 col-12">
								<h5>Vendas:</h5>
								<div id="fluxo_vendas"></div>
							</div>

							<div class="col-sm-12 col-lg-12 col-12">
								<h5>Total em caixa: 
									<strong id="total_caixa" class="text-success"></strong></h5>
								</div>
							</div>
						</div>


					</div>

				</div>
			</div>
		</div>

		<div class="modal fade" id="modal4" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">SUGESTÃO DE TROCO</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>

					<div class="modal-body">
						<h2>Valor do troco: <strong id="valor_troco" class="text-danger">0,00</strong></h2>

						<div class="row" style="height: 460px; overflow-y: auto;">
							<div class="col-sm-12 col-lg-12 col-12">

								<div class="row 50_reais" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-cel" src="/imgs/50_reais.jpeg"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_50_reais"></h4>
									</div>
								</div>
								<div class="row 20_reais" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-cel" src="/imgs/20_reais.jpeg"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_20_reais"></h4>
									</div>
								</div>

								<div class="row 10_reais" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-cel" src="/imgs/10_reais.jpeg"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_10_reais"></h4>
									</div>
								</div>

								<div class="row 5_reais" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-cel" src="/imgs/5_reais.jpeg"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_5_reais"></h4>
									</div>
								</div>

								<div class="row 2_reais" style="display: none">

									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-cel" src="/imgs/2_reais.jpeg"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_2_reais"></h4>
									</div>
								</div>

								<div class="row 1_real" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-moeda" src="/imgs/1_real.png"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_1_real"></h4>
									</div>
								</div>

								<div class="row 50_centavo" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-moeda" src="/imgs/50_centavo.png"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_50_centavos"></h4>
									</div>
								</div>

								<div class="row 25_centavo" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-moeda" src="/imgs/25_centavo.png"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_25_centavos"></h4>
									</div>
								</div>

								<div class="row 10_centavo" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-moeda" src="/imgs/10_centavo.png"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_10_centavos"></h4>
									</div>
								</div>


								<div class="row 5_centavo" style="display: none">
									<div class="col-sm-3 col-lg-3 col-3">
										<img class="money-moeda" src="/imgs/5_centavo.png"> 
									</div>
									<div class="col-sm-3 col-lg-3 col-3">
										<h4 id="qtd_5_centavos"></h4>
									</div>
								</div>
							</div>
						</div>


					</div>

				</div>
			</div>
		</div>

		<div id="modal4" class="modal">
			<div class="modal-content">
				<div class="row">
					<h4>Valor do troco: <strong id="valor_troco" class="orange-text">0,00</strong></h4>

					<h5>Sugestão:</h5>
					<div class="row 50_reais" style="display: none">
						<div class="col s3">
							<img class="money-cel" src="/imgs/50_reais.jpeg"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_50_reais"></h4>
						</div>
					</div>
					<div class="row 20_reais" style="display: none">
						<div class="col s3">
							<img class="money-cel" src="/imgs/20_reais.jpeg"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_20_reais"></h4>
						</div>
					</div>

					<div class="row 10_reais" style="display: none">
						<div class="col s3">
							<img class="money-cel" src="/imgs/10_reais.jpeg"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_10_reais"></h4>
						</div>
					</div>

					<div class="row 5_reais" style="display: none">
						<div class="col s3">
							<img class="money-cel" src="/imgs/5_reais.jpeg"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_5_reais"></h4>
						</div>
					</div>

					<div class="row 2_reais" style="display: none">
						<div class="col s3">
							<img class="money-cel" src="/imgs/2_reais.jpeg"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_2_reais"></h4>
						</div>
					</div>

					<div class="row 1_real" style="display: none">
						<div class="col s3">
							<img class="money-moeda" src="/imgs/1_real.png"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_1_real"></h4>
						</div>
					</div>

					<div class="row 50_centavo" style="display: none">
						<div class="col s3">
							<img class="money-moeda" src="/imgs/50_centavo.png"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_50_centavos"></h4>
						</div>
					</div>

					<div class="row 25_centavo" style="display: none">
						<div class="col s3">
							<img class="money-moeda" src="/imgs/25_centavo.png"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_25_centavos"></h4>
						</div>
					</div>

					<div class="row 10_centavo" style="display: none">
						<div class="col s3">
							<img class="money-moeda" src="/imgs/10_centavo.png"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_10_centavos"></h4>
						</div>
					</div>


					<div class="row 5_centavo" style="display: none">
						<div class="col s3">
							<img class="money-moeda" src="/imgs/5_centavo.png"> 
						</div>
						<div class="col s3">
							<h4 id="qtd_5_centavos"></h4>
						</div>
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<div class="modal-footer">
					<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
				</div>

			</div>
		</div>

		<div class="modal fade" id="modal-comanda" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">INFORME O CÓDIGO DA COMANDA</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-12 col-lg-12 col-12">
								<label class="col-form-label" id="">Código da comanda</label>
								<input type="text" placeholder="Comanda" id="cod-comanda" name="cod-comanda" class="form-control" value="">
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button style="width: 100%" type="button" onclick="apontarComanda()" class="btn btn-success font-weight-bold">APONTAR</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-obs" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">OBSERVAÇÃO</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							x
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group validated col-sm-12 col-lg-12 col-12">
								<label class="col-form-label" id="">Observação</label>
								<input type="text" placeholder="Observação" id="obs" class="form-control" @if(isset($observacao)) value="{{$observacao}}" @endif>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button style="width: 100%" type="button" onclick="apontarObs()" class="btn btn-success font-weight-bold">OK</button>
					</div>
				</div>
			</div>
		</div>


		<script>
			var KTAppSettings = {
				"breakpoints": {
					"sm": 576,
					"md": 768,
					"lg": 992,
					"xl": 1200,
					"xxl": 1400
				},
				"colors": {
					"theme": {
						"base": {
							"white": "#ffffff",
							"primary": "#3699FF",
							"secondary": "#E5EAEE",
							"success": "#1BC5BD",
							"info": "#8950FC",
							"warning": "#FFA800",
							"danger": "#F64E60",
							"light": "#E4E6EF",
							"dark": "#181C32"
						},
						"light": {
							"white": "#ffffff",
							"primary": "#E1F0FF",
							"secondary": "#EBEDF3",
							"success": "#C9F7F5",
							"info": "#EEE5FF",
							"warning": "#FFF4DE",
							"danger": "#FFE2E5",
							"light": "#F3F6F9",
							"dark": "#D6D6E0"
						},
						"inverse": {
							"white": "#ffffff",
							"primary": "#ffffff",
							"secondary": "#3F4254",
							"success": "#ffffff",
							"info": "#ffffff",
							"warning": "#ffffff",
							"danger": "#ffffff",
							"light": "#464E5F",
							"dark": "#ffffff"
						}
					},
					"gray": {
						"gray-100": "#F3F6F9",
						"gray-200": "#EBEDF3",
						"gray-300": "#E4E6EF",
						"gray-400": "#D1D3E0",
						"gray-500": "#B5B5C3",
						"gray-600": "#7E8299",
						"gray-700": "#5E6278",
						"gray-800": "#3F4254",
						"gray-900": "#181C32"
					}
				},
				"font-family": "Poppins"
			};
		</script>

		<!-- end::Global Config -->
		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="/metronic/js/plugins.bundle.js" type="text/javascript"></script>
		<script src="/metronic/js/prismjs.bundle.js" type="text/javascript"></script>
		<script src="/metronic/js/scripts.bundle.js" type="text/javascript"></script>
		<script src="/metronic/js/wizard.js" type="text/javascript"></script>

		<script src="/metronic/js/fullcalendar.bundle.js" type="text/javascript"></script>
		<script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
		<script src="/metronic/js/gmaps.js" type="text/javascript"></script>
		<script type="text/javascript" src="/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="/js/mascaras.js"></script>
		<script src="/metronic/js/select2.js" type="text/javascript"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script> -->
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

		<?php $path = getenv('PATH_URL') . "/"; ?>
		<script type="text/javascript">
			const path = "{{$path}}";
		</script>


		<script type="text/javascript" src="/js/frenteCaixa.js"></script>


		<script>

			jQuery(document).ready(function() {
				KTSelect2.init();
				$('.select2-selection__arrow').addClass('select2-selection__arroww')

				$('.select2-selection__arrow').removeClass('select2-selection__arrow')
				var KTBootstrapDatepicker = function() {

					var arrows;
					if (KTUtil.isRTL()) {
						arrows = {
							leftArrow: '<i class="la la-angle-right"></i>',
							rightArrow: '<i class="la la-angle-left"></i>'
						}
					} else {
						arrows = {
							leftArrow: '<i class="la la-angle-left"></i>',
							rightArrow: '<i class="la la-angle-right"></i>'
						}
					}

					// Private functions
					var demos = function() {

						// minimum setup
						$('#kt_datepicker_1').datepicker({
							rtl: KTUtil.isRTL(),
							todayHighlight: true,
							orientation: "bottom left",
							templates: arrows
						});

						// minimum setup for modal demo
						$('#kt_datepicker_1_modal').datepicker({
							rtl: KTUtil.isRTL(),
							todayHighlight: true,
							orientation: "bottom left",
							templates: arrows
						});

						// input group layout
						$('#kt_datepicker_2').datepicker({
							rtl: KTUtil.isRTL(),
							todayHighlight: true,
							orientation: "bottom left",
							templates: arrows
						});

						// input group layout for modal demo
						$('#kt_datepicker_2_modal').datepicker({
							rtl: KTUtil.isRTL(),
							todayHighlight: true,

							orientation: "bottom left",
							templates: arrows
						});

						// enable clear button
						$('#kt_datepicker_3, #kt_datepicker_3_validate').datepicker({
							rtl: KTUtil.isRTL(),
							todayBtn: "linked",
							clearBtn: false,
							format: 'dd/mm/yyyy',
							todayHighlight: false,
							templates: arrows
						});

						// enable clear button for modal demo
						$('#kt_datepicker_3_modal').datepicker({
							rtl: KTUtil.isRTL(),
							todayBtn: "linked",
							clearBtn: false,
							format: 'dd/mm/yyyy',
							todayHighlight: false,
							templates: arrows
						});

						// orientation
						$('#kt_datepicker_4_1').datepicker({
							rtl: KTUtil.isRTL(),
							orientation: "top left",
							todayHighlight: true,
							templates: arrows
						});

						$('#kt_datepicker_4_2').datepicker({
							rtl: KTUtil.isRTL(),
							orientation: "top right",
							todayHighlight: true,
							templates: arrows
						});

						$('#kt_datepicker_4_3').datepicker({
							rtl: KTUtil.isRTL(),
							orientation: "bottom left",
							todayHighlight: true,
							templates: arrows
						});


					}

					return {

						init: function() {
							demos();
						}
					};
				}();

				KTBootstrapDatepicker.init({
					format: 'dd/mm/yyyy'
				});

			});

			setInterval(() => {
				let hora = formatar(new Date())
				$('#timer').html(hora)
			}, 1000)

			const formatar = (data) => {
				const hora = data.getHours() < 10 ? '0'+data.getHours() : data.getHours();
				const min = data.getMinutes() < 10 ? '0'+data.getMinutes() : data.getMinutes();
				const seg = data.getSeconds() < 10 ? '0'+data.getSeconds() : data.getSeconds();

				return `${hora}:${min}:${seg}`;
			};



		</script>

	</body>


	</html>