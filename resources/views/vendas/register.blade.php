@extends('default.layout')
@section('content')
<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="content d-flex flex-column flex-column-fluid" id="kt_content" >

			<div class="row" id="anime" style="display: none">
				<div class="col s8 offset-s2">
					<lottie-player src="/anime/success.json" background="transparent" speed="0.8" style="width: 100%; height: 300px;" autoplay >
					</lottie-player>
				</div>
			</div>

			<div class="col-lg-12" id="content">
				<!--begin::Portlet-->

				<h3 class="card-title">DADOS INICIAIS</h3>

				<input type="hidden" id="produtos" value="{{json_encode($produtos)}}" name="">
				<input type="hidden" id="clientes" value="{{json_encode($clientes)}}" name="">
				<input type="hidden" id="_token" value="{{csrf_token()}}" name="">

				@if(isset($cliente))
				<input type="hidden" id="cliente_crediario" value="{{$cliente}}">
				@endif
				@if(isset($itens))
				<input type="hidden" value="{{json_encode($itens)}}" id="itens_credito">
				@endif
				
				<div class="row">
					<div class="col-xl-12">

						<div class="kt-section kt-section--first">
							<div class="kt-section__body">

								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-6">

										<h6>Ultima NF-e: <strong>{{$lastNF}}</strong></h6>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-6">

										@if($config->ambiente == 2)
										<h6>Ambiente: <strong class="text-primary">Homologação</strong></h6>
										@else
										<h6>Ambiente: <strong class="text-success">Produção</strong></h6>
										@endif
									</div>
								</div>

								<div class="row">
									<div class="form-group col-lg-4 col-md-4 col-sm-6">
										<label class="col-form-label">Natureza de Operação</label>
										<div class="">
											<div class="input-group date">
												<select class="custom-select form-control" id="natureza" name="natureza">
													@foreach($naturezas as $n)
													<option 
													@if($config->nat_op_padrao == $n->id)
													selected
													@endif
													value="{{$n->id}}">{{$n->natureza}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									@if(isset($listaPreco))
									<div class="form-group col-lg-4 col-md-4 col-sm-6">
										<label class="col-form-label">Lista de Preço</label>
										<div class="">
											<div class="input-group date">
												<select class="custom-select form-control" id="lista_id" name="lista_id">
													<option value="0">Padrão</option>
													@foreach($listaPreco as $l)
													<option value="{{$l->id}}">{{$l->nome}} - {{$l->percentual_alteracao}}%</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									@endif
								</div>

								<div class="row">
									<div class="form-group validated col-sm-9 col-lg-9 col-12">
										<label class="col-form-label" id="">Cliente</label><br>
										<select class="form-control select2" style="width: 100%" id="kt_select2_3" name="cliente">
											<option value="null">Selecione o cliente</option>
											@foreach($clientes as $c)
											<option value="{{$c->id}}">{{$c->id}} - {{$c->razao_social}} ({{$c->cpf_cnpj}})</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="row" id="div-cliente" style="display: none">
									<div class="col-xl-12">

										<div class="card card-custom gutter-b">
											<div class="card-body">

												<h4 class="center-align">CLIENTE SELECIONADO</h4>
												<div class="row">

													<div class="col-sm-6 col-lg-6 col-12">
														<h5>Razão Social: <strong id="razao_social" class="text-success">--</strong></h5>
														<h5>Nome Fantasia: <strong id="nome_fantasia" class="text-success">--</strong></h5>
														<h5>Logradouro: <strong id="logradouro" class="text-success">--</strong></h5>
														<h5>Numero: <strong id="numero" class="text-success">--</strong></h5>
														<h5>Limite: <strong id="limite" class="text-success"></strong></h5>
													</div>
													<div class="col-sm-6 col-lg-6 col-12">
														<h5>CPF/CNPJ: <strong id="cnpj" class="text-success">--</strong></h5>
														<h5>RG/IE: <strong id="ie" class="text-success">--</strong></h5>
														<h5>Fone: <strong id="fone" class="text-success">--</strong></h5>
														<h5>Cidade: <strong id="cidade" class="text-success">--</strong></h5>

													</div>
												</div>
											</div>
										</div>
									</div>

								</div>

							</div>
						</div>
					</div>

				</div>


				<!-- Wizzard -->
				<div class="card card-custom gutter-b">


					<div class="card-body">

						<div class="row">
							<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">

								<div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="between" data-wizard-clickable="true">
									<!--begin: Wizard Nav-->

									<div class="wizard-nav">

										<div class="wizard-steps px-8 py-8 px-lg-15 py-lg-3">
											<!--begin::Wizard Step 1 Nav-->
											<div class="wizard-step" data-wizard-type="step" data-wizard-state="done">
												<div class="wizard-label">
													<h3 class="wizard-title">
														<span>
															ITENS
														</span>
													</h3>
													<div class="wizard-bar"></div>
												</div>
											</div>
											<!--end::Wizard Step 1 Nav-->
											<!--begin::Wizard Step 2 Nav-->
											<div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
												<div class="wizard-label">
													<h3 class="wizard-title">
														<span>
															TRANSPORTE
														</span>
													</h3>
													<div class="wizard-bar"></div>
												</div>
											</div>

											<div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
												<div class="wizard-label">
													<h3 class="wizard-title">
														<span>
															PAGAMENTO
														</span>
													</h3>
													<div class="wizard-bar"></div>
												</div>
											</div>


										</div>
									</div>


									<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">

										<!--begin: Wizard Form-->
										<form class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_form">
											<!--begin: Wizard Step 1-->
											<div class="pb-5" data-wizard-type="step-content">

												<!-- Inicio da tabela -->

												<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
													<div class="row">
														<div class="col-xl-12">
															<div class="row align-items-center">
																<div class="form-group validated col-sm-6 col-lg-5 col-12">
																	<label class="col-form-label" id="">Produto</label><br>
																	<select class="form-control select2" style="width: 100%" id="kt_select2_1" name="produto">
																		<option value="null">Selecione o produto</option>
																		@foreach($produtos as $p)
																			@if ($p->ativo == 1)
																				<option value="{{$p->id}}">{{$p->id}} - {{$p->nome}}</option>
																			@endif
																		@endforeach
																	</select>
																</div>

																<div class="form-group col-lg-2 col-md-4 col-sm-6 col-6">
																	<label class="col-form-label">Quantidade</label>
																	<div class="">
																		<div class="input-group">
																			<input type="text" name="quantidade" class="form-control" value="0" id="quantidade"/>
																		</div>
																	</div>
																</div>
																<div class="form-group col-lg-2 col-md-4 col-sm-6 col-6">
																	<label class="col-form-label">Valor Unitário</label>
																	<div class="">
																		<div class="input-group">
																			<input type="text" name="valor" class="form-control money" value="0" id="valor"/>
																		</div>
																	</div>
																</div>

																<div class="form-group col-lg-2 col-md-4 col-sm-6 col-6">
																	<label class="col-form-label">Subtotal</label>
																	<div class="">
																		<div class="input-group">
																			<input type="text" name="subtotal" class="form-control" value="0" id="subtotal"/>
																		</div>
																	</div>
																</div>
																<div class="col-lg-1 col-md-4 col-sm-6 col-6">
																	<a href="#!" style="margin-top: 10px;" id="addProd" class="btn btn-light-success px-6 font-weight-bold">
																		<i class="la la-plus"></i>
																	</a>
																	
																</div>

															</div>
														</div>
													</div>


													<!-- Inicio tabela -->

													<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

														<table class="datatable-table" style="max-width: 100%; overflow: scroll;" id="prod">
															<thead class="datatable-head">
																<tr class="datatable-row" style="left: 0px;">
																	<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 70px;">Item</span></th>
																	<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 70px;">Cód Prod</span></th>
																	<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 300px;">Nome</span></th>
																	<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Quantidade</span></th>
																	<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>

																	<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Subtotal</span></th>

																	<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Ações</span></th>
																</tr>
															</thead>

															<tbody id="body" class="datatable-body">
																<tr class="datatable-row">

																</tr>
															</tbody>
														</table>
														<!-- Fim da tabela -->
													</div>
												</div>
											</div>

											<!--end: Wizard Step 1-->
											<!--begin: Wizard Step 2-->
											<div class="pb-5" data-wizard-type="step-content">

												<!-- Inicio do card -->

												<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
													<div class="row">
														<div class="col-xl-12">
															<h3>Transportadora</h3>

															<div class="row align-items-center">
																<div class="form-group validated col-sm-6 col-lg-5 col-12">
																	<select class="form-control select2" style="width: 100%" id="kt_select2_2" name="transportadora">
																		<option value="null">Selecione a transportadora (opcional)</option>
																		@foreach($transportadoras as $t)
																		<option value="{{$t->id}}">{{$t->id}} - {{$t->razao_social}}</option>
																		@endforeach
																	</select>
																</div>
															</div>
														</div>
													</div>
													<hr>

													<div class="row">
														<div class="col-xl-12">
															<h3>Frete</h3>

															<div class="row align-items-center">
																<div class="form-group validated col-sm-4 col-lg-4 col-8">
																	<label class="col-form-label" id="">Tipo</label>
																	<select class="custom-select form-control" id="frete" name="frete">
																		<option @if($config->frete_padrao == '0') selected @endif value="0">0 - Emitente</option>
																		<option @if($config->frete_padrao == '1') selected @endif  value="1">1 - Destinatário</option>
																		<option @if($config->frete_padrao == '2') selected @endif  value="2">2 - Terceiros</option>
																		<option @if($config->frete_padrao == '9') selected @endif  value="9">9 - Sem Frete</option>
																	</select>
																</div>

																<div class="form-group col-lg-2 col-md-4 col-sm-6 col-6">
																	<label class="col-form-label">Placa Veiculo</label>
																	<div class="">
																		<div class="input-group">
																			<input type="text" name="placa" class="form-control" value="" id="placa"/>
																		</div>
																	</div>
																</div>

																<div class="form-group validated col-sm-2 col-lg-2 col-6">
																	<label class="col-form-label" id="">UF</label>
																	<select class="custom-select form-control" id="uf_placa" name="uf_placa">
																		<option value="--">--</option>
																		<option value="AC">AC</option>
																		<option value="AL">AL</option>
																		<option value="AM">AM</option>
																		<option value="AP">AP</option>
																		<option value="BA">BA</option>
																		<option value="CE">CE</option>
																		<option value="DF">DF</option>
																		<option value="ES">ES</option>
																		<option value="GO">GO</option>
																		<option value="MA">MA</option>
																		<option value="MG">MG</option>
																		<option value="MS">MS</option>
																		<option value="MT">MT</option>
																		<option value="PA">PA</option>
																		<option value="PB">PB</option>
																		<option value="PE">PE</option>
																		<option value="PI">PI</option>
																		<option value="PR">PR</option>
																		<option value="RJ">RJ</option>
																		<option value="RN">RN</option>
																		<option value="RS">RS</option>
																		<option value="RO">RO</option>
																		<option value="RR">RR</option>
																		<option value="SC">SC</option>
																		<option value="SE">SE</option>
																		<option value="SP">SP</option>
																		<option value="TO">TO</option>
																	</select>
																</div>

																<div class="form-group col-lg-2 col-md-4 col-sm-6 col-6">
																	<label class="col-form-label">Valor</label>
																	<div class="">
																		<div class="input-group">
																			<input type="text" name="valor_frete" class="form-control" value="" id="valor_frete"/>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<hr>
													<div class="row">
														<div class="col-xl-12">
															<h3>Volume</h3>

															<div class="row align-items-center">
																
																<div class="form-group col-lg-3 col-md-4 col-sm-6 col-6">
																	<label class="col-form-label">Espécie</label>
																	<div class="">
																		<div class="input-group">
																			<input type="text" name="especie" class="form-control" value="" id="especie"/>
																		</div>
																	</div>
																</div>

																<div class="form-group col-lg-3 col-md-4 col-sm-6 col-6">
																	<label class="col-form-label">Marca</label>
																	<div class="">
																		<div class="input-group">
																			<input type="text" name="marca" class="form-control" value="" id="marca"/>
																		</div>
																	</div>
																</div>																

																<div class="form-group col-lg-3 col-md-4 col-sm-6 col-6">
																	<label class="col-form-label">Numeração de Volumes</label>
																	<div class="">
																		<div class="input-group">
																			<input type="text" name="numeracaoVol" class="form-control" value="" id="numeracaoVol"/>
																		</div>
																	</div>
																</div>

																<div class="form-group col-lg-3 col-md-4 col-sm-6 col-6">
																	<label class="col-form-label">Quantidade de Volumes</label>
																	<div class="">
																		<div class="input-group">
																			<input type="text" name="qtdVol" class="form-control" value="" id="qtdVol"/>
																		</div>
																	</div>
																</div>

																<div class="form-group col-lg-3 col-md-4 col-sm-6 col-6">
																	<label class="col-form-label">Peso Liquido</label>
																	<div class="">
																		<div class="input-group">
																			<input type="text" name="pesoL" class="form-control" value="" id="pesoL"/>
																		</div>
																	</div>
																</div>

																<div class="form-group col-lg-3 col-md-4 col-sm-6 col-6">
																	<label class="col-form-label">Peso Bruto</label>
																	<div class="">
																		<div class="input-group">
																			<input type="text" name="pesoB" class="form-control" value="" id="pesoB"/>
																		</div>
																	</div>
																</div>

																<a data-toggle="modal" href="#!" data-target="#modal-correios" style="margin-top: 14px;" class="btn btn-info" href="">
																	<i class="la la-truck"></i>
																	calcular frete
																</a>
															</div>
														</div>
													</div>

												</div>

											</div>
											<!--end: Wizard Step 2-->

											<div class="pb-5" data-wizard-type="step-content">

												<!-- Inicio do card -->

												<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
													<div class="row">
														<div class="col-xl-12">

															<div class="row">
																
																<div class="col-lg-4 col-md-4 col-sm-5 col-12">
																	<h3>Pagamento</h3>
																	

																	<div class="row">
																		
																		<div class="row">
																			<div class="form-group validated col-sm-12 col-lg-12 col-12">
																				<label class="col-form-label" id="">Tipo de Pagamento</label>
																				<select class="custom-select form-control" id="tipoPagamento" name="tipoPagamento">
																					<option value="--">Selecione o Tipo de pagamento</option>
																					@foreach($tiposPagamento as $key => $t)
																					<option 
																					@if($config->tipo_pagamento_padrao == $key)
																					selected
																					@endif
																					value="{{$key}}">{{$key}} - {{$t}}</option>
																					@endforeach
																				</select>
																			</div>
																		</div>
																		<div class="row">

																			<div class="form-group validated col-sm-12 col-lg-12 col-12">
																				<label class="col-form-label" id="">Forma de Pagamento</label>
																				<select class="custom-select form-control" id="formaPagamento" name="formaPagamento">
																					<option value="--">Selecione a forma de pagamento</option>
																					<option value="a_vista">A vista</option>
																					<option value="30_dias">30 Dias</option>
																					<option value="personalizado">Personalizado</option>
																					<option value="conta_crediario">Conta crediario</option>
																				</select>
																			</div>
																		</div>
																		<div class="row">

																			<div class="form-group col-lg-8 col-md-8 col-sm-8 col-12">
																				<label class="col-form-label">Quantidade de Parcelas</label>
																				<div class="">
																					<div class="input-group">
																						<input type="text" name="qtdParcelas" class="form-control" value="" id="qtdParcelas"/>
																					</div>
																				</div>
																			</div>

																			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-12">
																				<br>
																				<a data-toggle="modal" onclick="renderizarPagamento()" id="btn-modal-pagamentos"data-target="#modal-pagamentos" type="button" style="margin-top: 20px;" class="btn btn-light-info font-weight-bold disabled">
																					<i class="la la-list"></i>
																				</a>
																			</div>

																		</div>

																		<div class="row">

																			<div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
																				<label class="col-form-label">Data Vencimento</label>
																				<div class="">
																					<div class="input-group date">
																						<input type="text" name="data" class="form-control" id="kt_datepicker_3" />
																						<div class="input-group-append">
																							<span class="input-group-text">
																								<i class="la la-calendar"></i>
																							</span>
																						</div>
																					</div>
																				</div>
																			</div>

																			<div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
																				<label class="col-form-label">Valor Parcela</label>
																				<div class="">
																					<div class="input-group">
																						<input type="text" name="valor_parcela" class="form-control" value="" id="valor_parcela"/>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
																				<a id="add-pag" href="#!" style="width: 100%;" class="btn btn-light-success">
																					<i class="la la-check"></i>
																					Adicionar Pagamento
																				</a>
																			</div>
																		</div>

																	</div>
																</div>

																<div class="offset-lg-1 col-lg-7 col-md-7 col-sm-6 col-12">
																	<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
																		<div class="row">
																			<div class="col-xl-12">


																				<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

																					<table id="fatura" class="datatable-table" style="max-width: 100%; overflow: scroll;">
																						<thead class="datatable-head">
																							<tr class="datatable-row" style="left: 0px;">
																								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Parcela</span></th>
																								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Data</span></th>
																								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Valor</span></th>
																							</tr>
																						</thead>

																						<tbody class="datatable-body">
																							
																						</tbody>
																					</table>
																				</div>

																			</div>
																		</div>
																		<div class="row">
																			<button type="button" style="margin-top: 10px;" id="delete-parcelas" class="btn btn-light-danger">
																				<i class="la la-close"></i>
																				Excluir parcelas
																			</button>
																		</div>
																	</div>
																</div>
															</div>
														</div>


													</div>
												</div>
											</div>


										</form>

									</div>
								</div>
							</div>
						</div>

						<!-- Fim wizzard -->

					</div>
				</div>

				<div class="card card-custom gutter-b">


					<div class="card-body">

						<div class="row">
							<div class="col-sm-3 col-lg-4 col-md-6 col-xl-4">
								<h5 style="margin-top: 15px;">Valor Total: R$ <strong id="totalNF">0,00</strong></h5>
								<h5>Soma de quantidade: <strong id="soma-quantidade">0</strong></h5>
							</div>

							<div class="col-sm-2 col-lg-4 col-md-6 col-xl-2">
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
									<label class="col-form-label">Desconto</label>
									<div class="">
										<div class="input-group">
											<input type="text" name="desconto" class="form-control" value="" id="desconto"/>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-8 col-lg-8 col-md-12 col-xl-6">
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
									<label class="col-form-label">Informação Adicional</label>
									<div class="">
										<div class="input-group">
											<input type="text" name="obs" class="form-control" value="" id="obs"/>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-8 col-lg-8 col-md-12 col-xl-6">
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
									<label class="col-form-label">Nota Referenciada</label>
									<div class="">
										<div class="input-group">
											<input type="text" name="chave_ref" class="form-control" value="" id="chave_ref"/>
										</div>
									</div>
								</div>
							</div>							
						</div>
						<div class="row">
							<div class="col-sm-6 col-lg-6 col-md-6 col-xl-6 col-12">
								<a id="salvar-orcamento" style="width: 100%;" href="#" onclick="salvarOrcamento()" class="btn btn-primary disabled">Salvar como Orçamento</a>
							</div>

							<div class="col-sm-6 col-lg-6 col-md-6 col-xl-6 col-12">
								<a id="salvar-venda" style="width: 100%;" href="#" onclick="salvarVenda('nfe')" class="btn btn-success disabled">Salvar Venda</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-correios" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Calculo de Frete Correios</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group validated col-sm-4 col-lg-4 col-4">
						<label class="col-form-label" id="">Cep Origem</label>
						<input type="text" value="{{$config->cep}}" id="cep-origem-modal" class="form-control cepFrete">
					</div>

					<div class="form-group validated col-sm-4 col-lg-4 col-4">
						<label class="col-form-label" id="">Cep Destino</label>
						<input type="text" id="cep-destino-modal" class="form-control cepFrete">
					</div>

					<div class="form-group validated col-sm-4 col-lg-4 col-4">
						<label class="col-form-label" id="">Peso</label>
						<input type="text" id="peso-modal" class="form-control peso">
					</div>

					<div class="form-group validated col-sm-4 col-lg-4 col-4">
						<label class="col-form-label" id="">Comprimento</label>
						<input type="text" id="comprimento-modal" class="form-control dim">
					</div>

					<div class="form-group validated col-sm-4 col-lg-4 col-4">
						<label class="col-form-label" id="">Altura</label>
						<input type="text" id="altura-modal" class="form-control dim">
					</div>

					<div class="form-group validated col-sm-4 col-lg-4 col-4">
						<label class="col-form-label" id="">Largura</label>
						<input type="text" id="largura-modal" class="form-control dim">
					</div>
				</div>

				<div class="row" id="result-correio" style="display: none">
					
				</div>

			</div>
			<div class="modal-footer">
				<button style="width: 100%" type="button" id="btn-frete" onclick="calcularFrete()" class="btn btn-success font-weight-bold spinner-white spinner-right">Calcular</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-pagamentos" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">PAGAMENTOS</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">
				<div class="row">

					<div class="form-group validated col-sm-4 col-lg-4">
						<label class="col-form-label" id="">Intervalo (dias)</label>
						<div class="">
							<input type="text" id="intervalo" id="intervalo" class="form-control" value="30">
						</div>
					</div>

					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label" id="">Quantidade de parcelas</label>
						<div class="">
							<select class="custom-select form-control" id="qtd_parcelas">

							</select>
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="submit" id="gerarPagamentos" class="btn btn-light-info font-weight-bold">Gerar</button>

			</div>

		</div>
	</div>
</div>


@endsection