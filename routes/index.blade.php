@extends('delivery.default')
@section('content')
<!-- //navigation -->
<!-- //header 2 -->


@if(session()->has('message_sucesso'))
<div class="p-3 mb-2 bg-success text-white">{{ session()->get('message_sucesso') }}</div>
@endif

@if(session()->has('message_erro'))
<div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro') }}</div>
@endif


<!-- banner -->
@foreach($destaques as $d)
<div class="baneer-w3ls">
	<div class="row no-gutters">
		<div class="col-xl-5 col-lg-6">
			<div class="banner-left-w3">
				<div class="container">
					<div class="banner-info_agile_w3ls">

						<h3 class=""><span>{{$d->produto->nome}}</span> </h3>
						<p>{{$d->descricao}}</p>
						<h3 ><span style="color: orange">{{$d->valor}}</span> </h3>

						<a href="/cardapio/acompanhamento/{{$d->id}}" class="button-w3ls active mt-5">Adicionar ao Carrinho
							<span class="fa fa-caret-right ml-1" aria-hidden="true"></span>
						</a>
							<!-- <a href="menu.html" class="button-w3ls mt-5 ml-2">Ver Mais
								<span class="fa fa-caret-right ml-1" aria-hidden="true"></span>
							</a> -->

						</div>

					</div>

				</div>
				<br>
			</div>
			<div class="col-xl-7 col-lg-6 callbacks_container">
				<!-- banner slider -->
				<div class="csslider infinity" id="slider1">
					@foreach($d->galeria as $key => $g)
					<input type="radio" name="slides" @if($key+1 == 1) checked="checked" @endif id="slides_{{$key+1}}" />
					@endforeach
					<!-- <input type="radio" name="slides" id="slides_2" /> -->
					<!-- <input type="radio" name="slides" id="slides_3" /> -->
					<ul class="banner_slide_bg">
						@foreach($d->galeria as $key => $g)
						<li>
							<img style="width: auto; height: 400px;" 
							src="/imagens_produtos/{{$g->path}}">
						</li>
						@endforeach
						<!-- <li>
							<div class="banner-top2"></div>
						</li>
						<li>
							<div class="banner-top3"></div>
						</li> -->
					</ul>
					<div class="arrows">
						@foreach($d->galeria as $key => $g)
						<label for="slides_{{$key+1}}"></label>
						@endforeach
						<!-- <label for="slides_2"></label> -->
						<!-- <label for="slides_3"></label> -->
					</div>
					<div class="navigation">
						<div>
							@foreach($d->galeria as $key => $g)

							<label for="slides_{{$key+1}}"></label>
							@endforeach

							<!-- <label for="slides_2"></label> -->
							<!-- <label for="slides_3"></label> -->
						</div>
					</div>
				</div>
				<!-- //banner slider -->
			</div>
		</div>
	</div><br>

	@endforeach
	<!-- //banner -->
	<div class="clearfix"></div>

	<!-- about -->
	
	<!-- //about -->

	<!-- specials -->
	<section class="blog_w3ls py-5">
		<div class="container pb-xl-5 pb-lg-3">
			<div class="title-section text-center mb-md-5 mb-4">
				<p class="w3ls-title-sub">Categorias</p>
			</div>
			<div class="row">
				<!-- blog grid -->
				@foreach($categorias as $c)
				<div class="col-lg-4 col-md-6">
					<div class="card border-0 med-blog">
						<div class="card-header p-0">
							<a href="/cardapio/{{$c->id}}">
								<img style="height: 200px; width: 100%;" class="card-img-bottom" src="imagens_categorias/{{$c->path}}" alt="Card image cap">
							</a>
						</div>
						<div class="card-body border border-top-0">
							<h5 class="blog-title card-title m-0"><a href="menu.html">{{$c->nome}}</a></h5>
							<p style="height: 80px;" class="mt-3">{{$c->descricao}}</p>
							<a href="/cardapio/{{$c->id}}" class="btn button-w3ls mt-4 mb-3">Ver Produtos
								<span class="fa fa-caret-right ml-1" aria-hidden="true"></span>
							</a>
						</div>
					</div>
				</div>
				@endforeach
				<!-- //blog grid -->
				<!-- blog grid -->
				<!-- <div class="col-lg-4 col-md-6 mt-md-0 mt-5">
					<div class="card border-0 med-blog">
						<div class="card-header p-0">
							<a href="menu.html">
								<img class="card-img-bottom" src="images/blog2.jpg" alt="Card image cap">
							</a>
						</div>
						<div class="card-body border border-top-0">
							<h5 class="blog-title card-title m-0"><a href="menu.html">Veg Muffin</a></h5>
							<p class="mt-3">Cras ultricies ligula sed magna dictum porta auris blandita.</p>
							<a href="menu.html" class="button-w3ls active mt-4 mb-3">View More
								<span class="fa fa-caret-right ml-1" aria-hidden="true"></span>
							</a>
						</div>
					</div>
				</div>


				<div class="col-lg-4 col-md-6 mt-lg-0 mt-5">
					<div class="card border-0 med-blog">
						<div class="card-header p-0">
							<a href="menu.html">
								<img class="card-img-bottom" src="images/blog3.jpg" alt="Card image cap">
							</a>
						</div>
						<div class="card-body border border-top-0">
							<h5 class="blog-title card-title m-0"><a href="menu.html">Hashbrown Brioche</a></h5>
							<p class="mt-3">Cras ultricies ligula sed magna dictum porta auris blandita.</p>
							<a href="menu.html" class="button-w3ls mt-4 mb-3">View More
								<span class="fa fa-caret-right ml-1" aria-hidden="true"></span>
							</a>
						</div>
					</div>
				</div> 
			-->
		</div>
	</div>
</section>
<!-- //specials -->


<!-- //blog -->

<!-- slides images -->
<section class="wthree-slider" id="masthead">

</section>
<!-- //slides images -->

<!-- newsletter -->

<!-- //newsletter -->

<!-- footer -->

@endsection	