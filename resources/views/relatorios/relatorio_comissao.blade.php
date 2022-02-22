@extends('relatorios.cabecalho')
@section('content')
<div class="row">
	<div class="col s12">
		<h3 class="center-align">Relátorio de Comissão</h3>
		@if($data_inicial && $data_final)
		<h4>Periodo: {{$data_inicial}} - {{$data_final}}</h4>
		@endif

		@if($funcionario != 'null')
		<h4>Funcionario: <strong>{{$funcionario}}</strong></h4>
		@endif

		@if($produto != 'null')
		<h4>Produto: <strong>{{$produto}}</strong></h4>
		@endif
	</div>


	<table class="pure-table">
		<thead>
			<tr>
				<th width="150">DATA</th>
				<th width="150">VALOR DA COMISSÃO</th>
				<th width="150">VALOR DA VENDA</th>
				<th width="150">VENDEDOR</th>
			</tr>
		</thead>

		<tbody>
			@foreach($comissoes as $key => $c)
			<tr class="@if($key%2 == 0) pure-table-odd @endif">
				<td>{{ \Carbon\Carbon::parse($c->created_at)->format('d/m/Y H:i:s')}}</td>
				<td>{{number_format($c->valor, 2, ',', '.')}}</td>
				<td>{{number_format($c->valor_total_venda, 2, ',', '.')}}</td>
				<td>{{$c->funcionario}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>


</div>
@endsection
