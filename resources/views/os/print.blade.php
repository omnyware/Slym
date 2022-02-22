@extends('os.print_default')
@section('content')

<div class="row corpo-exame" style="height: 550px;">
	<div class="col s12 center-align">
		<h6 style="text-decoration: underline;"><strong id="nome-exame">OS {{$ordem->id}}</strong></h6>
	</div>
	<div class="col s12">
		<div class="col s12 left-align">
			<h6>Status: @if($ordem->estado == 'pd')
				<strong class="yellow-text">Pendente</strong>
				@elseif($ordem->estado == 'ap')
				<strong class="green-text">Aprovado</strong>
				@elseif($ordem->estado == 'rp')
				<strong class="red-text">Reprovado</strong>
				@else
				<strong class="blue-text">Finalizado</strong>
			@endif</h6>
			<h6>Resposável: {{$ordem->usuario->nome}}</h6>
		</div>
	</div>
	<div class="col s12 center-align">
		<h6 style="text-decoration: underline;"><strong id="nome-exame">SERVIÇOS</strong></h6>
	</div>

	<div class="col s12">
		@foreach($ordem->servicos as $s)
		<div class="col s12 left-align">
			<h5>{{$s->servico->nome}}</h5>
			<p>{{$s->quantidade}} x R$ {{number_format($s->servico->valor, 2)}}{{$s->servico->unidade_cobranca}} = 
				R$ {{number_format($s->servico->valor * $s->quantidade, 2)}}</p>
		</div>
		@endforeach
	</div>
</div>
@endsection
