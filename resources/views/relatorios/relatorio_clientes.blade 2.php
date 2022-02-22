@extends('relatorios.cabecalho')
@section('content')

<div class="row">
	<div class="col s12">
		<h3 class="center-align">Relátorio de Vendas Por Clientes {{$ordem}} Vendidos</h3>
		@if($data_inicial && $data_final)
		<h4>Periodo: {{$data_inicial}} - {{$data_final}}</h4>
		@endif
	</div>


	<table class="pure-table">
		<thead>
			<tr>
				<th width="70">CÓD CLIENTE</th>
				<th width="300">NOME</th>
				<th width="100">TOTAL DE VENDAS</th>
				<th width="100">TOTAL EM R$</th>
			</tr>
		</thead>



		<tbody>
			@foreach($vendas as $key => $v)
			<tr class="@if($key%2 == 0) pure-table-odd @endif">
				<td>{{$v->id}}</td>
				<td>{{$v->nome}}</td>
				<td>{{number_format($v->total, 0)}}</td>
				<td>{{number_format($v->total_dinheiro, 2, ',', '.')}}</td>

			</tr>
			@endforeach
		</tbody>
	</table>


</div>
@endsection


