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
			<input type="hidden" id="maximo_adicionais" value="{{$config->maximo_adicionais}}" name="">

			<div class="title-section text-center mb-md-5 mb-4">
				<h3 class="w3ls-title mb-3"><span>Adicionais para o produto 
					<strong style="color: black">{{$produto->produto->nome}}</strong> R$ <strong id="valor_produto">{{$produto->valor}}</strong></span></h3>
					@if($produto->descricao)
					<h4 class="w3ls-title mb-3"><span>Descrição: 
						<strong style="color: black">{{$produto->descricao}}</strong></span></h4>

						@endif

						@if($produto->ingredientes)
						<h4 class="w3ls-title mb-3"><span>Ingredientes: 
							<strong style="color: black">{{$produto->ingredientes}}</strong></span></h4>

							@endif
						</div>

						<input type="hidden" id="produto_id" value="{{$produto->id}}">
						@if(count($adicionais) > 0)
						<div class="row mt-4">

							@foreach($adicionais as $a)
							<div class="col-md-4" onclick="selet_add({{$a->complemento}}, '{{$a->complemento->nome}}')">
								<div class="gallery-demo" id="adicional_{{$a->complemento->id}}">
									<a href="#">

										<h4 class="p-mask">{{$a->complemento->nome}} - 
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
						<input type="hidden" id="whats_delivery" value="{{ getenv('WHATSAPP_DELIVERY') }}">
						<input type="hidden" id="total_init" value="{{ $produto->valor }}">

						<button onclick="adicionar()" type="button" class="btn btn-warning btn-lg btn-block">
							<span class="fa fa-cart-plus mr-2"></span> ADICIONAR R$ <strong id="valor_total">{{$produto->valor}}</strong>
						</button>



						@if(getenv('WHATSAPP_DELIVERY') != '')
						<button onclick="pedirWhats('{{$produto->produto->nome}}')" type="button" class="btn btn-success btn-lg btn-block">
							<span class="fa fa-whatsapp mr-2"></span> PEDIR NO WHATSAPP</strong>
						</button>
						@endif
					</section>

				</div>


				@endsection	
