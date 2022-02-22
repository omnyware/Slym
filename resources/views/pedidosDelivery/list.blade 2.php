@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">


			<form method="get" action="/pedidosDelivery/filtro">
				<div class="row align-items-center">


					<div class="form-group col-lg-3 col-md-4 col-sm-6">
						<label class="col-form-label">Data Inicial</label>
						<div class="">
							<div class="input-group date">
								<input type="text" name="data_inicial" class="form-control" readonly value="{{{isset($dataInicial) ? $dataInicial : ''}}}" id="kt_datepicker_3" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group col-lg-3 col-md-4 col-sm-6">
						<label class="col-form-label">Data Final</label>
						<div class="">
							<div class="input-group date">
								<input type="text" name="data_final" class="form-control" readonly value="{{{isset($dataFinal) ? $dataFinal : ''}}}" id="kt_datepicker_3" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

					

					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button style="margin-top: 15px;" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
					</div>
				</div>
			</form>
			<br>
			<h2>{{$tipo}}</h2>
			<h4>Total de Pedidos: <strong class="text-info">
				{{
					count($pedidosNovo) + count($pedidosAprovado) +
					count($pedidosRecusado) + count($pedidosReprovaco) + 
					count($pedidosFinalizado)

				}}
			</strong></h4>



			<div class="col-lg-12 col-xl-12">
				<div class="row">

					<div class="col-lg-6 col-xl-4 col-sm-6 col-md-6 col-12">
						<span style="width: 100%; margin-top: 5px;" class="label label-xl label-inline label-light-primary">Valor de Pedidos Novos: R$ {{number_format($somaNovos, 2, ',', '.')}}</span>
					</div>
					<div class="col-lg-6 col-xl-4 col-sm-6 col-md-6 col-12">
						<span style="width: 100%; margin-top: 5px;" class="label label-xl label-inline label-light-success">Valor de Pedidos Aprovados: R$ {{number_format($somaAprovados, 2, ',', '.')}}</span>
					</div>
					<div class="col-lg-6 col-xl-4 col-sm-6 col-md-6 col-12">
						<span style="width: 100%; margin-top: 5px;" class="label label-xl label-inline label-light-warning">Valor de Pedidos Recusados: R$ {{number_format($somaRecusados, 2, ',', '.')}}</span>
					</div>
					<div class="col-lg-6 col-xl-4 col-sm-6 col-md-6 col-12">
						<span style="width: 100%; margin-top: 5px;" class="label label-xl label-inline label-light-danger">Valor de Pedidos Reprovados: R$ {{number_format($somaReprovados, 2, ',', '.')}}</span>
					</div>
					<div class="col-lg-6 col-xl-4 col-sm-6 col-md-6 col-12">
						<span style="width: 100%; margin-top: 5px;" class="label label-xl label-inline label-light-info">Valor de Pedidos Finalizados: R$ {{number_format($somaFinalizados, 2, ',', '.')}}</span>
					</div>
					<div class="col-lg-6 col-xl-4 col-sm-6 col-md-6 col-12">
						<span style="width: 100%; margin-top: 5px;" class="label label-xl label-inline label-light-dark">Carrinho: R$ {{number_format($carrinho, 2, ',', '.')}}</span>
					</div>

				</div>

			</div>
			<br>


			<div class="col-lg-12 col-xl-12">
				<div class="accordion accordion-toggle-arrow" id="accordionExample1">
					<div class="card">
						<div class="card-header">
							<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOne1">
								Pedidos Novos <i class="la la-angle-double-down"></i>
							</div>
						</div>
						<div id="collapseOne1" class="collapse" data-parent="#accordionExample1">
							<div class="card-body">
								@if(count($pedidosNovo) > 0)
								@foreach($pedidosNovo as $p)

								<a style="margin-top: 5px;" href="/pedidosDelivery/verPedido/{{$p->id}}" class="btn btn-primary">
									Pedido N: {{$p->id}}, Cliente: {{$p->cliente->nome}}, Valor do pedido R$ 
									{{number_format($p->somaItens(), 2, ',', '.')}}, 
									Horario: {{ \Carbon\Carbon::parse($p->data_registro)->format('H:i:s')}}
								</a>
								@endforeach
								@else
								<h5>Nenhum pedido neste estado!</h5>
								@endif
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header">
							<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo1">
								Pedidos Aprovados <i class="la la-angle-double-down"></i>
							</div>
						</div>
						<div id="collapseTwo1" class="collapse" data-parent="#accordionExample1">
							<div class="card-body">
								@if(count($pedidosAprovado) > 0)
								@foreach($pedidosAprovado as $p)

								<a style="margin-top: 5px;" href="/pedidosDelivery/verPedido/{{$p->id}}" class="btn btn-light-success">
									Pedido N: {{$p->id}}, Cliente: {{$p->cliente->nome}}, Valor R$ 
									{{number_format($p->somaItens(), 2, ',', '.')}}, 
									Horario: {{ \Carbon\Carbon::parse($p->data_registro)->format('H:i:s')}}
								</a>

								@endforeach
								@else
								<h5>Nenhum pedido neste estado!</h5>
								@endif
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header">
							<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree1">
								Pedidos Recusados <i class="la la-angle-double-down"></i>
							</div>
						</div>
						<div id="collapseThree1" class="collapse" data-parent="#accordionExample1">
							<div class="card-body">
								@if(count($pedidosRecusado) > 0)
								@foreach($pedidosRecusado as $p)

								<a style="margin-top: 5px;" href="/pedidosDelivery/verPedido/{{$p->id}}" class="btn btn-light-warning">
									Pedido N: {{$p->id}}, Cliente: {{$p->cliente->nome}}, Valor R$ 
									{{number_format($p->somaItens(), 2, ',', '.')}}, 
									Horario: {{ \Carbon\Carbon::parse($p->data_registro)->format('H:i:s')}}
								</a>

								@endforeach
								@else
								<h5>Nenhum pedido neste estado!</h5>
								@endif
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header">
							<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseFour1">
								Pedidos Reprovados <i class="la la-angle-double-down"></i>
							</div>
						</div>
						<div id="collapseFour1" class="collapse" data-parent="#accordionExample1">
							<div class="card-body">
								@if(count($pedidosReprovaco) > 0)
								@foreach($pedidosReprovaco as $p)
								<a style="margin-top: 5px;" href="/pedidosDelivery/verPedido/{{$p->id}}" class="btn btn-light-danger">
									Pedido N: {{$p->id}}, Cliente: {{$p->cliente->nome}}, Valor R$ 
									{{number_format($p->somaItens(), 2, ',', '.')}}, 
									Horario: {{ \Carbon\Carbon::parse($p->data_registro)->format('H:i:s')}}
								</a>

								@endforeach
								@else
								<h5>Nenhum pedido neste estado!</h5>
								@endif
							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-header">
							<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseFive1">
								Pedidos Finalizados <i class="la la-angle-double-down"></i>
							</div>
						</div>
						<div id="collapseFive1" class="collapse" data-parent="#accordionExample1">
							<div class="card-body">
								@if(count($pedidosFinalizado) > 0)
								@foreach($pedidosFinalizado as $p)
								<a style="margin-top: 5px;" href="/pedidosDelivery/verPedido/{{$p->id}}" class="btn btn-light-info">
									Pedido N: {{$p->id}}, Cliente: {{$p->cliente->nome}}, Valor R$ 
									{{number_format($p->somaItens(), 2, ',', '.')}}, 
									Horario: {{ \Carbon\Carbon::parse($p->data_registro)->format('H:i:s')}}
								</a>

								@endforeach
								@else
								<h5>Nenhum pedido neste estado!</h5>
								@endif
							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-header">
							<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseSix1">
								Pedidos do Carrinho/A Finalizar <i class="la la-angle-double-down"></i>
							</div>
						</div>
						<div id="collapseSix1" class="collapse" data-parent="#accordionExample1">
							<div class="card-body">
								@if(!empty($carrinho))
								<a href="/pedidosDelivery/verCarrinhos" class="btn btn-dark">
									Ver carrinhos em aberto
								</a>
								@else
								<h5>Nenhum carrinho em aberto!</h5>
								@endif
							</div>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
</div>

@endsection	