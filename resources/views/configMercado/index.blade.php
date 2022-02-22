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
		<h4>{{{ isset($config) ? "Editar": "Cadastrar" }}} Configuração de Mercado</h4>
		<form method="post" action="/configMercado/save">
			<input type="hidden" name="id" value="{{{ isset($config->id) ? $config->id : 0 }}}">

			<section class="section-1">
				
				<div class="row">
					<div class="input-field col s4">
						<input value="{{{ isset($config->email) ? $config->email : old('email') }}}" id="email" name="email" type="text" class="validate" data-length="50">
						<label>Email</label>

						@if($errors->has('email'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('email') }}</span>
						</div>
						@endif
					</div>
				</div>

				<div class="row">
					<div class="input-field col s8">
						<input value="{{{ isset($config->funcionamento) ? $config->funcionamento : old('funcionamento') }}}" id="funcionamento" name="funcionamento" type="text" class="validate" data-length="100">
						<label>Descreva o Funcionamento</label>

						@if($errors->has('funcionamento'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('funcionamento') }}</span>
						</div>
						@endif
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12">
						<input value="{{{ isset($config->descricao) ? $config->descricao : old('descricao') }}}" id="descricao" name="descricao" type="text" class="validate" data-length="200">
						<label>Descrição Home Page</label>

						@if($errors->has('descricao'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('descricao') }}</span>
						</div>
						@endif
					</div>
				</div>

				<div class="row">
					<div class="input-field col s2">
						<input value="{{{ isset($config->total_de_produtos) ? $config->total_de_produtos : old('total_de_produtos') }}}" id="total_de_produtos" name="total_de_produtos" type="text" class="validate">
						<label>Total de Produtos</label>

						@if($errors->has('total_de_produtos'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('total_de_produtos') }}</span>
						</div>
						@endif
					</div>

					<div class="input-field col s2">
						<input value="{{{ isset($config->total_de_clientes) ? $config->total_de_clientes : old('total_de_clientes') }}}" id="total_de_clientes" name="total_de_clientes" type="text" class="validate">
						<label>Total de Clientes</label>

						@if($errors->has('total_de_clientes'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('total_de_clientes') }}</span>
						</div>
						@endif
					</div>

					<div class="input-field col s2">
						<input value="{{{ isset($config->total_de_funcionarios) ? $config->total_de_funcionarios : old('total_de_funcionarios') }}}" id="total_de_funcionarios" name="total_de_funcionarios" type="text" class="validate">
						<label>Total de Funcionários</label>

						@if($errors->has('total_de_funcionarios'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('total_de_funcionarios') }}</span>
						</div>
						@endif
					</div>

					
				</div>

				

				
				

			</div>


		</section>

		<input type="hidden" name="_token" value="{{ csrf_token() }}">


		<br>
		<div class="row">
			<div class="input-field col s12">

				<a class="btn-large red lighten-2" href="/frenteCaixa">Cancelar</a>
				<input type="submit" value="Salvar" class="btn-large green accent-3">
			</div>
		</div>

	</form>
</div>


@endsection