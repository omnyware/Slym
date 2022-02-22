@extends('relatorios.cabecalho')
@section('content')

<div class="row">
	<div class="col s12">
		<h3 class="center-align">Relátorio de Compras</h3>
		@if($data_inicial && $data_final)
		<h4>Periodo: {{$data_inicial}} - {{$data_final}}</h4>
		@endif
	</div>


	<table class="pure-table">
		<thead>
			<tr>
				<th width="150">DATA</th>
				<th width="150">TOTAL R$</th>
				<th width="150">QTD COMPRAS</th>
			</tr>
		</thead>



		<tbody>
			@foreach($compras as $key => $c)
			<tr class="@if($key%2 == 0) pure-table-odd @endif">
				<td>{{$c->data}}</td>
				<td>{{number_format($c->total, 2, ',', '.')}}</td>
				<td>{{number_format($c->compras_diarias)}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>


</div>


@endsection
