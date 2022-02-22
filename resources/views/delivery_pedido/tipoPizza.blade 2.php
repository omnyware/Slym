@extends('delivery_pedido.default')
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
			<h3 class="w3ls-title mb-3">Tipo da sua Pizza</h3>
		</div>
	</div>

	<form action="/pedido/escolherSabores" method="get">
		<section class="blog_w3ls py-5">

			<div class="container pb-xl-5 pb-lg-3">
				@if(session()->has('message_erro'))
				<div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro') }}</div>
				@endif
				<input type="hidden" name="categoria" value="{{$categoria->id}}">
				<input type="hidden" name="produto" value="{{{isset($produto) ? $produto->id : 0 }}}">
				
				<div class="container">

					<fieldset class="form-group">
						<div class="row">
							<div class="col-lg-4 col-md-6">
								<?php $temp = $tamanhos[0]->nome ?>
								@foreach($tamanhos as $t)
								@for($aux = 1; $aux <= $t->maximo_sabores; $aux++)

								@if($temp != $t->nome)
								<br>
								<?php $temp = $t->nome ?>
								@endif

								
								<div class="form-check">

									<input class="form-check-input" type="radio" name="tipo" id="credito" value="{{$t->nome}}-{{$aux}}">
									<label class="form-check-label" for="credito">
										{{$t->nome}}({{$t->pedacos}} pedaços) - {{$aux}} {{$aux == 1 ? 'sabor' : 'sabores'}}
									</label>


								</div>
								
								@endfor
								@endforeach

							</div>
						</div>
					</fieldset>

				</div>

			</div>
		</section>



		<button type="submit" class="btn btn-success btn-lg btn-block">
			<span class="fa fa-check mr-2"></span> Escolher Sabores </button>
		</form>
		<br>
	</div>


	@endsection	
