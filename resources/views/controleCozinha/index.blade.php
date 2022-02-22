@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">
		<div class="row">
			<h2 class="center-align">Controle de Pedidos</h2>
			<div class="col-sm-6 col-lg-6 col-md-6 col-xl-6">

				<div class="progresso" style="display: none">
					<div class="spinner spinner-track spinner-primary spinner-lg mr-15"></div>
				</div>
			</div>
		</div>

		<div class="row" id="itens">

			

			<!-- <div class="col-sm-6 col-lg-6 col-md-12">
				<div class="card card-custom gutter-b">
					<div class="card-header">
						<h3 style="margin-top: 20px;">Item Pedido: <strong class="text-success">1</strong></h3>
					</div>

					<div class="card-body">
						<h6>03/11/2020 09:15</h6>
						<h6>Item: <strong>Coca cola</strong></h6>
						<h6>Adicionais: <strong>Coca cola</strong></h6>
						<h6>Sabores: <strong>Coca cola</strong></h6>
						
					</div>

					<div class="card-footer">

						<a style="width: 100%; margin-top: 5px;" class="btn btn-success">
							<i class="la la-check"></i>Pronto
						</a>

					</div>
				</div>
			</div> -->

			<!-- <div id="itens">

			</div> -->
		</div>
	</div>
</div>

@endsection	