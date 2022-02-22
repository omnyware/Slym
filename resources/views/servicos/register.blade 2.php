@extends('default.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="{{{ isset($servico) ? '/servicos/update': '/servicos/save' }}}" enctype="multipart/form-data">


					<input type="hidden" name="id" value="{{{ isset($servico) ? $servico->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{isset($servico) ? 'Editar' : 'Novo'}} Serviço</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">
										<div class="form-group validated col-sm-6 col-lg-10">
											<label class="col-form-label">Nome</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('nome')) is-invalid @endif" name="nome" value="{{{ isset($servico) ? $servico->nome : old('nome') }}}">
												@if($errors->has('nome'))
												<div class="invalid-feedback">
													{{ $errors->first('nome') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-6 col-lg-3">
											<label class="col-form-label">Valor</label>
											<div class="">
												<input type="text" id="valor" class="form-control @if($errors->has('valor')) is-invalid @endif" name="valor" value="{{{ isset($servico) ? $servico->valor : old('valor') }}}">
												@if($errors->has('valor'))
												<div class="invalid-feedback">
													{{ $errors->first('valor') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-6 col-lg-3">
											<label class="col-form-label">Tempo de serviço(min)</label>
											<div class="">
												<input type="text" id="tempo_servico" class="form-control @if($errors->has('tempo_servico')) is-invalid @endif" name="tempo_servico" value="{{{ isset($servico) ? $servico->tempo_servico : old('tempo_servico') }}}">
												@if($errors->has('tempo_servico'))
												<div class="invalid-feedback">
													{{ $errors->first('tempo_servico') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-6 col-lg-3">
											<label class="col-form-label">Comissão(opcional)</label>
											<div class="">
												<input type="text" id="comissao" class="form-control @if($errors->has('comissao')) is-invalid @endif money" name="comissao" value="{{{ isset($servico) ? $servico->comissao : old('comissao') }}}">
												@if($errors->has('comissao'))
												<div class="invalid-feedback">
													{{ $errors->first('comissao') }}
												</div>
												@endif
											</div>
										</div>
									</div>
									<div class="row">

										<div class="form-group validated col-lg-4 col-md-6 col-sm-10">
											<label class="col-form-label">Categoria</label>

											<select class="custom-select form-control" name="categoria_id">
												@foreach($categorias as $cat)
												<option value="{{$cat->id}}" @isset($produto) @if($cat->id == $servico->categoria_id)
													selected=""
													@endif
													@endisset >{{$cat->nome}}</option>
													@endforeach
												</select>

											</div>

											<div class="form-group validated col-lg-4 col-md-6 col-sm-10">
												<label class="col-form-label">Unidade de cobrança</label>

												<select class="custom-select form-control" name="unidade_cobranca">
													<option @isset($servico) @if($servico->unidade_cobranca == 'UN') selected @endif @endisset  value="UN">UN</option>
													<option @isset($servico) @if($servico->unidade_cobranca == 'HR') selected @endif @endisset  value="HR">HR</option>
													<option @isset($servico) @if($servico->unidade_cobranca == 'MIN') selected @endif @endisset  value="MIN">MIN</option>
												</select>

											</div>

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
									<a style="width: 100%" class="btn btn-danger" href="/categoriasConta">
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