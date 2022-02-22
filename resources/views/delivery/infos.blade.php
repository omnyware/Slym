@extends('delivery.default')
@section('content')


@if(session()->has('message_sucesso'))
<div class="p-3 mb-2 bg-success text-white">{{ session()->get('message_sucesso') }}</div>
@endif

@if(session()->has('message_erro'))
<div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro') }}</div>
@endif
<div class="clearfix"></div>

<section class="blog_w3ls py-5">
	<div class="container pb-xl-5 pb-lg-3">
		<div class="title-section text-center mb-md-5 mb-4">
			<p class="w3ls-title-sub">Suas informações :)</p>
		</div>

		<input type="hidden" value="{{csrf_token()}}" id="token">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="card border-0 med-blog">
					<div class="card-header ">
						<h5 class="mb-0">Nome: <strong>{{$cliente->nome}} {{$cliente->sobre_nome}}</strong></h5>
						<h5 class="mb-0">Contato: <strong>{{$cliente->celular}}</strong></h5>
						<h5 class="mb-0">Email: <strong>{{$cliente->email}}</strong></h5>
						<br>

						<button onclick="alterarSenha('{{$cliente->id}}')" class="btn btn-danger"><span class="fa fa-key mr-2"></span>Alterar senha</button>

					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="title-section text-center mb-md-5 mb-4">
			<p class="w3ls-title-sub">Endereços</p>
		</div>

		<div class="row">


			@foreach($cliente->enderecos as $e)
			<div class="col-lg-12 col-md-12">
				<div class="card border-0 med-blog">
					<div class="card-header ">
						<h5 class="mb-0">Rua: <strong>{{$e->rua}}</strong></h5>
						<h5 class="mb-0">Número: <strong>{{$e->numero}}</strong></h5>
						<h5 class="mb-0">Bairro: <strong>{{$e->bairro()}}</strong></h5>
						<h5 class="mb-0">Referência: <strong>{{$e->referencia}}</strong></h5>
						<br>

						<a href="/info/alterarEndereco/{{$e->id}}" class="btn btn-warning"><span class="fa fa-edit mr-2"></span>Alterar</a>

					</div>
				</div>
			</div>

			@endforeach
		</div>


	</div>
</section>



@endsection	
