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

	@if(isset($fullcalendar))
	<link href='/fullcalendar/main.css' rel='stylesheet' />
	@endif
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
							@if(session('user_logged')['super'] == 1)
							<li class="menu-item menu-item-submenu menu-item" aria-haspopup="true" data-menu-toggle="hover">
								<a style="background: #F3933D" href="javascript:;" class="menu-link menu-toggle">
									<span class="svg-icon menu-icon">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12,18 L7.91561963,20.1472858 C7.42677504,20.4042866 6.82214789,20.2163401 6.56514708,19.7274955 C6.46280801,19.5328351 6.42749334,19.309867 6.46467018,19.0931094 L7.24471742,14.545085 L3.94038429,11.3241562 C3.54490071,10.938655 3.5368084,10.3055417 3.92230962,9.91005817 C4.07581822,9.75257453 4.27696063,9.65008735 4.49459766,9.61846284 L9.06107374,8.95491503 L11.1032639,4.81698575 C11.3476862,4.32173209 11.9473121,4.11839309 12.4425657,4.36281539 C12.6397783,4.46014562 12.7994058,4.61977315 12.8967361,4.81698575 L14.9389263,8.95491503 L19.5054023,9.61846284 C20.0519472,9.69788046 20.4306287,10.2053233 20.351211,10.7518682 C20.3195865,10.9695052 20.2170993,11.1706476 20.0596157,11.3241562 L16.7552826,14.545085 L17.5353298,19.0931094 C17.6286908,19.6374458 17.263103,20.1544017 16.7187666,20.2477627 C16.5020089,20.2849396 16.2790408,20.2496249 16.0843804,20.1472858 L12,18 Z" fill="#000000"/>
											</g>
										</svg>
									</span>
									<span class="menu-text text-light">SUPER</span>
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
											<a href="/empresas" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Empresas</span>
											</a>

										</li>

										<li class="menu-item  menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
											<a href="/planos" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">Planos</span>
											</a>

										</li>
									</ul>
								</div>
							</li>
							@endif

							@foreach($menu as $m)

							<li class="menu-item menu-item-submenu menu-item @if($rotaAtiva == $m['titulo']) menu-item-active @endif" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									{!! $m['icone'] !!}
									<span class="menu-text">{{$m['titulo']}}</span>
									
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

											@foreach($m['subs'] as $i)
											<a href="{{$i['rota']}}" class="menu-link menu-">
												<i class="menu-bullet menu-bullet-line">
													<span>

													</span>
												</i>
												<span class="menu-text">{{$i['nome']}}</span>
											</a>
											@endforeach

										</li>
									</ul>
								</div>
							</li>

							@endforeach

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

											<a href="/controleCozinha" class="menu-link menu-">
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
										<!-- <li class="menu-item menu-item-submenu menu-item-rel menu-item-active" data-menu-toggle="click" aria-haspopup="true">
											
											<a href="/pedidos" class="label label-xl label-inline label-light-primary">
												Pedidos Mesa/Comanda: <strong id="pedidos-aberto">x0</strong>
											</a>

										</li> -->
										<li class="menu-item menu-item-submenu menu-item-rel menu-item-active" data-menu-toggle="click" aria-haspopup="true">
											<a href="/configNF" class="label label-xl label-inline label-light-success">
												Empresa: {{session('user_logged')['empresa_nome']}}
											</a>
										</li>

										<li class="menu-item menu-item-submenu menu-item-rel menu-item-active" data-menu-toggle="click" aria-haspopup="true">
											<a href="/configNF" class="label label-xl label-inline label-light-info">
												Ambiente: {{session('user_logged')['ambiente']}}
											</a>
										</li>

										<li class="menu-item menu-item-submenu menu-item-rel menu-item-active" data-menu-toggle="click" aria-haspopup="true">
											<span class="label label-xl label-inline label-light-danger">
												<i style="color: #111; font-size: 20px;" class="fa fa-clock"></i>
												<strong id="timer" style="margin-left: 5px;">00:00:00</strong>
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
										<span style="margin-left: 3px; width: 1005" class="kt-header__topbar-username kt-hidden-mobile"> <span style="font-weight: bold;" class="text-info text-left">{{session('user_logged')['nome']}}</span></span>
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

				@if(isset($empresaJs))
				<script type="text/javascript" src="/js/empresa.js"></script>
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
			var audio = new Audio('/notificacao/s2.mp3');
			var tAnt = 0;
			let s = 0;
			let firstPedidos = true;
			// setInterval(() => {
			// 	s = <?php echo session('user_logged') ? session('user_logged')['id'] : 0 ?>;

			// 	if(s > 0){

			// 		$.get(path+'pedidos/emAberto')
			// 		.done((data) => {
			// 			$('#pedidos-aberto').html('x'+data)
			// 			if(tAnt != data && !firstPedidos){
			// 				if(data > 0 && tAnt <= data) audio.play();

			// 			}

			// 			tAnt = data;
			// 			firstPedidos = false;


			// 		})
			// 		.fail((err) => {
			// 			console.log("erro ao buscar pedidos em aberto")
			// 			console.log(err)
			// 		})
			// 	}
			// }, 3000)


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
			// setInterval(() => {

			// 	v = <?php echo session('user_logged') ? session('user_logged')['id'] : 0 ?>;

			// 	if(v > 0){
			// 		$.get(path+'pedidosDelivery/emAberto')
			// 		.done((data) => {

			// 			$('#pedidos-aberto-delivery').html('x'+data)
			// 			if(pAnt != data && !firstDelivery){
			// 				if(data > 0 && pAnt <= data) audio2.play();
			// 			}

			// 			pAnt = data;
			// 			firstDelivery = false;

			// 		})
			// 		.fail((err) => {
			// 			console.log("erro ao buscar pedidos em aberto delivery")
			// 			console.log(err)
			// 		})
			// 	}

			// }, 5000)

			var w = window.innerWidth
			setTimeout(() => {
				if(w < 900){
					$('#grade').trigger('click')
				}
			}, 500)

		</script>

	</body>
	<!-- end::Body -->

	</html>