@extends('delivery.default')
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
				<h5 class="text-center mb-4">Login</h5>
				<form action="" method="post">
					@csrf
					<div class="form-group">
						<label>Email ou Telefone</label>
						<input type="text" class="form-control" id="mail_phone" name="mail_phone" placeholder="" required="">
					</div>
					@if(session()->has('message_erro_telefone'))
					<div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro_telefone') }}</div>
					@endif
					<div class="form-group">
						<label class="mb-2">Senha</label>
						<input type="password" class="form-control" name="senha" required="">
					</div>
					<button type="submit" class="btn submit mb-4">Login</button>
					@if(session()->has('message_sucesso'))
					<div class="p-3 mb-2 bg-success text-white">{{ session()->get('message_sucesso') }}</div>
					@endif

					@if(session()->has('message_erro'))
					<div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro') }}</div>
					@endif
					<p class="forgot-w3ls text-center mb-3">
						<a href="/autenticar/esqueceu_a_senha" class="text-da">Esqueceu sua senha?</a>
					</p>
					<p class="account-w3ls text-center text-da">
						Ainda não tem cadastro?
						<a href="/autenticar/registro">Criar agora!</a>
					</p>

					@if($config->politica_privacidade)
					<p class="account-w3ls text-center text-da">
						<a href="#gal2" style="color: red" href="/autenticar/registro">Politica de privacidade!</a>
					</p>
					@endif

				</form>

			</div>
		</div>
	</div>
</div>

<div id="gal2" class="pop-overlay">
	<div id="endereco-modal" class="popup">

		<h4>Politica de privacidade</h4>

		<div id="form-endereco">
			<p>{{$config->politica_privacidade}}</p>
		</div>
		<a class="close" href="#!">×</a>
	</div>
</div>


@endsection	