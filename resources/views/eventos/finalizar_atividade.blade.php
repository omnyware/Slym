@extends('default.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/eventos/finalizarAtividade">
					<input type="hidden" name="atividade" value="{{{ isset($atividade) ? $atividade->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">
								Finalizar atividade evento: <strong style="margin-left: 5px;" class="text-info">{{$atividade->evento->nome}}</strong>
							</h3>

						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<h4 class="card-title">Responsável: 
										<strong class="text-info">{{$atividade->responsavel_nome}} - {{$atividade->responsavel_telefone}}</strong>
									</h4>

									<h4 class="card-title">Criança: 
										<strong class="text-info">
											{{$atividade->crianca_nome}}
										</strong>
									</h4>

									<h4 class="card-title">Inicio: 
										<strong class="text-success">
											{{$atividade->inicio}}
										</strong>
									</h4>

									<h4 class="card-title">Fim: 
										<strong class="text-danger">
											{{$atividade->fim}}
										</strong>
									</h4>

									@if($diferencaReal > $diferencaContratada)
									<h4 class="card-title">Tempo esgotado: 
										<strong class="text-danger">
											{{$diferencaReal - $diferencaContratada}} min
										</strong>
									</h4>
									@else
									<h4 class="card-title text-success">Tempo OK
									</h4>
									@endif

									@if($atividade->status == 0)

									<h4 class="card-title">Valor presumido: 
										<strong class="text-danger">
											R$ {{number_format($soma, 2, ',', '.')}} 
										</strong>
									</h4>
									@else
									<h4 class="card-title">Total: 
										<strong class="text-danger">
											R$ {{number_format($atividade->total, 2, ',', '.')}} 
										</strong>
									</h4>
									@endif

									@foreach($atividade->servicos as $key => $s)
									<span style="font-size: 20px;" class="text-info">{{$s->servico->nome}}
										@if($key < sizeof($atividade->servicos)-1) |
										@endif
									</span>
									@endforeach

									@if($atividade->status == 0)
									<div class="row">
										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">Valor total</label>
											<div class="">
												<input type="text" class="form-control money" value="{{number_format($soma, 2)}}" name="valor_total">
												@if($errors->has('valor_total'))
												<div class="invalid-feedback">
													{{ $errors->first('valor_total') }}
												</div>
												@endif
											</div>
										</div>
									</div>
									@endif
								</div>
							</div>
						</div>
					</div>

					@if($atividade->status == 0)
					<div class="card-footer">
						<div class="row">
							<div class="col-xl-2">

							</div>
							<div class="col-lg-3 col-sm-6 col-md-4">
								<a style="width: 100%" class="btn btn-danger" href="">
									<i class="la la-close"></i>
									<span class="">Cancelar</span>
								</a>
							</div>
							<div class="col-lg-3 col-sm-6 col-md-4">
								<button style="width: 100%" type="submit" class="btn btn-success">
									<i class="la la-check"></i>
									<span class="">Salvar</span>
								</button>
							</div>

						</div>
					</div>
					@endif
				</form>
			</div>
		</div>
	</div>
</div>

@endsection