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
	<form method="post" enctype="multipart/form-data" action="/ibpt/new">

		<div class="container">
			<div class="card card-custom gutter-b example example-compact">
				<div class="col-lg-12">
					<!--begin::Portlet-->


					<input type="hidden" name="id" value="{{{ isset($cliente) ? $cliente->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">@if(isset($ibpt)) Atualizar @else Nova @endif Tabela IBPT @if(isset($ibpt)) <strong style="margin-left: 5px;" class="text-info">{{$ibpt->uf}}</strong> @endif</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="row">
								<div class="col-lg-4">

									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="ibpt_id" value="@if(isset($ibpt)) {{$ibpt->id}} @else 0 @endif">
									<div class="form-group validated col-sm-10 col-lg-10">
										<label class="col-form-label">.CSV</label>
										<div class="">
											<span class="btn btn-primary btn-file">
												Procurar arquivo<input accept=".csv" name="file" type="file">
											</span>
											<label class="text-info" id="filename"></label>
										</div>
									</div>

								</div>

								@if(isset($estados))
								<div class="col-lg-4">

									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group validated col-sm-10 col-lg-10">
										<label class="col-form-label">UF</label>
										<div class="">
											<select name="uf" class="custom-select">
												@foreach($estados as $e)
												<option value="{{$e}}">{{$e}}</option>
												@endforeach
											</select>
										</div>
									</div>

								</div>
								@endif

								<div class="col-lg-4">

									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group validated col-sm-10 col-lg-10">
										<label class="col-form-label">Versão</label>
										<div class="">
											<input type="" name="versao" value="@if(isset($ibpt)) {{$ibpt->versao}} @endif" class="form-control" name="">
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
							<button id="send-csv" style="width: 100%" type="submit" class="btn btn-success spinner-white spinner-right">
								<i class="la la-check"></i>
								<span class="">Importar CSV</span>
							</button>
						</div>

					</div>
				</div>
			</div>
		</div>
	</form>
</div>

@endsection