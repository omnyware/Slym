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

	.logo{
		display: block;
		margin-left: auto;
		margin-right: auto;
		width: 20%;
	}
</style>
</head>
<body>

	<div class="row">

		<div class="col s12">

			<h3 class="center-align">{{$config->razao_social}}</h3>
			<h4 class="center-align">CNPJ: {{str_replace(" ", "", $config->cnpj)}}</h4>
			<h4 class="center-align">Endereço: {{$config->logradouro}}, {{$config->numero}} - {{$config->bairro}}</h4>
			<h4 class="center-align">Cidade: {{$config->municipio}} ({{$config->UF}})</h4>


		</div>


		<div class="col s12">

			<h3 class="center-align">Orçamento {{$orcamento->id}}</h3>
			<h5>Cliente: <strong>{{$orcamento->cliente->razao_social}}</strong></h5>
			<h5>CPF/CNPJ: <strong class="red-text">{{$orcamento->cliente->cpf_cnpj}}</strong></h5>
			<h5>IE/RG: <strong class="red-text">{{$orcamento->cliente->ie_rg}}</strong></h5>
			<h5>Logradouro: <strong class="red-text">{{$orcamento->cliente->rua}}, {{$orcamento->cliente->numero}} </strong></h5>
			<h5>Bairro: <strong class="red-text">{{$orcamento->cliente->bairro}} </strong></h5>
			<h5>Cidade: <strong class="red-text">{{$orcamento->cliente->cidade->nome}} ({{$orcamento->cliente->cidade->uf}})</strong></h5>
			<h5>Validade: <strong class="red-text">{{ \Carbon\Carbon::parse($orcamento->validade)->format('d/m/Y')}}</strong></h5>
			@if($orcamento->estado == 'APROVADO')
			<h5>Estado: <strong style="color: green">APROVADO</strong></h5>
			@elseif($orcamento->estado == 'REPROVADO')
			<h5>Estado: <strong class="red-text">REPROVADO</strong></h5>
			@else
			<h5>Estado: <strong style="color: blue">NOVO</strong></h5>
			@endif


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

					@foreach($orcamento->itens as $i)
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
					@if($orcamento->duplicatas()->exists())
					@foreach($orcamento->duplicatas as$key => $d)
					<tr>
						<td>00{{$key + 1}}</td>
						<td>{{ \Carbon\Carbon::parse($d->data_vencimento)->format('d/m/Y')}}</td>
						<td>{{number_format($d->valor, 2)}}</td>


					</tr>
					@endforeach
					@else
					<tr>
						<td>001</td>
						<td>{{ \Carbon\Carbon::parse($orcamento->created_at)->format('d/m/Y')}}</td>
						<td>{{number_format($orcamento->valor_total, 2)}}</td>

					</tr>
					@endif

				</tbody>
			</table>
		</div>

		<h4>DESCONTO: <strong style="color: red;">{{$orcamento->desconto}}</strong></h4>
		<h4>TOTAL DO ORÇAMENTO: <strong style="color: green;">{{number_format($orcamento->valor_total - $orcamento->desconto, 2)}}</strong></h4>
		
		@if($orcamento->frete)
		<h4>FRETE: <strong style="color: blue">{{number_format( $orcamento->frete->valor, 2) }}</strong></h4>
		@endif



	</div>

</body>
</html>