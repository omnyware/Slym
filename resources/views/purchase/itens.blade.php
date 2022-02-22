@extends('default.layout')
@section('content')

	<div class="row">
		<div class="col s12">

			<h4>Itens de Compras</h4>

			<br>

			<div class="row">
				<div class="col s12">
					<label>Numero de registros: {{count($itens)}}</label>					
				</div>
				<table class="col s12">
					<thead>
						<tr>
							<th>Código</th>
							<th>Produto</th>
							<th>Quantidade</th>
							<th>Valor Unitário</th>
							<th>Subtotal</th>
						</tr>
					</thead>

					<tbody>
						<?php $total = 0; ?>
						@foreach($itens as $i)
						<tr>
							<th>{{ $i->id }}</th>
							<th>{{ $i->product->name }}</th>
							<th>{{ $i->quantity }}</th>
							<th>{{ number_format($i->value, 2, ',', '.') }}</th>
							<th>{{ number_format($i->value * $i->quantity, 2, ',', '.') }}</th>
							<?php $total += $i->value * $i->quantity; ?>
						</tr>
						@endforeach
						<tr class="red lighten-4">
							<td colspan="4" class="center-align">Total</td>
							<td><strong>{{ number_format($total, 2, ',', '.') }}</strong></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection	