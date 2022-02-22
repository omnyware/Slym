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

	@if(isset($fullcalendar))
	<link href='/fullcalendar/main.css' rel='stylesheet' />
	@endif

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

	<link rel="shortcut icon" href="/../../imgs/slym.png" />
	
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

	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());
		gtag('config', 'UA-37564768-1');
	</script>


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

		.accordion.accordion-toggle-arrow .card .card-header .card-title::after{
			display: none
		}


	</style>
</head>


<!-- end::Head -->

<!-- begin::Body -->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

	<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">

		<a href="/graficos">
			<img width="100" alt="Logo" src="/../../imgs/slym.png" />
		</a>
		<div class="d-flex align-items-center">
			<!--begin::Aside Mobile Toggle-->
			<button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
				<span></span>
			</button>

			<button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
				<span></span>
			</button>



			<button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
				<span class="svg-icon svg-icon-xl">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<polygon points="0 0 24 0 24 24 0 24" />
							<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
							<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
						</g>
					</svg>
				</span>
			</button>
		</div>

	</div>

	<div class="d-flex flex-column flex-root" >
		<div class="d-flex flex-row flex-column-fluid page">

			<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside" style="overflow-y: auto;">
				<!-- begin:: Aside -->
				<div class="brand flex-column-auto" id="kt_brand">

					<a href="/graficos" class="brand-logo">
						<img width="100" alt="Logo" src="../../imgs/slym.png" />
					</a>

					<button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
						<span class="svg-icon svg-icon svg-icon-xl">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<polygon points="0 0 24 0 24 24 0 24" />
									<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) " />
									<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) " />
								</g>
							</svg>
						</span>
					</button>
				</div>

				<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
					<div id="kt_aside_menu" class="aside-menu my-4 " data-menu-dropdown-timeout="500">

						<ul class="menu-nav">
							<li class="menu-item menu-item-submenu menu-item @if($rotaAtiva == 'cadastros') menu-item-active @endif" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<span class="svg-icon menu-icon">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24"></rect>
												<rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
												<path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
											</g>
										</svg>
									</span>
									<span class="menu-text">Cadastros</span>
								</a>
								<div class="menu-submenu " style="" kt-hidden-height="320">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item  menu-item-parent" aria-haspopup="true">
											<span class="menu-link">
												<span class="menu-text"></span>
											</span>
										</li>

										<li class="menu-item  menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
											<a href="/categorias" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Categorias</span>
											</a>

											<a href="/produtos" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Produtos</span>
											</a>

											<a href="/clientes" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Clientes</span>
											</a>
											<a href="/fornecedores" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Fornecedores</span>
											</a>

											<a href="/transportadoras" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Transportadoras</span>
											</a>
											<a href="/funcionarios" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Funcionarios</span>
											</a>
											@if(getenv('OS') == 1)
											<a href="/categoriasServico" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Categorias de Serviços</span>
											</a>
											<a href="/servicos" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Serviços</span>
											</a>
											@endif

											<a href="/listaDePrecos" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Lista de Preços</span>
											</a>

											<a href="/categoriasConta" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Categorias de Contas</span>
											</a>

											<a href="/veiculos" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Veiculos</span>
											</a>
											<a href="/usuarios" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Usuarios</span>
											</a>
										</li>
									</ul>
								</div>
							</li>

							<li class="menu-item menu-item-submenu menu-item @if($rotaAtiva == 'entradas') menu-item-active @endif" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<span class="svg-icon menu-icon">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<rect fill="#000000" opacity="0.3" transform="translate(9.000000, 12.000000) rotate(-270.000000) translate(-9.000000, -12.000000) " x="8" y="6" width="2" height="12" rx="1" />
												<path d="M20,7.00607258 C19.4477153,7.00607258 19,6.55855153 19,6.00650634 C19,5.45446114 19.4477153,5.00694009 20,5.00694009 L21,5.00694009 C23.209139,5.00694009 25,6.7970243 25,9.00520507 L25,15.001735 C25,17.2099158 23.209139,19 21,19 L9,19 C6.790861,19 5,17.2099158 5,15.001735 L5,8.99826498 C5,6.7900842 6.790861,5 9,5 L10.0000048,5 C10.5522896,5 11.0000048,5.44752105 11.0000048,5.99956624 C11.0000048,6.55161144 10.5522896,6.99913249 10.0000048,6.99913249 L9,6.99913249 C7.8954305,6.99913249 7,7.89417459 7,8.99826498 L7,15.001735 C7,16.1058254 7.8954305,17.0008675 9,17.0008675 L21,17.0008675 C22.1045695,17.0008675 23,16.1058254 23,15.001735 L23,9.00520507 C23,7.90111468 22.1045695,7.00607258 21,7.00607258 L20,7.00607258 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.000000, 12.000000) rotate(-90.000000) translate(-15.000000, -12.000000) " />
												<path d="M16.7928932,9.79289322 C17.1834175,9.40236893 17.8165825,9.40236893 18.2071068,9.79289322 C18.5976311,10.1834175 18.5976311,10.8165825 18.2071068,11.2071068 L15.2071068,14.2071068 C14.8165825,14.5976311 14.1834175,14.5976311 13.7928932,14.2071068 L10.7928932,11.2071068 C10.4023689,10.8165825 10.4023689,10.1834175 10.7928932,9.79289322 C11.1834175,9.40236893 11.8165825,9.40236893 12.2071068,9.79289322 L14.5,12.0857864 L16.7928932,9.79289322 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.500000, 12.000000) rotate(-90.000000) translate(-14.500000, -12.000000) " />
											</g>
										</svg>
									</span>
									<span class="menu-text">Entradas</span>
									<!-- <i class="la la-arrow-down"></i> -->
								</a>
								<div class="menu-submenu " style="" kt-hidden-height="320">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item  menu-item-parent" aria-haspopup="true">
											<span class="menu-link">
												<span class="menu-text"></span>
											</span>
										</li>

										<li class="menu-item  menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
											<a href="/compraFiscal" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Compra Fiscal</span>
											</a>

											<a href="/compraManual" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Compra Manual</span>
											</a>

											<a href="/compras" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Compras</span>
											</a>
											@if(getenv('COTACAO') == 1)
											<a href="/cotacao" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Cotação</span>
											</a>
											@endif

										</li>
									</ul>
								</div>
							</li>

							<li class="menu-item menu-item-submenu menu-item" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<span class="svg-icon menu-icon">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<rect fill="#000000" opacity="0.3" x="4" y="5" width="16" height="2" rx="1" />
												<rect fill="#000000" opacity="0.3" x="4" y="13" width="16" height="2" rx="1" />
												<path d="M5,9 L13,9 C13.5522847,9 14,9.44771525 14,10 C14,10.5522847 13.5522847,11 13,11 L5,11 C4.44771525,11 4,10.5522847 4,10 C4,9.44771525 4.44771525,9 5,9 Z M5,17 L13,17 C13.5522847,17 14,17.4477153 14,18 C14,18.5522847 13.5522847,19 13,19 L5,19 C4.44771525,19 4,18.5522847 4,18 C4,17.4477153 4.44771525,17 5,17 Z" fill="#000000" />
											</g>
										</svg>
									</span>
									<span class="menu-text">Estoque</span>
									<!-- <i class="la la-arrow-down"></i> -->
								</a>
								<div class="menu-submenu " style="" kt-hidden-height="320">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item  menu-item-parent" aria-haspopup="true">
											<span class="menu-link">
												<span class="menu-text"></span>
											</span>
										</li>

										<li class="menu-item  menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
											<a href="/estoque" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Manutenção</span>
											</a>

											<!--<a href="/estoque/apontamentoProducao" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Apontameto de Produçao</span>
											</a>-->

										</li>
									</ul>
								</div>
							</li>

							<li class="menu-item menu-item-submenu menu-item" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<span class="svg-icon menu-icon">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero" />
												<path d="M8.7295372,14.6839411 C8.35180695,15.0868534 7.71897114,15.1072675 7.31605887,14.7295372 C6.9131466,14.3518069 6.89273254,13.7189711 7.2704628,13.3160589 L11.0204628,9.31605887 C11.3857725,8.92639521 11.9928179,8.89260288 12.3991193,9.23931335 L15.358855,11.7649545 L19.2151172,6.88035571 C19.5573373,6.44687693 20.1861655,6.37289714 20.6196443,6.71511723 C21.0531231,7.05733733 21.1271029,7.68616551 20.7848828,8.11964429 L16.2848828,13.8196443 C15.9333973,14.2648593 15.2823707,14.3288915 14.8508807,13.9606866 L11.8268294,11.3801628 L8.7295372,14.6839411 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(14.000019, 10.749981) scale(1, -1) translate(-14.000019, -10.749981) " />
											</g>
										</svg>
									</span>
									<span class="menu-text">Financeiro</span>
									<!-- <i class="la la-arrow-down"></i> -->
								</a>
								<div class="menu-submenu " style="" kt-hidden-height="320">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item  menu-item-parent" aria-haspopup="true">
											<span class="menu-link">
												<span class="menu-text"></span>
											</span>
										</li>

										<li class="menu-item  menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
											<a href="/contasPagar" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Contas a Pagar</span>
											</a>

											<a href="/contasReceber" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Contas a Receber</span>
											</a>

											<a href="/fluxoCaixa" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Fluxo de Caixa</span>
											</a>

											<a href="/graficos" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Gráficos</span>
											</a>

											<a href="/relatorios" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Relatórios</span>
											</a>

										</li>
									</ul>
								</div>
							</li>

							<li class="menu-item menu-item-submenu menu-item" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<span class="svg-icon menu-icon">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3" />
												<path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000" />
												<rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1" />
												<rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1" />
												<rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1" />
												<rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1" />
												<rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1" />
												<rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1" />
											</g>
										</svg>
									</span>
									<span class="menu-text">Fiscal</span>
									<!-- <i class="la la-arrow-down"></i> -->
								</a>
								<div class="menu-submenu " style="" kt-hidden-height="320">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item  menu-item-parent" aria-haspopup="true">
											<span class="menu-link">
												<span class="menu-text"></span>
											</span>
										</li>

										<li class="menu-item  menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
											<a href="/configNF" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Configurar Emitente</span>
											</a>

											<a href="/escritorio" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Configurar Escritório</span>
											</a>

											<a href="/naturezaOperacao" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Natureza de Operação</span>
											</a>

											<a href="/tributos" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Tributação</span>
											</a>

											<a href="/enviarXml" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Enviar XML</span>
											</a>

											<a href="/dfe" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Manifesto</span>
											</a>

										</li>
									</ul>
								</div>
							</li>

							<li class="menu-item menu-item-submenu menu-item" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<span class="svg-icon menu-icon">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<rect fill="#000000" opacity="0.3" x="11.5" y="2" width="2" height="4" rx="1" />
												<rect fill="#000000" opacity="0.3" x="11.5" y="16" width="2" height="5" rx="1" />
												<path d="M15.493,8.044 C15.2143319,7.68933156 14.8501689,7.40750104 14.4005,7.1985 C13.9508311,6.98949895 13.5170021,6.885 13.099,6.885 C12.8836656,6.885 12.6651678,6.90399981 12.4435,6.942 C12.2218322,6.98000019 12.0223342,7.05283279 11.845,7.1605 C11.6676658,7.2681672 11.5188339,7.40749914 11.3985,7.5785 C11.2781661,7.74950085 11.218,7.96799867 11.218,8.234 C11.218,8.46200114 11.2654995,8.65199924 11.3605,8.804 C11.4555005,8.95600076 11.5948324,9.08899943 11.7785,9.203 C11.9621676,9.31700057 12.1806654,9.42149952 12.434,9.5165 C12.6873346,9.61150047 12.9723317,9.70966616 13.289,9.811 C13.7450023,9.96300076 14.2199975,10.1308324 14.714,10.3145 C15.2080025,10.4981676 15.6576646,10.7419985 16.063,11.046 C16.4683354,11.3500015 16.8039987,11.7268311 17.07,12.1765 C17.3360013,12.6261689 17.469,13.1866633 17.469,13.858 C17.469,14.6306705 17.3265014,15.2988305 17.0415,15.8625 C16.7564986,16.4261695 16.3733357,16.8916648 15.892,17.259 C15.4106643,17.6263352 14.8596698,17.8986658 14.239,18.076 C13.6183302,18.2533342 12.97867,18.342 12.32,18.342 C11.3573285,18.342 10.4263378,18.1741683 9.527,17.8385 C8.62766217,17.5028317 7.88033631,17.0246698 7.285,16.404 L9.413,14.238 C9.74233498,14.6433354 10.176164,14.9821653 10.7145,15.2545 C11.252836,15.5268347 11.7879973,15.663 12.32,15.663 C12.5606679,15.663 12.7949989,15.6376669 13.023,15.587 C13.2510011,15.5363331 13.4504991,15.4540006 13.6215,15.34 C13.7925009,15.2259994 13.9286662,15.0740009 14.03,14.884 C14.1313338,14.693999 14.182,14.4660013 14.182,14.2 C14.182,13.9466654 14.1186673,13.7313342 13.992,13.554 C13.8653327,13.3766658 13.6848345,13.2151674 13.4505,13.0695 C13.2161655,12.9238326 12.9248351,12.7908339 12.5765,12.6705 C12.2281649,12.5501661 11.8323355,12.420334 11.389,12.281 C10.9583312,12.141666 10.5371687,11.9770009 10.1255,11.787 C9.71383127,11.596999 9.34650161,11.3531682 9.0235,11.0555 C8.70049838,10.7578318 8.44083431,10.3968355 8.2445,9.9725 C8.04816568,9.54816454 7.95,9.03200304 7.95,8.424 C7.95,7.67666293 8.10199848,7.03700266 8.406,6.505 C8.71000152,5.97299734 9.10899753,5.53600171 9.603,5.194 C10.0970025,4.85199829 10.6543302,4.60183412 11.275,4.4435 C11.8956698,4.28516587 12.5226635,4.206 13.156,4.206 C13.9160038,4.206 14.6918294,4.34533194 15.4835,4.624 C16.2751706,4.90266806 16.9686637,5.31433061 17.564,5.859 L15.493,8.044 Z" fill="#000000" />
											</g>
										</svg>
									</span>
									<span class="menu-text">Saídas</span>
									<!-- <i class="la la-arrow-down"></i> -->
								</a>
								<div class="menu-submenu " style="" kt-hidden-height="320">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item  menu-item-parent" aria-haspopup="true">
											<span class="menu-link">
												<span class="menu-text"></span>
											</span>
										</li>

										<li class="menu-item  menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
											@if(getenv('OS') == 1)
											<a href="/ordemServico" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Ordem de Serviço</span>
											</a>
											@endif

											<a href="/frenteCaixa" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">PDV-Frente de Caixa</span>
											</a>

											<a href="/vendas/lista" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Vendas</span>
											</a>

											<a href="/vendas/nova" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Nova Venda</span>
											</a>

											<a href="/vendasEmCredito" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Conta Crédito</span>
											</a>

											<a href="/devolucao" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Devolução de Compra</span>
											</a>

											<a href="/orcamentoVenda" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Orçamentos</span>
											</a>

											<a href="/agendamentos" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Agendamentos</span>
											</a>

										</li>
									</ul>
								</div>
							</li>

							@if(getenv("PEDIDO_LOCAL") == 1)
							<li class="menu-item menu-item-submenu menu-item" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<span class="svg-icon menu-icon">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24" />
												<path d="M3.52270623,14.028695 C2.82576459,13.3275941 2.82576459,12.19529 3.52270623,11.4941891 L11.6127629,3.54050571 C11.9489429,3.20999263 12.401513,3.0247814 12.8729533,3.0247814 L19.3274172,3.0247814 C20.3201611,3.0247814 21.124939,3.82955935 21.124939,4.82230326 L21.124939,11.2583059 C21.124939,11.7406659 20.9310733,12.2027862 20.5869271,12.5407722 L12.5103155,20.4728108 C12.1731575,20.8103442 11.7156477,21 11.2385688,21 C10.7614899,21 10.3039801,20.8103442 9.9668221,20.4728108 L3.52270623,14.028695 Z M16.9307214,9.01652093 C17.9234653,9.01652093 18.7282432,8.21174298 18.7282432,7.21899907 C18.7282432,6.22625516 17.9234653,5.42147721 16.9307214,5.42147721 C15.9379775,5.42147721 15.1331995,6.22625516 15.1331995,7.21899907 C15.1331995,8.21174298 15.9379775,9.01652093 16.9307214,9.01652093 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
											</g>
										</svg>
									</span>
									<span class="menu-text">Pedidos</span>
									<!-- <i class="la la-arrow-down"></i> -->
								</a>
								<div class="menu-submenu " style="" kt-hidden-height="320">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item  menu-item-parent" aria-haspopup="true">
											<span class="menu-link">
												<span class="menu-text"></span>
											</span>
										</li>

										<li class="menu-item  menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
											<a href="/pedidos" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Listar</span>
											</a>

											<a href="/telasPedido" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Telas de Pedido</span>
											</a>

											<a href="/controleCozinha/selecionar" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Controle de Pedidos</span>
											</a>

											<a href="/mesas" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Mesas</span>
											</a>

											<a href="/pedidos/controleComandas" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Controle de Comandas</span>
											</a>

										</li>
									</ul>
								</div>
							</li>
							@endif

							@if(getenv("DELIVERY") == 1 || getenv("DELIVERY_MERCADO") == 1)

							<li class="menu-item menu-item-submenu menu-item" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<span class="svg-icon menu-icon">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M2.88070511,5.66588911 C5.49624739,3.97895289 8.61140593,3 11.9552112,3 C15.2990164,3 18.4141749,3.97895289 21.0297172,5.66588911 L11.9552112,22 L2.88070511,5.66588911 Z" fill="#000000" opacity="0.3" />
												<circle fill="#000000" opacity="0.3" cx="9.5" cy="9.5" r="1.5" />
												<circle fill="#000000" opacity="0.3" cx="15.5" cy="7.5" r="1.5" />
												<circle fill="#000000" opacity="0.3" cx="12.5" cy="15.5" r="1.5" />
											</g>
										</svg>
									</span>
									<span class="menu-text">Delivery</span>
									<!-- <i class="la la-arrow-down"></i> -->
								</a>
								<div class="menu-submenu " style="" kt-hidden-height="320">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item  menu-item-parent" aria-haspopup="true">
											<span class="menu-link">
												<span class="menu-text"></span>
											</span>
										</li>

										<li class="menu-item  menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
											<a href="/deliveryCategoria" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Categorias</span>
											</a>

											<a href="/deliveryProduto" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Produtos</span>
											</a>

											<a href="/deliveryComplemento" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Adicionais</span>
											</a>

											<a href="/bairrosDelivery" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Bairros</span>
											</a>

											<a href="/motoboys" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Motoboy</span>
											</a>

											<a href="/pedidosDelivery" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Pedidos de Delivery</span>
											</a>

											<a href="/pedidosDelivery/frente" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Frente de Pedido</span>
											</a>

											<a href="/configDelivery" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Configuração</span>
											</a>

											@if(getenv("DELIVERY_MERCADO") == 1)

											<a href="/configMercado" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Configuração de Mercado</span>
											</a>

											@endif

											<a href="/funcionamentoDelivery" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Funcionamento</span>
											</a>

											<a href="/push" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Push</span>
											</a>

											<a href="/tamanhosPizza" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Tamanhos de Pizza</span>
											</a>

											<a href="/clientesDelivery" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Clientes</span>
											</a>

											<a href="/codigoDesconto" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Códigos Promocionais</span>
											</a>

											@if(getenv("DELIVERY_MERCADO") == 1)

											<a href="/bannerTopo" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Banner do Topo</span>
											</a>

											<a href="/bannerMaisVendido" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Banner mais Vendido</span>
											</a>

											@endif

										</li>
									</ul>
								</div>
							</li>
							@endif

							@if(getenv('CTE') == 1)

							<li class="menu-item menu-item-submenu menu-item" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<span class="svg-icon menu-icon">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M8,17 C8.55228475,17 9,17.4477153 9,18 L9,21 C9,21.5522847 8.55228475,22 8,22 L3,22 C2.44771525,22 2,21.5522847 2,21 L2,18 C2,17.4477153 2.44771525,17 3,17 L3,16.5 C3,15.1192881 4.11928813,14 5.5,14 C6.88071187,14 8,15.1192881 8,16.5 L8,17 Z M5.5,15 C4.67157288,15 4,15.6715729 4,16.5 L4,17 L7,17 L7,16.5 C7,15.6715729 6.32842712,15 5.5,15 Z" fill="#000000" opacity="0.3" />
												<path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000" />
											</g>
										</svg>
									</span>
									<span class="menu-text">CT-e</span>
									<!-- <i class="la la-arrow-down"></i> -->
								</a>
								<div class="menu-submenu " style="" kt-hidden-height="320">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item  menu-item-parent" aria-haspopup="true">
											<span class="menu-link">
												<span class="menu-text"></span>
											</span>
										</li>

										<li class="menu-item  menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
											
											<a href="/cte" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Lista</span>
											</a>

											<a href="/cte/nova" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Nova</span>
											</a>

											<a href="/categoriaDespesa" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Categorias</span>
											</a>

										</li>
									</ul>
								</div>
							</li>

							@endif

							@if(getenv('MDFE') == 1)
							<li class="menu-item menu-item-submenu menu-item" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<span class="svg-icon menu-icon">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M16.5428932,17.4571068 L11,11.9142136 L11,4 C11,3.44771525 11.4477153,3 12,3 C12.5522847,3 13,3.44771525 13,4 L13,11.0857864 L17.9571068,16.0428932 L20.1464466,13.8535534 C20.3417088,13.6582912 20.6582912,13.6582912 20.8535534,13.8535534 C20.9473216,13.9473216 21,14.0744985 21,14.2071068 L21,19.5 C21,19.7761424 20.7761424,20 20.5,20 L15.2071068,20 C14.9309644,20 14.7071068,19.7761424 14.7071068,19.5 C14.7071068,19.3673918 14.7597852,19.2402148 14.8535534,19.1464466 L16.5428932,17.4571068 Z" fill="#000000" fill-rule="nonzero" />
												<path d="M7.24478854,17.1447885 L9.2464466,19.1464466 C9.34021479,19.2402148 9.39289321,19.3673918 9.39289321,19.5 C9.39289321,19.7761424 9.16903559,20 8.89289321,20 L3.52893218,20 C3.25278981,20 3.02893218,19.7761424 3.02893218,19.5 L3.02893218,14.136039 C3.02893218,14.0034307 3.0816106,13.8762538 3.17537879,13.7824856 C3.37064094,13.5872234 3.68722343,13.5872234 3.88248557,13.7824856 L5.82567301,15.725673 L8.85405776,13.1631936 L10.1459422,14.6899662 L7.24478854,17.1447885 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
											</g>
										</svg>
									</span>
									<span class="menu-text">MDF-e</span>
									<!-- <i class="la la-arrow-down"></i> -->
								</a>
								<div class="menu-submenu " style="" kt-hidden-height="320">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item  menu-item-parent" aria-haspopup="true">
											<span class="menu-link">
												<span class="menu-text"></span>
											</span>
										</li>

										<li class="menu-item  menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
											<a href="/mdfe" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Lista</span>
											</a>

											<a href="/mdfe/nova" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Nova</span>
											</a>

										</li>
									</ul>
								</div>
							</li>
							@endif

						</ul>
					</div>
				</div>
			</div>
			<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
				<div id="kt_header" class="header  header-fixed">

					<div class="container-fluid  d-flex align-items-stretch justify-content-between">
						<div id="kt_header_menu_wrapper" class="header-menu-wrapper header-menu-wrapper-left">
							<div id="kt_header_menu" class="header-menu header-menu-mobile  header-menu-layout-default ">
								<ul class="menu-nav ">
									<ul class="menu-nav">
										@if(getenv('PEDIDO_LOCAL'))
										<li class="menu-item menu-item-submenu menu-item-rel menu-item-active" data-menu-toggle="click" aria-haspopup="true">
											
											<a href="/pedidos" class="label label-xl label-inline label-light-primary">
												Pedidos Mesa/Comanda: <strong id="pedidos-aberto">x0</strong>
											</a>

										</li>
										@endif

										@if(getenv('DELIVERY'))

										<li class="menu-item menu-item-submenu menu-item-rel menu-item-active" data-menu-toggle="click" aria-haspopup="true">

											<a href="/pedidosDelivery" class="label label-xl label-inline label-light-success">
												Pedidos Delivery: <strong id="pedidos-aberto-delivery">x0</strong>
											</a>
										</li>
										@endif

										<li class="menu-item menu-item-submenu menu-item-rel menu-item-active" data-menu-toggle="click" aria-haspopup="true">
											<a href="/configNF" class="label label-xl label-inline label-light-info">
												Ambiente: {{session('user_logged')['ambiente']}}
											</a>
										</li>

										<li class="menu-item menu-item-submenu menu-item-rel menu-item-active" data-menu-toggle="click" aria-haspopup="true">
											<span class="label label-xl label-inline label-light-danger">
												<i style="color: #111; font-size: 20px;" class="la la-clock"></i>
												<strong id="timer">00:00:00</strong>
											</span>
										</li>
									</ul>


								</ul>
							</div>
						</div>
					</div>

					<div class="topbar">
						<div class="topbar-item">
							<a class="btn btn-light-success" href="/frenteCaixa">PDV</a>
						</div>
						<!--begin: Search -->
						<!--begin: Search -->
						<div class="dropdown">
							<!--begin::Toggle-->
							@if(sizeof($alertas) > 0)
							<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
								<div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse-dark">
									<span class="svg-icon svg-icon-xl svg-icon-danger">
										<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Code/Compiling.svg-->
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24"/>
												<path d="M11.6734943,8.3307728 L14.9993074,6.09979492 L14.1213255,5.22181303 C13.7308012,4.83128874 13.7308012,4.19812376 14.1213255,3.80759947 L15.535539,2.39338591 C15.9260633,2.00286161 16.5592283,2.00286161 16.9497526,2.39338591 L22.6066068,8.05024016 C22.9971311,8.44076445 22.9971311,9.07392943 22.6066068,9.46445372 L21.1923933,10.8786673 C20.801869,11.2691916 20.168704,11.2691916 19.7781797,10.8786673 L18.9002333,10.0007208 L16.6692373,13.3265608 C16.9264145,14.2523264 16.9984943,15.2320236 16.8664372,16.2092466 L16.4344698,19.4058049 C16.360509,19.9531149 15.8568695,20.3368403 15.3095595,20.2628795 C15.0925691,20.2335564 14.8912006,20.1338238 14.7363706,19.9789938 L5.02099894,10.2636221 C4.63047465,9.87309784 4.63047465,9.23993286 5.02099894,8.84940857 C5.17582897,8.69457854 5.37719743,8.59484594 5.59418783,8.56552292 L8.79074617,8.13355557 C9.76799113,8.00149544 10.7477104,8.0735815 11.6734943,8.3307728 Z" fill="#000000"/>
												<polygon fill="#000000" opacity="0.3" transform="translate(7.050253, 17.949747) rotate(-315.000000) translate(-7.050253, -17.949747) " points="5.55025253 13.9497475 5.55025253 19.6640332 7.05025253 21.9497475 8.55025253 19.6640332 8.55025253 13.9497475"/>
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>
									<span class="pulse-ring"></span>
								</div>
							</div>
							@endif
							<!--end::Toggle-->
							<!--begin::Dropdown-->
							<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
								<form>
									<!--begin::Header-->
									<div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top">
										<!--begin::Title-->
										@if(sizeof($alertas) > 0)
										<h4 class="d-flex flex-center rounded-top">
											<span class="text-white">Notificações</span>
											<span class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2">{{sizeof($alertas)}} novas</span>
										</h4>
										@endif
										<!--end::Title-->
										<!--begin::Tabs-->
										
										<!--end::Tabs-->
									</div>
									<!--end::Header-->
									<!--begin::Content-->
									<div class="tab-content">
										<!--begin::Tabpane-->
										<div class="tab-pane active show p-8" id="topbar_notifications_notifications" role="tabpanel">
											<!--begin::Scroll-->
											<div class="scroll pr-7 mr-n7 ps" data-scroll="true" data-height="300" data-mobile-height="200" style="height: 300px; overflow: hidden;">
												<!--begin::Item-->

												<!--end::Item-->
												<!--begin::Item-->
												@if(sizeof($alertas) > 0)
												@foreach($alertas as $a)
												<div class="d-flex align-items-center mb-6">
													<!--begin::Symbol-->
													<a href="{{$a['link']}}">
														@if($a['titulo'] == 'Alerta validade')
														<div class="symbol symbol-40 symbol-light-warning mr-5">
															<span class="symbol-label">
																<span class="svg-icon svg-icon-lg svg-icon-warning">
																	<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Write.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<rect x="0" y="0" width="24" height="24"/>
																			<path d="M22,13.9146471 L22,19 C22,20.1045695 21.1045695,21 20,21 L14,21 C14,19.8954305 13.1045695,19 12,19 C10.8954305,19 10,19.8954305 10,21 L4,21 C2.8954305,21 2,20.1045695 2,19 L2,7 L22,7 L22,11.0853529 C21.8436105,11.0300771 21.6753177,11 21.5,11 C20.6715729,11 20,11.6715729 20,12.5 C20,13.3284271 20.6715729,14 21.5,14 C21.6753177,14 21.8436105,13.9699229 22,13.9146471 Z M9,17 C11.209139,17 13,15.209139 13,13 C13,10.790861 11.209139,9 9,9 C6.790861,9 5,10.790861 5,13 C5,15.209139 6.790861,17 9,17 Z M18,18 C18.5522847,18 19,17.5522847 19,17 C19,16.4477153 18.5522847,16 18,16 C17.4477153,16 17,16.4477153 17,17 C17,17.5522847 17.4477153,18 18,18 Z M5,21 C5.55228475,21 6,20.5522847 6,20 C6,19.4477153 5.55228475,19 5,19 C4.44771525,19 4,19.4477153 4,20 C4,20.5522847 4.44771525,21 5,21 Z" fill="#000000"/>
																			<path d="M19.5954729,5.83476152 L4.60883918,4.07162814 C4.23525261,4.02767678 3.86860536,4.19709197 3.65994764,4.51007855 L2,7 C15.3333333,7 22,7 22,7 C22,7 22,7 22,7 L22,7 C21.352294,6.35229396 20.5051936,5.94178748 19.5954729,5.83476152 Z" fill="#000000" opacity="0.3"/>
																		</g>
																	</svg>
																	<!--end::Svg Icon-->
																</span>
															</span>
														</div>
														@elseif($a['titulo'] == 'Validade próxima')
														<div class="symbol symbol-40 symbol-light-danger mr-5">
															<span class="symbol-label">
																<span class="svg-icon svg-icon-lg svg-icon-danger">
																	<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Write.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<rect x="0" y="0" width="24" height="24"/>
																			<polygon fill="#000000" opacity="0.3" points="12 20.6599888 9.46440699 20.6354368 7.31805655 19.2852462 5.19825383 17.8937466 4.12259707 15.5974894 3.09160702 13.2808335 3.42815736 10.7675551 3.81331204 8.26126488 5.45521712 6.32891335 7.13423264 4.4287182 9.5601992 3.69080156 12 3 14.4398008 3.69080156 16.8657674 4.4287182 18.5447829 6.32891335 20.186688 8.26126488 20.5718426 10.7675551 20.908393 13.2808335 19.8774029 15.5974894 18.8017462 17.8937466 16.6819434 19.2852462 14.535593 20.6354368"/>
																			<circle fill="#000000" opacity="0.3" cx="8.5" cy="13.5" r="1.5"/>
																			<circle fill="#000000" opacity="0.3" cx="13.5" cy="7.5" r="1.5"/>
																			<circle fill="#000000" opacity="0.3" cx="14.5" cy="15.5" r="1.5"/>
																		</g>
																	</svg>
																	<!--end::Svg Icon-->
																</span>
															</span>
														</div>
														@elseif($a['titulo'] == 'Alerta contas')
														<div class="symbol symbol-40 symbol-light-info mr-5">
															<span class="symbol-label">
																<span class="svg-icon svg-icon-lg svg-icon-info">
																	<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Write.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<rect x="0" y="0" width="24" height="24"/>
																			<path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z" fill="#000000" opacity="0.3" transform="translate(11.500000, 12.000000) rotate(-345.000000) translate(-11.500000, -12.000000) "/>
																			<path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z M11.5,14 C12.6045695,14 13.5,13.1045695 13.5,12 C13.5,10.8954305 12.6045695,10 11.5,10 C10.3954305,10 9.5,10.8954305 9.5,12 C9.5,13.1045695 10.3954305,14 11.5,14 Z" fill="#000000"/>
																		</g>
																	</svg>
																	<!--end::Svg Icon-->
																</span>
															</span>
														</div>
														@elseif($a['titulo'] == 'Receber')
														<div class="symbol symbol-40 symbol-light-success mr-5">
															<span class="symbol-label">
																<span class="svg-icon svg-icon-lg svg-icon-success">
																	<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Write.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<rect x="0" y="0" width="24" height="24"/>
																			<path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z" fill="#000000" opacity="0.3" transform="translate(11.500000, 12.000000) rotate(-345.000000) translate(-11.500000, -12.000000) "/>
																			<path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z M11.5,14 C12.6045695,14 13.5,13.1045695 13.5,12 C13.5,10.8954305 12.6045695,10 11.5,10 C10.3954305,10 9.5,10.8954305 9.5,12 C9.5,13.1045695 10.3954305,14 11.5,14 Z" fill="#000000"/>
																		</g>
																	</svg>
																	<!--end::Svg Icon-->
																</span>
															</span>
														</div>
														@elseif($a['titulo'] == 'Alerta estoque')
														<div class="symbol symbol-40 symbol-light-dark mr-5">
															<span class="symbol-label">
																<span class="svg-icon svg-icon-lg svg-icon-dark">
																	<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Write.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<rect x="0" y="0" width="24" height="24"/>
																			<path d="M8,4 C8.55228475,4 9,4.44771525 9,5 L9,17 L18,17 C18.5522847,17 19,17.4477153 19,18 C19,18.5522847 18.5522847,19 18,19 L9,19 C8.44771525,19 8,18.5522847 8,18 C7.44771525,18 7,17.5522847 7,17 L7,6 L5,6 C4.44771525,6 4,5.55228475 4,5 C4,4.44771525 4.44771525,4 5,4 L8,4 Z" fill="#000000" opacity="0.3"/>
																			<rect fill="#000000" opacity="0.3" x="11" y="7" width="8" height="8" rx="4"/>
																			<circle fill="#000000" cx="8" cy="18" r="3"/>
																		</g>
																	</svg>
																	<!--end::Svg Icon-->
																</span>
															</span>
														</div>
														@endif
													</a>
													<!--end::Symbol-->
													<!--begin::Text-->
													
													<div class="d-flex flex-column font-weight-bold">
														<a href="{{$a['link']}}" class="text-dark-75 text-hover-primary mb-1 font-size-lg">{{$a['titulo']}}</a>
														<span class="text-muted">{{$a['msg']}}</span>
													</div>

													<!--end::Text-->
												</div>
												@endforeach
												@endif
												<!--end::Item-->
												<!--begin::Item-->
												
												<!--end::Item-->
												<!--begin::Item-->
												
												<!--end::Item-->
												<!--begin::Item-->
												
												
												<!--begin::Item-->
												
												<!--end::Item-->
												<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
												<!--end::Scroll-->
												<!--begin::Action-->
												
												<!--end::Action-->
											</div>
											<!--end::Tabpane-->
											<!--begin::Tabpane-->
											
											<!--end::Tabpane-->
											<!--begin::Tabpane-->
											<div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
												<!--begin::Nav-->
												<div class="d-flex flex-center text-center text-muted min-h-200px">All caught up! 
													<br>No new notifications.</div>
													<!--end::Nav-->
												</div>
												<!--end::Tabpane-->
											</div>
											<!--end::Content-->
										</form>
									</div>
									<!--end::Dropdown-->
								</div>

								<div class="topbar-item">
									<div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2">
										<span class="kt-header__topbar-welcome kt-hidden-mobile">Olá,</span>
										<span style="margin-left: 3px;" class="kt-header__topbar-username kt-hidden-mobile"> {{session('user_logged')['nome']}}</span>
										<a style="margin-left: 10px;" href="/login/logoff" class="btn btn-danger">Logoff</a>
									</div>
								</div>
							</div>

							<div id="kt_scrolltop" class="scrolltop">
								<span class="svg-icon">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon points="0 0 24 0 24 24 0 24" />
											<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
											<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
										</g>
									</svg>
								</span>
							</div>

						</div>

						<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

							<div id="kt_subheader" class="subheader py-2 py-lg-4  subheader-solid ">

							</div>


							@if(session()->has('mensagem_sucesso'))
							<div class="row" style="background: #fff; height: 120px; margin-top: -25px">
								<div class="container">
									<div class="alert alert-custom alert-success fade show" role="alert" style="margin-top: 10px;">
										<div class="alert-icon"><i class="la la-check"></i></div>
										<div class="alert-text">{{ session()->get('mensagem_sucesso') }}</div>
										<div class="alert-close">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true"><i class="la la-close"></i></span>
											</button>
										</div>
									</div>
								</div>
							</div>
							@endif

							@if(session()->has('mensagem_erro'))
							<div class="row" style="background: #fff; height: 120px; margin-top: -25px">
								<div class="container">
									<div class="alert alert-custom alert-danger fade show" role="alert" style="margin-top: 10px;">
										<div class="alert-icon"><i class="la la-check"></i></div>
										<div class="alert-text">{{ session()->get('mensagem_erro') }}</div>
										<div class="alert-close">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true"><i class="la la-close"></i></span>
											</button>
										</div>
									</div>
								</div>
							</div>

							@endif
							<div style="margin-top: -20px;">
								@yield('content')
							</div>

						</div>


					</div>


				</div>
				<script>var HOST_URL = "/metronic/theme/html/tools/preview";</script>
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
				<script src="/metronic/js/fullcalendar.bundle.js" type="text/javascript"></script>
				<script src="/metronic/js/file.js" type="text/javascript"></script>

				<script src="/metronic/js/wizard.js" type="text/javascript"></script>
				<script src="/metronic/js/user.js" type="text/javascript"></script>



				<script type="text/javascript" src="/js/jquery.mask.min.js"></script>
				<script type="text/javascript" src="/js/mascaras.js"></script>
				<script src="/metronic/js/select2.js" type="text/javascript"></script>
				<script src="/metronic/js/timepicker.js" type="text/javascript"></script>
				<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script> -->
				<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


				<?php $path = getenv('PATH_URL') . "/"; ?>
				<script type="text/javascript">
					const path = "{{$path}}";
					
				</script>

				@if(isset($pessoaFisicaOuJuridica))
				<script type="text/javascript" src="/js/pessoaFisicaOuJuridica.js"></script>
				@endif

				@if(isset($service))
				<script type="text/javascript" src="/js/service.js"></script>
				@endif

				@if(isset($client))
				<script type="text/javascript" src="/js/client.js"></script>
				@endif

				@if(isset($nf))
				<script type="text/javascript" src="/js/nf.js"></script>
				@endif

				@if(isset($fornecedor))
				<script type="text/javascript" src="/js/fornecedor.js"></script>
				@endif

				@if(isset($budget))
				<script type="text/javascript" src="/js/budget.js"></script>
				@endif

				@if(isset($order))
				<script type="text/javascript" src="/js/order.js"></script>
				@endif

				@if(isset($usuarioJs))
				<script type="text/javascript" src="/js/usuario.js"></script>
				@endif

				<script type="text/javascript" src="/js/google-api.js"></script>


				@if(isset($purchase))
				<script type="text/javascript" src="/js/purchase.js"></script>
				@endif

				@if(isset($funcionario))
				<script type="text/javascript" src="/js/funcionario.js"></script>
				@endif

				@if(isset($produtoJs))
				<script type="text/javascript" src="/js/produto.js"></script>
				@endif

				@if(isset($pedidoJs))
				<script type="text/javascript" src="/js/pedido.js"></script>
				@endif

				@if(isset($servicoJs))
				<script type="text/javascript" src="/js/servicos.js"></script>
				@endif

				@if(isset($relatorioJs))
				<script type="text/javascript" src="/js/relatorio.js"></script>
				@endif

				@if(isset($compraFiscalJs))
				<script type="text/javascript" src="/js/compraFiscal.js"></script>
				@endif

				@if(isset($pedidoDeliveryJs))
				<script type="text/javascript" src="/js/pedidoDelivery.js"></script>
				@endif

				@if(isset($cidadeJs))
				<script type="text/javascript" src="/js/cidades.js"></script>
				@endif

				@if(isset($vendaJs))
				<script type="text/javascript" src="/js/venda.js"></script>
				@endif

				@if(isset($creditoVenda))
				<script type="text/javascript" src="/js/creditoVenda.js"></script>
				@endif

				@if(isset($compraManual))
				<script type="text/javascript" src="/js/compraManual.js"></script>
				@endif

				@if(isset($cotacaoJs))
				<script type="text/javascript" src="/js/cotacao.js"></script>
				@endif

				@if(isset($categoriaJs))
				<script type="text/javascript" src="/js/categoria.js"></script>
				@endif

				@if(isset($pushJs))
				<script type="text/javascript" src="/js/push.js"></script>
				@endif

				@if(isset($frenteCaixa))
				<script type="text/javascript" src="/js/frenteCaixa.js"></script>
				@endif

				@if(isset($adicional))
				<script type="text/javascript" src="/js/adicional.js"></script>
				@endif

				@if(isset($cloneJs))
				<script type="text/javascript" src="/js/clone.js"></script>
				@endif

				@if(isset($cteJs))
				<script type="text/javascript" src="/js/cte.js"></script>
				@endif

				@if(isset($cteEnvioJs))
				<script type="text/javascript" src="/js/cte_envio.js"></script>
				@endif

				@if(isset($cozinhaJs))
				<script type="text/javascript" src="/js/cozinha.js"></script>
				@endif

				@if(isset($codigoJs))
				<script type="text/javascript" src="/js/codigo.js"></script>
				@endif

				@if(isset($devolucaoJs))
				<script type="text/javascript" src="/js/devolucao.js"></script>
				@endif

				@if(isset($devolucaoNF))
				<script type="text/javascript" src="/js/devolucaoNF.js"></script>
				@endif

				@if(isset($mdfeJs))
				<script type="text/javascript" src="/js/mdfe.js"></script>
				@endif

				@if(isset($mdfeEnvioJs))
				<script type="text/javascript" src="/js/mdfe_envio.js"></script>
				@endif

				@if(isset($print))
				<script type="text/javascript" src="/js/jQuery.print/jQuery.print.js"></script>
				<script type="text/javascript" src="/js/print.js"></script>
				@endif

				@if(isset($mapJs))
				<script src="https://maps.googleapis.com/maps/api/js?key={{getenv('API_KEY_MAPS')}}"
				async defer></script>
				<script type="text/javascript" src="/js/map.js"></script>
				@endif

				@if(isset($graficoHomeJs)){
				<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
				<script type="text/javascript" src="/js/grafico_home.js"></script>
				@endif

				@if(isset($relatorioJS))
				<script type="text/javascript" src="/js/relatorios.js"></script>
				@endif

				@if(isset($dfeJS))
				<script type="text/javascript" src="/js/dfe.js"></script>
				@endif

				@if(isset($naoEncerradosMDFeJS))
				<script type="text/javascript" src="/js/naoEncerradosMDFe.js"></script>
				@endif

				@if(isset($NFeEntradaJS))
				<script type="text/javascript" src="/js/nfeEntrada.js"></script>
				@endif

				@if(isset($controleHorarioJs))
				<script type="text/javascript" src="/js/controleHorario.js"></script>
				@endif

				@if(isset($frentePedidoDeliveryJs))
				<script type="text/javascript" src="/js/frentePedidoDelivery.js"></script>
				@endif

				@if(isset($frentePedidoDeliveryPedidoJs))
				<script type="text/javascript" src="/js/frentePedidoDeliveryPedido.js"></script>
				@endif

				@if(isset($testeJs))
				<script type="text/javascript" src="/js/teste.js"></script>
				@endif

				@if(isset($bannerJs))
				<script type="text/javascript" src="/js/banner.js"></script>
				@endif

				<script src="/js/lottie-player.js"></script>


				@if(isset($graficoJs))

				<script type="text/javascript" src="/js/grafico.js"></script>
				@endif

				@if(isset($orcamentoJs))
				<script type="text/javascript" src="/js/orcamento.js"></script>
				@endif

				@if(isset($atribuirComandaJs))
				<script type="text/javascript" src="/js/atribuirComandaJs.js"></script>
				@endif

				@if(isset($motoboyEntrega))
				<script type="text/javascript" src="/js/motoboyEntrega.js"></script>
				@endif

				@if(isset($comissaoJs))
				<script type="text/javascript" src="/js/comissao.js"></script>
				@endif

				@if(isset($receberConta))
				<script type="text/javascript" src="/js/receberConta.js"></script>
				@endif

				@if(getenv("GERA_ARQUIVO"))
				<script type="text/javascript" src="/js/geraArquivo.js"></script>
				@endif

				@if(isset($fullcalendar))
				<script src='/fullcalendar/main.js'></script>
				<script src='/fullcalendar/locales/pt-br.js'></script>
				<script src='/js/calendario.js'></script>
				@endif

				<script>

					jQuery(document).ready(function() {
						KTSelect2.init();
						$('.select2-selection__arrow').addClass('select2-selection__arroww')
						
						$('.select2-selection__arrow').removeClass('select2-selection__arrow')
						$('.delivery-arrow').removeClass('select2-selection__arrow')
						// $('.ki ki-arrow-up').addClass('la la-plus')
				// Class definition
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
						// public functions
						init: function() {
							demos();
						}
					};

				}();

				KTBootstrapDatepicker.init(
				{
					format: 'dd/mm/yyyy'
				}
				);

			});


		</script>

		<script type="text/javascript">
			// console.log = function() {}
			var audio = new Audio('/notificacao/s2.mp3');
			var tAnt = 0;
			let s = 0;
			let firstPedidos = true;
			setInterval(() => {
				s = <?php echo session('user_logged') ? session('user_logged')['id'] : 0 ?>;

				if(s > 0){

					$.get(path+'pedidos/emAberto')
					.done((data) => {
						try{
							parseInt(data)
							$('#pedidos-aberto').html('x'+data)
							if(tAnt != data && !firstPedidos){
								if(data > 0 && tAnt <= data) audio.play();

							}

							tAnt = data;
							firstPedidos = false;
						}catch{
							console.log("sessao expirada")
						}

						
					})
					.fail((err) => {
						console.log("erro ao buscar pedidos em aberto")
						console.log(err)
					})
				}
			}, 3000)


			const formatar = (data) => {
				const hora = data.getHours() < 10 ? '0'+data.getHours() : data.getHours();
				const min = data.getMinutes() < 10 ? '0'+data.getMinutes() : data.getMinutes();
				const seg = data.getSeconds() < 10 ? '0'+data.getSeconds() : data.getSeconds();

				return `${hora}:${min}:${seg}`;
			};


			setInterval(() => {
				let hora = formatar(new Date())
				$('#timer').html(hora)
			}, 1000)
		</script>

		<script type="text/javascript">
			var audio2 = new Audio('/notificacao/s1.mp3');
			var pAnt = 0;
			let v = 0;
			let firstDelivery = true;
			setInterval(() => {

				v = <?php echo session('user_logged') ? session('user_logged')['id'] : 0 ?>;

				if(v > 0){
					$.get(path+'pedidosDelivery/emAberto')
					.done((data) => {
						try{
							parseInt(data)
							$('#pedidos-aberto-delivery').html('x'+data)
							if(pAnt != data && !firstDelivery){
								if(data > 0 && pAnt <= data) audio2.play();
							}

							pAnt = data;
							firstDelivery = false;
						}catch{
							console.log("sessao expirada")
						}
					})
					.fail((err) => {
						console.log("erro ao buscar pedidos em aberto delivery")
						console.log(err)
					})
				}

			}, 5000)

		</script>

	</body>
	<!-- end::Body -->

	</html>