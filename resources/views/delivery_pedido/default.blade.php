<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<!DOCTYPE html>
<html>

<head>
	<title>{{$title}}</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords"
	content="Tasty Burger Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!--// Meta tag Keywords -->

	<!-- Custom-Files -->
	<link rel="stylesheet" href="/cssboot/bootstrap.css">
	<!-- Bootstrap-Core-CSS -->
	<link href="/cssboot/css_slider.css" type="text/css" rel="stylesheet" media="all">
	<!-- css slider -->
	<link rel="stylesheet" href="/cssboot/style.css" type="text/css" media="all" />
	<!-- Style-CSS -->
	<link href="/cssboot/font-awesome.min.css" rel="stylesheet">
	@if(isset($carrinho) || isset($historico))
	<link href="/css/delivery.css" rel="stylesheet">
	<link href="/css/card.css" rel="stylesheet">

	@endif

	@if(isset($historico))
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	@endif
	<!-- Font-Awesome-Icons-CSS -->
	<!-- //Custom-Files -->

	<!-- Web-Fonts -->
	<link
	href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext"
	rel="stylesheet">
	<link
	href="//fonts.googleapis.com/css?family=Barlow+Semi+Condensed:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
	rel="stylesheet">

	<style type="text/css">
	.cod{
		width: 40px;
		height: 40px;
		text-align: center;
		margin-left: -5px;
	}
</style>

<!-- Colar OneSignal -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
	window.OneSignal = window.OneSignal || [];
	OneSignal.push(function() {
		OneSignal.init({
			appId: <?php echo getenv('ONE_SIGNAL_APP_ID'); ?>,
		});

	});
</script>

<!-- Fim Colar OneSignal -->


<!-- Manter aqui -->
<script type="text/javascript">
	
	window.OneSignal = window.OneSignal || [];
	OneSignal.push(function() {
		let path = window.location.protocol + '//' + window.location.host
		let user = $('#user').val() ? $('#user').val() : 0;

		OneSignal.getUserId().then(function(userId) {
			let js = {
				user: user,
				token: userId
			}
			console.log(js)
			console.log("OneSignal User ID:", userId);
			$.get(path + '/autenticar/saveTokenWeb', js)
			.done((res) => {
				console.log(res)
			})	
			.fail((err) => {
				console.log(err)
			})		
		});
	});
</script>

<!-- Fim manter aqui -->

<!-- //Web-Fonts -->
</head>

<body>
	<!-- header -->


	<header id="home">
		<!-- top-bar -->
		<div class="top-bar py-2 border-bottom">
			<div class="main-top py-1">
				<div class="container">
					<div class="nav-content">
						<!-- logo -->
						<h1>

							<a id="logo" class="logo" href="/pedido">
								<img src="/images/logo.png" alt="" class="img-fluid">
								<span>{{$config->nomeExib(0)}}</span> {{$config->nomeExib(1)}}

							</a>
						</h1>
						<!-- //logo -->
						<!-- nav -->
						<div class="nav_web-dealingsls">
							<nav>
								<label for="drop" class="toggle">Menu</label>
								<input type="checkbox" id="drop" />
								<ul class="menu">
									<!-- <li><a href="/">INICIO</a></li> -->
									<li><a href="/pedido">CARDÁPIO</a></li>

									<li><a href="/pedido/ver">MEU PEDIDO</a></li>
									<!-- <li><a href="/carrinho/historico">MEUS PEDIDOS</a></li> -->
									<!-- <li><a href="/carrinho/cupons">CUPONS DE DESCONTO</a></li> -->

								</ul>
							</nav>
						</div>
						<!-- //nav -->
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- //top-bar -->

	<!-- header 2 -->
	<!-- navigation -->
	
	<!-- //navigation -->

	@yield('content')


	<!-- //footer -->
	<!-- copyright -->
	<div class="cpy-right text-center py-3">
		<p>© 2020 Slym | Design by
			<a href="http://slymtech.com.br"> SlymTech.</a>
		</p>
	</div>


	<!-- //copyright -->
	<!-- move top icon -->
	<a href="#home" class="move-top text-center">
		<span class="fa fa-level-up" aria-hidden="true"></span>
	</a>
	<!-- //move top icon -->

	<?php $path = getenv('PATH_URL')."/";?>
	<script type="text/javascript">
		const path = "{{$path}}";
	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	@if(isset($historico))
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

	@else

	<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/js/jquery.mask.min.js"></script>

	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script type="text/javascript">

		$('#quantidade').mask('00', {reverse: true});
		$('#telefone').mask('00 00000-0000', {reverse: true});
		$(".qtd").mask('00', {reverse: true});
		$('#troco_para').mask('000000,00', {reverse: true});
		$('#cod1').mask('0', {reverse: true});
		$('#cod2').mask('0', {reverse: true});
		$('#cod3').mask('0', {reverse: true});
		$('#cod4').mask('0', {reverse: true});
		$('#cod5').mask('0', {reverse: true});
		$('#cod6').mask('0', {reverse: true});
		$('#cpf').mask('000.000.000-00', {reverse: true});


	</script>


	@endif

	@if(isset($acompanhamento))
	<script src="/jsd_pedido/acompanhamento.js" type="text/javascript"></script>
	@endif

	@if(isset($acompanhamentoPizza))
	<script src="/jsd_pedido/acompanhamentoPizza.js" type="text/javascript"></script>
	@endif

	@if(isset($carrinho))
	<script src="/jsd_pedido/carrinho.js" type="text/javascript"></script>
	@endif

	@if(isset($forma_pagamento))
	<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
	<script src="/jsd_pedido/card.js" type="text/javascript"></script>
	<script src="/jsd_pedido/forma_pagamento.js" type="text/javascript"></script>

	<script type="text/javascript">

		new Card({
			form: document.querySelector('form'),
			container: '.card-wrapper',
			width: 300,
			placeholders: {
				number: '•••• •••• •••• ••••',
				name: 'Nome Completo',
				expiry: '••/••••',
				cvc: 'CVC'
			},
			debug: true,
			formSelectors: {
				numberInput: 'input#number', 
				expiryInput: 'input#validade', 
				cvcInput: 'input#cvc', 
				nameInput: 'input#nome' 
			},
		});

	</script>
	@endif

	<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
	@if(isset($cadastro_ative))
	<script src="/jsd_pedido/cadastro_ative.js" type="text/javascript"></script>
	@endif

	@if(isset($pizzaJs))
	<script src="/jsd_pedido/pizza.js" type="text/javascript"></script>
	@endif

	@if(isset($login_ative))
	<script src="/jsd_pedido/login_ative.js" type="text/javascript"></script>
	@endif

	@if(isset($mapaJs))
	<script src="https://maps.googleapis.com/maps/api/js?key={{getenv('API_KEY_MAPS')}}"
	async defer></script>
	@endif

	@if(isset($tokenJs))
	<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-app.js"></script>

	@endif

	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>

	@if(session()->has('message_sucesso_swal'))
	<script type="text/javascript">
		swal('Sucesso!', '<?php echo session()->get('message_sucesso_swal') ?>', 'success');
	</script>
	@endif
</body>

</html>