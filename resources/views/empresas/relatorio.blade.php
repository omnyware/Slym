@extends('relatorios.cabecalho')
@section('content')

<div class="row">
	<div class="col s12">
		<h3 >Relátorio de Empresas</h3>
	</div>

	<table class="pure-table">
		<thead>
			<tr>

				<th width="80">ID</th>
				<th width="140">NOME</th>
				<th width="180">ENDEREÇO</th>
				<th width="100">CIDADE</th>
				<th width="100">STATUS</th>
			</tr>
		</thead>

		<tbody>
			<?php $somaContas = 0; ?>
			@foreach($empresas as $key => $e)
			<tr class="@if($key%2 == 0) pure-table-odd @endif">

				<td>{{ $e->id}}</td>
				<td>{{ $e->nome}}</td>
				<td>
					{{$e->rua}}, {{$e->numero}} - {{$e->bairro}}
				</td>
				<td>{{$e->cidade}}</td>
				<td>
					@if($e->status() == -1)
						MASTER
					@elseif($e->status())
						ATIVO
					@else
						DESATIVADO
					@endif
				</td>
			</tr>

			@endforeach
		</tbody>
	</table>
</div>
@endsection

