<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-oAOxQR6DkCoMliIh8yFnu25d7Eq/PHS21PClpwjOTeU2jRSq11vu66rf90/cZr47" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/materialize.min.css">

	<style type="text/css">
		strong{
			color: red;
		}
	</style>
</head>
<body>

	<div class="row">
		<div class="col s12">

			<h3 class="center-align">Relátorio Venda {{$venda->id}}</h3>
			<h5>Cliente: <strong>{{$venda->cliente->razao_social}}</strong></h5>
			<h5>CPF/CNPJ: <strong class="red-text">{{$venda->cliente->cpf_cnpj}}</strong></h5>
			<h5>IE/RG: <strong class="red-text">{{$venda->cliente->ie_rg}}</strong></h5>
			<h5>Logradouro: <strong class="red-text">{{$venda->cliente->rua}}, {{$venda->cliente->numero}} </strong></h5>
			<h5>Bairro: <strong class="red-text">{{$venda->cliente->bairro}} </strong></h5>
			<h5>Cidade: <strong class="red-text">{{$venda->cliente->cidade->nome}} ({{$venda->cliente->cidade->uf}})</strong></h5>


		</div>

		<div class="col s12">
			<h5>PRODUTOS</h5>
			<table class="pure-table">
				
				<thead>
					<tr>
						<th width="200">PRODUTO</th>
						<th width="50">QTD</th>
						<th width="80">VALOR UNIT</th>
						<th width="100">SUBTOTAL</th>
					</tr>
				</thead>

				<tbody>

					@foreach($venda->itens as $i)
					<tr>
						<td>{{$i->produto->nome}}</td>
						<td>{{number_format($i->quantidade, 2)}}</td>
						<td>{{number_format($i->valor, 2)}}</td>
						<td>{{number_format($i->quantidade * $i->valor, 2)}}</td>

					</tr>
					@endforeach

				</tbody>
			</table>
		</div>
		<br>
		<div class="col s12">
			<h5>FATURA</h5>
			<table class="pure-table">
				
				<thead>
					<tr>
						<th width="80">#</th>
						<th width="150">VENCIMENTO</th>
						<th width="120">VALOR</th>
					</tr>
				</thead>

				<tbody>
					@if($venda->duplicatas()->exists())
					@foreach($venda->duplicatas as$key => $d)
					<tr>
						<td>00{{$key + 1}}</td>
						<td>{{ \Carbon\Carbon::parse($d->data_vencimento)->format('d/m/Y')}}</td>
						<td>{{number_format($d->valor, 2)}}</td>


					</tr>
					@endforeach
					@else
					<tr>
						<td>001</td>
						<td>{{ \Carbon\Carbon::parse($venda->created_at)->format('d/m/Y')}}</td>
						<td>{{number_format($venda->valor_total, 2)}}</td>

					</tr>
					@endif

				</tbody>
			</table>
		</div>

		<h4>TOTAL DA VENDA: <strong style="color: green">{{$venda->valor_total}}</strong></h4>
		@if($venda->NfNumero > 0)
		<h4>NUMERO NF-e: <strong style="color: blue">{{$venda->NfNumero}}</strong></h4>

		@endif

		@if($venda->frete)
		<h4>FRETE: <strong style="color: blue">{{number_format( $venda->frete->valor, 2) }}</strong></h4>

		@endif



	</div>

</body>
</html>