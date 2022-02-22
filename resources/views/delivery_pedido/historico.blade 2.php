@extends('delivery_pedido.default')
@section('content')

<div class="clearfix"></div>


@if(session()->has('message_erro'))
<div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro') }}</div>
@endif


<section class="blog_w3ls py-5">

	<div class="accordion" id="accordionExample">

		@if(count($pedidos) == 0)
		<div class="row">
			<div class="container">
				<h3 class="text-danger">Nenhum pedido realizado até o momento! :((</h3>

				<a href="/cardapio" class="btn btn-success">IR PARA CARDÁPIO</a>
			</div>
		</div>
		@endif
		@foreach($pedidos as $key => $p)
		<div class="card">
			<div class="card-header" id="heading_{{$p->id}}">
				<h5 class="mb-0">
					<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$p->id}}" aria-expanded="true" aria-controls="collapseThree">
						<h4>Numero do Pedido: <strong>{{$p->id}}</strong></h4>
						<h4>Data: <strong>{{ \Carbon\Carbon::parse($p->data_registro)->format('d/m/Y H:i:s')}}</strong></h4>

					</button>
				</h5>
			</div>
			<div id="collapse{{$p->id}}" class="collapse" aria-labelledby="heading_{{$p->id}}" data-parent="#accordionExample">
				<div class="card-body">
					<?php $geral = 0; ?>
					@foreach($p->itens as $i)
					<div class="row">

						<div class="col-sm">
							

							@if(isset($i->produto->galeria[0]))
							<img src="/imagens_produtos/{{$i->produto->galeria[0]->path}}" alt="..." class="img-responsive mini"/>
							@else
							<img src="/imgs/no_image.png" alt="..." class="img-responsive mini"/>
							@endif

						</div>
						<div class="col-sm">

							<?php $total = $i->produto->valor * $i->quantidade; ?>
							<h4>{{$i->produto->produto->nome}}</h4>
							<!-- <p>Tamanho: M</p> -->
							<p>Adicionais: 
								@if(count($i->itensAdicionais)>0)
								@foreach($i->itensAdicionais as $a)
								<label>{{$a->adicional->nome}}</label>
								<?php  $total += $a->adicional->valor * $i->quantidade?>
								@endforeach
								@else
								<label>Nenhum adicional</label>

								@endif

								@if(count($i->sabores) > 0)
								<br>
								<span>Sabores: 
									@foreach($i->sabores as $key => $s)
									<strong>{{$s->produto->produto->nome}}</strong>
									{{($key+1 >= count($i->sabores) ? '' : '|')}}

									@endforeach
								</span><br>
								<span>Total de sabores: <strong>{{count($i->sabores)}}</strong></span>
								@endif
								<br>
							</p>
							<!-- <p>Total: R$ {{number_format($total, 2, ',', '.')}}</p> -->
							

						</div>

						<div class="col-sm">
							@if(count($i->sabores) > 0)
							<?php 
							$maiorValor = 0; 

							foreach($i->sabores as $it){
								$v = $it->maiorValor($it->produto->id, $i->tamanho_id);
								if($v > $maiorValor) $maiorValor = $v;
							}

							$total += $maiorValor * $i->quantidade;
							?>

							@endif
							<label data-th="Price">R$ {{number_format($total, 2, ',', '.')}}</label>

						</div>
						<div class="col-sm">

							<label>Quantidade</label><br>
							<input disabled="" style="width: 80px;" class="form-control" type="text" value="{{(int)$i->quantidade}}" id="qtd_item_{{$i->id}}">

						</div>

					</div>
					<br>
					<?php $geral += $total; ?>
					@endforeach
					<div class="row">
						<div class="container">


							<h3>Total: R$ <strong class="text-danger">R$ {{number_format($p->valor_total, 2, ',', '.')}}</strong></h3>
							<h4>Estado: 
								@if($p->estado == 'nv')
								<strong class="text-primary">Novo Pedido</strong>
								@elseif($p->estado == 'ap')
								<strong class="text-primary">Pedido Aprovado</strong>
								@elseif($p->estado == 'rp')
								<strong class="text-danger">Pedido Reprovado</strong>
								@elseif($p->estado == 'rc')
								<strong class="text-warning">Pedido Recusado</strong>

								@else
								<strong class="text-info">Pedido Finalizado</strong>

								@endif
							</h4>

							@if($p->endereco)
							<h4>Endereço: <strong>{{$p->endereco->rua}}, {{$p->endereco->numero}} - {{$p->endereco->bairro}}</strong></h4>
							<h4>Referência: <strong>{{$p->endereco->referencia}}</strong></h4>
							@else
							<h4>Retirar no Balcao</h4>
							@endif

							<h4>Forma de pagamento: <strong>
								
								@if($p->forma_pagamento == 'credito')
								Cartão de crédito
								@elseif($p->forma_pagamento == 'debito')
								Cartão de débito
								@else
								Dinheiro
								@endif
							</strong></h4>


							@if($p->estado != 'nv')
							<a href="/carrinho/pedir_novamente/{{$p->id}}" class="btn btn-success">Pedir Novamente</a>
							@endif

							@if($p->estado == 'nv' || $p->estado == 'ap')
							<div class="card">
								<div class="container">
									<h4>Tempo médio para entrega: <strong>{{$config->tempo_medio_entrega}}</strong></h4>
								</div>
							</div>
							@endif

							<br><br>
						</div>
					</div>
				</div>

			</div>
		</div>
		@endforeach
	</div>
</section>

@endsection	
