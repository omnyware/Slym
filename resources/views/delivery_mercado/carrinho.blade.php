
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

.stepper-arrow {
	margin-left: -10px;
	margin-right: -10px;
}

</style>

<section class="section section-md section-last bg-default text-md-left">
	<div class="container">
		<div class="row row-50">

			<div class="col-lg-12">
				<h2 class="wow slideInUp" data-wow-delay="0s">Carrinho</h2>
				<input type="hidden" id="token" value="{{csrf_token()}}" name="">
				<input type="hidden" id="pedido_id" value="{{$pedido->id}}" name="">
				<div class="row">

					@foreach($pedido->itens as $key => $i)
					<div id="div_{{$i->produto->id}}" class="col-lg-4 col-md-6 col-xs-4 col-12 wow slideInLeft" data-wow-delay="0.{{$key}}s">
						<div class="unit align-items-center">
							<div class="unit-left">
								<a class="cart-inline-figure" href="#">

									@if(sizeof($i->produto->galeria) > 0)
									<img loading="lazy" src="/imagens_produtos/{{$i->produto->galeria[0]->path}}" style="width: 108px; height: 100px;"/>
									@else
									<img src="/imgs/no_image.png" style="width: 108px; height: 100px;"/>
									@endif

								</a>
							</div>
							<div class="unit-body">
								<h6 class="cart-inline-name"><a href="#">{{$i->produto->produto->nome}}</a></h6>
								<div>
									<div class="group-xs group-inline-middle">
										<div class="table-cart-stepper">
											<div class="stepper ">
												<input class="form-input stepper-input" type="number" id="input_prod_{{$i->produto->id}}" disabled value="{{{ $i->produto->produto->unidade_venda == 'UNID' ? (int)$i->quantidade : $i->quantidade}}}" @if($i->produto->produto->unidade_venda != 'UNID') style="padding-left: 32px; font-size: 14px;" @endif>

												<span onclick="upProd({{$i->produto->id}}, '{{$i->produto->produto->unidade_venda}}')" class="stepper-arrow up"></span>

												<span onclick="downProd({{$i->produto->id}}, '{{$i->produto->produto->unidade_venda}}')" class="stepper-arrow down"></span>
											</div>
										</div>
										
										<h6 class="cart-inline-title">R$ <strong id="input_html_{{$i->produto->id}}">{{number_format($i->quantidade * $i->produto->valor, 2)}}</strong></h6>
										<div style="display: none;" id="loader_{{$i->produto->id}}" class="loader"></div>


									</div>
									
								</div>
							</div>
						</div>
					</div>
					@endforeach

					

				</div>
				<form method="post" action="/delivery/finalizar" class="wow slideInRight" data-wow-delay="0.3s">
					@csrf
					<input type="hidden" name="pedido_id" value="{{$pedido->id}}">
					<button style="width: 100%;" class="button button-{{getenv('COLOR_BUTTON')}} button-pipaluk"  type="submit">Finalziar <strong id="soma">R$ {{number_format($pedido->somaItens(), 2)}}</strong></button>
				</form>

			</div>
		</div>
	</div>
</div>
</section>

@endsection 