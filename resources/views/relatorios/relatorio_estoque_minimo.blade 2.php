@extends('relatorios.cabecalho')
@section('content')

	<div class="row">
		<div class="col s12">
			<h3 class="center-align">Relátorio de Estoque Mínimo</h3>
			@if($data_inicial && $data_final)
			<h4>Periodo: {{$data_inicial}} - {{$data_final}}</h4>
			@endif
		</div>


		<table class="pure-table">
			<thead>
				<tr>
					<!-- <th width="50">ID</th> -->
					<th width="170">PRODUTO</th>
					<th width="80">TOTAL DISPONIVEL</th>
					<th width="80">ESTOQUE MINIMO</th>
					<th width="80">TOTAL A COMPRAR</th>
					<th width="80">VALOR DE COMPRA ANTERIOR POR ITEM</th>
				</tr>
			</thead>

			

			<tbody>
				<?php 
				$somaItens = 0; 
				$somaValor = 0; 
				?>
				@foreach($itens as $key => $i)
				<tr class="@if($key%2 == 0) pure-table-odd @endif">
					<!-- <td>{{$i['id']}}</td> -->
					<td>{{$i['nome']}}</td>
					<td>{{number_format($i['estoque_atual'], 2, ',', '.')}}</td>
					<td>{{number_format($i['estoque_minimo'], 2, ',', '.')}}</td>
					<td>{{number_format($i['total_comprar'], 2, ',', '.')}}</td>
					<td>{{number_format($i['valor_compra'], 2, ',', '.')}}</td>

					<?php 
					$somaItens ++; 
					$somaValor += $i['total_comprar'] * $i['valor_compra']; 
					?>
				</tr>
				@endforeach
			</tbody>

		</table>
		<h4>Total de itens para comprar: <strong class="text-danger">{{number_format($somaItens)}}</strong></h4>
		<h4>Valor presumido: <strong class="text-danger">{{number_format($somaValor, 2, ',', '.')}}</strong></h4>


	</div>
@endsection
	