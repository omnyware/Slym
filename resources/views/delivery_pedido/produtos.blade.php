@extends('delivery_pedido.default')
@section('content')

<div class="clearfix"></div>


<div class="main-banner-2">

</div>

<section class="portfolio py-5">
	<div class="container py-xl-5 py-lg-3">
		<div class="title-section text-center mb-md-5 mb-4">
			<h3 class="w3ls-title mb-3"><span>Produtos Categoria {{$categoria->nome}}</span></h3>
			<p class="titile-para-text mx-auto">{{$categoria->descricao}}</p>
		</div>
		<?php $ativo = false; ?>

		<div class="row mt-4">

			@foreach($produtos as $p)
			@if($p->status)
			<div @if(!$p->itemPedido()) style="opacity: 0.5" @endif class="col-md-4">
				<div class="gallery-demo">
					<a @if($p->itemPedido()) 
						href="/pedido/adicionais/{{$p->id}}"
						@else
						href="#!"
						@endif>
						@if(count($p->galeria) > 0)
						<img loading="lazy" src="/imagens_produtos/{{$p->galeria[0]->path}}" 
						alt="" style="height: 300px; width: 100%;" class="img-fluid" />
						@else
						<img style="height: 300px; width: 100%" src="/imagens/sem-imagem.png"  class="img-fluid" >
						@endif

						<?php $ativo = true; ?>
						<h4 class="p-mask">{{$p->produto->nome}} - <span>R${{$p->valor}}</span></h4>
						@if(!$p->itemPedido())
						<p style="color: red; margin-left: 10px;">Limite diário de vendas atingido</p>
						@endif
					</a>
				</div>
			</div>
			@endif
			@endforeach


		</div>
		@if(!$ativo)
		<div class="title-section text-center mb-md-5 mb-4">
			<h4 class="w3ls-title mb-3 "><span>Esta categoria ainda não possui produtos :(</span></h4>
		</div>
		@endif

	</div>
</section>

@endsection	

