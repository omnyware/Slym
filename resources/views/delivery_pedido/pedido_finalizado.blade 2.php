@extends('delivery_pedido.default')
@section('content')

@if(session()->has('message_sucesso'))
<div class="p-3 mb-2 bg-success text-white">{{ session()->get('message_sucesso') }}</div>
@endif
<div class="clearfix"></div>

<br><br>

<div class="col-lg-12 col-md-12">
	<div class="card border-0 med-blog">

		<div class="row">
			<div class="container">
				<h2 class="text-success">Obrigado pela confiança, se diriga até o caixa<i class="fa fa-check"></i></h2>


					<h4 class="text-center"><strong>Total pedido = <span style="color: red">R$ {{number_format($pedido->somaItems(), 2, ',', '.')}}</span></strong></h4>

					<h4 class="text-center"><strong>Abertura da mesa: <span style="color: blue">{{ \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y H:i')}}</span></strong></h4>
					<h4 class="text-center"><strong>FEchamento da mesa: <span style="color: blue">{{ \Carbon\Carbon::parse($pedido->updated_at)->format('d/m/Y H:i')}}</span></strong></h4>

			</div>
		</div>

		
	</div>
</div>

<br>


@endsection	
