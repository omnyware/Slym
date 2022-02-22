@extends('default.layout')
@section('content')
<div class="row" id="anime" style="display: none">
	<div class="col s8 offset-s2">
		<lottie-player src="/anime/success.json" background="transparent" speed="0.8" style="width: 100%; height: 300px;" autoplay>
		</lottie-player>
	</div>
</div>


<div class="row" id="content" style="display: block">

	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">



		<div class="container">
			<div class="card card-custom gutter-b example example-compact">
				<div class="col-lg-12">
					<!--begin::Portlet-->


					<input type="hidden" name="id" value="{{{ isset($cliente) ? $cliente->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">DADOS INICIAIS</h3>
						</div>

						<div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="between" data-wizard-clickable="true">
							<!--begin: Wizard Nav-->
							<div class="wizard-nav">
								<div class="wizard-steps px-8 py-8 px-lg-15 py-lg-3">
									<!--begin::Wizard Step 1 Nav-->
									<div class="wizard-step" data-wizard-type="step" data-wizard-state="done">
										<div class="wizard-label">
											<h3 class="wizard-title">
												<span>1.</span>ITENS</h3>
											<div class="wizard-bar"></div>
										</div>
									</div>
									<!--end::Wizard Step 1 Nav-->
									<!--begin::Wizard Step 2 Nav-->
									<div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
										<div class="wizard-label">
											<h3 class="wizard-title">
												<span>2.</span>PAGAMENTO</h3>
											<div class="wizard-bar"></div>
										</div>
									</div>
									<!--end::Wizard Step 2 Nav-->

								</div>
							</div>
							<!--end: Wizard Nav-->
							<!--begin: Wizard Body-->
							<div class="row justify-content-center py-10 px-8 py-lg-12 px-lg-10">
								<div class="col-xl-12">
									<!--begin: Wizard Form-->
									<form class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_form">
										<!--begin: Wizard Step 1-->
										<div class="pb-5" data-wizard-type="step-content">
											<h4 class="mb-10 font-weight-bold text-dark">Selecione o Fornecedor</h4>
											<!--begin::Input-->
											<select class="form-control select2 fornecedor" id="kt_select2_1" name="fornecedor">
												<option value="--">Selecione o fornecedor</option>
												@foreach($fornecedores as $f)
												<option value="{{$f->id}}">{{$f->razao_social}} ({{$f->cpf_cnpj}})</option>
												@endforeach
											</select>


											<div class="row" id="fornecedor" style="display: none">

												<br>
												<div class="col-sm-6 col-lg-6">
													<h5>Razão Social: <strong id="razao_social" class="red-text">--</strong></h5>
													<h5>Nome Fantasia: <strong id="nome_fantasia" class="red-text">--</strong></h5>
													<h5>Logradouro: <strong id="logradouro" class="red-text">--</strong></h5>
													<h5>Numero: <strong id="numero" class="red-text">--</strong></h5>

												</div>
												<div class="col-sm-6 col-lg-6">
													<h5>CPF/CNPJ: <strong id="cnpj" class="red-text">--</strong></h5>
													<h5>RG/IE: <strong id="ie" class="red-text">--</strong></h5>
													<h5>Fone: <strong id="fone" class="red-text">--</strong></h5>
													<h5>Cidade: <strong id="cidade" class="red-text">--</strong></h5>

												</div>


											</div>

											<hr>
											<br>
											<h4 class="mb-10 font-weight-bold text-dark">Produtos da Compra</h4>
											<div class="row">
												<div class="form-group validated col-sm-8 col-lg-8">
													<label class="col-form-label">Produto</label>
													<select class="form-control select2 produto" id="kt_select2_2" name="produto">
														@foreach($produtos as $p)
														<option value="{{$p->id}} - {{$p->nome}}">{{$p->id}} - {{$p->nome}}</option>
														@endforeach
													</select>
												</div>
												<div class="form-group validated col-sm-4 col-lg-4">
													<label class="col-form-label">Quantidade</label>
													<div class="">
														<input type="text" class="form-control" name="bairro" id="quantidade">

													</div>
												</div>

												<div class="form-group validated col-sm-4 col-lg-4">
													<label class="col-form-label">Valor Unitário</label>
													<div class="">
														<input type="text" class="form-control" name="valor" value="0" id="valor">

													</div>
												</div>

												<div class="form-group validated col-sm-4 col-lg-4">
													<label class="col-form-label">Quantidade</label>
													<div class="">
														<input type="text" class="form-control" id="subtotal" value="0" disabled>

													</div>
												</div>

												<div class="form-group validated col-sm-4 col-lg-4">
													<br>
													<a style="margin-top: 13px;" id="addProd" class="btn btn-success font-weight-bold text-uppercase px-9 py-4">
														Adicionar
													</a>
												</div>
											</div>

											<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded prod">
												<table class="datatable-table" style="max-width: 100%;overflow: scroll">
													<thead class="datatable-head">
														<tr class="datatable-row" style="left: 0px;">
															<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 60px;">#</span></th>
															<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 60px;">Código</span></th>
															<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Nome</span></th>
															<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Valor</span></th>
															<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Quantidade</span></th>
															<th data-field="Status" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Subtotal</span></th>
															<th data-field="Actions" data-autohide-disabled="false" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Ações</span></th>
														</tr>
													</thead>

													<tbody class="datatable-body">
													</tbody>

												</table>

											</div>
										</div>
										<!--end: Wizard Step 1-->


										<!--begin: Wizard Step 2-->
										<div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
											<h4 class="mb-10 font-weight-bold text-dark">Selecione a forma de pagamento</h4>
											<!--begin::Input-->
											<div class="row">
												<div class="form-group validated col-sm-8 col-lg-8">
													<label class="col-form-label">Forma de pagamento</label>
													<select class="custom-select form-control" id="formaPagamento">
														<option value="--">Selecione a forma de pagamento</option>
														<option value="a_vista">A vista</option>
														<option value="30_dias">30 Dias</option>
														<option value="personalizado">Personalizado</option>
													</select>
												</div>
												<div class="form-group validated col-sm-2 col-lg-2">
													<label class="col-form-label">Quantidade de parcelas</label>
													<div class="">
														<input type="text" class="form-control" name="bairro" id="qtdParcelas">

													</div>
												</div>

												<div class="form-group validated col-sm-4 col-lg-4">
													<label class="col-form-label">Data de Vencimento</label>
													<div class="">
														<div class="input-group date">
															<input type="text" class="form-control data-input" id="kt_datepicker_3">
															<div class="input-group-append">
																<span class="input-group-text">
																	<i class="la la-calendar"></i>
																</span>
															</div>
														</div>
													</div>
												</div>

												<div class="form-group validated col-sm-4 col-lg-4">
													<label class="col-form-label">Valor da parcela</label>
													<div class="">
														<input type="text" class="form-control" id="valor_parcela">

													</div>
												</div>

												<div class="form-group validated col-sm-4 col-lg-4">
													<br>
													<a style="margin-top: 13px;" id="add-pag" class="btn btn-primary font-weight-bold text-uppercase px-9 py-4">
														Adicionar Pag.
													</a>
												</div>
											</div>

											<div class="row">
												<div class="form-group validated col-sm-12 col-lg-12">

													<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded fatura">
														<table class="datatable-table" style="max-width: 100%;overflow: scroll">
															<thead class="datatable-head">
																<tr class="datatable-row" style="left: 0px;">
																	<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 260px;">Parcela</span></th>
																	<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 260px;">Data</span></th>
																	<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 260px;">Valor</span></th>
																</tr>
															</thead>

															<tbody class="datatable-body">
															</tbody>

														</table>

													</div>
												</div>
											</div>

										</div>
										<!--end: Wizard Step 2-->

										<!--begin: Wizard Actions-->
										<div class="d-flex justify-content-between border-top mt-5 pt-10">
											<div class="mr-2">
												<button type="button" class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-prev">Voltar para Itens</button>
											</div>
											<div>
												<!-- <button type="button" class="btn btn-success font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-submit">Salvar Compra</button> -->
												<button type="button" class="btn btn-primary font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-next">Ir Paga pagamento</button>
											</div>
										</div>
										<!--end: Wizard Actions-->

									</form>
									<!--end: Wizard Form-->
								</div>
							</div>
							<!--end: Wizard Body-->
						</div>

						<div class="row justify-content-center py-10 px-8 py-lg-12 px-lg-10">
							<div class="col-xl-12">
								<h5>Valor Total R$ <strong id="total" class="cyan-text">0,00</strong></h5>
								<div class="row">

									<div class="form-group validated col-sm-2 col-lg-2">
										<label class="col-form-label">Desconto</label>
										<div class="">
											<input type="text" class="form-control" id="desconto">

										</div>
									</div>

									<div class="form-group validated col-sm-8 col-lg-8">
										<label class="col-form-label">Observação</label>
										<div class="">
											<input type="text" class="form-control" id="obs">

										</div>
									</div>

									<div class="form-group validated col-sm-4 col-lg-2">
										<br>
										<button type="button" class="btn btn-success font-weight-bold text-uppercase px-9 py-4 disabled" id="salvar-venda" style="width: 100%; margin-top: 13px;" href="#" onclick="salvarCompra()">Finalizar</button>

									</div>

								</div>
							</div>
						</div>

					</div>

				</div>
			</div>

			<input type="hidden" id="_token" value="{{ csrf_token() }}">


		</div>

	</div>
</div>


@endsection