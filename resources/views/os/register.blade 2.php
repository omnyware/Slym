@extends('default.layout')
@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="{{{ isset($ordem) ? '/ordemServico/update': '/ordemServico/save' }}}">

					<input type="hidden" name="id" value="{{{ isset($ordem->id) ? $ordem->id : 0 }}}">

					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{{ isset($ordem) ? "Editar": "Adicionar" }}} Ordem de Serviço</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">
										<div class="form-group validated col-sm-12 col-lg-12">
											<label class="col-form-label" id="lbl_cpf_cnpj">Cliente</label>
											<div class="">
												<select class="form-control select2 cliente" id="kt_select2_1" name="cliente">
													@foreach($clientes as $c)
													<option value="{{$c->id}}">{{$c->id}} - {{$c->razao_social}} ({{$c->cpf_cnpj}})</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group validated col-sm-12 col-lg-12">
											<label class="col-form-label">Descrição</label>
											<div class="">
												<textarea class="form-control" name="descricao" rows="3">{{{ isset($os->descricao) ? $os->descricao : old('descricao') }}}</textarea>
												@if($errors->has('descricao'))
												<div class="invalid-feedback">
													{{ $errors->first('descricao') }}
												</div>
												@endif
											</div>
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
								<a style="width: 100%" class="btn btn-danger" href="/ordemServico">
									<i class="la la-close"></i>
									<span class="">Cancelar</span>
								</a>
							</div>
							<div class="col-lg-3 col-sm-6 col-md-4">
								<button style="width: 100%" id="salvar-cotacao" type="submit" class="btn btn-success">
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