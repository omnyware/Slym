@extends('default.layout')
@section('content')


<div class="card card-custom gutter-b">
	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<div class="row">


				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-6">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<h3 class="card-title">Relatório de Vendas
							</h3>
						</div>

						<div class="divider"></div>
						<div class="card-content">
							<div class="col-xl-12">
								<form method="get" action="/relatorios/filtroVendas">
									<div class="row">

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Data Inicial</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="data_inicial" class="form-control" readonly value="" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Data Final</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="data_final" class="form-control" readonly value="" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Nro. Resultados</label>
											<div class="">
												<input id="razao_social" type="text" class="form-control" name="total_resultados" value="">
											</div>
										</div>

										<div class="form-group validated col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Ordem</label>

											<select class="custom-select form-control" id="" name="ordem">
												<option value="desc">Maior Valor</option>
												<option value="asc">Menor Valor</option>
												<option value="data">Data</option>
											</select>

										</div>

										<div class="form-group validated col-lg-12 col-xl-12 mt-12 mt-lg-0">
											<button style="width: 100%" class="btn btn-light-primary px-6 font-weight-bold">Gerar Relatório</button>
										</div>



									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-6">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<h3 class="card-title">Relatório de Compras
							</h3>
						</div>

						<div class="divider"></div>
						<div class="card-content">
							<div class="col-xl-12">
								<form method="get" action="/relatorios/filtroCompras">
									<div class="row">

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Data Inicial</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="data_inicial" class="form-control" readonly value="" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Data Final</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="data_final" class="form-control" readonly value="" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Nro. Resultados</label>
											<div class="">
												<input id="razao_social" type="text" class="form-control" name="total_resultados" value="">
											</div>
										</div>

										<div class="form-group validated col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Ordem</label>

											<select class="custom-select form-control" id="" name="ordem">
												<option value="desc">Maior Valor</option>
												<option value="asc">Menor Valor</option>
												<option value="data">Data</option>
											</select>

										</div>

										<div class="form-group validated col-lg-12 col-xl-12 mt-12 mt-lg-0">
											<button style="width: 100%" class="btn btn-light-success px-6 font-weight-bold">Gerar Relatório</button>
										</div>



									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-6">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<h3 class="card-title">Relatório de Vendas de Produtos
							</h3>
						</div>

						<div class="divider"></div>
						<div class="card-content">
							<div class="col-xl-12">
								<form method="get" action="/relatorios/filtroVendaProdutos">
									<div class="row">

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Data Inicial</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="data_inicial" class="form-control" readonly value="" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Data Final</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="data_final" class="form-control" readonly value="" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Nro. Resultados</label>
											<div class="">
												<input id="razao_social" type="text" class="form-control" name="total_resultados" value="">
											</div>
										</div>

										<div class="form-group validated col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Ordem</label>

											<select class="custom-select form-control" id="" name="ordem">
												<option value="desc">Mais Vendidos</option>
												<option value="asc">Menos Vendidos</option>
											</select>

										</div>

										<div class="form-group validated col-lg-12 col-xl-12 mt-12 mt-lg-0">
											<button style="width: 100%" class="btn btn-light-danger px-6 font-weight-bold">Gerar Relatório</button>
										</div>



									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-6">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<h3 class="card-title">Relatório de Vendas para Clientes
							</h3>
						</div>

						<div class="divider"></div>
						<div class="card-content">
							<div class="col-xl-12">
								<form method="get" action="/relatorios/filtroVendaClientes">
									<div class="row">

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Data Inicial</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="data_inicial" class="form-control" readonly value="" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Data Final</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="data_final" class="form-control" readonly value="" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Nro. Resultados</label>
											<div class="">
												<input id="razao_social" type="text" class="form-control" name="total_resultados" value="">
											</div>
										</div>

										<div class="form-group validated col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Ordem</label>

											<select class="custom-select form-control" id="" name="ordem">
												<option value="desc">Mais Vendas</option>
												<option value="asc">Menos Vendas</option>
											</select>

										</div>

										<div class="form-group validated col-lg-12 col-xl-12 mt-12 mt-lg-0">
											<button style="width: 100%" class="btn btn-light-info px-6 font-weight-bold">Gerar Relatório</button>
										</div>



									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-6">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<h3 class="card-title">Relatório de Estoque Mínimo
							</h3>
						</div>

						<div class="divider"></div>
						<div class="card-content">
							<div class="col-xl-12">
								<form method="get" action="/relatorios/filtroEstoqueMinimo">
									<div class="row">



										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Nro. Resultados</label>
											<div class="">
												<input id="razao_social" type="text" class="form-control" name="total_resultados" value="">
											</div>
										</div>

										

										<div class="form-group validated col-lg-12 col-xl-12 mt-12 mt-lg-0">
											<button style="width: 100%" class="btn btn-light-warning px-6 font-weight-bold">Gerar Relatório</button>
										</div>


									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-6">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<h3 class="card-title">Relatório de Venda Diária
							</h3>
						</div>

						<div class="divider"></div>
						<div class="card-content">
							<div class="col-xl-12">
								<form method="get" action="/relatorios/filtroVendaDiaria">
									<div class="row">

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Data</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="data_inicial" class="form-control" readonly value="" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</div>

										

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Nro. Resultados</label>
											<div class="">
												<input id="razao_social" type="text" class="form-control" name="total_resultados" value="">
											</div>
										</div>


										<div class="form-group validated col-lg-12 col-xl-12 mt-12 mt-lg-0">
											<button style="width: 100%" class="btn btn-light-dark px-6 font-weight-bold">Gerar Relatório</button>
										</div>


									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-6">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<h3 class="card-title">Relatório de Lucro
							</h3>
						</div>

						<div class="divider"></div>
						<div class="card-content">
							<div class="col-xl-12">
								<form method="get" action="/relatorios/filtroLucro">
									<div class="row">

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label dt">Data Inicial</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="data_inicial" class="form-control" readonly value="" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group col-lg-6 col-md-6 col-sm-6" id="lucro_col">
											<label class="col-form-label">Data Final</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="data_final" class="form-control" readonly value="" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group validated col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Ordem</label>

											<select class="custom-select form-control" id="tipo_lucro" name="tipo">
												<option value="grupo">Agrupado</option>
												<option value="detalhado">Detalhado</option>
											</select>

										</div>

										<div class="form-group validated col-lg-12 col-xl-12 mt-12 mt-lg-0">
											<button style="width: 100%" class="btn btn-light-danger px-6 font-weight-bold">Gerar Relatório</button>
										</div>



									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-6">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<h3 class="card-title">Relatório de estoque de produtos
							</h3>
						</div>

						<div class="divider"></div>
						<div class="card-content">
							<div class="col-xl-12">
								<form method="get" action="/relatorios/estoqueProduto">
									<div class="row">

										<div class="form-group validated col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Ordem</label>

											<select class="custom-select form-control" id="usuario" name="ordem">
												<option value="nome">Nome</option>
												<option value="qtd">Quantidade</option>
												<!-- <option value="ultima_movimentacao">Ultima movimentação</option> -->
											</select>

										</div>
										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Nro. Resultados</label>
											<div class="">
												<input id="razao_social" type="text" class="form-control" name="total_resultados" value="">
											</div>
										</div>

										<div style="height: 100px;">
											<br>
										</div>
										<div class="form-group validated col-lg-12 col-xl-12 mt-12 mt-lg-0">
											<button style="width: 100%" class="btn btn-light-info px-6 font-weight-bold">Gerar Relatório</button>
										</div>

									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12 col-lg-6 col-md-6 col-xl-6">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">
							<h3 class="card-title">Relatório de Comissão de Vendas
							</h3>
						</div>

						<div class="divider"></div>
						<div class="card-content">
							<div class="col-xl-12">
								<form method="get" action="/relatorios/comissaoVendas">
									<div class="row">

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Data Inicial</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="data_inicial" class="form-control" readonly value="" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Data Final</label>
											<div class="">
												<div class="input-group date">
													<input type="text" name="data_final" class="form-control" readonly value="" id="kt_datepicker_3" />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label">Produto</label>
											<div class="">
												<select class="form-control select2" style="width: 100%" id="kt_select2_1" name="produto">
													<option value="null">Selecione o produto</option>
													@foreach($produtos as $p)
													<option value="{{$p->id}}">{{$p->id}} - {{$p->nome}}</option>
													@endforeach
												</select>
											</div>
										</div>

										<div class="form-group validated col-lg-6 col-md-6 col-sm-6">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Vendedor</label>

											<select class="form-control select2" style="width: 100%" id="kt_select2_2" name="funcionario">
												<option value="null">Selecione o vendedor</option>
												@foreach($funcionarios as $p)
												<option value="{{$p->id}}">{{$p->id}} - {{$p->nome}}</option>
												@endforeach
											</select>

										</div>

										<div class="form-group validated col-lg-12 col-xl-12 mt-12 mt-lg-0">
											<button style="width: 100%" class="btn btn-light-success px-6 font-weight-bold">Gerar Relatório</button>
										</div>



									</div>
								</form>
							</div>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>
</div>




@endsection	