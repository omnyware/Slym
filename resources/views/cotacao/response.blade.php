<!DOCTYPE html>
<html>
<head>
	<title>Resposta de Cotação</title>
	<meta name = "viewport" content = "width = device-width, initial-scale = 1">      
	<link rel = "stylesheet"
	href = "https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">

</head>
<body>

	<div class="row" id="anime" style="display: none">
		<div class="col s8 offset-s2">
			<lottie-player 
			src="/anime/success.json"  background="transparent"  speed="0.8"  style="width: 100%; height: 300px;"    autoplay >
		</lottie-player>
	</div>
</div>

<div class="row" id="content" style="display: block">
	<div class="col s12">
		<div class="card">
			<div class="card-content">
				<h3 class="center-align">COTAÇÃO N° {{$cotacao->id}}</h3>
				<input type="hidden" id="priceId" value="{{$cotacao->id}}">
				<div class="row">
					<div class="col s5">
						<h5>SOLICITANTE: {{strtoupper($config->razao_social)}}</h5>
					</div>
					<div class="col s4">
						<h5>FONE: {{$config->fone}}</h5>
					</div>
				</div>
				<div class="row">
					<div class="col s5">
						<h5>FORNECEDOR: {{strtoupper($cotacao->fornecedor->razao_social)}}</h5>
					</div>
					<div class="col s4">
						<h5>CIDADE: {{strtoupper($cotacao->fornecedor->cidade->nome)}} 
							- {{strtoupper($cotacao->fornecedor->cidade->uf)}}</h5>
						</div>
						<div class="col s3">
							<h5>CNPJ: {{$cotacao->fornecedor->cpf_cnpj}}</h5>
						</div>
					</div>

				</div>
			</div>

			<div class="card">
				<div class="card-content">
					<h5 style="font-weight: bold;">ITENS</h5>
					<p class="red-text">- Prencha todas as linhas da tabela para envio</p>
					<p class="red-text">* Campos opcionais</p>
					<br>
					<table id="cotacao">
						<thead>
							<tr class="">
								<th>PRODUTO</th>
								<th>QUANTIDADE</th>
								<th>VALOR UN</th>
								<th>OBSERVAÇÃO *</th>
								<th>TOTAL</th>
							</tr>
						</thead>

						<tbody>
							<input type="hidden" id="_token" value="{{ csrf_token() }}">
							@foreach($cotacao->itens as $linha => $p)
							<tr class="itens">
								<td style="display: none" id="id_prod">{{$p->id}}</td>
								<td>{{strtoupper($p->produto->nome)}}</td>
								<td id="quantity">{{$p->quantidade}}</td>

								<td>
									<div class="input-field col s5">
										<input type="text" class="value" id="value" name="value">
										<label>Valor</label>
									</div>
								</td>

								<td>
									<div class="input-field col s10">
										<input type="text" name="note" id="note">
										<label>*</label>
									</div>
								</td>

								<td id="total">
									0,00
								</td>
							</tr>
							@endforeach
							<tr class="blue lighten-4">
								<td colspan="4" class="center-align">TOTAL COTAÇÃO</td>
								<td id="totalMax" style="font-weight: bold;">0,00</td>
							</tr>
						</tbody>
					</table>

					<br>
					<div class="row">
						<div class="input-field col s8">
							<textarea name="payment_form" id="payment_form" rows="3" class="materialize-textarea" data-length="120"></textarea>
							<label for="payment_form">*FORMA DE PAGAMENTO</label>
							<p class="red-text">*descreva as informações sobre o pagamento: parcelas, valores, datas etc.</p>
						</div>

						<div class="input-field col s3 offset-s1">
							<input type="text" id="responsible">
							<label for="responsible">RESPONSAVEL</label>
						</div>

					</div>


				</div>



			</div>


			<div class="row">

				<div class="col s3 offset-s9 right-align">
					<button style="width: 100%;" type="" id="salvar" class="btn-large">
						Salvar
					</button>
				</div>
			</div>

		</div>
	</div>

	<script type="text/javascript">
		const path = "<?php echo getenv('PATH_URL') ?>" + "/";
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>
	<script type = "text/javascript"
	src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>  
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>
	<script type="text/javascript">
		$('.value').mask('000.000.000.000.000,00', {reverse: true});
	</script>
	<script src="/js/quotes.js"></script>
	<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>
</html>