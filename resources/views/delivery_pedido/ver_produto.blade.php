@extends('delivery_pedido.default')
@section('content')


@if(session()->has('message_sucesso'))
<div class="p-3 mb-2 bg-success text-white">{{ session()->get('message_sucesso') }}</div>
@endif

@if(session()->has('message_erro'))
<div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro') }}</div>
@endif



<div class="baneer-w3ls">
	<div class="row no-gutters">
		<div class="col-xl-5 col-lg-6">
			<div class="banner-left-w3">
				<div class="container">
					<div class="banner-info_agile_w3ls" style="">

						<h3 class=""><span>{{$produto->nome}}</span> </h3>
						<p>{{$produto->descricao}}</p>

						
						@if(count($produto->pizza) == 0)
						<h4 style="text-decoration: line-through;">de R$ <span">{{$produto->valor_anterior}}</span> </h4>
						<h3>Por R$ <span style="color: orange">{{$produto->valor}}</span> </h3>
						@else

						@foreach($produto->pizza as $tp)
						<h4>{{$tp->tamanho->nome}}: 
							<span style="color: orange">{{number_format($tp->valor, 2)}}</span></h4> 
							@endforeach

							@endif

							<a href="/cardapio/acompanhamento/{{$produto->id}}" class="button-w3ls active mt-5">Adicionar ao Carrinho
								<span class="fa fa-caret-right ml-1" aria-hidden="true"></span>
							</a>

						</div>
					</div>	
				</div>
				<br>
			</div>
			<div class="col-xl-7 col-lg-6 callbacks_container">

				<div class="csslider infinity" id="slider1">
					@foreach($produto->galeria as $key => $g)
					<input type="radio" name="slides" @if($key+1 == 1) checked="checked" @endif id="slides_{{$key+1}}" />
					@endforeach

					<ul class="banner_slide_bg">
						@foreach($produto->galeria as $key => $g)
						<li>
							<img style="width: 100%; height: 400px;" 
							src="/imagens_produtos/{{$g->path}}">
						</li>
						@endforeach
						
					</ul>
					<div class="arrows">
						@foreach($produto->galeria as $key => $g)
						<label for="slides_{{$key+1}}"></label>
						@endforeach

					</div>
					<div class="navigation">
						<div>
							@foreach($produto->galeria as $key => $g)

							<label for="slides_{{$key+1}}"></label>
							@endforeach

						</div>
					</div>
				</div>

			</div>
		</div>
	</div><br>



	<div class="clearfix"></div>

	


	<section class="wthree-slider" id="masthead">

	</section>


	@endsection	