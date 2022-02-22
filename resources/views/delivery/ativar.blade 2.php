@extends('delivery.default')
@section('content')

<div class="login-contect py-5">
	<div class="py-xl-5 py-1">
		<div class="login-body">
			<div class="login p-4 mx-auto">
				<h4 class="text-center mb-4">Olá {{$cliente->nome}}, por favor ative seu cadastro! </h4>

				@if(getenv("AUTENTICACAO_SMS") == 1)
				<h5>Contato para ativação xx xxxxx-x{{substr($cliente->celular, 10,3)}}</h5>
				<a  style="width: 100%;" id="enviar-sms" href="#!" class="btn btn-success"><span class="fa fa-paper-plane mr-2"></span>Enviar SMS</a>

				<br>
				<input type="hidden" id="token" value="{{csrf_token()}}">
				<input type="hidden" id="id" value="{{$cliente->id}}">
				<div class="sms-enviado" style="display: none">
					<br>
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
				</div>
				@else
				<h5 class="text-center mb-4">Verifique seu email</h5>
				@endif
			</div>
		</div>
	</div>
</div>


@endsection	

