<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-oAOxQR6DkCoMliIh8yFnu25d7Eq/PHS21PClpwjOTeU2jRSq11vu66rf90/cZr47" crossorigin="anonymous">
</head>
<body>

	<div class="row">
		<div class="col s12">
			<h3 class="center-align">Relátorio de Fluxo de Caixa</h3>
		</div>



		<table class="pure-table">
			<thead>
				<tr>
					<th>DATA</th>
					<th width="120px;">VENDAS</th>
					<th>CONTAS A RECEBER</th>
					<th>CONTA CRÉDITO</th>
					<th>CONTA A PAGAR</th>
					<th>RESULTADO</th>
				</tr>
			</thead>

			<?php  
			$totalVenda = 0;
			$totalContaReceber = 0;
			$totalContaPagar = 0;
			$totalCredito = 0;
			$totalResultado = 0; 
			?>

			<tbody>
				@foreach($fluxo as $key => $f)
				<tr class="@if($key%2 == 0) pure-table-odd @endif">
					<td>{{$f['data']}}</td>
					<td><label>Vendas: R$ {{number_format($f['venda'], 2, ',', '.')}}</label><br>
						<label>Frente de caixa: R$ {{number_format($f['venda_caixa'], 2, ',', '.')}}</label>
						<h5>Total R$ {{number_format($f['venda']+$f['venda_caixa'], 2, ',', '.')}}</h5>
					</td>
					<td>R$ {{number_format($f['conta_receber'], 2, ',', '.')}}</td>
					<td>R$ {{number_format($f['credito_venda'], 2, ',', '.')}}</td>
					<td>R$ {{number_format($f['conta_pagar'], 2, ',', '.')}}</td>
					<?php 
					$resultado = $f['credito_venda']+$f['conta_receber']+$f['venda_caixa']+$f['venda']-$f['conta_pagar'];
					?>
					<td>
						@if($resultado > 0)
						<h5 class="green-text"> R$ {{number_format($resultado, 2, ',', '.')}}</h5>
						@elseif($resultado == 0)
						<h5 class="blue-text"> R$ {{number_format($resultado, 2, ',', '.')}}</h5>
						@else
						<h5 class="red-text"> R$ {{number_format($resultado, 2, ',', '.')}}</h5>
						@endif
					</td>

					<?php  
					$totalVenda += $f['venda']+$f['venda_caixa'];
					$totalContaReceber += $f['conta_receber'];
					$totalContaPagar += $f['conta_pagar'];
					$totalCredito += $f['credito_venda'];
					$totalResultado += $resultado; 
					?>
				</tr>
				@endforeach
				<tr bgcolor="#FF0000">
					<td>SOMATÓRIO</td>
					<td>R$ {{number_format($totalVenda, 2, ',', '.')}}</td>
					<td>R$ {{number_format($totalContaReceber, 2, ',', '.')}}</td>
					<td>R$ {{number_format($totalCredito, 2, ',', '.')}}</td>
					<td>R$ {{number_format($totalContaPagar, 2, ',', '.')}}</td>
					<td>R$ {{number_format($totalResultado, 2, ',', '.')}}</td>
				</tr>
			</tbody>
		</table>


	</div>

</body>
</html>