<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-oAOxQR6DkCoMliIh8yFnu25d7Eq/PHS21PClpwjOTeU2jRSq11vu66rf90/cZr47" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/materialize.min.css">

</head>
<body>

	<div class="row">
		<div class="col s12">
			<h3 class="center-align">Relátorio de Lucro Detalhado</h3>
			@if($data_inicial)
			<h4>Data: {{$data_inicial}}</h4>
			@endif
		</div>

		<table class="pure-table">
			<thead>
				<tr>
					<th width="60">HORÁRIO</th>
					<th width="60">LOCAL</th>
					<th width="110">CLIENTE</th>
					<th width="110">VALOR VENDA/COMPRA</th>
					<th width="110">LUCRO</th>
					<th width="110">%LUCRO</th>
				</tr>
			</thead>

			

			<tbody>
			</tbody>
				<?php
			 		$somaLucro = 0;
			 		$somaPerc = 0;
			 	?>
				@foreach($lucros as $key => $v)
				<tr class="@if($key%2 == 0) pure-table-odd @endif">
					<td>{{$v['horario']}}</td>
					<td>{{$v['local']}}</td>
					<td>{{$v['cliente']}}</td>
					<td>{{number_format($v['valor_venda'], 2)}} / {{number_format($v['valor_compra'], 2)}}</td>
					<td>{{number_format($v['lucro'], 2)}}</td>
					<td>{{$v['lucro_percentual']}}</td>
				</tr>

				<?php $somaLucro += $v['lucro']; ?>
				<?php $somaPerc += $v['lucro_percentual']; ?>
				@endforeach
			</tbody>
		</table>

		<h4>Total lucro: <strong style="color: green">R$ {{number_format($somaLucro, 2, ',', '.')}}</strong></h4>
		<h5>% Médio: <strong style="color: red">{{number_format(($somaPerc/sizeof($lucros)), 2, ',', '.')}}</strong></h5>
	</div>
	<div class="row">
		<canvas id="grafico-vendas" style="width: 100%; margin-left: 100px; margin-top: 20px;"></canvas>
	</div>

</body>
</html>