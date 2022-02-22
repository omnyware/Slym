@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">
		<div class="row">

			@foreach($pedidos as $p)
			<div class="col-sm-4 col-lg-4 col-md-6">

				<div class="card card-custom gutter-b @if($p->status) green lighten-4 @endif">

					<div class="card-body" style="height: 200px;">

						<h4>Cliente: <strong class="text-info">{{$p->cliente->nome}}</strong></h4>
						<h4>Itens do Pedido: <strong class="text-danger">{{count($p->itens)}}</strong></h4>
						<h4>Soma parcial: <strong class="text-danger">{{number_format($p->somaItens(), 2)}}</strong></h4>

					</div>

					<div class="card-footer">
						<a class="btn btn-danger" style="width: 100%;" 
						onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/pedidosDelivery/removerCarrinho/{{ $p->id }}" }else{return false} })' href="#!"><i class="la la-times"></i> Remover</a>
						<a href="/pedidosDelivery/verCarrinho/{{$p->id}}" style="width: 100%; margin-top: 5px;" class="btn btn-info">
							<i class="la la-list"></i>Visualizar
						</a>

					</div>

				</div>


			</div>

			@endforeach

		</div>
	</div>
</div>

@endsection	