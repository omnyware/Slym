@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">


	<div class="card-body">
		<div class="">
			<div class="col-sm-12 col-lg-4 col-md-6 col-xl-4">

				<a href="/eventos/novaAtividade/{{$evento->id}}" class="btn btn-lg btn-success">
					<i class="fa fa-plus"></i>Nova Atividade
				</a>
			</div>
		</div>
		<br>

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<form method="get" action="/eventos/filtroAtividade">
				<div class="row align-items-center">

					<input type="hidden" name="evento_id" value="{{$evento->id}}">

					<div class="form-group col-lg-3 col-md-4 col-sm-6">
						<label class="col-form-label">Reponsável</label>
						<div class="">
							<div class="input-group">
								<input type="text" name="responsavel" class="form-control" value="{{{isset($responsavel) ? $responsavel : ''}}}" />
							</div>
						</div>
					</div>

					<div class="form-group col-lg-2 col-md-4 col-sm-6">
						<label class="col-form-label">Estado</label>
						<div class="">
							<div class="input-group date">
								<select class="custom-select form-control" id="estado" name="estado">
									<option @if(isset($estado) && $estado == 'TODOS') selected @endif value="TODOS">TODOS</option>
									<option @if(isset($estado) && $estado == 'CONCLUIDO') selected @endif value="1">CONCLUIDO</option>
									<option @if(isset($estado) && $estado == 'OPERANDO') selected @endif value="0">OPERANDO</option>
								</select>
							</div>
						</div>
					</div>

					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button style="margin-top: 15px;" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
					</div>
				</div>
			</form>
			<br>
			<h4>Lista de Atividades</h4>

			<div class="row">

				@foreach($atividades as $e)

				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-6">
					<div class="card card-custom gutter-b example example-compact" style="height: 350px;">
						<div class="card-header">
							<div class="card-title">
								<h3 style="width: 230px; font-size: 12px; height: 10px;" class="card-title">
									{{$e->responsavel_nome}}
								</h3>
							</div>

							
						</div>

						<div class="card-body">

							<div class="kt-widget__info">
								<span class="kt-widget__label">Atividades:</span>
								<a target="_blank" class="kt-widget__data text-success">
									@foreach($e->servicos as $key => $s)
									<span>{{$s->servico->nome}}
										@if($key < sizeof($e->servicos)-1) |
										@endif
									</span>
									@endforeach
								</a>
							</div>
							<div class="kt-widget__info">
								<span class="kt-widget__label">Status:</span>
								<a target="_blank" class="kt-widget__data text-success">
									@if($e->status)
									<span class="label label-xl label-inline label-light-info">CONCLUIDO</span>
									@else
									<span class="label label-xl label-inline label-light-success">OPERANDO</span>
									@endif
								</a>
							</div>
							<div class="kt-widget__info">
								<span class="kt-widget__label">Início:</span>
								<a target="_blank" class="kt-widget__data text-success">
									{{ \Carbon\Carbon::parse($e->inicio)->format('H:i')}}
								</a>
							</div>
							<div class="kt-widget__info">
								<span class="kt-widget__label">Fim:</span>
								<a target="_blank" class="kt-widget__data text-danger">
									{{ \Carbon\Carbon::parse($e->fim)->format('H:i')}}
								</a>
							</div>

							@if($e->status == 1)
							<div class="kt-widget__info">
								<span class="kt-widget__label">Valor:</span>
								<a target="_blank" class="kt-widget__data text-danger">
									{{ number_format($e->total, 2, ',', '.')}}
								</a>
							</div>
							@endif


						</div>

						<div class="card-footer">
							@if($e->status == 0)
							<a style="width: 100%;" href="/eventos/finalizarAtividade/{{$e->id}}" class="btn btn-light-danger">
								<i class="la la-close"></i>
								Finalizar
							</a>
							@else
							<a style="width: 100%;" href="/eventos/finalizarAtividade/{{$e->id}}" class="btn btn-light-info">
								<i class="la la-list"></i>
								
								Detalhes
							</a>
							@endif

							<a style="width: 100%;" target="_blank" href="/eventos/imprimirComprovante/{{$e->id}}" class="btn btn-light-primary">
								<i class="la la-print"></i>
								Imprimir
							</a>
						</div>
					</div>
				</div>

				@endforeach

			</div>

			<div class="d-flex justify-content-between align-items-center flex-wrap">
				<div class="d-flex flex-wrap py-2 mr-3">
					@if(isset($links))
					{{$eventos->links()}}
					@endif
				</div>
			</div>
		</div>

	</div>
</div>

@endsection