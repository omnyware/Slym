@extends('default.layout')
@section('content')

<div class="row">


	<div class="col s12">
		@if(session()->has('message'))
		<div class="row">
			<div style="border-radius: 10px;" class="col s12 {{ session('color') }}">
				<h5 class="center-align white-text">{{ session()->get('message') }}</h5>
			</div>
		</div>
		@endif

		<h3>Comanda: {{$pedido->comanda}}</h3>
		

		<table class="striped col s12">
			<thead>
				<tr>
					<th>#</th>
					<th>Produto</th>
					<th>Valor</th>
					<th>Quantidade</th>
					<th>Subtotal</th>
					<th>Ações</th>
				</tr>
			</thead>


			<tbody>
				@foreach($pedido->itens as $i)
				<tr>
					<td>{{$i->produto_id}}</td>
					<td>{{$i->produto->nome}}</td>
					<td>{{number_format($i->produto->valor_venda, 2, ',', '.')}}</td>
					<td>{{$i->quantidade}}</td>
					<td>{{number_format(($i->produto->valor_venda * $i->quantidade), 2, ',', '.')}}</td>
					<td>
						<a onclick = "if (! confirm('Deseja excluir este registro?')) { return false; }" href="/pedido/deleteItem/{{ $i->id }}">
							<i class="material-icons left red-text">delete</i>					
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>


		<div class="row">
			<div class="col s12">
				<h4>TOTAL: <strong class="green-text">{{number_format($pedido->somaItems(), 2, ',', '.')}}</strong></h4>

				<br>
			</div>
		</div>

		<div class="row">
			<div class="col s12">
				<div class="input-field col s6">
					<i class="material-icons prefix">person</i>
					<input autocomplete="off" type="text" name="cliente" id="autocomplete-cliente" class="autocomplete-cliente">
					<label for="autocomplete-cliente">Cliente</label>
					@if($errors->has('cliente'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('cliente') }}</span>
					</div>
					@endif
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col s12">
				<a class="btn-large" href="/pedidos/finalziar/{{$pedido->id}}">Finalizar Comanda</a>

			</div>
		</div>
	</div>


</div>
@endsection	