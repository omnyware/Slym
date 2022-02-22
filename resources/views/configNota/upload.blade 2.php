@extends('default.layout')
@section('content')
<style type="text/css">
.btn-file {
	position: relative;
	overflow: hidden;
}

.btn-file input[type=file] {
	position: absolute;
	top: 0;
	right: 0;
	min-width: 100%;
	min-height: 100%;
	font-size: 100px;
	text-align: right;
	filter: alpha(opacity=0);
	opacity: 0;
	outline: none;
	background: white;
	cursor: inherit;
	display: block;
}
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form class="container" method="post" action="/configNF/certificado" enctype="multipart/form-data">



					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">Upload de Certificado</h3>
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
											<label class="col-form-label">Arquivo</label>
											<div class="">
												<span style="width: 100%" class="btn btn-primary btn-file">
													Procurar arquivo<input accept=".bin, .pfx" name="file" type="file">

												</span>
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">Senha</label>
											<div class="">
												<input id="senha" type="password" class="form-control @if($errors->has('razao_social')) is-invalid @endif" name="senha" >
												
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
								<a style="width: 100%" class="btn btn-danger" href="/configNF">
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