@extends('delivery.default')
@section('content')

<style type="text/css">

.pulsate {
	-webkit-animation: pulsate 3s ease-out;
	-webkit-animation-iteration-count: infinite; 
	opacity: 0.5;
}
@-webkit-keyframes pulsate {
	0% { 
		opacity: 0.5;
	}
	50% { 
		opacity: 1.0;
	}
	100% { 
		opacity: 0.5;
	}
}
#map{
	width: 100%;
	height: 500px;
	background: #999;
}

.margin{
	margin-top: 10px;
}



@media only screen and (max-width: 400px) {
	#endereco-modal{
		width: 100%; height: 100%; margin-left: 0px;
	}

	.modal-body { height: 500px; margin-left: 0px;}
	.popup{
		margin-left: 0px;
	}
}
@media only screen and (min-width: 401px) and (max-width: 1699px){
	#endereco-modal{
		width: 100%;
	}

	.modal-body{
		height: 600px;
		overflow-y: auto;
		width: 380px;
		margin-left: 0px;

	}

}


</style>



<div class="row" id="content" style="display: block;">


	<section class="blog_w3ls">
		<div class="container">
			<div class="title-section text-center mb-md-5 mb-4">
				<h3 class="w3ls-title mb-3">Alterar Endereço</h3>
				
			</div>	
			<form method="post" action="/info/updateEndereco">
				<div class="col-lg-12 col-md-12">

					<input type="hidden" name="endereco_id" value="{{$endereco->id}}">


					@csrf

					<div class="form-group">
						<label>Rua</label>
						<input type="text" class="form-control fr" value="{{$endereco->rua}}" name="rua" placeholder="" required="">
					</div>

					<div class="form-group">
						<label class="mb-2">Número</label>
						<input type="text" class="form-control fr" value="{{$endereco->numero}}" name="numero" required="true">
					</div>


					@if($config->usar_bairros == 1)

					<div class="form-group">
						<label class="mb-2">Bairro</label>
						<select name="bairro_id" class="form-control">
							<option value="" disabled selected hidden>Selecione o bairro...</option>
							@foreach($bairros as $b)
							<option @if($endereco->bairro_id == $b->id) selected @endif value="{{$b->id}}">{{$b->nome}} - R$ {{number_format($b->valor_entrega, 2)}}</option>
							@endforeach
						</select>
					</div>

					@else
					<div class="form-group">
						<label class="mb-2">Bairro</label>
						<input type="text" class="form-control fr" value="{{$endereco->bairro}}" name="bairro" required="true">
					</div>
					@endif

					<div class="form-group">
						<label class="mb-2">Referencia ou apartamento</label>
						<input type="text" class="form-control fr" value="{{$endereco->referencia}}" name="referencia" required="">
					</div>
					
				</div>


				<button type="submit" id="finalizar-venda" class="btn btn-success btn-lg btn-block">
					<span class="fa fa-check mr-2"></span> Salvar
				</button>
			</form>


		</div>
	</section>

	
	<br>
</div>



@endsection	
