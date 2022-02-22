@extends('delivery_pedido.default')
@section('content')

@if(session()->has('message_erro'))
<div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro') }}</div>
@endif

@if(session()->has('message_sucesso'))
<div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_sucesso') }}</div>
@endif


<div class="clearfix"></div>

<div class="login-contect py-5">
	<div class="container py-xl-5 py-3">
		<div class="login-body">
			<div class="login p-4 mx-auto">
				<h5 class="text-center mb-4">Registrar-se Agora</h5>
				<form action="/autenticar/registro" method="post">
					@csrf
					<div class="form-group">
						<label>Nome</label>
						<input type="text" value="{{old('nome')}}" class="form-control" name="nome" placeholder="">
						@if($errors->has('nome'))
						<div class="center-align red lighten-2">
							<span class="text-danger">{{ $errors->first('nome') }}</span>
						</div>
						@endif
					</div>
					<div class="form-group">
						<label>Sobrenome</label>
						<input type="text" value="{{old('sobre_nome')}}"  class="form-control" name="sobre_nome" placeholder="">
						@if($errors->has('sobre_nome'))
						<div class="center-align red lighten-2">
							<span class="text-danger">{{ $errors->first('sobre_nome') }}</span>
						</div>
						@endif
					</div>

					<div class="form-group">
						<label>Celular</label>
						<input type="text" value="{{old('celular')}}" id="telefone" class="form-control" name="celular" placeholder="">
						@if($errors->has('celular'))
						<div class="center-align red lighten-2">
							<span class="text-danger">{{ $errors->first('celular') }}</span>
						</div>
						@endif
					</div>

					<div class="form-group">
						<label>Email</label>
						<input type="text" value="{{old('email')}}" class="form-control" name="email" placeholder="">
						@if($errors->has('email'))
						<div class="center-align red lighten-2">
							<span class="text-danger">{{ $errors->first('email') }}</span>
						</div>
						@endif
					</div>

					<div class="form-group">
						<label class="mb-2">Senha</label>
						<input type="password" class="form-control" value="{{old('senha')}}"  name="senha" id="password1" placeholder="">
						@if($errors->has('senha'))
						<div class="center-align red lighten-2">
							<span class="text-danger">{{ $errors->first('senha') }}</span>
						</div>
						@endif
					</div>

					<div class="form-group">
						<label>Confirme a senha</label>
						<input type="password" value="{{old('senha')}}" class="form-control" name="senha_confirma" id="password2" placeholder="">
						@if($errors->has('senha_confirma'))
						<div class="center-align red lighten-2">
							<span class="text-danger">{{ $errors->first('senha_confirma') }}</span>
						</div>
						@endif
					</div>

					<button type="submit" class="btn submit mb-4">Registrar-se</button>
					<p class="text-center">
						<a href="/termos" class="text-da">Termos de registro</a>
					</p>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection	

