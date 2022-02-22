<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>{{ $title }}</title>
	<link href="/css/material-icons.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/materialize.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link
	href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap"
	rel="stylesheet"
	/>
	

	<link rel="stylesheet" href="../../css/style.css">
</head>
<body>
	
	<nav class="navbar">
		<ul class="navbar-nav accordion" id="accordion" >
			<li class="logo">
				<a href="#" class="nav-link">
					<span class="link-text logo-text">
						<img style="margin-top: 15px; width: 120px" src="../../imgs/slym.png">
					</span>
					<svg
					aria-hidden="true"
					focusable="false"
					data-prefix="fad"
					data-icon="angle-double-right"
					role="img"
					xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 448 512"
					class="svg-inline--fa fa-angle-double-right fa-w-14 fa-5x"
					>
					<g class="fa-group">
						<path
						fill="currentColor"
						d="M224 273L88.37 409a23.78 23.78 0 0 1-33.8 0L32 386.36a23.94 23.94 0 0 1 0-33.89l96.13-96.37L32 159.73a23.94 23.94 0 0 1 0-33.89l22.44-22.79a23.78 23.78 0 0 1 33.8 0L223.88 239a23.94 23.94 0 0 1 .1 34z"
						class="fa-secondary"
						></path>
						<path
						fill="currentColor"
						d="M415.89 273L280.34 409a23.77 23.77 0 0 1-33.79 0L224 386.26a23.94 23.94 0 0 1 0-33.89L320.11 256l-96-96.47a23.94 23.94 0 0 1 0-33.89l22.52-22.59a23.77 23.77 0 0 1 33.79 0L416 239a24 24 0 0 1-.11 34z"
						class="fa-primary"
						></path>
					</g>
				</svg>
			</a>
		</li>

		<li class="nav-item">
			<div class="link"><a href="#" class="nav-link">
				<i class="material-icons right black-text">assignment</i>
				<span style="margin-left: 50px;">Cadastros</span>
			</a></div>
			<ul class="submenu"> 
				<li><a href="/categorias"><span class="left material-icons">radio_button_unchecked</span>Categorias</a></li>
				<li><a href="/produtos"><span class="left material-icons">radio_button_unchecked</span>Produtos</a></li>
				<li><a href="/clientes"><span class="left material-icons">radio_button_unchecked</span>Clientes</a></li>
				<li><a href="/fornecedores"><span class="left material-icons">radio_button_unchecked</span>Fornecedores</a></li>
				<li><a href="/transportadoras"><span class="left material-icons">radio_button_unchecked</span>Transportadoras</a></li>
				<li><a href="/funcionarios"><span class="left material-icons">radio_button_unchecked</span>Funcionarios</a></li>

				<li><a href="/categoriasServico"><span class="left material-icons">radio_button_unchecked</span>Categorias de Serviços</a></li>
				<li><a href="/categoriasConta"><span class="left material-icons">radio_button_unchecked</span>Categorias de Conta</a></li>
				<li><a href="/servicos"><span class="left material-icons">radio_button_unchecked</span>Serviços</a></li>
				<li><a href="/veiculos"><span class="left material-icons">radio_button_unchecked</span>Veiculos</a></li>
				<li><a href="/usuarios"><span class="left material-icons">radio_button_unchecked</span>Usuarios</a></li>
			</ul> 
		</li>

		<li class="nav-item">
			<div class="link"><a href="#" class="nav-link">
				<i class="material-icons right black-text">more</i>
				<span style="margin-left: 50px;">Entradas</span>
			</a></div>
			<ul class="submenu"> 
				<li><a href="/compraFiscal"><span class="left material-icons">radio_button_unchecked</span>Compra Fiscal</a></li>
				<li><a href="/compraManual"><span class="left material-icons">radio_button_unchecked</span>Compra Manual</a></li>
				<li><a href="/compras"><span class="left material-icons">radio_button_unchecked</span>Manter</a></li>
				<li><a href="/cotacao"><span class="left material-icons">radio_button_unchecked</span>Cotação</a></li>
			</ul> 
		</li>

		<li class="nav-item">
			<div class="link"><a href="#" class="nav-link">
				<i class="material-icons right black-text">inbox</i>
				<span style="margin-left: 50px;">Estoque</span>
			</a></div>
			<ul class="submenu"> 
				<li><a href="/estoque"><span class="left material-icons">radio_button_unchecked</span>Manter</a></li>
				<li><a href="/estoque/apontamentoProducao"><span class="left material-icons">radio_button_unchecked</span>Apontameto de Produçao</a></li>
			</ul> 
		</li>

		<li class="nav-item">
			<div class="link"><a href="#" class="nav-link">
				<i class="material-icons right black-text">layers</i>
				<span style="margin-left: 50px;">Financeiro</span>
			</a></div>
			<ul class="submenu"> 
				<li><a href="/contasPagar"><span class="left material-icons">radio_button_unchecked</span>Contas a Pagar</a></li>
				<li><a href="/contasReceber"><span class="left material-icons">radio_button_unchecked</span>Contas a Receber</a></li>
				<li><a href="/fluxoCaixa"><span class="left material-icons">radio_button_unchecked</span>Fluxo de Caixa</a></li>
				<li><a href="/graficos"><span class="left material-icons">radio_button_unchecked</span>Gráfico</a></li>
			</ul> 
		</li>

		<li class="nav-item">
			<div class="link"><a href="#" class="nav-link">
				<i class="material-icons right black-text">format_quote</i>
				<span style="margin-left: 50px;">Fiscal</span>
			</a></div>
			<ul class="submenu"> 
				<li><a href="/configNF"><span class="left material-icons">radio_button_unchecked</span>Configurar Emitente</a></li>
				<li><a href="/escritorio"><span class="left material-icons">radio_button_unchecked</span>Configurar Escritório</a></li>
				<li><a href="/naturezaOperacao"><span class="left material-icons">radio_button_unchecked</span>Natureza de Operação</a></li>
				<li><a href="/tributos"><span class="left material-icons">radio_button_unchecked</span>Tributação</a></li>
				<li><a href="/enviarXml"><span class="left material-icons">radio_button_unchecked</span>Enviar XML</a></li>
			</ul> 
		</li>

		<li class="nav-item">
			<div class="link"><a href="#" class="nav-link">
				<i class="material-icons right black-text">class</i>
				<span style="margin-left: 50px;">Saidas</span>
			</a></div>
			<ul class="submenu"> 
				<li><a href="/ordemServico"><span class="left material-icons">radio_button_unchecked</span>Ordem de Serviço</a></li>
				<li><a href="/frenteCaixa#autocomplete-cliente"><span class="left material-icons">radio_button_unchecked</span>Frente de Caixa</a></li>
				<!-- <li><a href="/orcamentos">Orçamento</a></li> -->
				<li><a href="/vendas/lista"><span class="left material-icons">radio_button_unchecked</span>Vendas</a></li>
				<li><a href="/vendas/nova"><span class="left material-icons">radio_button_unchecked</span>Nova Venda</a></li>

				<li><a href="/vendasEmCredito"><span class="left material-icons">radio_button_unchecked</span>Conta Crédito</a></li>
				<li><a href="/devolucao"><span class="left material-icons">radio_button_unchecked</span>Devolução</a></li>
			</ul> 
		</li>

		<li class="nav-item">
			<div class="link"><a href="#" class="nav-link">
				<i class="material-icons right black-text">devices</i>
				<span style="margin-left: 50px;">Pedidos</span>
			</a></div>
			<ul class="submenu">
				<li><a href="/pedidos"><span class="left material-icons">radio_button_unchecked</span>Listar</a></li>
				<li><a href="/controleCozinha"><span class="left material-icons">radio_button_unchecked</span>Controle de Pedidos</a></li>

			</ul> 
		</li>

		<li class="nav-item">
			<div class="link"><a href="#" class="nav-link">
				<i class="material-icons right black-text">local_shipping</i>
				<span style="margin-left: 50px;">Delivery</span>
			</a></div>
			<ul class="submenu"> 
				
				<li><a href="/deliveryCategoria"><span class="left material-icons">radio_button_unchecked</span>Categorias</a></li>
				<li><a href="/deliveryProduto"><span class="left material-icons">radio_button_unchecked</span>Produtos</a></li>
				<li><a href="/deliveryComplemento"><span class="left material-icons">radio_button_unchecked</span>Adicionais</a></li>
				<li><a href="/pedidosDelivery"><span class="left material-icons">radio_button_unchecked</span>Pedidos de Delivery</a></li>
				<li><a href="/configDelivery"><span class="left material-icons">radio_button_unchecked</span>Configuração</a></li>
				<li><a href="/funcionamentoDelivery"><span class="left material-icons">radio_button_unchecked</span>Funcionamento</a></li>
				<li><a href="/push"><span class="left material-icons">radio_button_unchecked</span>Push</a></li>
				<li><a href="/tamanhosPizza"><span class="left material-icons">radio_button_unchecked</span>Tamanhos de Pizza</a></li>
				<li><a href="/clientesDelivery"><span class="left material-icons">radio_button_unchecked</span>Clientes</a></li>
				<li><a href="/codigoDesconto"><span class="left material-icons">radio_button_unchecked</span>Códigos Promocionais</a></li>
			</ul> 
		</li>


		<li class="nav-item">
			<div class="link"><a href="#" class="nav-link">
				<i class="material-icons right black-text">directions_bus</i>
				<span style="margin-left: 50px;">CT-e</span>
			</a></div>
			<ul class="submenu"> 
				<li><a href="/ordemServico"><span class="left material-icons">radio_button_unchecked</span>Ordem de Serviço</a></li>
				<li><a href="/categoriaDespesa"><span class="left material-icons">radio_button_unchecked</span>Categorias</a></li>
				<li><a href="/cte"><span class="left material-icons">radio_button_unchecked</span>Lista</a></li>
				<li><a href="/cte/nova"><span class="left material-icons">radio_button_unchecked</span>Nova</a></li>
				<li><a href="/categoriaDespesa"><span class="left material-icons">radio_button_unchecked</span>Categorias de Despesa</a></li>

			</ul> 
		</li>

		<li class="nav-item">
			<div class="link"><a href="#" class="nav-link">
				<i class="material-icons right black-text">directions</i>
				<span style="margin-left: 50px;">MDF-e</span>
			</a></div>
			<ul class="submenu"> 
				<li><a href="/mdfe"><span class="left material-icons">radio_button_unchecked</span>Lista</a></li>
				<li><a href="/mdfe/nova"><span class="left material-icons">radio_button_unchecked</span>Nova</a></li>

			</ul> 
		</li>



	</ul>
</nav>


<div class="row space black" style="margin-top: 0">
	<div class="col s6" style="margin-top: 5px;">
		<i style="margin-top: 5px;" class="material-icons white-text left">local_pizza</i>
		<h6 class="white-text">Pedidos Mesa/Comanda: <strong class="pedidos-aberto" id="pedidos-aberto">x0</strong></h6>
	</div>
	<div class="col s6" style="margin-top: 5px;">
		<i style="margin-top: 5px;" class="material-icons white-text left">local_pizza</i>
		<h6 class="white-text">Pedidos Delivery: <strong class="pedidos-aberto" id="pedidos-aberto-delivery">x0</strong></h6>
	</div>
</div>
<!-- FIM MENU -->
<div class="space">
	@yield('content')
</div>

<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
<script src="/js/materialize.min.js"></script>
<script type="text/javascript" src="/js/init.js"></script>

<script type="text/javascript" src="/js/jquery.mask.min.js"></script>
<script type="text/javascript" src="/js/mascaras.js"></script>

<?php $path = getenv('PATH_URL')."/";?>
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

<script type="text/javascript" src="https://www.google.com/jsapi"></script>


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

@if(isset($testeJs))
<script type="text/javascript" src="/js/teste.js"></script>
@endif

@if(isset($mapJs))
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqDmzire4loEp5mlUxhz6VCdT0rzgN56U"
async defer></script>
<script type="text/javascript" src="/js/map.js"></script>
@endif

@if(isset($graficoHomeJs)){
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
	
	<script type="text/javascript" src="/js/grafico_home.js"></script>
@endif



<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>


@if(isset($graficoJs))

<script type="text/javascript" src="/js/grafico.js"></script>
@endif



<script type="text/javascript">
	var audio = new Audio('/notificacao/s2.mp3');
	var tAnt = 0;
	let s = 0;
	let firstPedidos = true;
	setInterval(() => {
		s = <?php echo session('user_logged') ? session('user_logged')['id'] : 0 ?>;

		if(s > 0){

			$.get(path+'pedidos/emAberto')
			.done((data) => {
				$('#pedidos-aberto').html('x'+data)
				if(tAnt != data && !firstPedidos){
					if(data > 0 && tAnt <= data) audio.play();

				}

				tAnt = data;
				firstPedidos = false;


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

				$('#pedidos-aberto-delivery').html('x'+data)
				if(pAnt != data && !firstDelivery){
					if(data > 0 && pAnt <= data) audio2.play();
				}

				pAnt = data;
				firstDelivery = false;

			})
			.fail((err) => {
				console.log("erro ao buscar pedidos em aberto delivery")
				console.log(err)
			})
		}

	}, 5000)

</script>


<script type="text/javascript">



	$('#ver-senha').click(() => {
		let tp = $('#senha-view').is("[type=text]");
		if(!tp) $('#senha-view').prop('type', 'text');
		else $('#senha-view').prop('type', 'password');
	});

	$( "nav" ).hover(
		function() {
			$('.nav-link span').css('display', 'block')
			$('.submenu').css('display', 'none')
			$('.navbar').css('overflow-y', 'visible')
		}, function() {
			$('.nav-link span').css('display', 'none')
			$('.submenu').css('display', 'none')
			$('.navbar').css('overflow-y', 'hidden')

		}
		)

	$(function() {


		var Accordion = function(el, multiple) {
			this.el = el || {};
			this.multiple = multiple || false;

			var links = this.el.find('.link');

			links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
		}

		Accordion.prototype.dropdown = function(e) {
			var $el = e.data.el;
			$this = $(this),
			$next = $this.next();

			$next.slideToggle();
			$this.parent().toggleClass('open');

			if (!e.data.multiple) {
				$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
			};
		}	

		var accordion = new Accordion($('#accordion'), false);
	});

	const themeMap = {
		dark: "light",
		light: "solar",
		solar: "dark"
	};

	const theme = localStorage.getItem('theme')
	|| (tmp = Object.keys(themeMap)[0],
		localStorage.setItem('theme', tmp),
		tmp);
	const bodyClass = document.body.classList;
	bodyClass.add(theme);

	function toggleTheme() {
		const current = localStorage.getItem('theme');
		const next = themeMap[current];

		bodyClass.replace(current, next);
		localStorage.setItem('theme', next);
	}
	document.getElementById('themeButton').onclick = toggleTheme;


	
</script>


<?php 
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
if(getenv('PATH_URL') != $protocol.$_SERVER['HTTP_HOST']){
	echo "<script type='text/javascript'>alert('Por favor configure a variavel PATH_URL dp arquivo .env corretamente')</script>";
}

?>

<br><br>

<footer class="page-footer black space">
	<label class="info-user right white-text">
		Usuário: <strong class="blue-text">{{ session('user_logged')['nome']}} </strong> 
		| <a class="red-text" href="/login/logoff">Sair</a></label>
		<span class="green-text text-accent-3" style="margin-left: 10px;"><i class="material-icons">timer</i><strong id="timer">00:00:00</strong></span>
		

	</footer>
</body>
</html>