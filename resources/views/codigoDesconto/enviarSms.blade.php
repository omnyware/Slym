@extends('default.layout')
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form class="col s12" method="post" action="/codigoDesconto/sms">
					@csrf
					<input type="hidden" value="{{$cupom->id}}" name="cupom_id">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">Envio de Notificação Push App Delivery</h3>
						</div>

					</div>
					@if($cupom->sms)
					<h4 class="text-danger">SMS JÁ ENVIADO</h4>
					@endif

					<h6>Créditos da Api: <strong class="text-info">{{$totalSms}}</strong></h6>
					<h6>Cupom: <strong class="text-info">{{$cupom->id}}</strong></h6>
					<h6>Código: <strong class="text-info">{{$cupom->codigo}}</strong></h6>
					<h6>Cliente: 
						@if($cupom->cliente_id != null)
						<strong class="text-info">{{$cupom->cliente->nome}}</strong>
						@else
						<strong class="text-info">Envio para todos ativos <strong>{{$cupom->totalDeClientesAtivosCad()}}</strong> cliente(s) ativo(s)</strong>
						@endif
					</h6>


					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">
									
									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-10">
											<label class="col-form-label">Titulo</label>
											<div class="">
												<textarea class="form-control" name="mensagem" placeholder="Descrição" rows="3">Utilize {{$cupom->codigo}} para desconto de @if($cupom->tipo == 'valor')R$@endif{{number_format($cupom->valor, 2)}}@if($cupom->tipo == 'percentual')%@endif, especial para você@if($cupom->cliente_id != null) {{$cupom->cliente->nome}}@endif!</textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">

								<div class="row">
									<div class="col-xl-2">

									</div>
									<div class="col-lg-3 col-sm-6 col-md-4">
										<a style="width: 100%" class="btn btn-danger" href="/codigoDesconto">
											<i class="la la-close"></i>
											<span class="">Cancelar</span>
										</a>
									</div>
									<div class="col-lg-3 col-sm-6 col-md-4">
										<button style="width: 100%" type="submit" class="btn btn-success">
											<i class="la la-send"></i>
											<span class="">Enviar</span>
										</button>
									</div>

								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection	