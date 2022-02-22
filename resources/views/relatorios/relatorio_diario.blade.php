@extends('relatorios.cabecalho')
@section('content')
<div class="row">
	<div class="col s12">
		<h3 class="center-align">Relátorio de Venda {{$data_inicial}}</h3>

	</div>

	<table class="pure-table">
		<thead>
			<tr>
				<th width="80">#</th>
				<th width="80">TOTAL</th>
			</tr>
		</thead>


		<?php $soma = 0; $inc = 0; ?>
		<tbody>
			@foreach($vendas as $key => $v)

			@foreach($v['itens'] as $i)
			<tr style="background: #e8eaf6">
				<td>{{$i->quantidade}} x {{$i->produto->nome}} {{$i->produto->unidade_venda}} x {{number_format($i->valor, 2, ',', '.')}} = R$ {{number_format(($i->quantidade * $i->valor), 2, ',', '.')}}</td>
				<td></td>
			</tr>
			@endforeach
			<tr>
				<td style="color: green; border-bottom: 1px solid #000;">Venda: {{$v['id']}} - {{$v['data']}}</td>
				<td style="color: green; border-bottom: 1px solid #000;">{{number_format($v['total'], 2, ',', '.')}}</td>
			</tr>


			<?php $soma += $v['total']; $inc++;?>
			@endforeach
		</tbody>
	</table>
	<h4>Total de vendas: <strong class="text-danger">{{$inc}}</strong></h4>
	<h4>Valor Total: <strong class="text-success">R$ {{number_format($soma, 2, ',', '.')}}</strong></h4>

</div>
@endsection
