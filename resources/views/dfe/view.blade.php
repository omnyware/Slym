@extends('default.layout')
@section('content')


<div class="row" id="anime" style="display: none">
	<div class="col s8 offset-s2">
		<lottie-player src="/anime/success.json" background="transparent" speed="0.8" style="width: 100%; height: 300px;" autoplay>
		</lottie-player>
	</div>
</div>
<div id="content" style="display: block">
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">


		<div class="container">
			<div class="card card-custom gutter-b example example-compact">
				<div class="col-lg-12">
					<!--begin::Portlet-->


					<input type="hidden" name="id" value="{{{ isset($cliente) ? $cliente->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">Importando XML</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">

							<h4 class="center-align">Nota Fiscal: <strong class="text-primary">{{$infos['nNf']}}</strong></h4>
							<h4 class="center-align">Chave: <strong class="text-primary">{{$infos['chave']}}</strong></h4>
							
							@if($fornecedor['novo_cadastrado'])
							<h5 class="text-danger center-align">Fornecedor Cadastrado com Sucesso!</h5>
							@endif

							<div class="row">
								<div class="col s8">
									<h5>Fornecedor: <strong>{{$fornecedor['razaoSocial']}}</strong></h5>
									<h5>Nome Fantasia: <strong>{{$fornecedor['nomeFantasia']}}</strong></h5>
								</div>
								<div class="col s4">
									<h5>CNPJ: <strong>{{$fornecedor['cnpj']}}</strong></h5>
									<h5>IE: <strong>{{$fornecedor['ie']}}</strong></h5>
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									<h5>Logradouro: <strong>{{$fornecedor['logradouro']}}</strong></h5>
									<h5>Numero: <strong>{{$fornecedor['numero']}}</strong></h5>
									<h5>Bairro: <strong>{{$fornecedor['bairro']}}</strong></h5>
								</div>
								<div class="col s4">
									<h5>CEP: <strong>{{$fornecedor['cep']}}</strong></h5>
									<h5>Fone: <strong>{{$fornecedor['fone']}}</strong></h5>
								</div>
							</div>

							

						</div>
						<div class="col-xl-12">
							<div class="row">
								<div class="col-xl-12">

									
									<h4>Itens da NF</h4>
									<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">
										<table class="datatable-table" style="max-width: 100%;overflow: scroll">
											<thead class="datatable-head">
												<tr class="datatable-row" style="left: 0px;">
													<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 70px;">#</span></th>
													<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 180px;">Produto</span></th>
													<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">NCM</span></th>
													<th data-field="CompanyName" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">CFOP</span></th>
													<th data-field="Status" class="datatable-cell datatable-cell-sort"><span style="width: 90px;">Cod Barra</span></th>
													<th data-field="Type" data-autohide-disabled="false" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Un. Compra</span></th>
													<th data-field="Type" data-autohide-disabled="false" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Valor</span></th>
													<th data-field="Type" data-autohide-disabled="false" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Qtd</span></th>
													
													<th data-field="Type" data-autohide-disabled="false" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Subtotal</span></th>
													<th data-field="Actions" data-autohide-disabled="false" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Ações</span></th>
												</tr>
											</thead>

											<tbody class="datatable-body">
												@foreach($itens as $i)
												<tr class="datatable-row" id="tr_{{$i['codigo']}}" style="left: 0px;">
													<td class="datatable-cell"><span class="codigo" style="width: 70px;">{{$i['codigo']}}</span></td>
													<td class="datatable-cell" id="th_{{$i['codigo']}}"><span style="width: 180px;" class="{{$i['produtoNovo'] == true ? 'text-danger' : ''}}">{{$i['xProd']}}</span></td>
													<td class="datatable-cell"><span class="ncm" style="width: 80px;">{{$i['NCM']}}</span></td>
													<td class="datatable-cell"><span class="cfop" style="width: 80px;">{{$i['CFOP']}}</span></td>
													<td class="datatable-cell"><span class="codBarras" style="width: 90px;">{{$i['codBarras']}}</span></td>
													<td class="datatable-cell"><span class="unidade" style="width: 80px;">{{$i['uCom']}}</span></td>
													<td class="datatable-cell"><span class="valor" style="width: 80px;">{{$i['vUnCom']}}</span></td>
													<td class="datatable-cell"><span class="quantidade" style="width: 80px;">{{$i['qCom']}}</span></td>

													<th class="cod" id="th_prod_id_{{$i['codigo']}}" style="display: none">{{$i['produtoId']}}</th>
													<th style="display: none" class="conv_estoque" id="th_prod_conv_unit_{{$i['codigo']}}">
														{{$i['conversao_unitaria']}}
													</th>

													

													<td class="datatable-cell quantidade"><span style="width: 80px;">{{number_format((float) $i['qCom'] * (float) $i['vUnCom'], 2, ',', '.')}}</span></td>

													<th class="datatable-cell">
														<span style="width: 80px;">
															<a id="th_acao1_{{$i['codigo']}}" @if($i['produtoNovo']) style="display: block" @else style="display: none" @endif onclick="cadProd('{{$i['codigo']}}','{{$i['xProd']}}','{{$i['codBarras']}}','{{$i['NCM']}}','{{$i['CFOP']}}','{{$i['uCom']}}','{{$i['vUnCom']}}', '{{$i['qCom']}}', '{{$i['vUnCom']}}', '{{$infos['nNf']}}')" href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2">
																<span class="svg-icon svg-icon-success">
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
																			<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1" />
																		</g>
																	</svg>
																</span>
															</a>

															@if(!$i['produtoNovo'])
															@if(!$i['produtoSetadoEstoque'])

															<a title="Setar Estoque" onclick="salvarEstoque('{{$i['produto_id']}}','{{$i['qCom']}}', '{{$i['vUnCom']}}', '{{$infos['nNf']}}')" href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2">
																<span class="svg-icon svg-icon-warning">
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<rect x="0" y="0" width="24" height="24"/>
																			<path d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z" fill="#000000"/>
																			<path d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z" fill="#000000" opacity="0.3"/>
																		</g>
																	</svg>
																</span>
															</a>


															@endif
															@endif

															<!-- <a id="th_acao2_{{$i['codigo']}}" @if($i['produtoNovo']) style="display: none" @else style="display: block" @endif  href="/produtos/edit/1" class="btn btn-sm btn-clean btn-icon mr-2">
																<span class="svg-icon svg-icon-danger"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
																		<rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1" />
																	</g>
																</svg>
															</span>
														</a> -->
													</span>
												</th>

											</tr>
											@endforeach
										</tbody>
									</table>
									<br><br>


								</div>


							</div>
						</div>
					</div>
					<div class="col-xl-12">
						<div class="">
							<h2 style="margin-left: 10px;;">Fatura</h2>
							<input type="hidden" id="fatura" value="{{json_encode($fatura)}}">
							<div class="row">

								@foreach($fatura as $f)


								<div class="col-sm-12 col-lg-6 col-md-6 col-xl-4">
									<div class="card card-custom gutter-b example example-compact">
										<div class="card-header">
											<div class="card-title">
												<h3 style="width: 230px; font-size: 20px; height: 10px;" class="card-title">R$ {{$f['valor_parcela']}}
												</h3>
											</div>

											<div class="card-toolbar">
												<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Ações">
													<a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

													</a>

												</div>
											</div>

											<div class="card-body">
												<div class="kt-widget__info">
													<span class="kt-widget__label">Número:</span>
													<a target="_blank" class="kt-widget__data text-success">{{$f['numero']}}</a>
												</div>
												<div class="kt-widget__info">
													<span class="kt-widget__label">Vencimento:</span>
													<a target="_blank" class="kt-widget__data text-success">{{$f['vencimento']}}</a>
												</div>

											</div>
										</div>
									</div>

								</div>

								@endforeach


							</div>

							@if(count($fatura) > 0)
							<div class="row">
								<div class="col-sm-12 col-lg-6 col-md-6 col-xl-4">
									<form method="get" action="/dfe/salvarFatura">
										<input type="hidden" id="" value="{{$infos['chave']}}" name="chave">
										<input type="hidden" id="" value="{{json_encode($fatura)}}" name="fatura">
										<button @if($fatura_salva) disabled @endif class="btn btn-light-primary">Salvar Fatura no Contas a Pagar</button>
									</form>
								</div>
							</div>
							@endif
						</div>
					</div>

					<div class="col-xl-12">
						<br>
						<div class="row">
							<div class="col-xl-6">
								<h4>Total: <strong id="valorDaNF" class="blue-text">{{$infos['vProd']}}</strong></h4>
							</div>
							<div class="col-xl-3">
							</div>
							<div class="col-xl-3">
								<a href="/dfe/downloadXml/{{$infos['chave']}}" style="width: 100%" type="submit" class="btn btn-light-info">
									<i class="la la-file"></i>
									Baixar XML
								</a>
							</div>
						</div>
					</div>

				</div>
				<br>
			</div>
		</div>
	</div>
</div>
</div>



<div class="modal fade" id="modal1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Adicionar produto</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="form-group validated col-sm-12 col-lg-12">
						<label class="col-form-label">Nome do Produto</label>
						<div class="">
							<input id="nome" type="text" class="form-control" name="nome" value="">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">NCM</label>
						<div class="">
							<input id="ncm" type="text" class="form-control" name="ncm" value="">
						</div>
					</div>
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">CFOP</label>
						<div class="">
							<input id="cfop" type="text" class="form-control" name="cfop" value="">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">Unidade de Compra</label>
						<div class="">
							<input id="un_compra" type="text" class="form-control" name="un_compra" value="">
						</div>
					</div>
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">Conversão unitária para estoque</label>
						<div class="">
							<input id="conv_estoque" type="text" class="form-control" name="conv_estoque" value="">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">Valor de compra</label>
						<div class="">
							<input id="valor" type="text" class="form-control" name="valor" value="">
						</div>
					</div>
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">Quantidade</label>
						<div class="">
							<input id="quantidade" type="text" class="form-control" name="quantidade" value="">
						</div>
					</div>
				</div>
				<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
				<div class="row">
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">Valor de Venda</label>
						<div class="">
							<input id="valor_venda" type="text" class="form-control" name="valor_venda" value="">
						</div>
					</div>
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">Unidade de venda</label>
						<select class="custom-select form-control" id="unidade_venda">
							@foreach($unidadesDeMedida as $u)
							<option value="{{$u}}">{{$u}}</option>
							@endforeach
						</select>
					</div>

				</div>

				<div class="row">
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">Cor (Opcional)</label>
						<select class="custom-select form-control" id="cor">
							<option value="--">--</option>
							<option value="Preto">Preto</option>
							<option value="Branco">Branco</option>
							<option value="Dourado">Dourado</option>
							<option value="Vermelho">Vermelho</option>
							<option value="Azul">Azul</option>
							<option value="Rosa">Rosa</option>
						</select>
					</div>
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">Categoria</label>
						<select class="custom-select form-control" id="categoria_id">
							@foreach($categorias as $cat)
							<option value="{{$cat->id}}">{{$cat->nome}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">CST/CSOSN</label>
						<select class="custom-select form-control" id="CST_CSOSN">
							@foreach($listaCSTCSOSN as $key => $c)
							<option value="{{$key}}" @if($config !=null) @if(isset($produto)) @if($key==$produto->CST_CSOSN)
								selected
								@endif
								@else
								@if($key == $config->CST_CSOSN_padrao)
								selected
								@endif
								@endif

								@endif
								>{{$key}} - {{$c}}
							</option>
							@endforeach
						</select>
					</div>




					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">CST PIS</label>
						<select class="custom-select form-control" id="CST_PIS">
							@foreach($listaCST_PIS_COFINS as $key => $c)
							<option value="{{$key}}" @if($config !=null) @if(isset($produto)) @if($key==$produto->CST_PIS)
								selected
								@endif
								@else
								@if($key == $config->CST_PIS_padrao)
								selected
								@endif
								@endif

								@endif
								>{{$key}} - {{$c}}
							</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row">
					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">CST COFINS</label>
						<select class="custom-select form-control" id="CST_COFINS">
							@foreach($listaCST_PIS_COFINS as $key => $c)
							<option value="{{$key}}" @if($config !=null) @if(isset($produto)) @if($key==$produto->CST_COFINS)
								selected
								@endif
								@else
								@if($key == $config->CST_COFINS_padrao)
								selected
								@endif
								@endif

								@endif
								>{{$key}} - {{$c}}
							</option>
							@endforeach
						</select>
					</div>

					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">CST IPI</label>
						<select class="custom-select form-control" id="CST_IPI">
							@foreach($listaCST_IPI as $key => $c)
							<option value="{{$key}}" @if($config !=null) @if(isset($produto)) @if($key==$produto->CST_IPI)
								selected
								@endif
								@else
								@if($key == $config->CST_IPI_padrao)
								selected
								@endif
								@endif

								@endif
								>{{$key}} - {{$c}}
							</option>
							@endforeach
						</select>
					</div>

				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="button" id="salvar" class="btn btn-success font-weight-bold spinner-white spinner-right">Salvar</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal2" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Adicionar produto</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="form-group validated col-sm-12 col-lg-12">
						<label class="col-form-label">Nome do Produto</label>
						<div class="">
							<input id="nomeEdit" type="text" class="form-control" name="nomeEdit" value="">

						</div>
					</div>
				</div>


				<div class="row">

					<div class="form-group validated col-sm-6 col-lg-6">
						<label class="col-form-label">Conversão unitária para estoque</label>
						<div class="">
							<input id="conv_estoqueEdit" type="text" class="form-control" name="conv_estoqueEdit" value="">
						</div>
					</div>
				</div>




			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="button" id="salvarEdit" class="btn btn-success font-weight-bold spinner-white spinner-right">Salvar</button>
			</div>
		</div>
	</div>
</div>






@endsection	