@extends('default.layout')
@section('content')

<style type="text/css">
.dismiss{

}
</style>
<div class="row">
	<div class="col s12">

		<h4>Conta Crediário</h4>
		

		@if(session()->has('message'))
		<div class="row">
			<div style="border-radius: 10px;" class="col s12 {{ session('color') }}">
				<h5 class="center-align white-text">{{ session()->get('message') }}</h5>
			</div>
		</div>
		@endif

		<form method="get" action="/vendasEmCredito/filtro">
			<div class="row">
				<div class="col s4 input-field">
					<input value="{{{ isset($cliente) ? $cliente : '' }}}" type="text" class="validate" name="cliente">
					<label>Cliente</label>
				</div>

				<div class="col s2 input-field">
					<input value="{{{ isset($dataInicial) ? $dataInicial : '' }}}" type="text" class="datepicker" name="data_inicial">
					<label>Data Inicial</label>
				</div>
				<div class="col s2 input-field">
					<input value="{{{ isset($dataFinal) ? $dataFinal : '' }}}" type="text" class="datepicker" name="data_final">
					<label>Data Final</label>
				</div>

				<div class="col s2 input-field">
					<select name="status">
						<option @if(isset($stats) && $status == 'todos') selected @endif value="todos">TODOS</option>
						<option @if(isset($stats) && $status == 'pago') selected @endif value="pago">PAGO</option>
						<option @if(isset($stats) && $status == 'pendente') selected @endif value="pendente">PENDENTE</option>
					</select>
					<label>Estado</label>
				</div>

				<div class="col s2">
					<button type="submit" class="btn-large">
						<i class="material-icons">search</i>
					</button>
				</div>
			</div>
		</form>

		<div class="row">
			<div class="col s3">
				<button class="btn orange disabled" id="btn-receber" onclick="receber()">
					<i class="material-icons left">monetization_on</i>
				Receber Conta(s)</button>
			</div>
			<div class="col s5">
				<h5>Total a Selecionado: <strong class="orange-text" id="total-select">R$ 0,00</strong></h5>
			</div>
		</div>
		
		<div class="row">
			<div class="col s12 m12 l12">
				<label>Numero de registros: {{count($vendas)}}</label>					
			</div>
			
			<p class="red-text">* Marque as contas e clique no botão para receber</p>
			<table class="striped">
				<thead>
					<tr>
						<th></th>
						<th>Código</th>
						<th>Cliente</th>
						<th>Venda</th>
						<th>Valor</th>
						<th>Data</th>
						<th>Status</th>
						<th>Ações</th>

					</tr>
				</thead>

				<tbody class="body">
					<?php 
					$soma = 0;
					?>
					@foreach($vendas as $v)
					<tr>
						<td id="checkbox">
							@if(!$v->status)
							<p>
								<input type="checkbox" class="check" id="test_{{$v->id}}" />
								<label for="test_{{$v->id}}"></label>
							</p>
							@endif
						</td>
						<th id="id">{{ $v->id }}</th>
						<th>{{ $v->cliente->razao_social }}</th>
						<th>{{ $v->venda->id }}</th>
						<th id="valor">{{ number_format($v->venda->valor_total, 2, ',', '.') }}</th>

						<th>{{ \Carbon\Carbon::parse($v->created_at)->format('d/m/Y H:i')}}</th>
						
						<th>
							@if($v->status == true)
							<i class="material-icons green-text">brightness_1</i>
							@else
							<i class="material-icons red-text">brightness_1</i>
							@endif
						</th>

						<th>
							<a target="_blank" title="CUPOM NAO FISCAL" href="/nfce/imprimirNaoFiscalCredito/{{$v->id}}">
								<i class="material-icons blue-text">print</i>
							</a>

							<a title="REMOVER" href="/vendasEmCredito/delete/{{$v->id}}">
								<i class="material-icons red-text">delete</i>
							</a>
						</th>
					</tr>

					<?php 
					$soma += $v->venda->valor_total;
					?>
					@endforeach
					<tr class="green lighten-3 red-text">
						<th colspan="4">SOMATÓRIO</th>
						<th>{{ number_format($soma, 2, ',', '.') }}</th>
						<th colspan="2"></th>
					</tr>
				</tbody>
			</table>
		</div>
		<br>

		<input type="hidden" id="creditos" value="{{json_encode($somaCareditos)}}">

		@if(count($vendas) > 0)
		<div class="row">
			<h4 class="center-align">Graficos</h4>
			<div class="col s6">
				<div style="height: 400px; width: 100%;" id="pizza"></div>
				
			</div>
			<div class="col s6">
				<div style="height: 400px; width: 100%;" id="coluna"></div>
				
			</div>
		</div>
		@endif
	</div>
</div>


@endsection	