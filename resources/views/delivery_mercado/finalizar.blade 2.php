
@extends('delivery_mercado.default')
@section('content')

<style type="text/css">
.loader {
	border: 10px solid #f3f3f3; /* Light grey */
	border-top: 10px solid #3498db; /* Blue */
	border-radius: 50%;
	width: 30px;
	height: 30px;
	animation: spin 0.5s linear infinite;

}

@keyframes spin {
	0% { transform: rotate(0deg); }
	100% { transform: rotate(360deg); }
}

#map{
	width: 100%;
	min-height: 400px;
	border: none;
	display: block;
}
</style>

<div class="row" id="anime" style="display: none;">
	<section class="section section-md section-last bg-default text-md-left">
		<div class="container">
			<div class="col s8 offset-s2">
				<lottie-player src="/anime/finish{{rand(1,4)}}.json" background="transparent"  speed="0.8"  style="width: 100%; height: auto;"    autoplay >
				</lottie-player>
			</div>
		</div>
	</section>
</div>


<div class="row" id="content" style="display: block;">

	<section class="section section-md section-last bg-default text-md-left">

		<div class="container">
			<div class="oh">
				<h2 class="wow slideInUp" data-wow-delay="0s">Finalizar Pedido</h2>
				<h4 class="wow slideInUp" data-wow-delay="0.5s">TOTAL: R$ {{number_format($pedido->somaItens(), 2)}}</h4>

			</div>
			<div class="row row-30 justify-content-center">

				@if(count($enderecos) == 0)
				<p style="margin-left: 10px;" class="text-warning">Você ainda não possui endereços cadastrados</p><br>

				@endif

			</div>

			<input type="hidden" id="total-init" value="{{$total}}" name="">
			<input type="hidden" id="pedido_id" value="{{$pedido->id}}" name="">
			<input type="hidden" id="lat_padrao" value="{{getenv('LATITUDE_PADRAO')}}">
			<input type="hidden" id="lng_padrao" value="{{getenv('LONGITUDE_PADRAO')}}">
			<input type="hidden" id="email-cliente" value="{{$cliente->email}}">
			<input type="hidden" id="usar_bairros" value="{{$usar_bairros}}">

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
				<a data-toggle="modal" data-target="#modal-mapa" href="#gal2" id="novo-endereco" class="button button-{{getenv('COLOR_BUTTON')}} button-pipaluk">Novo Endereço</a>

			</div>
			<br>
			<hr>
			<div id="acrescimo-entrega" style="display: none" class="form-group"><br>
				<h4 style="margin-left: 10px;">Acrescimo de entrega R$ <strong id="valor-entrega" style="color: red;">

				</strong></h4>
				<h5 id="frete-gratuito" style="margin-left: 10px; display: none; color: blue;">Seu frete é gratuito para este endereço</h5>
			</div>

			<h5 id="entrega-distante" style="margin-left: 10px; margin-top: 10px; display: none; color: red;">Este endereço excede o limite de nossas entregas: maximo {{$config->maximo_km_entrega}} KM</h5>
			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="form-group">
						<label class="mb-2">Celular para contato</label>
						<input type="text" class="form-control fr" value="{{$ultimoPedido != null ? $ultimoPedido->telefone : ''}}" id="telefone" required="true">
					</div>
				</div>

				<div class="col-12">
					<div class="form-group">
						<label class="mb-2">Observação do Pedido (opcional)</label>
						<input type="text" class="form-control fr" id="observacao" required="true">
					</div>
				</div>

				<div class="col-lg-4 col-md-6">
					<div class="form-group">
						<label style="color: red" class="mb-2">Cupom de Desconto (opcional)</label>
						<input type="text" class="form-control" id="cupom" value="" required="">
					</div>
				</div>
			</div>

			<hr>
			<br>
			<div class="row">
				<div class="col-12">
					<h4 class="wow slideInLeft" data-wow-delay="0.2s">Forma de Pagamento</h4>

					<fieldset class="form-group">
						<div class="wow slideInLeft" data-wow-delay="0.7s">
							<div class="col-sm-12"><br>
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

			<div class="row">
				<button style="width: 100%;" type="button" id="finalizar-venda" class="button button-facebook">
					<span class="fa fa-check mr-2"></span> FINALIZAR <strong id="total"></strong>
				</button><br>
			</div>

		</div>

	</section>


	<div class="modal fade" id="modal-mapa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div id="info-mapa">
						<p>Deslize o pino até sua localização!</p>
						<div id="map">	
						</div>
						<button style="color: #fff" id="btn-end-map" class="button button-{{getenv('COLOR_BUTTON')}} button-pipaluk">Pronto</button>
					</div>

					<div id="form-endereco" style="display: none">

						<button style="color: #fff" id="abrir-mapa" class="button button-{{getenv('COLOR_BUTTON')}} button-pipaluk">Abrir Mapa</button>



						<input type="hidden" id="_token" value="{{ csrf_token() }}">
						<input type="hidden" id="cliente_id" value="{{$cliente->id}}">

						<div class="form-group">
							<label>Rua</label>
							<input type="text" class="form-control fr" id="rua" placeholder="" required="">
						</div>

						<div class="form-group">
							<label class="mb-2">Numero</label>
							<input type="text" class="form-control fr" id="numero" required="true">
						</div>

						@if($usar_bairros == 1)

						<div class="col-lg-12 col-md-12">
							<label>Baiirro</label><br>
							<select id="bairro" style="width: 300px; height: 50px; text-align: center;">
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
							<label class="mb-2">Referencia</label>
							<input type="text" class="form-control fr" id="referencia" required="">
						</div>
						<a href="#!" id="salvar_endereco" class="button button-secondary button-pipaluk">Salvar</a>


					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-pagseguro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button style="margin-left: 0px;" class="close" id="voltar"><i id="icon-spin" class="fa fa-arrow-circle-left"></i></button>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				</div>
				<div class="modal-body">

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
								<div class="col-sm-4" style="margin-top: 10px;">
									<input class="form-check-input" type="radio" name="escolha-cartao" value="null">
									<img width="70"  src="/imgs/credit-card.png">

								</div>
								<div class="col-sm-8">
									<label class="form-check-label" style="font-size: 25px; margin-top: 10px; color: #555;">
										Novo Cartão
									</label><br>

								</div>

							</div>
						</div>

					</div>

					<div class="modal-body" id="div-pagar" @if(sizeof($cartoes) > 0) style="display: none" @else style="display: block" @endif>
						<div class="card-wrapper" style="margin-left: -20px;"></div>

						<form id="form-pag" style="margin-top: 0px;">

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


								<div class="col-lg-12 col-md-12">
									<label>Parcelamento</label><br>
									<select id="fator" style="width: 300px; height: 50px; text-align: center;">
									</select>

								</div>

							</div>
							<div style="display: none;" id="loader" class="loader"></div><br>
							<button style="color: #fff" type="button" id="finalizar-venda-cartao" class="button button-facebook">
								<span class="fa fa-check mr-2"></span> FINALIZAR <strong id="total-cartao"></strong> 
							</button>
							<br>
						</form>
					</div>


				</div>

			</div>
		</div>
	</div>
</div>

@endsection 