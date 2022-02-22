@extends('default.layout')
@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/funcionarios/saveContato">

				<input type="hidden" value="{{$funcionario->id}}" name="funcionario_id">
				<input type="hidden" name="id" value="{{{ isset($contato->id) ? $contato->id : 0 }}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">Lista de contatos de <strong style="margin-left: 4px;" class="text-danger">{{$funcionario->nome}}</strong></h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">


									<div class="row">
										<div class="form-group validated col-sm-10 col-lg-10">
											<label class="col-form-label">Nome</label>
											<div class="">
												<input id="nome" type="text" class="form-control @if($errors->has('nome')) is-invalid @endif" 
												value="{{{ isset($contato->id) ? $contato->nome : old('nome') }}}" name="nome">
												@if($errors->has('nome'))
												<div class="invalid-feedback">
													{{ $errors->first('nome') }}
												</div>
												@endif
											</div>
										</div>
									</div>


									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-3">
											<label class="col-form-label">Telefone</label>
											<div class="">
												<input id="telefone" type="text" class="form-control @if($errors->has('telefone')) is-invalid @endif" 
												value="{{{ isset($contato->id) ? $contato->telefone : old('telefone') }}}" name="telefone">
												@if($errors->has('telefone'))
												<div class="invalid-feedback">
													{{ $errors->first('telefone') }}
												</div>
												@endif
											</div>
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
						<button type="reset" style="width: 100%" class="btn btn-danger">
							<i class="la la-close"></i>
							<span class="">Limpar</span>
						</button>
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

<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="margin-top: -40px">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<div class="card card-custom gutter-b example example-compact">
					<div class="card-header">
						<h3 class="card-title">Lista de Contatos</h3>
					</div>

				</div>

				<label>Total de registros: {{count($funcionario->contatos)}}</label>
				<div class="row">
					@foreach($funcionario->contatos as $c)


					<div class="col-sm-12 col-lg-6 col-md-6 col-xl-4">
						<div class="card card-custom gutter-b example example-compact bg-primary">
							<div class="card-header">
								<div class="card-title">
									<h3 style="width: 230px; font-size: 12px; height: 10px;" class="card-title text-white">{{$c->id}} - {{substr($c->nome, 0, 30)}}
									</h3>
								</div>

								<div class="card-toolbar">
									<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Ações">
										<a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-ellipsis-h"></i>
										</a>
										<div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
											<!--begin::Navigation-->
											<ul class="navi navi-hover">
												<li class="navi-header font-weight-bold py-4">
													<span class="font-size-lg">Ações:</span>
												</li>
												<li class="navi-separator mb-3 opacity-70"></li>

												<li class="navi-item">
													<a href="/funcionarios/editContato/{{ $c->id }}" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-primary">Editar</span>
														</span>
													</a>
												</li>

												<li class="navi-item">
													<a onclick="if(!confirm('Deseja excluir este registro?')) { return false; }" 
													href="/funcionarios/deleteContato/{{$c->id}}" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-danger">Excluir</span>
														</span>
													</a>
												</li>

											</ul>
											<!--end::Navigation-->
										</div>
									</div>

								</div>

								<div class="card-body">

									<div class="kt-widget__info">
										<span class="kt-widget__label text-white">Telefone:</span>
										<a target="_blank" class="kt-widget__data text-white">{{ $c->telefone }}</a>
									</div>

								</div>

							</div>

						</div>

					</div>

					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@endsection