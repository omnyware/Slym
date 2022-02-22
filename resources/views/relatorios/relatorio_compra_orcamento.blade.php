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
			<h3 class="center-align">Relátorio de Compras Orçamento</h3>
			@if($data_inicial && $data_final)
			<h4>Periodo: <strong style="color: blue">{{$data_inicial}} - {{$data_final}}</strong></h4>
			@endif
		</div>


		<table class="pure-table">
			<thead>
				<tr>
					<th width="80">CÓDIGO</th>
					<th width="250">PRODUTO</th>
					<th width="120">QUANTIDADE</th>
				</tr>
			</thead>

			

			<tbody>
				@foreach($itens as $key => $i)
				<tr class="@if($key%2 == 0) pure-table-odd @endif">
					<td>{{$i['codigo']}}</td>
					<td>{{$i['produto']}}</td>
					<td>{{number_format($i['quantidade'], 2, ',', '.')}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>


	</div>
	<div class="row">
		<canvas id="grafico-vendas" style="width: 100%; margin-left: 100px; margin-top: 20px;"></canvas>
	</div>

</body>
</html>