@extends('default.layout')
@section('content')

<div class="row" id="anime" style="display: none">
	<div class="col s8 offset-s2">
		<lottie-player src="/anime/success-upload.json" background="transparent" speed="0.8" style="width: 100%; height: 300px;" autoplay>
		</lottie-player>
	</div>
</div>

<div class="row" id="content" style="display: block">
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

		<div class="container">
			<div class="card card-custom gutter-b example example-compact">
				<div class="col-lg-12">
					<!--begin::Portlet-->


					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">Nova Cotação</h3>
						</div>



						<div class="row">
							<input type="hidden" id="_token" value="{{ csrf_token() }}">


							<div class="col-xl-12">
								<div class="form-group validated col-sm-12 col-lg-12">

									<div class="kt-section kt-section--first">
										<div class="kt-section__body">

											<div class="row">
												<div class="form-group validated col-sm-6 col-lg-6">
													<label class="col-form-label" id="lbl_cpf_cnpj">Fornecedor</label>
													<div class="">
														<select class="form-control select2 fornecedor" id="kt_select2_1" name="cidade">
															@foreach($fornecedores as $f)
															<option value="{{$f->id}}">{{$f->id}} - {{$f->razao_social}}</option>
															@endforeach
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">Itens da Cotação</h3>
						</div>

						<div class="col-xl-12">
							<div class="row">
								<div class="form-group validated col-sm-5 col-lg-5">
									<label class="col-form-label" id="lbl_cpf_cnpj">Produto</label>
									<div class="">
										<select class="form-control select2 produto" id="kt_select2_2">
											@foreach($produtos as $f)
											<option value="{{$f->id}} - {{$f->nome}}">{{$f->id}} - {{$f->nome}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group validated col-sm-3 col-lg-2">
									<label class="col-form-label" id="">Quantidade</label>
									<div class="">
										<input type="text" id="quantidade" class="form-control" value="">

									</div>
								</div>
								<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0"><br>
									<button style="margin-top: 17px;" id="addProd" class="btn btn-light-success px-6 font-weight-bold">Adicionar</button>
								</div>
							</div>

							<div class="row">
								<div class="col-xl-12">
									<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

										<table class="datatable-table" style="max-width: 100%;overflow: scroll">
											<thead class="datatable-head">
												<tr class="datatable-row" style="left: 0px;">
													<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">#</span></th>
													<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Código Produto</span></th>
													<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 550px;">Produto</span></th>
													<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Quantidade</span></th>
													<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Ações</span></th>
												</tr>
											</thead>

											<tbody id="body" class="datatable-body">

											</tbody>

										</table>


									</div>
									<div class="row">
										<h5 style="margin-top: 20px;">Total de Itens: <strong class="blue-text" id="total_itens">0</strong></h5>
									</div>
								</div>

							</div>


						</div>

					</div>

					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<div class="form-group validated col-sm-4 col-lg-4">
								<label class="col-form-label" id="">Referencia <strong class="red-text">(Necessário para clonar)</strong></label>
								<div class="">
									<input maxlength="20" type="text" id="referencia" class="form-control" value="">

								</div>
							</div>

							<div class="form-group validated col-sm-8 col-lg-8">
								<label class="col-form-label" id="">Observação</label>
								<div class="">
									<input maxlength="100" type="text" id="obs" class="form-control" value="">

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
							<a style="width: 100%" class="btn btn-danger" href="/cotacao">
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
			</div>

		</div>
	</div>

</div>

@endsection