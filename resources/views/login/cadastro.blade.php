<!DOCTYPE html>

<html lang="br">
<!-- begin::Head -->

<head>
	<meta charset="utf-8" />

	<title>Cadastre-se</title>
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
	</style>
</head>


<!-- end::Head -->

<!-- begin::Body -->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">


	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
		<div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
			<!--begin::Aside-->
			<div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
				<!--begin: Aside Container-->
				<div class="d-flex flex-column-fluid flex-column justify-content-between py-12 col-12 py-lg-12 px-lg-35">
					<!--begin::Logo-->
					
					<!--end::Logo-->
					<!--begin::Aside body-->
					<div class="d-flex flex-column-fluid flex-column" >
						<a href="#" class="text-center pt-2">
							<img src="/imgs/slym2.png" class="max-h-200px" alt="" />
						</a>
						<!--begin::Signin-->
						<div class="login-form login-signin py-2">
							<!--begin::Form-->

							<form method="post" class="form" novalidate="novalidate" id="kt_login_signin_form">
								@csrf
								<!--begin::Title-->
								<div class="text-center pb-8">
									<h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Dados da sua Empresa</h2>

								</div>

								@if(session()->has('mensagem_erro'))
								<span style="width: 100%;" class="label label-xl label-inline label-light-danger">{{ session()->get('mensagem_erro') }}</span>
								@endif


								<!--end::Title-->
								<!--begin::Form group-->
								<div class="row">
									<div class="form-group col-9 col-lg-8">
										<label class="font-size-h6 font-weight-bolder text-dark">CNPJ</label>
										<input name="cnpj" id="cnpj" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg @if($errors->has('cnpj')) is-invalid @endif" type="text" autocomplete="off" value="{{old('cnpj')}}"/>
										@if($errors->has('cnpj'))
										<span class="text-danger">
											{{ $errors->first('cnpj') }}
										</span>
										@endif
									</div>
									<div class="form-group col-2 col-lg-4" style="margin-top: 35px;">
										<button id="consulta" style="margin-left: -15px;" id="kt_login_signin_submit" class="btn btn-success font-weight-bolder font-size-h1 px-10 spinner-white spinner-right" type="button">
											<i class="la la-search"></i>
										</button>
									</div>

								</div>
								<div class="row">
									<!--end::Form group-->
									<!--begin::Form group-->
									<div class="form-group col-12 col-lg-6">
										<label class="font-size-h6 font-weight-bolder text-dark">Nome da Empresa</label>
										<input name="nome_empresa" id="nome_empresa" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg @if($errors->has('nome_empresa')) is-invalid @endif" type="text" autocomplete="off" value="{{old('nome_empresa')}}"/>
										@if($errors->has('nome_empresa'))
										<span class="text-danger">
											{{ $errors->first('nome_empresa') }}
										</span>
										@endif
									</div>
									<div class="form-group col-12 col-lg-6">
										<div class="d-flex justify-content-between mt-n5">
											<label class="font-size-h6 font-weight-bolder text-dark pt-5">Telefone</label>

										</div>
										<input name="telefone" id="telefone" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg telefone @if($errors->has('telefone')) is-invalid @endif" value="{{old('telefone')}}" type="text" autocomplete="off" />
										@if($errors->has('telefone'))
										<span class="text-danger">
											{{ $errors->first('telefone') }}
										</span>
										@endif
									</div>
								</div>
								<div class="row">
									<div class="form-group col-12 col-lg-6">
										<div class="d-flex justify-content-between mt-n5">
											<label class="font-size-h6 font-weight-bolder text-dark pt-5">Cidade</label>

										</div>
										<input name="cidade" id="cidade" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg @if($errors->has('cidade')) is-invalid @endif" type="text" name="text" autocomplete="off" value="{{old('cidade')}}"/>
										@if($errors->has('cidade'))
										<span class="text-danger">
											{{ $errors->first('cidade') }}
										</span>
										@endif
									</div>

									<div class="form-group col-12 col-lg-6">
										<div class="d-flex justify-content-between mt-n5">
											<label class="font-size-h6 font-weight-bolder text-dark pt-5">Email</label>

										</div>
										<input name="email" id="email" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg @if($errors->has('email')) is-invalid @endif" type="email" name="text" autocomplete="off" value="{{old('email')}}"/>
										@if($errors->has('email'))
										<span class="text-danger">
											{{ $errors->first('email') }}
										</span>
										@endif
									</div>
								</div>

								<div class="row">
									<div class="form-group col-12 col-lg-6">
										<div class="d-flex justify-content-between mt-n5">
											<label class="font-size-h6 font-weight-bolder text-dark pt-5">
											Usuário</label>

										</div>
										<input name="login" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg @if($errors->has('login')) is-invalid @endif" type="text" name="text" autocomplete="off" value="{{old('login')}}"/>
										@if($errors->has('login'))
										<span class="text-danger">
											{{ $errors->first('login') }}
										</span>
										@endif
									</div>

									<div class="form-group col-12 col-lg-6">
										<div class="d-flex justify-content-between mt-n5">
											<label class="font-size-h6 font-weight-bolder text-dark pt-5">
											Senha</label>

										</div>
										<input name="senha" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg @if($errors->has('senha')) is-invalid @endif" type="password" name="text" autocomplete="off" value="{{old('senha')}}"/>
										@if($errors->has('senha'))
										<span class="text-danger">
											{{ $errors->first('senha') }}
										</span>
										@endif
									</div>
								</div>

								@if(session()->has('mensagem_login'))
								<p class="text-danger">{{ session()->get('mensagem_login') }}</p>
								@endif

								<!--end::Form group-->
								<!--begin::Action-->
								<div class="text-center pt-2">
									<button id="kt_login_signin_submit" class="btn btn-dark font-weight-bolder font-size-h6 px-8 py-4 my-3 btn-block">CADASTRAR</button>
								</div>

								<a href="/login">Já sou cadastrado</a>

								<!--end::Action-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Signin-->
						<!--begin::Signup-->

						<!--end::Signup-->
						<!--begin::Forgot-->
						<div class="login-form login-forgot pt-11">
							<!--begin::Form-->
							<a target="_blank" class="txt2" href="http://wa.me/55{{getenv('RESP_FONE')}}">
								<i class="fa fa-whatsapp" aria-hidden="true"></i>
								Suporte {{getenv("RESP_FONE")}}

							</a>
							<!--end::Form-->
						</div>
						<!--end::Forgot-->
					</div>
					<!--end::Aside body-->

					<!--end: Aside footer for desktop-->
				</div>
				<!--end: Aside Container-->
			</div>
			<!--begin::Aside-->
			<!--begin::Content-->
			<div class="content order-1 order-lg-2 d-flex flex-column w-100 pb-0" style="background-color: #FFF;">
				<!--begin::Title-->
				<!--end::Title-->
				<!--begin::Image-->
				<div class="content-img flex-row-fluid bgi-no-repeat bgi-position-x-center" style="background-image: url(/imgs/login2.png); margin-top: 120px;"></div>
				<!--end::Image-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Login-->
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
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script> -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


	<script>
		jQuery(document).ready(function() {
			KTSelect2.init();
			$('.select2-selection__arrow').addClass('select2-selection__arroww')

			$('.select2-selection__arrow').removeClass('select2-selection__arrow')
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
			$('#consulta').click(() => {
				$('#consulta').addClass('spinner');
				let cnpj = $('#cnpj').val();

				cnpj = cnpj.replace('.', '');
				cnpj = cnpj.replace('.', '');
				cnpj = cnpj.replace('-', '');
				cnpj = cnpj.replace('/', '');

				if(cnpj.length == 14){

					$.ajax({

						url: 'https://www.receitaws.com.br/v1/cnpj/'+cnpj, 
						type: 'GET', 
						crossDomain: true, 
						dataType: 'jsonp', 
						success: function(data) 
						{ 
							$('#consulta').removeClass('spinner');
							console.log(data);
							if(data.status == "ERROR"){
								swal(data.message, "", "error")
							}else{
								$('#nome_empresa').val(data.nome)
								$('#telefone').val(data.telefone.replace("(", "").replace(")", ""))
								$('#cidade').val(data.municipio)
								$('#email').val(data.email)

							}

						}, 
						error: function(e) { 
							$('#consulta').removeClass('spinner');
							console.log(e)
							swal("Alerta", "Nenhum retorno encontrado para este CNPJ, informe manualmente por gentileza", "warning")

						},
					});
				}else{
					swal("Alerta", "Informe corretamente o CNPJ", "warning")
				}
			})
		</script>

	</body>
	<!-- end::Body -->

	</html>