@extends('delivery_pedido.default')
@section('content')

@if(session()->has('message_sucesso'))
<div class="p-3 mb-2 bg-success text-white">{{ session()->get('message_sucesso') }}</div>
@endif
<div class="clearfix"></div>

<section class="blog_w3ls py-5">
	<div class="container pb-xl-5 pb-lg-3">
		<div class="title-section text-center mb-md-5 mb-4">
			<p class="w3ls-title-sub">Seus cupons</p>
		</div>
		<div class="row">

			@foreach($cupons as $c)

			<div class="col-lg-4 col-md-6">
				<div class="card border-0 med-blog">
					<div class="card-header p-0">

						<a @if($c->ativo) href="/carrinho/forma_pagamento/{{$c->codigo}}" @else href="#1" @endif>
							@if($c->tipo == 'valor')


							@if($c->valor > 2 && $c->valor <= 7)

							<img style="height: 200px; width: 100%;" class="card-img-bottom" src="/imgs/desconto_dinheiro_amarelo.png">

							@elseif($c->valor > 7 && $c->valor <= 15)
							<img style="height: 200px; width: 100%;" class="card-img-bottom" src="/imgs/desconto_dinheiro_azul.png">

							@elseif($c->valor > 15)
							<img style="height: 200px; width: 100%;" class="card-img-bottom" src="/imgs/desconto_dinheiro_verde.png">

							@endif

							@else

							@if($c->valor > 2 && $c->valor <= 7)

							<img style="height: 200px; width: 100%;" class="card-img-bottom" src="/imgs/desconto_percent_amarelo.png">

							@elseif($c->valor > 7 && $c->valor <= 15)
							<img style="height: 200px; width: 100%;" class="card-img-bottom" src="/imgs/desconto_percent_azul.png">

							@elseif($c->valor > 15)
							<img style="height: 200px; width: 100%;" class="card-img-bottom" src="/imgs/desconto_percent_verde.png">

							@endif



							@endif
						</a>
						
					</div>
					<div class="card-body border border-top-0">
						<h5 class="blog-title card-title m-0"><a @if($c->ativo) href="/carrinho/forma_pagamento/{{$c->codigo}}" @else href="#1" @endif>Código: <strong>{{$c->codigo}}</strong></a></h5>
						@if($c->tipo == 'valor')
						<h5 class="blog-title card-title m-0"><a href="menu.html">R$ {{number_format($c->valor, 2)}}</a></h5>
						@else
						<h5 class="blog-title card-title m-0"><a href="menu.html">% {{number_format($c->valor, 0)}}</a></h5>
						@endif
						
						@if($c->ativo)
						<p style="color: green" class="mt-3">ATIVO</p>
						@else
						<p style="color: red" class="mt-3">DESATIVADO</p>
						@endif
						
					</div>
				</div>
			</div>
			@endforeach
			
		</div>
	</div>
</section>



@endsection	
