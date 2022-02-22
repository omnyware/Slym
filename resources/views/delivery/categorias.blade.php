@extends('delivery.default')
@section('content')

<div class="clearfix"></div>


<section class="blog_w3ls py-5">
	<div class="container pb-xl-5 pb-lg-3">
		<div class="title-section text-center mb-md-5 mb-4">
			<p class="w3ls-title-sub">Categorias</p>
		</div>
		<div class="row">

			@foreach($categorias as $key => $c)

			<div class="col-lg-4 col-md-6">
				<div class="card border-0 med-blog">
					<div class="card-header p-0">
						@if($key%3 == 0 && $key > 0) <br> @endif
						<a href="/cardapio/{{$c->id}}">
							<img loading="lazy" style="height: 200px; width: 100%;" class="card-img-bottom" src="/imagens_categorias/{{$c->path}}" alt="Card image cap">
						</a>
					</div>
					<div class="card-body border border-top-0">
						<h5 class="blog-title card-title m-0"><a href="#!">{{$c->nome}}</a></h5>
						<p style="height: 80px;" class="mt-3">{{$c->descricao}}</p>
						<a href="/cardapio/{{$c->id}}" class="btn button-w3ls mt-4 mb-3">Ver Produtos
							<span class="fa fa-caret-right ml-1" aria-hidden="true"></span>
						</a>
					</div>
				</div>
			</div>
			@endforeach
			
		</div>
	</div>
</section>

@endsection	
