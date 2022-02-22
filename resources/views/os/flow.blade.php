@extends('default.layout')
@section('content')

	<div class="row">
		<div class="col s12">

			<h4>Lista de OS</h4>

			@if(session()->has('message'))
			<div style="border-radius: 10px;" class="col s12 {{ session('color') }}">
				<h5 class="center-align white-text">{{ session()->get('message') }}</h5>
			</div>
			@endif

			<form method="get" action="/order/cashFlowFilter" class="row col s6">
				<div class="input-field col s4">
			          <input id="date_start" name="date_start" type="text" class="datepicker">
			          <label for="date_start">Data Inicio</label>
			    </div>
			    <div class="input-field col s4">
			          <input id="date_last" name="date_last" type="text" class="datepicker">
			          <label for="date_last">Data Final</label>
			    </div>
			    <button class="btn black col s2 black" type="submit">
			      <i class="material-icons">date_range</i>	
			    </button>
			</form>

			<div class="row">
				<div class="col s12">
					<label>Numero de registros: {{count($orders)}}</label>					
				</div>
				<table class="col s12">
					<thead>
						<tr>
							<th>Código</th>
							<th>Código Cotação</th>
							<th>Cliente</th>
							<th>Valor Integral</th>
							<th>Desconto</th>
							<th>Garantia</th>
							<th>Usuário</th>
							<th>Data de registro OS</th>
							<th>Data de Orçamento</th>
							<th>Ações</th>
						</tr>
					</thead>

					<tbody>
						<?php 
							$totalValue = 0;
							$totalDiscount = 0;

							$totalAvista = 0;
							$totalMaquineta = 0;
							$totalPrazo = 0;
						?>
						@foreach($orders as $o)
						<tr>
							<th>{{ $o->id }}</th>
							<th>{{ $o->budget->id }}</th>
							<th>{{ $o->budget->client->name }}</th>
							<th>{{ number_format($o->budget->value, 2, ',', '.') }}</th>
							<th>{{ number_format($o->discount, 2, ',', '.') }}</th>
							<th>{{ $o->warranty }}</th>
							<th>{{ $o->user->name }}</th>
							<th>{{ \Carbon\Carbon::parse($o->date_register)->format('d/m/Y H:i:s')}}</th>
							<th>{{ \Carbon\Carbon::parse($o->budget->date_register)
								->format('d/m/Y H:i:s')}}</th>

							<th>
								@if(is_adm())
								<a onclick = "if (! confirm('Deseja excluir este registro?')) { return false; }" href="/order/delete/{{ $o->id }}">
	      							<i class="material-icons left red-text">delete</i>					
								</a>
								@endif

								<a href="/order/print/{{ $o->id }}">
	      							<i class="material-icons left blue-text">print</i>					
								</a>
							</th>

							<?php 
								$totalValue += $o->budget->value;
								$totalDiscount += $o->discount;

								if($o->payment_form == "A Vista"){
									$totalAvista += $o->budget->value;
								}else if($o->payment_form == "Maquineta"){
									$totalMaquineta += $o->budget->value;
								}else if($o->payment_form == "Parcelado"){
									$totalPrazo += $o->budget->value;
								}
							?>
						</tr>
						
						@endforeach

						<tr class="red lighten-5">
							<td colspan="3"></td>
							<td><strong class="green-text">{{number_format($totalValue , 2, ',', '.')}}</strong></td>
							<td><strong class="blue-text">{{number_format($totalDiscount , 2, ',', '.')}}</strong></td>
							<td colspan="3">Diferença Integral para Desconto</td>
							<td><strong class="red-text">{{$totalValue > 0 ? (number_format(100-
							((($totalValue - $totalDiscount)/$totalValue) * 100), 
							2, ',', '.')) : '0'}} %</strong></td>
							<td colspan="3"></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="row">
				<div class="col s4 white-text">
					<div class="card center-align green lighten-2">
						<h5>Vendas a Vista</h5>
						<h5><strong>{{number_format($totalAvista, 2, ',', '.')}}</strong></h5>
					</div>
				</div>
				<div class="col s4 white-text">
					<div class="card center-align blue lighten-2">
						<h5>Maquineta</h5>
						<h5><strong>{{number_format($totalMaquineta, 2, ',', '.')}}</strong></h5>
					</div>
				</div>
				<div class="col s4 white-text">
					<div class="card center-align red lighten-2">
						<h5>Parcelado</h5>
						<h5><strong>{{number_format($totalPrazo, 2, ',', '.')}}</strong></h5>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection	