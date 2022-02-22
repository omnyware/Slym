@extends('delivery.default')
@section('content')


<div class="row" id="anime" style="display: none;">
	<div class="col s8 offset-s2">
		<lottie-player 
		src="/anime/success.json" background="transparent"  speed="0.8"  style="width: 100%; height: auto;"    autoplay >
	</lottie-player>
</div>
</div>

<div class="row" id="content" style="display: block;">

	<div class="clearfix"></div>

	<section class="portfolio py-5">
		<div class="container py-xl-5 py-lg-3">
			<div class="title-section text-center mb-md-5 mb-4">
				<h3 class="w3ls-title mb-3"><span>Adicionais para a pizza 
					@foreach($saboresIncluidos as $key => $s)
					<strong style="color: black">{{$s['produto']['nome']}} {{count($saboresIncluidos) > $key+1 ? '|' : ''}}</strong> </span>
					@endforeach

				</h3>
				<input type="hidden" value="{{json_encode($sabores)}}" id="sabores">
				<input type="hidden" value="{{$tamanho}}" id="tamanho">
				<h3>Valor R$ <strong id="valor_produto">{{number_format($maiorValor, 2)}}</strong></span></h3>
				@if(getenv("DIVISAO_VALOR_PIZZA") == 0)
				<p>Permanece o preço do sabor com maior valor.</p>
				@endif
			</div>

			<input type="hidden" id="maximo_adicionais_pizza" value="{{$config->maximo_adicionais_pizza}}" name="">


			<button onclick="location.reload()" type="button" class="btn btn-danger btn-lg">
				Remover Adicionais
			</button>
			@if(count($adicionais) > 0)
			<div class="row mt-4">


				@foreach($adicionais as $a)
				<div class="col-md-4" onclick="selet_add({{$a->complemento}})">
					<div class="gallery-demo" id="adicional_{{$a->complemento->id}}">
						<a href="#">

							<h4 class="p-mask">{{$a->complemento->nome()}} - 
								<span>R$ {{$a->complemento->valor}}</span></h4>
							</a>
						</div>
					</div>
					@endforeach


				</div>
				@else
				<div class="title-section text-center mb-md-5 mb-4">
					<h4 class="w3ls-title mb-3 "><span>Esta categoria de produto não possui adicionais</span></h4>
				</div>
				@endif

			</div><br>


			
			<div class="container">

				<div class="col-sm-12 col-md-4 col-lg-4">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1">Quantidade</span>
						</div>
						<input type="number" class="form-control" value="1" id="quantidade" aria-describedby="basic-addon1">
					</div>
				</div>
				<div class="col-sm-12 col-md-8 col-lg-8">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">Observação</span>
						</div>
						<input type="text" class="form-control" id="observacao" aria-label="Observação" aria-describedby="basic-addon1">
					</div>
				</div>

			</div>



			<input type="hidden" id="_token" value="{{ csrf_token() }}">

			<button onclick="adicionar()" type="button" class="btn btn-warning btn-lg btn-block">
				<span class="fa fa-cart-plus mr-2"></span> ADICIONAR R$ <strong id="valor_total">{{number_format($maiorValor, 2)}}</strong>
			</button>
		</section>

	</div>


	@endsection	
