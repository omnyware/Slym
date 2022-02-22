@extends('delivery_pedido.default')
@section('content')

<div class="login-contect py-5">
	<div class="container py-xl-5 py-3">
		<div class="login-body">
			<div class="login p-4 mx-auto">
				@if(getenv("AUTENTICACAO_EMAIL") == 1 && getenv("AUTENTICACAO_SMS") == 1)
				<h4 class="text-center mb-4">Foi enviado um Email de ativação e um SMS para o numero <strong>{{$celular}}</strong></h4>
				@elseif(getenv("AUTENTICACAO_EMAIL") == 1 && getenv("AUTENTICACAO_SMS") == 0)
				<h4 class="text-center mb-4">Foi enviado um Email de ativação</h4>
				@elseif(getenv("AUTENTICACAO_EMAIL") == 0 && getenv("AUTENTICACAO_SMS") == 1)
				<h4 class="text-center mb-4">Foi enviado um SMS para o numero <strong>{{$celular}}</strong></h4>
				@endif

				@if(getenv("AUTENTICACAO_SMS") == 1)
				<input type="hidden" id="celular" value="{{$celular}}">
				<h5 class="text-center mb-4">Tempo restante <strong id="timer" style="color: orange">60</strong></h5>
				<div class="form-group">

					<input type="hidden" id="token" value="{{csrf_token()}}">

					<div class="row">
						<div class="col-2 col-sm-2 col-xl-2 col-md-2 col-lg-2">
							<input type="text" class="form-control cod" id="cod1" name="cod1">
						</div>
						<div class="col-2 col-sm-2 col-xl-2 col-md-2 col-lg-2">
							<input type="text" class="form-control cod" id="cod2" name="cod2">
						</div>
						<div class="col-2 col-sm-2 col-xl-2 col-md-2 col-lg-2">
							<input type="text" class="form-control cod" id="cod3" name="cod3">
						</div>
						<div class="col-2 col-sm-2 col-xl-2 col-md-2 col-lg-2">
							<input type="text" class="form-control cod" id="cod4" name="cod4">
						</div>
						<div class="col-2 col-sm-2 col-xl-2 col-md-2 col-lg-2">
							<input type="text" class="form-control cod" id="cod5" name="cod5">
						</div>
						<div class="col-2 col-sm-2 col-xl-2 col-md-2 col-lg-2">
							<input type="text" class="form-control cod" id="cod6" name="cod6">
						</div>
					</div>
					
				</div>
				@endif
			</div>
		</div>
	</div>
</div>


@endsection	

