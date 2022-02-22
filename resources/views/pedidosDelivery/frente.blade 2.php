@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="card-body">

		<h2>Frente de Pedido de Delivery</h2>
		<input type="hidden" id="clientes" value="{{json_encode($clientes)}}" name="">
		<input type="hidden" value="{{getenv('DIVISAO_VALOR_PIZZA')}}" id="DIVISAO_VALOR_PIZZA">

		<div class="row align-items-center">
			@if(!isset($pedido)) 
			<div class="col-12">
				<p class="text-danger">Informe o cliente primeiramente!!</p>
			</div>
			@endif
			@if(!isset($pedido))
			<div class="form-group validated col-sm-5 col-lg-5 col-10">
				<label class="col-form-label" id="">Cliente</label><br>
				<select class="form-control select2" style="width: 100%" id="kt_select2_3" name="cliente">
					<option value="null">Selecione o cliente</option>
					@foreach($clientes as $c)
					<option value="{{$c->id}}">{{$c->id}} - {{$c->nome}} ({{$c->celular}})</option>
					@endforeach
				</select>
			</div>

			<div class="col-sm-1 col-lg-1 col-2">
				<!-- Modal add cliente -->
				<a style="margin-top: 12px;" href="#" data-toggle="modal" data-target="#modal-cliente" class="btn btn-icon btn-circle btn-success">
					<i class="la la-plus"></i>
				</a>
			</div>
			@else
			<div class="form-group validated col-sm-5 col-lg-5 col-10"><br>
				<h5>Cliente: <strong class="text-info">{{$pedido->cliente->nome}} {{$pedido->cliente->sobre_nome}}</strong></h5>
				<h5>Celular: <strong class="text-info">{{$pedido->cliente->celular}}</strong></h5>
			</div>
			@endif

			<div class="form-group validated col-sm-4 col-lg-4 col-10">
				<label class="col-form-label" id="">Endereço</label><br>
				<select class="form-control custom-select" @if(!isset($pedido)) disabled @endif id="endereco" style="width: 100%" name="cliente">
					<option value="NULL">Balcão</option>
					@if(isset($pedido))
					@foreach($pedido->cliente->enderecos as $e)
					<option value="{{$e->id}}"
						@if(isset($pedido))
						@if($pedido->endereco_id == $e->id)
						selected
						@endif
						@endif
						>{{$e->rua}}, {{$e->numero}} - {{$e->bairro()}}
					</option>
					@endforeach
					@endif
				</select>
			</div>
			<div class="col-sm-1 col-lg-1 col-2">
				<!-- Modal add cliente -->
				<a data-toggle="modal" data-target="#modal-endereco" style="margin-top: 12px;" href="#" class="btn btn-icon btn-circle btn-info @if(!isset($pedido)) disabled @endif">
					<i class="la la-plus"></i>
				</a>
			</div>
		</div>


		<!-- Item -->

		<div class="card card-custom gutter-b">
			<div class="card-body">

				<form class="col s12" method="post" action="/pedidosDelivery/saveItemCaixa">
					<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" id="pedido_id" name="pedido_id" value="{{{ isset($pedido) ? $pedido->id : 0 }}}">

					<input type="hidden" id="pedido_id" name="id" value="{{{ isset($pedido) ? $pedido->id : 0 }}}">
					<input type="hidden" id="produtos" value="{{json_encode($produtos)}}" name="">
					<input type="hidden" id="adicionais" value="{{json_encode($adicionais)}}" name="">
					<input type="hidden" id="pizzas" value="{{json_encode($pizzas)}}" name="">
					<br>

					<div class="row align-items-center">
						<div class="form-group validated col-sm-6 col-lg-5 col-12">
							<label class="col-form-label" id="">Produto</label><br>
							<select class="form-control select2" style="width: 100%" @if(!isset($pedido)) disabled @endif id="kt_select2_1" name="produto">
								<option value="null">Selecione o produto</option>
								@foreach($produtos as $p)
								<option value="{{$p->id}}">{{$p->id}} - {{$p->produto->nome}}</option>
								@endforeach
							</select>
						</div>


						<div class="form-group validated col-sm-3 col-lg-3 col-6">
							<div style="display: none;" id="tamanhos-pizza">
								<label class="col-form-label" id="">Tamanho de Pizza</label>
								<select class="custom-select form-control" id="seleciona_tamanho" name="seleciona_tamanho">
									@foreach($tamanhos as $t)
									<option value="{{$t->id}}">{{$t->nome}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group validated col-sm-3 col-lg-3 col-6">
							<div style="display: none;" id="sabores-pizza">
								<label class="col-form-label" id="">Sabores</label>
								<select class="custom-select form-control" id="sabores" name="sabores">
									<option></option>
								</select>
							</div>

						</div>
						<div class="col-sm-1 col-lg-1 col-3" style="display: none;" id="btn-add-sabor">
							<a style="margin-top: 12px;" class="btn btn-light-info">
								<i class="la la-plus"></i>
							</a>
						</div>

						<input type="hidden" name="tamanho_pizza_id" id="tamanho_pizza_id">
						<input type="" name="sabores_escolhidos" id="sabores_escolhidos">
						<input type="hidden" name="adicioanis_escolhidos" id="adicioanis_escolhidos">
					</div>
					
					<div id="sabores-html" style="display: none;">
						<div class="row">

						</div>
					</div>


					<div class="row align-items-center">
						<div class="form-group validated col-sm-5 col-lg-5 col-12">
							<label class="col-form-label" id="">Adicionais</label><br>
							<select class="form-control select2" @if(!isset($pedido)) disabled @endif style="width: 100%" id="kt_select2_2">
								@foreach($adicionais as $a)
								<option value="{{$a->id}}">{{$a->id}} - {{$a->nome}} - R${{$a->valor}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-sm-1 col-lg-1 col-3" id="btn-add-adicional">
							<a style="margin-top: 12px;" class="btn btn-light-info">
								<i class="la la-plus"></i>
							</a>
						</div>

						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-6">
							<label class="col-form-label">Observação</label>
							<div class="">
								<div class="input-group">
									<input type="text" name="observacao" class="form-control" id="observacao"/>
								</div>
							</div>
						</div>
					</div>

					<div id="adicioanais-html" style="display: none;">
						<div class="row">

						</div>
					</div>

					<div class="row align-items-center">

						<div class="form-group col-lg-2 col-md-2 col-sm-6 col-6">
							<label class="col-form-label">Quantidade</label>
							<div class="">
								<div class="input-group">
									<input type="text" value="1.000" name="quantidade" class="form-control @if($errors->has('quantidade')) is-invalid @endif" id="quantidade"/>
									@if($errors->has('quantidade'))
									<div class="invalid-feedback">
										{{ $errors->first('quantidade') }}
									</div>
									@endif
								</div>
							</div>
						</div>

						<div class="form-group col-lg-2 col-md-2 col-sm-6 col-6">
							<label class="col-form-label">Valor</label>
							<div class="">
								<div class="input-group">
									<input type="text" value="0" name="valor" class="form-control @if($errors->has('valor')) is-invalid @endif" id="valor"/>
									@if($errors->has('valor'))
									<div class="invalid-feedback">
										{{ $errors->first('valor') }}
									</div>
									@endif
								</div>
							</div>
						</div>

						<div class="col-lg-2 col-md-2 col-sm-6 col-6">
							<button style="margin-top: 12px;" value="0" type="submit" class="btn btn-success @if(!isset($pedido)) disabled @endif">
								<i class="la la-plus"></i> Adicionar
							</button>
						</div>
					</div>


				</form>
			</div>
		</div>

		<div class="card card-custom gutter-b">
			<div class="card-body">
				<div class="row">
					<div class="col-xl-12">
						<br>
						<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

							<table class="datatable-table" style="max-width: 100%; overflow: scroll">
								<thead class="datatable-head">
									<tr class="datatable-row" style="left: 0px;">

										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Produto</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Tamanho Pizza</span></th>
										<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Sabores</span></th>
										<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Adicionais</span></th>

										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Status</span></th>

										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Quantidade</span></th>
										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Subtotal+adicional</span></th>
										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Observação</span></th>
										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 180px;">Ações</span></th>
									</tr>
								</thead>
								<?php $finalizado = 0; $pendente = 0; ?>
								<?php $soma = 0; ?>
								@if(isset($pedido))
								<tbody id="body" class="datatable-body">
									@foreach($pedido->itens as $i)
									<tr class="datatable-row" @if($i->status) style="background: #64ffda" @endif>
										<?php $temp = $i; ?>
										
										<td style="display: none" id="item_id">{{$i->id}}</td>

										<td class="datatable-cell">
											<span class="codigo" style="width: 200px;">
												{{$i->produto->produto->nome}}
											</span>
										</td>
										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												@if(!empty($i->tamanho))
												<label>{{$i->tamanho->nome}}</label>
												@else
												<label>--</label>
												@endif
											</span>
										</td>

										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												@if(count($i->sabores) > 0)
												<label>
													@foreach($i->sabores as $key => $s)
													{{$s->produto->produto->nome}}
													@if($key < count($i->sabores)-1)
													| 
													@endif
													@endforeach
												</label>
												@else
												<label>--</label>
												@endif
											</span>
										</td>

										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												<?php $somaAdicionais = 0; ?>
												@if(count($i->itensAdicionais) > 0)
												<label>
													@foreach($i->itensAdicionais as $key => $a)
													{{$a->adicional->nome()}}
													<?php $somaAdicionais += $a->adicional->valor * $i->quantidade?>
													@if($key < count($i->itensAdicionais)-1)
													| 
													@endif
													@endforeach
												</label>
												@else
												<label>--</label>
												@endif
											</span>
										</td>

										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">
												@if($i->status)
												<span class="label label-xl label-inline label-light-success">OK</span>
												@else
												<span class="label label-xl label-inline label-light-danger">PENDENTE</span>
												@endif
											</span>
										</td>
										<?php 
										$valorVenda = 0;
										$valorVenda = $i->valorProduto();
										?>
										<?php $soma += $i->quantidade * $valorVenda; ?>

										<td class="datatable-cell">
											<span style="width: 100px;">
												{{$temp->quantidade}}
											</span>
										</td>

										<td class="datatable-cell">
											<span style="width: 100px;">
												{{number_format((($valorVenda * $i->quantidade)), 2, ',', '.')}}
											</span>
										</td>


										<td class="datatable-cell">
											<span class="codigo" style="width: 100px;">

												<a href="#!" onclick='swal("", "{{$i->observacao}}", "info")' class="btn btn-light-info @if(!$i->observacao) disabled @endif">
													Ver
												</a>

											</span>
										</td>

										<td class="datatable-cell">
											<span class="codigo" style="width: 180px;">

												<a onclick='swal("Atenção!", "Deseja excluir este registro?", "warning").then((sim) => {if(sim){ location.href="/pedidosDelivery/deleteItem/{{$i->id}}" }else{return false} })' href="#!" class="btn btn-danger">
													<i class="la la-trash"></i>				
												</a>

											</span>
										</td>

									</tr>

									<?php 
									if($i->status) $finalizado++;
									else $pendente++;
									?>
									@endforeach
								</tbody>
								@endif
							</table>
						</div>
					</div>
				</div>

				<h3>TOTAL: <strong class="text-info">R$ {{number_format($soma, 2)}}</strong></h3>
			</div>
		</div>
		@if(isset($pedido))
		<form method="get" action="/pedidosDelivery/frenteComPedidoFinalizar">
			<div class="card card-custom gutter-b">
				<div class="card-body">
					<div class="row align-items-center">
						<div class="form-group validated col-sm-2 col-lg-2 col-6">
							<label class="col-form-label" id="">Taxa de Entrega</label>
							<div class="">
								<input type="text" id="taxa_entrega" name="taxa_entrega" value="{{{ $pedido->endereco_id != NULL ? $valorEntrega : 0 }}}" class="form-control money">
							</div>
						</div>

						<div class="form-group validated col-sm-3 col-lg-3 col-6">
							<label class="col-form-label" id="">Telefone</label>
							<div class="">
								<input type="text" id="telefone" name="telefone" value="{{$pedido->cliente->celular}}" class="form-control">
							</div>
						</div>

						<div class="form-group validated col-sm-3 col-lg-3 col-6">
							<label class="col-form-label" id="">Troco Para</label>
							<div class="">
								<input type="text" id="troco_para" name="troco_para" value="" class="form-control money">
							</div>
						</div>
						<div class="col-sm-3 col-lg-3 col-6">
							<input type="hidden" value="{{$pedido->id}}" name="pedido_id">
							<button style="width: 100%" type="submit" @if(!isset($pedido) || sizeof($pedido->itens) == 0) disabled @endif class="btn btn-lg btn-success">Salvar</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		@endif

	</div>
</div>

<div class="modal fade" id="modal-endereco" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<form method="post" action="/pedidosDelivery/novoEnderecoClienteCaixa">
				@csrf
				<div class="modal-body">
					<div class="row">

						<div class="form-group validated col-sm-8 col-lg-8">
							<label class="col-form-label" id="">Rua</label>
							<div class="">
								<input type="text" id="rua" name="rua" class="form-control" value="">
							</div>
						</div>
						<div class="form-group validated col-sm-2 col-lg-2">
							<label class="col-form-label" id="">Número</label>
							<div class="">
								<input type="text" id="sobre_nome" name="sobre_nome" class="form-control" value="">
							</div>
						</div>
						<div class="form-group validated col-sm-6 col-lg-6">
							<label class="col-form-label" id="">Celular</label>
							<div class="">
								<input type="text" id="celular" name="celular" class="form-control" value="">
							</div>
						</div>

						@if($config->usar_bairros)
						<div class="form-group validated col-sm-6 col-lg-6">
							<label class="col-form-label" id="">Bairro</label>
							<select name="bairro_id" class="custom-select form-control">
								@foreach($bairros as $b)
								<option value="{{$b->id}}">{{$b->nome}} R$ {{$b->valor_entrega}}</option>
								@endforeach
							</select>

						</div>
						@else
						<div class="form-group validated col-sm-6 col-lg-6">
							<label class="col-form-label" id="">Bairro</label>
							<div class="">
								<input type="text" name="bairro" id="bairro" class="form-control">
							</div>
						</div>
						@endif

						<div class="form-group validated col-sm-6 col-lg-6">
							<label class="col-form-label" id="">Referência</label>
							<div class="">
								<input type="password" id="referencia" name="referencia" class="form-control" value="">
							</div>
						</div>

					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
					<button type="submit" id="btn-cancelar-3" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modal-endereco" class="modal">

	<form method="post" action="/pedidosDelivery/novoEnderecoClienteCaixa">
		<div class="modal-content">
			<h4>Novo Endereço</h4>
			<input type="hidden" id="pedido_id" name="pedido_id" value="{{{ isset($pedido) ? $pedido->id : 0 }}}">
			<div class="row">
				@csrf
				<div class="input-field col s8">
					<input type="text" name="rua" id="rua" data-length="50">
					<label>Rua</label>
				</div>
				<div class="input-field col s2">
					<input type="text" name="numero" id="numero" data-length="10">
					<label>Número</label>
				</div>

				@if($config->usar_bairros)
				<div class="input-field col s10">
					<select name="bairro_id">
						@foreach($bairros as $b)
						<option value="{{$b->id}}">{{$b->nome}} R$ {{$b->valor_entrega}}</option>
						@endforeach
					</select>
					<label>Bairro</label>
				</div>
				@else
				<div class="input-field col s10">
					<input type="text" name="bairro" id="bairro" data-length="50">
					<label>Bairro</label>
				</div>
				@endif
			</div>

			<div class="row">
				<div class="input-field col s5">
					<input type="text" name="referencia" id="referencia" data-length="30">
					<label>Referência</label>
				</div>
			</div>

		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close red white-text waves-effect waves-green btn-flat">Fechar</a>
			<button href="#!" class="modal-action waves @if(!isset($pedido)) disabled @endif green accent-3 btn">Salvar</button>
		</div>
	</form>
</div>

<div class="modal fade" id="modal-cliente" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<form method="post" action="/pedidosDelivery/novoClienteDeliveryCaixa">
				@csrf
				<div class="modal-body">
					<div class="row">

						<div class="form-group validated col-sm-6 col-lg-6">
							<label class="col-form-label" id="">Nome</label>
							<div class="">
								<input type="text" id="nome" name="nome" class="form-control" value="">
							</div>
						</div>
						<div class="form-group validated col-sm-6 col-lg-6">
							<label class="col-form-label" id="">Sobre nome</label>
							<div class="">
								<input type="text" id="sobre_nome" name="sobre_nome" class="form-control" value="">
							</div>
						</div>
						<div class="form-group validated col-sm-6 col-lg-6">
							<label class="col-form-label" id="">Celular</label>
							<div class="">
								<input type="text" id="celular" name="celular" class="form-control" value="">
							</div>
						</div>
						<div class="form-group validated col-sm-6 col-lg-6">
							<label class="col-form-label" id="">Senha</label>
							<div class="">
								<input type="password" id="senha" name="senha" class="form-control" value="">
							</div>
						</div>

					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
					<button type="submit" id="btn-cancelar-3" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>


@endsection	
