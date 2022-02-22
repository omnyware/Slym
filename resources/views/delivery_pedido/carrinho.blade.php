@extends('delivery_pedido.default')
@section('content')

@if(session()->has('message_sucesso'))
<div class="p-3 mb-2 bg-success text-white">{{ session()->get('message_sucesso') }}</div>
@endif
<div class="clearfix"></div>

<br><br>

<div class="col-lg-12 col-md-12">
	<div class="card border-0 med-blog">
		<div class="card-header p-0">
			<div class="container">
				<h2 class="">ITENS DA MESA</h2>
			</div>
		</div>
		<div class="card-body border border-top-0">
			<?php $geral = 0; ?>


			<div class="row">
				<table id="cart" class="table table-hover table-condensed">
					<thead>
						<tr>
							<th style="width:50%">Produto</th>
							<th style="width:10%">Valor</th>
							<th style="width:8%">Quantidade</th>
							<th style="width:22%" class="text-center">Subtotal</th>
							<th style="width:10%"></th>
						</tr>
					</thead>
					<tbody>
						@if($pedido)
						@foreach($pedido->itens as $i)

						<tr>
							<td data-th="Produto">
								<div class="row">
									<div class="col-sm-3 hidden-xs">
										@if(isset($i->produto->galeria[0]))
										<img src="/imagens_produtos/{{$i->produto->galeria[0]->path}}" alt="..." class="img-responsive mini"/>
										@else
										<img src="/imgs/no_image.png" alt="..." class="img-responsive mini"/>
										@endif
									</div>
									<div class="col-sm-9">
										<h4 class="nomargin">{{$i->produto->nome}}</h4>
										<p>
											<?php $total = $i->valor * $i->quantidade; ?>


											<span>Adicionais: 
												@if(count($i->itensAdicionais)>0)
												@foreach($i->itensAdicionais as $a)
												<strong>{{$a->adicional->nome()}}</strong>
												<?php  $total += $i->quantidade * $a->adicional->valor ?>
												@endforeach
												@else
												<label>Nenhum adicional</label>
												@endif
											</span>

											@if($i->observacao != '')
											<br>
											<span>Observação: {{$i->observacao}}
											</span>
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
											<span>| Tamanho <strong>{{$i->tamanho->nome}}</strong></span>
											@endif
											<br>

											

										</p>
									</div>
								</div>
							</td>
							@if(count($i->sabores) > 0)
							<?php 
								$maiorValor = 0; 
								$somaValores = 0;
								foreach($i->sabores as $it){
									$v = $it->maiorValor($it->produto->id, $i->tamanho_id);
									$somaValores += $v;
									if($v > $maiorValor) $maiorValor = $v;
								}


								if(getenv("DIVISAO_VALOR_PIZZA") == 1){
									$maiorValor = $somaValores/sizeof($i->sabores);
								}

								foreach($i->itensAdicionais as $a){
									$maiorValor += $a->adicional->valor;
								}
								$total = number_format($maiorValor * $i->quantidade, 2);
							?>
								<td data-th="Preço">R${{number_format($maiorValor, 2)}}</td>

							@else
							<td data-th="Preço">R${{number_format($total, 2)}}</td>
							@endif
							<td data-th="Quantidade">
								<input readonly id="qtd_item_{{$i->id}}" type="number" class="qtd form-control text-center" value="{{(int)$i->quantidade}}">
							</td>


							<td data-th="Subtotal" class="text-center">R${{number_format($total, 2, ',', '.')}}</td>
							<!-- <td class="actions" >
								<button onclick="refresh({{$i->id}})" class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></button>
								<button onclick="removeItem({{$i->id}})" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>								
							</td> -->
						</tr>
						<?php $geral += $total; ?>
						@endforeach
						@else
						<div class="container">
							<p class="text-center">Nenhum item no seu carrinho
								<a href="/cardapio" class="btn btn-primary">
									<span class="fa fa-bars"></span> Cardápio
								</a></p>
								<br>
							</div>
							@endif
						</tbody>
						<tfoot>
							<tr class="visible-xs">
								<td class="text-center"><strong>Total {{number_format($geral, 2, ',', '.')}}</strong></td>
							</tr>

						</tfoot>
					</table>
				</div>

				@if(sizeof($pedido->itens) == 0)
				<a href="/pedido" type="button" class="btn btn-primary btn-lg btn-block">
					<span class="fa fa-bars mr-2"></span>CARDÁPIO</strong>
				</a>
				@endif

				@if($pedido)
				<a onclick='swal("Atenção!", "Deseja finalizar esta mesa? não irá pedir mais nada?", "warning").then((sim) => {if(sim){ location.href="/pedido/finalizar" }else{return false} })' type="button" href="#!" class="btn btn-success btn-lg btn-block @if(sizeof($pedido->itens) == 0) disabled @endif">
					<span class="fa fa-check mr-2"></span> FINALIZAR
					<strong>R$ {{number_format($geral, 2, ',', '.')}}</strong>
				</a>
				<!-- <a href="/cardapio" style="font-size: 15px; color: #fff" type="button" class="btn btn-warning btn-lg btn-block">
					<span class="fa fa-bars mr-2"></span>CONTINUAR COMPRANDO
				</a> -->
				@else
				<a href="/pedido" type="button" class="btn btn-primary btn-lg btn-block">
					<span class="fa fa-bars mr-2"></span>CARDÁPIO</strong>
				</a>
				@endif
			</div>
		</div>
	</div>
	<br>

@endsection	
