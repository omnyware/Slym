@extends('default.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->
				<input type="hidden" value="{{json_encode($categorias)}}" id="categorias" name="">
				<input type="hidden" value="{{json_encode($servicos)}}" id="servicos" name="">
				<form method="post" action="/eventos/salvarAtividade">
					<input type="hidden" name="id" value="{{{ isset($evento) ? $evento->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">
								Nova atividade para evento <strong style="margin-left: 5px;" class="text-info">{{$evento->nome}}</strong>
							</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">
										<div class="form-group validated col-sm-6 col-lg-6">
											<label class="col-form-label">Nome responsável</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('responsavel_nome')) is-invalid @endif" value="{{old('responsavel_nome')}}" name="responsavel_nome">
												@if($errors->has('responsavel_nome'))
												<div class="invalid-feedback">
													{{ $errors->first('responsavel_nome') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">Telefone responsável</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('responsavel_telefone')) is-invalid @endif telefone" value="{{old('responsavel_telefone')}}" name="responsavel_telefone">
												@if($errors->has('responsavel_telefone'))
												<div class="invalid-feedback">
													{{ $errors->first('responsavel_telefone') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-6 col-lg-6">
											<label class="col-form-label">Nome criança</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('crianca_nome')) is-invalid @endif" name="crianca_nome">
												@if($errors->has('crianca_nome'))
												<div class="invalid-feedback">
													{{ $errors->first('crianca_nome') }}
												</div>
												@endif
											</div>
										</div>
										
										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">Início</label>
											<div class="">
												<input type="text" value="{{$hora}}" class="form-control @if($errors->has('inicio')) is-invalid @endif picker" id="inicio" name="inicio">
												@if($errors->has('inicio'))
												<div class="invalid-feedback">
													{{ $errors->first('inicio') }}
												</div>
												@endif
											</div>
										</div>


									</div>

									@if(sizeof($categorias) > 1)
									<div class="categorias" style="margin-top: 15px;">
										<h3>Categorias</h3>
										@foreach($categorias as $key => $c)
										<button @if($key == 0) class="btn btn-info" @else class="btn btn-light" @endif id="cat_{{$c->id}}" onclick="filtraServicos('{{$c->id}}')">
											{{$c->nome}}
										</button>
										@endforeach
									</div>
									@endif

									<h3>Serviços</h3>

									<div class="servicos">

									</div>
									@if($errors->has('servicos_selecionados'))
									<p class="text-danger">
										{{ $errors->first('servicos_selecionados') }}
									</p>
									@endif

									

									<div class="row" style="">
										<div class="form-group validated col-sm-3 col-lg-3">
											<!-- <label class="col-form-label">Término</label> -->
											<div class="">
												<input type="hidden" class="form-control @if($errors->has('fim')) is-invalid @endif picker" id="fim" name="fim">
												@if($errors->has('fim'))
												<div class="invalid-feedback">
													{{ $errors->first('fim') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row" style="margin-top: 10px;">
										<div class="col-sm-12">
											<h3>Total: R$ <strong class="text-success" id="somaValor">0</strong></h3>
										</div>
									</div>
									<!-- <div class="row">
										<div class="col-sm-12">
											<h3>Tempo de Serviço: <strong class="text-danger" id="tempoServico">0</strong> Min.</h3>
										</div>
									</div> -->



									<input type="hidden" id="servicos_selecionados" name="servicos_selecionados">
									<input type="hidden" name="total" id="total">

								</div>
							</div>
						</div>
					</div>
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
				</form>
			</div>
		</div>
	</div>
</div>

@endsection