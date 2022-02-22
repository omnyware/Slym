@extends('relatorios.cabecalho')
@section('content')

<div class="row">
	<div class="col s12">
		<h3 class="center-align">Relátorio de Estoque</h3>

	</div>


	<table class="pure-table">
		<thead>
			<tr>

				<th width="150">PRODUTO</th>
				<th width="80">ESTOQUE ATUAL</th>
				<th width="80">ESTOQUE MINIMO</th>
				<th width="80">VALOR DE VENDA</th>
				<th width="120">VALOR TOTAL DE ESTOQUE</th>
				<th width="80">DATA ULT. COMPRA</th>
			</tr>
		</thead>



		<tbody>
			@foreach($produtos as $key => $p)
			<tr class="@if($key%2 == 0) pure-table-odd @endif">

				<td>{{$p->nome}}</td>
				@if($p->unidade_venda == 'UNID' || $p->unidade_venda == 'UN')
				<td>{{number_format($p->quantidade)}} {{$p->unidade_venda}}</td>
				@else
				<td>{{number_format($p->quantidade, 3, ',', '.')}} {{$p->unidade_venda}}</td>
				@endif
				<td>{{$p->estoque_minimo}}</td>
				<td>R$ {{number_format($p->valor_venda, 2, ',', '.')}}</td>
				<td>R$ {{number_format($p->valor_venda*$p->quantidade, 2, ',', '.')}}</td>
				<td>{{$p->data_ultima_compra}}</td>

			</tr>
			@endforeach
		</tbody>
	</table>


</div>
@endsection
