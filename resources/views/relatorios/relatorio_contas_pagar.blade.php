@extends('relatorios.cabecalho')
@section('content')

<div class="row">
	<div class="col s12">
		<h3 >Relátorio de Contas a pagar</h3>
		@if($data_inicial && $data_final)
		<h4>Periodo: {{$data_inicial}} - {{$data_final}}</h4>
		@endif
	</div>

	<table class="pure-table">
		<thead>
			<tr>

				<th width="110">VALOR</th>
				<th width="110">FORNECEDOR</th>
				<th width="60">DATA DE CADASTRO</th>
				<th width="60">DATA DE VENCIMENTO</th>
				<th width="60">ESTADO</th>
			</tr>
		</thead>

		<tbody>
			<?php $somaContas = 0; ?>
			@foreach($contas as $key => $c)
			<tr class="@if($key%2 == 0) pure-table-odd @endif">

				<td>{{ $c->valor_integral}}</td>
				<td>{{ $c->fornecedor ? $c->fornecedor->razao_social : '-'}}</td>
				<td>{{ \Carbon\Carbon::parse($c->created_at)->format('d/m/Y')}}</td>
				<td>{{ \Carbon\Carbon::parse($c->vencimento)->format('d/m/Y')}}</td>
				<td>
					@if($c->status)
					<span class="text-success">Pago</span>
					@else
					<span class="text-danger">Pendente</span>
					@endif
				</td>


			</tr>

			<?php $somaContas += $c->valor_integral; ?>
			@endforeach
		</tbody>
	</table>
	<h4 class="soma">Soma total: <strong class="text-success">R$ {{number_format($somaContas, 2, ',', '.')}}</strong></h4>


</div>
@endsection

