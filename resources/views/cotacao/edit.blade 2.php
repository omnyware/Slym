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
		<div class="card">

			<div class="row">
				<form class="col s12" method="post" action="/cotacao/saveItem">
					<h5>Cotação: <strong class="orange-text">{{$cotacao->id}}</strong></h5>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" value="{{$cotacao->id}}">
					<br>
					<div class="row">
						<div class="input-field col s4">
							<i class="material-icons prefix">inbox</i>
							<input autocomplete="off" type="text" name="produto" id="autocomplete-produto" class="autocomplete-produto">
							<label for="autocomplete-produto">Produto</label>
							@if($errors->has('produto'))
							<div class="center-align red lighten-2">
								<span class="white-text">{{ $errors->first('produto') }}</span>
							</div>
							@endif
						</div>

						<div class="input-field col s2">
							<input type="text" id="quantidade" name="quantidade">
							<label>Quantidade</label>
						</div>

						<div class="col s2">
							<button type="submit" class="btn-large green accent-3">
								<i class="material-icons">add</i>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="card">
			<div class="row">
				<div class="col s12">
					<h4>Itens da Cotação</h4>
					<table class="striped col s12">
						<thead>
							<tr>
								<th>#</th>
								<th>Produto</th>
								<th>Quantidade</th>
								<th>Valor</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
							@foreach($cotacao->itens as $i)
							<tr>
								<td>{{$i->id}}</td>
								<td>{{$i->produto->nome}}</td>
								<td>{{$i->quantidade}}</td>
								<td>{{number_format($i->valor, 2, ',', '.')}}</td>
								<td>
									<a href="/cotacao/deleteItem/{{$i->id}}">
										<i class="material-icons red-text">delete</i>
									</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection	