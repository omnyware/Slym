@extends('delivery.default')
@section('content')

<style type="text/css">

.pulsate {
	-webkit-animation: pulsate 3s ease-out;
	-webkit-animation-iteration-count: infinite; 
	opacity: 0.5;
}
@-webkit-keyframes pulsate {
	0% { 
		opacity: 0.5;
	}
	50% { 
		opacity: 1.0;
	}
	100% { 
		opacity: 0.5;
	}
}
#map{
	width: 100%;
	height: 500px;
	background: #999;
}

.margin{
	margin-top: 10px;
}



@media only screen and (max-width: 400px) {
	#endereco-modal{
		width: 100%; height: 100%; margin-left: 0px;
	}

	.modal-body { height: 500px; margin-left: 0px;}
	.popup{
		margin-left: 0px;
	}
}
@media only screen and (min-width: 401px) and (max-width: 1699px){
	#endereco-modal{
		width: 100%;
	}

	.modal-body{
		height: 600px;
		overflow-y: auto;
		width: 380px;
		margin-left: 0px;

	}

}


</style>



<div class="row" id="anime" style="display: none;">
	<div class="col s8 offset-s2">
		<lottie-player 
		src="/anime/finish{{rand(1,4)}}.json" background="transparent"  speed="0.8"  style="width: 100%; height: auto;"    autoplay >
	</lottie-player>
</div>
</div>


<div class="row" id="content" style="display: block;">
	<div class="container ">
		<div class="title-section text-center">
			<h3 class="w3ls-title mb-3">Total do Pedido <span>{{number_format($total, 2, ',', '.')}}</span></h3>

		</div>
	</div>


	<!-- <input id="nome-cliente" type="hidden" value="{{$pedido->cliente->nome}} {{$pedido->cliente->sobre_nome}}" name=""> -->
	<input type="hidden" id="email-cliente" value="{{$cliente->email}}">

	<section class="blog_w3ls">
		<div class="container">
			<div class="title-section text-center mb-md-5 mb-4">
				<h3 class="w3ls-title mb-3">Forma de Entrega</h3>
				@if(count($enderecos) > 0)
				<p>Seus Endereços Cadastrados</p>
				@endif
			</div>
			<input type="hidden" id="lat_padrao" value="{{getenv('LATITUDE_PADRAO')}}">
			<input type="hidden" id="lng_padrao" value="{{getenv('LONGITUDE_PADRAO')}}">
			<input type="hidden" id="usar_bairros" value="{{$usar_bairros}}">


			@if(count($enderecos) == 0)
			<p style="margin-left: 10px;" class="text-warning">Você ainda não possui endereços cadastrados</p><br>

			@endif

			<h4 class="w3ls-title mb-4">Selecione o endereço de entrega:</h4>

			<div class="row ends">

				@foreach($enderecos as $e)

				<div class="col-lg-4 col-md-6" onclick="set_endereco({{$e->id}})">

					<div id="endereco_select_{{$e->id}}" class="card border-0 med-blog">

						<div class="card-body border border-top-0">
							<h5 class="blog-title card-title m-0">
								{{$e->rua}}, {{$e->numero}}
							</h5>
							<h5>{{$e->bairro}}</h5>
							<p>Referencia: {{$e->referencia}}</p>
						</div>
					</div>
				</div>

				@endforeach

				<div class="col-lg-4 col-md-6" onclick="set_endereco('balcao')">
					<div id="endereco_select_balcao" class="card border-0 med-blog">

						<div class="card-body border border-top-0">
							<h5 class="blog-title card-title m-0">
								Retirar no Balcão
							</h5>

						</div>
					</div>
				</div>
			</div>
			
			<div class="container"><br>
				<a href="#gal2" id="novo-endereco" class="btn btn-success btn-lg">Novo Endereço</a>

			</div>


		</div>
	</section>

	<hr>

	<div class="container">
		<div id="acrescimo-entrega" style="display: none" class="form-group"><br>
			<h4 style="margin-left: 10px;">Acrescimo de entrega R$ <strong id="valor-entrega" style="color: red;">
				
			</strong></h4>
			<h5 id="frete-gratuito" style="margin-left: 10px; display: none; color: blue;">Seu frete é gratuito para este endereço</h5>

		</div>

		<h5 id="entrega-distante" style="margin-left: 10px; display: none; color: red;">Este endereço excede o limite de nossas entregas: maximo {{$maximo_km_entrega}} KM</h5>

		<div class="form-group">
			<div class="col-lg-4 col-md-6 col-10">
				<label class="mb-2">Celular para contato</label>
				<input type="text" value="{{$ultimoPedido != null ? $ultimoPedido->telefone : $cliente->celular}}" class="form-control" id="telefone" required="">
			</div>
		</div>

		<div class="form-group">
			<div class="col-lg-12 col-md-12 col-12">
				<label class="mb-2">Observação do Pedido (opcional)</label>
				<input type="text" class="form-control" id="observacao" required="">
			</div>
		</div>

		<br>
		<div class="form-group">
			<div class="col-lg-4 col-md-4 col-8">
				<label style="color: red" class="mb-2">Cupom de Desconto (opcional)</label>
				<input type="text" class="form-control" id="cupom" value="{{$cupom > 0 ? $cupom : ''}}" required="">
			</div>
		</div>

		<div id="desconto" style="display: none" class="col-lg-4 col-md-4 col-8">
			<h4>Valor do cupom: <strong style="color: green" id="valor-cupom"></strong></h4><br>
		</div>

		<div id="cupom-invalido" style="display: none" class="col-lg-4 col-md-4 col-8">
			<h4 style="color: red">Cupom inválido</h4><br>
		</div>
	</div>

	<section class="blog_w3ls py-5">
		<div class="container pb-xl-5 pb-lg-3">
			<div class="title-section text-center mb-md-5 mb-4">
				<h3 class="w3ls-title mb-3">Forma de Pagamento</h3>

			</div>
			<div class="container">

				<fieldset class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-check">

								<input class="form-check-input" type="radio" name="gridRadios" id="maquineta" value="maquineta">
								<label class="form-check-label" for="maquineta">
									Maquina de cartão Crédito/Débito
								</label>
								<img width="40" src="/imgs/credit-card.png">

							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="gridRadios" id="dinheiro" value="dinheiro">
								<label class="form-check-label" for="dinheiro">
									Dinheiro
								</label>
								<img width="50" src="/imgs/100-real.png">

								<div id="div_do_troco" style="display: none" class="form-group">
									<label class="mb-2">Troco Para</label>
									<div class="col-sm-3">
										<input type="text" placeholder="Ex:  {{ $total%10 == 0 ? $total : ((int)($total/10) +1)*10}},00" class="form-control" id="troco_para">

									</div>
								</div>
							</div>

							@if($pagseguroAtivado == true)
							<div class="form-check">
								<input class="form-check-input" type="radio" name="gridRadios" id="pagseguro" value="pagseguro">
								<label class="form-check-label" for="debito">
									Cartão de Crédito
								</label>
								<img width="40" src="/imgs/debit-card.png">

							</div>
							@endif

						</div>
					</div>
				</fieldset>

			</div>

		</div>
	</section>

	<input type="hidden" id="pedido_id" value="{{$pedido->id}}">
	<input type="hidden" id="total-init" value="{{$total}}">

	<a href="#!" type="button" id="finalizar-venda" class="btn btn-success btn-lg btn-block">
		<span class="fa fa-check mr-2"></span> FINALIZAR <strong id="total"></strong>
	</a>
	<br>
</div>

<div id="gal2" class="pop-overlay">
	<div id="endereco-modal" class="popup">

		<div id="info-mapa">
			<p>Deslize o pino até sua localização!</p>
			<div id="map">	
			</div>
			<a style="color: #fff" id="btn-end-map" class="btn btn-success btn-block mb-4">Pronto</a>
		</div>

		<div id="form-endereco" style="display: none">
			
			<a style="color: #fff" id="abrir-mapa" class="btn btn-success btn-block mb-4">Abrir Mapa</a>



			<input type="hidden" id="_token" value="{{ csrf_token() }}">
			<input type="hidden" id="cliente_id" value="{{$cliente->id}}">
			
			<div class="form-group">
				<label>Rua</label>
				<input type="text" class="form-control fr" id="rua" placeholder="" required="">
			</div>

			<div class="form-group">
				<label class="mb-2">Número</label>
				<input type="text" class="form-control fr" id="numero" required="true">
			</div>


			@if($usar_bairros == 1)

			<div class="form-group">
				<label class="mb-2">Bairro</label>
				<select id="bairro" class="form-control">
					<option value="" disabled selected hidden>Selecione o bairro...</option>
					@foreach($bairros as $b)
					<option value="id:{{$b->id}}">{{$b->nome}} - R$ {{number_format($b->valor_entrega, 2)}}</option>
					@endforeach
				</select>
			</div>

			@else
			<div class="form-group">
				<label class="mb-2">Bairro</label>
				<input type="text" class="form-control fr" id="bairro" required="true">
			</div>
			@endif

			<div class="form-group">
				<label class="mb-2">Referencia ou apartamento</label>
				<input type="text" class="form-control fr" id="referencia" required="">
			</div>
			<a href="#!" id="salvar_endereco" class="btn btn-danger btn-block mb-4 disabled">Salvar</a>


		</div>
		<a class="close" href="#!">×</a>
	</div>
</div>

<div id="modal-pagseguro" class="pop-overlay">
	<div style="overflow-y: scroll; overflow-x: scroll;" class="popup">
		<div class="row" id="div-cartao-antigo" @if(sizeof($cartoes) > 0) style="display: block" @else style="display: none" @endif>
			<div class="col-sm-12">
				<h6>Cartões utilizados em compras anteriores:</h6>
			</div><br>

			@foreach($cartoes as $c)
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-4">

						<input class="form-check-input" type="radio" name="escolha-cartao" value="{{$c}}">
						<img width="100" src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/{{$c['bandeira']}}.png">

					</div>
					<div class="col-sm-8" >

						
						<label class="form-check-label" style="color: #555; margin-top: 8px; ">
							Número: {{$c['numero_cartao']}}
						</label><br>
						<label class="form-check-label" style="color: #555;">
							CPF: {{$c['cpf']}}
						</label>
					</div>

				</div>
			</div>

			@endforeach
			<hr>
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-4">

						<input class="form-check-input" type="radio" name="escolha-cartao" value="null">
						<img width="70" src="/imgs/credit-card.png">

					</div>
					<div class="col-sm-8">

						<label class="form-check-label" style="font-size: 25px; margin-top: 10px; color: #555;">
							Novo Cartão
						</label><br>
						
					</div>

				</div>
			</div>

		</div><br>
		<div class="modal-body" id="div-pagar" @if(sizeof($cartoes) > 0) style="display: none" @else style="display: block" @endif>
			<div class="card-wrapper" style="margin-left: -20px;"></div>
			
			<form style="margin-top: 20px;">

				<div class="row">

					<div class="col-lg-12 col-md-12">
						<label class="">Número do Cartão</label>
						<input type="tel" class="form-control" id="number" name="number">
					</div>

					<div class="col-lg-12 col-md-12 margin">
						<label class="">Nome Impresso no Cartão</label>
						<input type="text" value="{{$pedido->cliente->nome}} {{$pedido->cliente->sobre_nome}}" class="form-control" id="nome" name="name">
					</div>

					<div class="col-lg-12 col-md-12 margin">
						<label class="">CPF</label>
						<input type="tel" class="form-control" id="cpf" name="cpf">
					</div>

					<div class="col-lg-12 col-md-12 margin">
						<label class="">Validade</label>
						<input type="tel" placeholder="**/****" class="form-control" id="validade" name="validade">
					</div>

					<div class="col-lg-12 col-md-12 margin">
						<label class="">CVC</label>
						<input type="tel" class="form-control" id="cvc" name="cvc">
					</div>

					<div class="col-lg-12 col-md-12 margin">
						<label>Parcelamento</label>
						<select id="fator" class="form-control">
						</select>

					</div>

				</div><br>

				<a style="color: #fff" type="button" id="finalizar-venda-cartao" class="btn btn-success btn-lg btn-block">
					<span class="fa fa-check mr-2"></span> FINALIZAR  <strong id="total-cartao"></strong> <i id="icon-spin" style="display: none;" class="fa fa-spinner fa-spin"></i>
				</a><br>
			</form>
		</div>
		<a class="close" href="#!"><i id="icon-spin" class="fa fa-close"></i></a>
		<a style="margin-right: 30px;" class="close" id="voltar"><i id="icon-spin" class="fa fa-arrow-circle-left"></i></a>
	</div>
</div>


@endsection	
