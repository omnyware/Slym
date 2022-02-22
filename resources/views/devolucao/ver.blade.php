@extends('default.layout')
@section('content')

<div class="row" id="anime" style="display: none">
	<div class="col s8 offset-s2">
		<lottie-player 
		src="/anime/success.json"  background="transparent"  speed="0.8"  style="width: 100%; height: 300px;"    autoplay >
	</lottie-player>
</div>
</div>

<div class="row" id="content" style="display: block">
	<div class="col s12">
		<h1 class="center-align">Visualizando Devolução</h1>
		<h4 class="center-align">Nota Fiscal de Entrada <strong class="grey-text">{{$dadosNf['nNf']}}</strong></h4>
		<h4 class="center-align">Chave de Entrada <strong class="grey-text">{{$dadosNf['chave']}}</strong></h4>

		@if($devolucao->chave_gerada)
		<h4 class="center-align">Chave de Devolução <strong class="grey-text">{{$devolucao->chave_gerada}}</strong></h4>
		@endif
		

		<div class="card">
			<div class="card-content">
				<div class="row">
					<div class="col s8">
						<h5>Fornecedor: <strong>{{$dadosEmitente['razaoSocial']}}</strong></h5>
						<h5>Nome Fantasia: <strong>{{$dadosEmitente['nomeFantasia']}}</strong></h5>
					</div>
					<div class="col s4">
						<h5>CNPJ: <strong>{{$dadosEmitente['cnpj']}}</strong></h5>
						<h5>IE: <strong>{{$dadosEmitente['ie']}}</strong></h5>
					</div>
				</div>
				<div class="row">
					<div class="col s8">
						<h5>Logradouro: <strong>{{$dadosEmitente['logradouro']}}</strong></h5>
						<h5>Numero: <strong>{{$dadosEmitente['numero']}}</strong></h5>
						<h5>Bairro: <strong>{{$dadosEmitente['bairro']}}</strong></h5>
					</div>
					<div class="col s4">
						<h5>CEP: <strong>{{$dadosEmitente['cep']}}</strong></h5>
						<h5>Fone: <strong>{{$dadosEmitente['fone']}}</strong></h5>
					</div>
				</div>
				
			</div>
		</div>
		

		<div class="card">
			<div class="row">
				<div class="col s12">
					<h4>Itens da NF</h4>
					<p class="red-text">* Produtos em vermelho ainda não cadastrado no sistma</p>
					
					<table class="striped" id="tbl">
						<thead>
							<tr>
								<th>Código</th>
								<th>Produto</th>
								<th>NCM</th>
								<th>CFOP</th>
								<th>Cod Barra</th>
								<th>Un. Compra</th>
								<th>Valor</th>
								<th>Quantidade</th>
								<th>Subtotal</th>

							</tr>
						</thead>

						<tbody id="tbody">
							@foreach($devolucao->itens as $i)
							<tr>
								<td>{{$i->cod}}</td>
								<td>{{$i->nome}}</td>
								<td>{{$i->ncm}}</td>
								<td>{{$i->cfop}}</td>
								<td>{{$i->codBarras}}</td>
								<td>{{$i->unidade_medida}}</td>
								<td>{{$i->valor_unit}}</td>
								<td>{{$i->quantidade}}</td>
								<td>{{number_format(($i->quantidade * $i->valor_unit), 2)}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<div class="row">
						<h5>Soma dos Itens: <strong id="soma-itens" class="red-text"></strong></h5>
					</div>
				</div>
				
			</div>
		</div>


		<div class="card">

			

			<div class="row">
				<div class="col s6">
					<h4>Valor Integral da NF: <strong id="valorDaNF" class="blue-text">R$ {{$dadosNf['vProd']}}</strong></h4>
				</div>

				<div class="col s6">
					<h4>Valor Devolvido: <strong class="red-text">R$ {{$devolucao->valor_devolvido}}</strong></h4>
				</div>
				
			</div>

			<div class="row">
				<div class="col s4">
					<a style="width: 100%;" href="/devolucao/downloadXmlEntrada/{{$devolucao->id}}" class="btn red" target="_blank">
						Downlaod XML de entrada
					</a>
				</div>

				<div class="col s4">
					<a style="width: 100%;" href="/devolucao/downloadXmlDevolucao/{{$devolucao->id}}" class="btn" target="_blank">
						Downlaod XML de devolução
					</a>
				</div>
			</div>

			<br>

		</div>
	</div>

	
</div>
@endsection	