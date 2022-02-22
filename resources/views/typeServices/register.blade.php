@extends('default.layout')
@section('content')
	<div class="row">
		<div class="col s12">
			<h4>{{{ isset($type) ? "Editar": "Cadastrar" }}} Tipo de Serviço</h4>
			<form method="post" action="{{{ isset($type) ? '/tipoServico/update': '/tipoServico/save' }}}" >
				<input type="hidden" name="id" value="{{{ isset($type->id) ? $type->id : 0 }}}">
				
				<div class="row">
					<div class="input-field col s6">
			          <input value="{{{ isset($type->name) ? $type->name : old('name') }}}" id="name" name="name" type="text" class="validate">
			          <label for="name">Nome</label>
			          
			          @if($errors->has('name'))
			          <div class="center-align red lighten-2">
			          	<span class="white-text">{{ $errors->first('name') }}</span>
			          </div>
			          @endif

			        </div>
				</div>

				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				

				
				<br>
				<div class="row">
					<a class="btn red lighten-2" href="/tipoServico">Cancelar</a>
					<input type="submit" value="Salvar" class="btn green">
				</div>
			</form>
		</div>
	</div>
@endsection