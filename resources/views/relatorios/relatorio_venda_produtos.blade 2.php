@extends('relatorios.cabecalho')
@section('content')

<div class="row">
	<div class="col s12">
		<h3 class="center-align">Relátorio de Produtos {{$ordem}} Vendidos</h3>
		@if($data_inicial && $data_final)
		<h4>Periodo: {{$data_inicial}} - {{$data_final}}</h4>
		@endif
	</div>


	<table class="pure-table">
		<thead>
			<tr>
				<th width="70">CÓD PRODUTO</th>
				<th width="200">PRODUTO</th>
				<th width="80">TOTAL QTD</th>
				<th width="80">TOTAL R$</th>
			</tr>
		</thead>

		

		<tbody>
			@foreach($itens as $key => $i)
			<tr class="@if($key%2 == 0) pure-table-odd @endif">
				<td>{{$i['id']}}</td>
				<td>{{$i['nome']}} - R$ {{number_format($i['valor_venda'], 2, ',', '.')}}UN</td>
				<td>{{number_format($i['total'], 2, ',', '.')}}</td>
				<td>{{number_format($i['total_dinheiro'], 2, ',', '.')}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>


</div>
@endsection
