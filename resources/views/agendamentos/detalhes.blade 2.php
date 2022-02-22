@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">
	<div class="card-body">
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<h3>Agendamento <strong>{{$agendamento->id}}</strong></h3>
			<h3>Cliente: <strong class="text-info">{{$agendamento->cliente->razao_social}} - {{$agendamento->cliente->telefone}}</strong></h3>

			<h3>Atendente: <strong class="text-info">{{$agendamento->funcionario->nome}}</strong></h3>
			<h3>Total: <strong class="text-info">{{$agendamento->total}}</strong></h3>
			@if($agendamento->desconto > 0)
			<h3>Desconto: <strong class="text-danger">{{$agendamento->desconto}}</strong></h3>
			@endif
			@if($agendamento->acrescimo > 0)
			<h3>Acrescimo: <strong class="text-danger">{{$agendamento->acrescimo}}</strong></h3>
			@endif

			@if($agendamento->observacao != '')
			<h3>Observação: <strong class="text-danger">{{$agendamento->observacao}}</strong></h3>
			@endif

			<div class="row">
				<div class="col-sm-6 col-lg-6 col-12">
					<div class="card card-custom gutter-b">
						<div class="card-body">
							<h4>Data: <strong class="text-primary">{{ \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y')}}</strong></h4>
							<h4>Início: <strong class="text-success">{{ $agendamento->inicio}} </strong></h4>
							<h4>Término: <strong class="text-danger">{{ $agendamento->termino}} </strong></h4>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-lg-6 col-12">
					<div class="card card-custom gutter-b">
						<div class="card-body">
							<h4>Serviços: </h4>

							@foreach($agendamento->itens as $s)
							<p>{{$s->servico->nome}} x R$ {{$s->servico->valor}}</p>
							@endforeach
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<a class="btn btn-danger" onclick='swal("Atenção!", "Deseja remover este registro?", "warning").then((sim) => {if(sim){ location.href="/agendamentos/delete/{{ $agendamento->id }}" }else{return false} })' href="#!">
					Remover agendamento			
				</a>

				<a style="margin-left: 10px;" class="btn btn-success" onclick='swal("Atenção!", "Deseja ir para frente de caixa?", "warning").then((sim) => {if(sim){ location.href="/agendamentos/irParaFrenteCaixa/{{ $agendamento->id }}" }else{return false} })' href="#!">
					Ir Para frente de caixa			
				</a>

				<a style="margin-left: 10px;" class="btn btn-warning" onclick='swal("Atenção!", "Deseja alterar para finalizado?", "warning").then((sim) => {if(sim){ location.href="/agendamentos/alterarStatus/{{ $agendamento->id }}" }else{return false} })' href="#!">
					Alterar para finalizado		
				</a>
			</div>

		</div>
	</div>
</div>

@endsection	