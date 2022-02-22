@extends('delivery_pedido.default')
@section('content')

<div class="login-contect py-5">
	<div class="container py-xl-5 py-3">
		<div class="login-body">
			<div class="login p-4 mx-auto">
				<h5 class="text-center mb-4">Esqueceu sua Senha</h5>
				<form action="" method="post">
					@csrf
					<div class="form-group">
						<label>Email ou Telefone</label>
						<input type="text" class="form-control" id="mail_phone" name="mail_phone" placeholder="" required="">
					</div>
					@if(session()->has('message_erro_telefone'))
					<div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro_telefone') }}</div>
					@endif
					
					<button type="submit" class="btn submit mb-4">Recuperar</button>
					@if(session()->has('message_sucesso'))
					<div class="p-3 mb-2 bg-success text-white">{{ session()->get('message_sucesso') }}</div>
					@endif

					@if(session()->has('message_erro'))
					<div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro') }}</div>
					@endif
					
				</form>

			</div>
		</div>
	</div>
</div>


@endsection	

