@extends('default.layout')
@section('content')
<div class="card card-custom gutter-b">
	<div class="card-body">


		<h3>Comanda: <strong class="text-danger">{{$pedido->comanda}}</strong></h3>
		@if($pedido->mesa_id != NULL)
		<h3>Mesa: <strong class="text-danger">{{$pedido->mesa->nome}}</strong></h3>
		@else
		<h3>Mesa: <strong class="text-danger">Avulsa</strong></h3>
		@endif
		<input type="hidden" id="DIVISAO_VALOR_PIZZA" value="{{getenv('DIVISAO_VALOR_PIZZA')}}" name="">
		@if($pedido->observacao != '')
		<h5>Observação: <strong class="text-info">{{$pedido->observacao}}</strong></h5>
		@endif

		<input type="hidden" id="produtos" value="{{json_encode($produtos)}}" name="">
		<input type="hidden" id="adicionais" value="{{json_encode($adicionais)}}" name="">
		<input type="hidden" id="pizzas" value="{{json_encode($pizzas)}}" name="">

		<div class="card card-custom gutter-b">
			<div class="card-body">

				<form method="post" action="/pedidos/saveItem">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" id="pedido_id" name="id" value="{{$pedido->id}}">
					<br>

					<div class="row align-items-center">
						<div class="form-group validated col-sm-6 col-lg-5 col-12">
							<label class="col-form-label" id="">Produto</label><br>
							<select class="form-control select2" style="width: 100%" id="kt_select2_1" name="produto">
								<option value="null">Selecione o produto</option>
								@foreach($produtos as $p)
								<option value="{{$p->id}}">{{$p->id}} - {{$p->nome}}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group validated col-sm-3 col-lg-3 col-6">
							<div style="display: block;" id="tamanhos-pizza">
								<label class="col-form-label" id="">Tamanho de Pizza</label>
								<select class="custom-select form-control" id="seleciona_tamanho" name="seleciona_tamanho">
									@foreach($tamanhos as $t)
									<option value="{{$t->id}}">{{$t->nome}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group validated col-sm-3 col-lg-3 col-6">
							<div style="display: block;" id="sabores-pizza">
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
						<input type="hidden" name="sabores_escolhidos" id="sabores_escolhidos">
						<input type="hidden" name="adicioanis_escolhidos" id="adicioanis_escolhidos">
					</div>
					
					<div id="sabores-html" style="display: none;">
						<div class="row">

						</div>
					</div>


					<div class="row align-items-center">
						<div class="form-group validated col-sm-5 col-lg-5 col-12">
							<label class="col-form-label" id="">Adicionais</label><br>
							<select class="form-control select2" style="width: 100%" id="kt_select2_2">
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
							<button style="margin-top: 12px;" value="0" type="submit" class="btn btn-success">
								<i class="la la-plus"></i> Adicionar
							</button>
						</div>
					</div>


				</form>
			</div>
		</div>
		<div class="card card-custom gutter-b">
			<div class="card-body">

				@if(sizeof($pedido->itens) > 0)

				<a href="/pedidos/imprimirPedido/{{$pedido->id}}" target="_blank" class="btn btn-primary">
					<i class="la la-print"></i>
					Imprimir pedido
				</a>

				<a onclick="imprimirItens()" target="_blank" class="btn btn-danger">
					<i class="la la-print"></i>
					Imprimir itens
				</a>
				@endif

				<div class="row">
					<div class="col-xl-12">
						<br>
						<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

							<table class="datatable-table" style="max-width: 100%; overflow: scroll">
								<thead class="datatable-head">
									<tr class="datatable-row" style="left: 0px;">
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 60px;">#</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Produto</span></th>
										<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Tamanho Pizza</span></th>
										<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Sabores</span></th>
										<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Adicionais</span></th>

										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Status</span></th>

										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>
										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Quantidade</span></th>
										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Subtotal+adicional</span></th>
										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Observação</span></th>
										<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 180px;">Ações</span></th>
									</tr>
								</thead>
								<?php $finalizado = 0; $pendente = 0; ?>
								<tbody id="body" class="datatable-body">
									@foreach($pedido->itens as $i)
									<tr class="datatable-row" @if($i->status) style="background: #64ffda" @endif>
										<?php $temp = $i; ?>
										<td id="checkbox">

											<p style="width: 70px;">
												<input type="checkbox" class="check" @if($i->impresso == 0) checked @endif id="item_{{$i->id}}"/>
												<label for="item{{$i->id}}"></label>
											</p>
										</td>
										<td style="display: none" id="item_id">{{$i->id}}</td>

										<td class="datatable-cell"><span class="codigo" style="width: 200px;">{{$i->produto->nome}}</span>
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
										$valorVenda = $i->valor;
										?>

										<td class="datatable-cell">
											<span style="width: 100px;">
												{{number_format($valorVenda, 2, ',', '.')}}
											</span>
										</td>

										<td class="datatable-cell">
											<span style="width: 100px;">
												{{$temp->quantidade}}
											</span>
										</td>

										<td class="datatable-cell">
											<span style="width: 100px;">
												{{number_format((($valorVenda * $i->quantidade) + $somaAdicionais), 2, ',', '.')}}
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

												<a onclick='swal("Atenção!", "Deseja excluir este registro?", "warning").then((sim) => {if(sim){ location.href="/pedidos/deleteItem/{{$i->id}}" }else{return false} })' href="#!" class="btn btn-danger">
													<i class="la la-trash"></i>				
												</a>
												@if(!$i->status)
												<a href="/pedidos/alterarStatus/{{$i->id}}" class="btn btn-success">
													<i class="la la-check"></i>
												</a>
												@endif

											</span>
										</td>

									</tr>

									<?php 
									if($i->status) $finalizado++;
									else $pendente++;
									?>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>


			</div>
		</div>
		<div class="card card-custom gutter-b">
			<div class="card-body">

				<div class="row align-items-center">
					<div class="form-group col-lg-4 col-md-4 col-sm-6">
						<label class="col-form-label">Selecione o Bairro (Opcional)</label>
						<div class="">
							<div class="input-group date">
								<select class="custom-select form-control" id="bairro" name="bairro">
									<option value="0">Selecione o Bairro</option>
									@foreach($bairros as $b)
									<option @if($pedido->bairro_id == $b->id) selected @endif value="{{$b->id}}">{{$b->nome}} - R$ {{$b->valor_entrega}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2">
						<a style="margin-top: 13px;" href="#modal-endereco" data-toggle="modal" data-target="#modal-endereco" class="btn btn-info">
							<i class="la la-map"></i>
						</a>
					</div>
				</div>

				<div class="row">
					@if($pedido->rua != '')
					<div class="form-group col-lg-12 col-md-12 col-sm-12">
						<h5>Nome: <strong class="text-success">{{$pedido->nome}}</strong></h5>
						<h5>Rua: <strong class="text-success">{{$pedido->rua}}, {{$pedido->numero}}</strong>, Telefone: <strong class="text-success">{{$pedido->telefone}}</strong></h5>
						<h5>Refêrencia: <strong class="text-success">{{$pedido->referencia}}</strong></h5>
					</div>
					@endif
				</div>

				<div class="row">
					<div class="form-group col-lg-12 col-md-12 col-sm-12">
						<h3>TOTAL PRODUTOS: <strong class="text-info">{{number_format($pedido->somaItems(), 2, ',', '.')}}</strong></h3>
						@if($pedido->bairro_id != null)
						<h3>ENTREGA: <strong class="text-info">{{number_format($pedido->bairro->valor_entrega, 2, ',', '.')}}</strong></h3>
						<h2>TOTAL GERAL: <strong class="text-danger">{{number_format($pedido->somaItems() + $pedido->bairro->valor_entrega, 2, ',', '.')}}</strong></h2>
						@endif

						<h3>ITENS FINALIZADOS: <strong class="text-success">{{$finalizado}}</strong></h3>
						<h3>ITENS PENDENTES: <strong class="text-warning">{{$pendente}}</strong></h3>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4">
						<a style="width: 100%;" class="btn btn-ls btn-success @if($pendente > 0 || $pedido->status) disabled @endif green accent-4" href="/pedidos/finalizar/{{$pedido->id}}">
							<i class="la la-check"></i>
						Finalizar Pedido</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal-endereco" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<form method="get" action="/pedidos/setarEndereco">

		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">ENDEREÇO</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						x
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="pedido_id" value="{{$pedido->id}}">
					<div class="row">
						<div class="form-group validated col-sm-8 col-lg-8">
							<label class="col-form-label" id="">Nome</label>
							<div class="">
								<input type="text" id="nome" name="nome" value="{{$pedido->nome}}" class="form-control">
							</div>
						</div>
						<div class="form-group validated col-sm-8 col-lg-8">
							<label class="col-form-label" id="">Rua</label>
							<div class="">
								<input type="text" id="nome" name="rua" value="{{$pedido->rua}}" class="form-control">
							</div>
						</div>
						<div class="form-group validated col-sm-2 col-lg-2">
							<label class="col-form-label" id="">Número</label>
							<div class="">
								<input type="text" id="numero" name="numero" class="form-control" value="{{$pedido->numero}}">
							</div>
						</div>

						<div class="form-group validated col-sm-4 col-lg-4">
							<label class="col-form-label" id="">Referência</label>
							<div class="">
								<input type="text" id="referencia" name="referencia" class="form-control" value="{{$pedido->referencia}}">
							</div>
						</div>

						<div class="form-group validated col-sm-4 col-lg-4">
							<label class="col-form-label" id="">Telefone</label>
							<div class="">
								<input type="text" id="telefone" name="telefone" class="form-control" value="{{$pedido->telefone}}">
							</div>
						</div>

					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
					<button type="submit" id="btn-inut-2" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Salvar</button>
				</div>
			</div>
		</div>
	</form>
</div>

@endsection	