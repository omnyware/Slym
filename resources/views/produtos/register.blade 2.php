@extends('default.layout')
@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="{{{ isset($produto) ? '/produtos/update': '/produtos/save' }}}" enctype="multipart/form-data">


					<input type="hidden" name="id" value="{{{ isset($produto) ? $produto->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{isset($produto) ? 'Editar' : 'Novo'}} Produto</h3>
						</div>

					</div>
					@csrf
					<p class="kt-widget__data text-danger">Campos com (*) obrigatório</p>
					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">
										<div class="form-group validated col-sm-9 col-lg-9">
											<label class="col-form-label">Nome*</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('nome')) is-invalid @endif" name="nome" value="{{{ isset($produto) ? $produto->nome : old('nome') }}}">
												@if($errors->has('nome'))
												<div class="invalid-feedback">
													{{ $errors->first('nome') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">Referência</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('referencia')) is-invalid @endif" name="referencia" value="{{{ isset($produto) ? $produto->referencia : old('referencia') }}}">
												@if($errors->has('referencia'))
												<div class="invalid-feedback">
													{{ $errors->first('referencia') }}
												</div>
												@endif
											</div>
										</div>
									</div>


									<div class="row">
										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">Valor de Venda*</label>
											<div class="">
												<input type="text" id="valor_venda" class="form-control @if($errors->has('valor_venda')) is-invalid @endif money" name="valor_venda" value="{{{ isset($produto) ? $produto->valor_venda : old('valor_venda') }}}">
												@if($errors->has('valor_venda'))
												<div class="invalid-feedback">
													{{ $errors->first('valor_venda') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">Valor de Compra*</label>
											<div class="">
												<input type="text" id="valor_compra" class="form-control @if($errors->has('valor_compra')) is-invalid @endif money" name="valor_compra" value="{{{ isset($produto) ? $produto->valor_compra : old('valor_compra') }}}">
												@if($errors->has('valor_compra'))
												<div class="invalid-feedback">
													{{ $errors->first('valor_compra') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-6 col-lg-3">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Valor livre</label>
											<div class="col-6">
												<span class="switch switch-outline switch-primary">
													<label>
														<input value="true" @if(isset($produto->valor_livre) && $produto->valor_livre) checked @endisset type="checkbox" name="valor_livre" id="valor_livre">
														<span></span>
													</label>
												</span>
											</div>
										</div>

										<div class="form-group validated col-sm-3 col-lg-3">
											<label class="col-form-label">Estoque minimo</label>
											<div class="">
												<input type="text" id="estoque_minimo" class="form-control @if($errors->has('estoque_minimo')) is-invalid @endif" name="estoque_minimo" value="{{{ isset($produto) ? $produto->estoque_minimo : old('estoque_minimo') }}}">
												@if($errors->has('estoque_minimo'))
												<div class="invalid-feedback">
													{{ $errors->first('estoque_minimo') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">

										<div class="form-group validated col-sm-6 col-lg-3">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Gerenciar estoque</label>
											<div class="col-6">
												<span class="switch switch-outline switch-primary">
													<label>
														<input value="true" @if(isset($produto) && $produto->gerenciar_estoque) checked @elseif(getenv("PRODUTO_GERENCIAR_ESTOQUE") == 1 && !isset($produto)) checked @endif type="checkbox" name="gerenciar_estoque" id="gerenciar_estoque">
														<span></span>
													</label>
												</span>
											</div>
										</div>

										<div class="form-group validated col-lg-5 col-md-5 col-sm-10">
											<label class="col-form-label text-left col-lg-4 col-sm-12">Categoria</label>

											<select class="form-control custom-select" name="categoria_id">
												@foreach($categorias as $cat)
												<option value="{{$cat->id}}" @isset($produto) @if($cat->id == $produto->categoria_id)
													selected=""
													@endif
													@endisset >{{$cat->nome}}
												</option>
												@endforeach
											</select>
											@if($errors->has('categoria'))
											<div class="invalid-feedback">
												{{ $errors->first('categoria') }}
											</div>
											@endif
										</div>

										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">Limite maximo desconto %</label>
											<div class="">
												<input type="text" id="limite_maximo_desconto" class="form-control @if($errors->has('limite_maximo_desconto')) is-invalid @endif" name="limite_maximo_desconto" value="{{{ isset($produto) ? $produto->limite_maximo_desconto : old('limite_maximo_desconto') }}}">
												@if($errors->has('limite_maximo_desconto'))
												<div class="invalid-feedback">
													{{ $errors->first('limite_maximo_desconto') }}
												</div>
												@endif
											</div>
										</div>
									</div>


								</div>

								<div class="row">
									<div class="form-group validated col-lg-5 col-md-5 col-sm-10">
										<label class="col-form-label text-left col-lg-3 col-sm-6">Cor</label>

										<select class="form-control select2" id="kt_select2_2" name="cor">
											<option value="--">--</option>
											<option value="Preto">Preto</option>
											<option value="Branco">Branco</option>
											<option value="Dourado">Dourado</option>
											<option value="Vermelho">Vermelho</option>
											<option value="Azul">Azul</option>
											<option value="Rosa">Rosa</option>
										</select>

									</div>
									<div class="form-group validated col-sm-3 col-lg-4">
										<label class="col-form-label">Alerta de Venc. (Dias)</label>
										<div class="">
											<input type="text" id="alerta_vencimento" class="form-control @if($errors->has('alerta_vencimento')) is-invalid @endif" name="alerta_vencimento" value="{{{ isset($produto) ? $produto->alerta_vencimento : old('alerta_vencimento') }}}">
											@if($errors->has('alerta_vencimento'))
											<div class="invalid-feedback">
												{{ $errors->first('alerta_vencimento') }}
											</div>
											@endif
										</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group validated col-lg-4 col-md-6 col-sm-10">
										<label class="col-form-label text-left col-lg-12 col-sm-12">Unidade de compra *</label>

										<select class="custom-select form-control" id="unidade_compra" name="unidade_compra">
											@foreach($unidadesDeMedida as $u)
											<option @if(isset($produto)) @if($u==$produto->unidade_compra)
												selected
												@endif
												@else
												@if($u == 'UNID')
												selected
												@endif
												@endif value="{{$u}}">{{$u}}
											</option>
											@endforeach
										</select>

									</div>
									<div class="form-group validated col-sm-3 col-lg-3" id="conversao" style="display: none">
										<label class="col-form-label">Conversão Unitária</label>
										<div class="">
											<input type="text" id="alerta_vencimento" class="form-control @if($errors->has('alerta_vencimento')) is-invalid @endif" name="alerta_vencimento" value="{{{ isset($produto->conversao_unitaria) ? $produto->conversao_unitaria : old('conversao_unitaria') }}}">
											@if($errors->has('conversao_unitaria'))
											<div class="invalid-feedback">
												{{ $errors->first('conversao_unitaria') }}
											</div>
											@endif
										</div>
									</div>
									<div class="form-group validated col-lg-4 col-md-6 col-sm-10">
										<label class="col-form-label text-left col-lg-12 col-sm-12">Unidade de venda *</label>

										<select class="custom-select form-control" id="unidade_venda" name="unidade_venda">
											@foreach($unidadesDeMedida as $u)
											<option @if(isset($produto)) @if($u==$produto->unidade_venda)
												selected
												@endif
												@else
												@if($u == 'UNID')
												selected
												@endif
												@endif value="{{$u}}">{{$u}}
											</option>
											@endforeach
										</select>

									</div>
								</div>

								<div class="row">
									<div class="form-group validated col-sm-3 col-lg-3">
										<label class="col-form-label">NCM *</label>
										<div class="">
											<input type="text" id="ncm" class="form-control @if($errors->has('NCM')) is-invalid @endif" name="NCM" value="{{{ isset($produto->NCM) ? $produto->NCM : $tributacao->ncm_padrao }}}">
											@if($errors->has('NCM'))
											<div class="invalid-feedback">
												{{ $errors->first('NCM') }}
											</div>
											@endif
										</div>
									</div>

									<div class="form-group validated col-sm-3 col-lg-3">
										<label class="col-form-label">CEST</label>
										<div class="">
											<input type="text" id="cest" class="form-control @if($errors->has('CEST')) is-invalid @endif" name="CEST" value="{{{ isset($produto->CEST) ? $produto->CEST : old('CEST') }}}">
											@if($errors->has('CEST'))
											<div class="invalid-feedback">
												{{ $errors->first('CEST') }}
											</div>
											@endif
										</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group validated col-lg-10 col-md-10 col-sm-10">
										<label class="col-form-label text-left col-lg-12 col-sm-12">CST/CSOSN *</label>

										<select class="custom-select form-control" id="CST_CSOSN" name="CST_CSOSN">
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
								</div>

								<div class="row">
									<div class="form-group validated col-lg-5 col-md-10 col-sm-10">
										<label class="col-form-label text-left col-lg-12 col-sm-12">CST PIS *</label>

										<select class="custom-select form-control" id="CST_CSOSN" name="CST_PIS">
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

									<div class="form-group validated col-lg-5 col-md-10 col-sm-10">
										<label class="col-form-label text-left col-lg-12 col-sm-12">CST COFINS *</label>

										<select class="custom-select form-control" id="CST_CSOSN" name="CST_COFINS">
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
												>{{$key}} - {{$c}}</option>
												@endforeach
											</select>

										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-lg-10 col-md-10 col-sm-10">
											<label class="col-form-label text-left col-lg-12 col-sm-12">CST IPI *</label>

											<select class="custom-select form-control" id="CST_IPI" name="CST_IPI">
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
													>{{$key}} - {{$c}}</option>
													@endforeach
												</select>

											</div>
										</div>

										<div class="row">
											<div class="form-group validated col-sm-4 col-lg-4">
												<label class="col-form-label">Código de Barras EAN13</label>
												<div class="">
													<input type="text" class="form-control @if($errors->has('codBarras')) is-invalid @endif" name="codBarras" value="{{{ isset($produto->codBarras) ? $produto->codBarras : old('codBarras') }}}">
													@if($errors->has('codBarras'))
													<div class="invalid-feedback">
														{{ $errors->first('codBarras') }}
													</div>
													@endif
												</div>
											</div>
											<div class="form-group validated col-sm-4 col-lg-4">
												<label class="col-form-label">CFOP saida interno *</label>
												<div class="">
													<input type="text" id="CFOP_saida_estadual" class="form-control @if($errors->has('CFOP_saida_estadual')) is-invalid @endif" name="CFOP_saida_estadual" 
													value="{{{ isset($produto->CFOP_saida_estadual) ? $produto->CFOP_saida_estadual : $natureza->CFOP_saida_estadual }}}">
													@if($errors->has('CFOP_saida_estadual'))
													<div class="invalid-feedback">
														{{ $errors->first('CFOP_saida_estadual') }}
													</div>
													@endif
												</div>
											</div>
											<div class="form-group validated col-sm-4 col-lg-4">
												<label class="col-form-label">CFOP saida externo *</label>
												<div class="">
													<input type="text" id="CFOP_saida_inter_estadual" class="form-control @if($errors->has('CFOP_saida_inter_estadual')) is-invalid @endif" name="CFOP_saida_inter_estadual" 
													value="{{{ isset($produto->CFOP_saida_inter_estadual) ? $produto->CFOP_saida_inter_estadual : $natureza->CFOP_saida_inter_estadual }}}">
													@if($errors->has('CFOP_saida_inter_estadual'))
													<div class="invalid-feedback">
														{{ $errors->first('CFOP_saida_inter_estadual') }}
													</div>
													@endif
												</div>
											</div>
										</div>

										<div class="row">
											<div class="form-group validated col-sm-3 col-lg-3">
												<label class="col-form-label">%ICMS *</label>
												<div class="">
													<input type="text" id="perc_icms" class="form-control trib @if($errors->has('perc_icms')) is-invalid @endif" name="perc_icms" 
													value="{{{ isset($produto->perc_icms) ? $produto->perc_icms : $tributacao->icms }}}">
													@if($errors->has('perc_icms'))
													<div class="invalid-feedback">
														{{ $errors->first('perc_icms') }}
													</div>
													@endif
												</div>
											</div>
											<div class="form-group validated col-sm-3 col-lg-3">
												<label class="col-form-label">%PIS *</label>
												<div class="">
													<input type="text" id="perc_pis" class="form-control trib @if($errors->has('perc_pis')) is-invalid @endif" name="perc_pis" 
													value="{{{ isset($produto->perc_pis) ? $produto->perc_pis : $tributacao->pis }}}">
													@if($errors->has('perc_pis'))
													<div class="invalid-feedback">
														{{ $errors->first('perc_pis') }}
													</div>
													@endif
												</div>
											</div>
											<div class="form-group validated col-sm-3 col-lg-3">
												<label class="col-form-label">%COFINS *</label>
												<div class="">
													<input type="text" id="perc_cofins" class="form-control trib @if($errors->has('perc_cofins')) is-invalid @endif" name="perc_cofins" 
													value="{{{ isset($produto->perc_cofins) ? $produto->perc_cofins : $tributacao->cofins }}}">
													@if($errors->has('perc_cofins'))
													<div class="invalid-feedback">
														{{ $errors->first('perc_cofins') }}
													</div>
													@endif
												</div>
											</div>
											<div class="form-group validated col-sm-3 col-lg-3">
												<label class="col-form-label">%IPI *</label>
												<div class="">
													<input type="text" id="perc_ipi" class="form-control trib @if($errors->has('perc_ipi')) is-invalid @endif" name="perc_ipi" 
													value="{{{ isset($produto->perc_ipi) ? $produto->perc_ipi : $tributacao->ipi }}}">
													@if($errors->has('perc_ipi'))
													<div class="invalid-feedback">
														{{ $errors->first('perc_ipi') }}
													</div>
													@endif
												</div>
											</div>
										</div>

										<div class="row">
											<div class="form-group validated col-sm-3 col-lg-3">
												<label class="col-form-label">%ISS *</label>
												<div class="">
													<input type="text" id="perc_iss" class="form-control trib @if($errors->has('perc_iss')) is-invalid @endif" name="perc_iss" 
													value="{{{ isset($produto->perc_iss) ? $produto->perc_iss : 0.00 }}}">
													@if($errors->has('perc_iss'))
													<div class="invalid-feedback">
														{{ $errors->first('perc_iss') }}
													</div>
													@endif
												</div>
											</div>

											<div class="form-group validated col-sm-4 col-lg-4">
												<label class="col-form-label">Cod Lista Serviço (ISS)</label>
												<div class="">
													<input type="text" id="cListServ" class="form-control @if($errors->has('cListServ')) is-invalid @endif" name="cListServ" value="{{{ isset($produto->cListServ) ? $produto->cListServ : old('cListServ') }}}">
													@if($errors->has('cListServ'))
													<div class="invalid-feedback">
														{{ $errors->first('cListServ') }}
													</div>
													@endif
												</div>
											</div>

											<div class="form-group validated col-lg-5 col-md-10 col-sm-10">
												<label class="col-form-label text-left col-lg-12 col-sm-12">Identificaçao ANP</label>

												<select class="custom-select form-control" id="anp" name="anp">
													<option value="">--</option>
													@foreach($anps as $key => $a)
													<option value="{{$key}}" @isset($produto->codigo_anp)
														@if($key == $produto->codigo_anp)
														selected=""
														@endif
														@endisset >[{{$key}}] - {{$a}}
													</option>

													@endforeach
												</select>

											</div>
										</div>


										<div class="row">
											<div class="form-group validated col-lg-12 col-md-12 col-sm-12">
												<label class="col-xl-12 col-lg-12 col-form-label text-left">Imagem</label>
												<div class="col-lg-12 col-xl-12">




													<div class="image-input image-input-outline" id="kt_image_1">
														<div class="image-input-wrapper" @if(!isset($produto) || $produto->imagem == '') style="background-image: url(/imgs/no_image.png)" @else
															style="background-image: url(/imgs_produtos/{{$produto->imagem}})"
															@endif>

														</div>
														<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
															<i class="fa fa-pencil icon-sm text-muted"></i>
															<input type="file" name="file" accept=".png, .jpg, .jpeg">
															<input type="hidden" name="profile_avatar_remove">
														</label>
														<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel avatar">
															<i class="fa fa-close icon-xs text-muted"></i>
														</span>
													</div>

													<span class="form-text text-muted">.png, .jpg, .jpeg</span>
													@if($errors->has('file'))
													<div class="invalid-feedback">
														{{ $errors->first('file') }}
													</div>
													@endif
												</div>
											</div>
										</div>

										<div class="row">
											<div class="form-group validated col-lg-12 col-md-12 col-sm-12">
												<label class="col-xl-12 col-lg-12 col-form-label text-left">Composto</label>
												<div class="col-lg-12 col-xl-12">
													<span class="switch switch-outline switch-success">
														<label>
															<input @if(isset($produto->composto) && $produto->composto) checked @endisset value="true" name="composto" class="red-text" type="checkbox">
															<span></span>
														</label>
													</span>

													<p class="text-danger">*Produzido no estabelecimento composto de outros produtos já cadastrados, deverá ser criado uma receita para redução de estoque. </p>

												</div>
											</div>
										</div>

									</div>

									<hr>

									<h3>Dados de dimensão e peso do produto (Opcional)</h3>
									<div class="row">

										<div class="form-group validated col-lg-3 col-md-4 col-sm-4">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Largura (cm)</label>

											<input type="text" id="largura" class="form-control @if($errors->has('largura')) is-invalid @endif" name="largura" 
											value="{{{ isset($produto->largura) ? $produto->largura : '' }}}">
										</div>

										<div class="form-group validated col-lg-3 col-md-4 col-sm-4">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Altura (cm)</label>

											<input type="text" id="altura" class="form-control @if($errors->has('altura')) is-invalid @endif" name="altura" 
											value="{{{ isset($produto->altura) ? $produto->altura : '' }}}">
										</div>

										<div class="form-group validated col-lg-3 col-md-4 col-sm-4">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Comprimento (cm)</label>

											<input type="text" id="comprimento" class="form-control @if($errors->has('comprimento')) is-invalid @endif" name="comprimento" value="{{{ isset($produto->comprimento) ? $produto->comprimento : '' }}}">
										</div>
									</div>

									<div class="row">

										<div class="form-group validated col-lg-3 col-md-4 col-sm-4">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Peso liquido</label>

											<input type="text" id="peso_liquido" class="form-control @if($errors->has('peso_liquido')) is-invalid @endif" name="peso_liquido" 
											value="{{{ isset($produto->peso_liquido) ? $produto->peso_liquido : '' }}}">
										</div>

										<div class="form-group validated col-lg-3 col-md-4 col-sm-4">
											<label class="col-form-label text-left col-lg-12 col-sm-12">Peso bruto</label>

											<input type="text" id="peso_bruto" class="form-control @if($errors->has('peso_bruto')) is-invalid @endif" name="peso_bruto" 
											value="{{{ isset($produto->peso_bruto) ? $produto->peso_bruto : '' }}}">
										</div>

										<div class="col-lg-12 col-xl-12">
											<p class="text-danger">*Se atente a preencher todos os dados para utilizar a Api dos correios.</p>
										</div>

									</div>

									@if(getenv('DELIVERY') == 1)
									<div class="row">
										<div class="form-group validated col-lg-12 col-md-12 col-sm-12">
											<label class="col-xl-12 col-lg-12 col-form-label text-left">Atribuir ao Delivery</label>
											<div class="col-lg-12 col-xl-12">
												<span class="switch switch-outline switch-success">
													<label>
														<input @if(isset($produto->delivery) && $produto->delivery) checked @endisset value="true" name="atribuir_delivery" class="red-text" type="checkbox" id="atribuir_delivery">
														<span></span>
													</label>
												</span>

											</div>
										</div>
									</div>

									@endif
									@if(getenv('DELIVERY') == 1)
									<div id="delivery" style="display: none">

										<div class="row">
											<div class="form-group validated col-lg-3 col-md-6 col-sm-3">
												<label class="col-xl-12 col-lg-12 col-form-label text-left">Destaque</label>
												<div class="col-lg-12 col-xl-12">
													<span class="switch switch-outline switch-success">
														<label>
															<input @if(isset($produto->delivery->destaque) && $produto->delivery->destaque)
															checked @endisset value="true" name="destaque" class="red-text" type="checkbox">
															<span></span>
														</label>
													</span>

												</div>
											</div>

											<div class="form-group validated col-sm-6 col-lg-4">
												<label class="col-form-label">Limite Diário de venda *</label>
												<div class="">
													<input type="text" id="limite_diario" class="form-control @if($errors->has('limite_diario')) is-invalid @endif" name="limite_diario" value="{{{ isset($produto->limite_diario) ? $produto->limite_diario : old('limite_diario') }}}">
													@if($errors->has('limite_diario'))
													<div class="invalid-feedback">
														{{ $errors->first('limite_diario') }}
													</div>
													@endif
												</div>
											</div>

											<div class="form-group validated col-sm-8 col-lg-5">
												<label class="col-form-label text-left col-lg-12 col-sm-12">Categoria de Delivery</label>

												<select class="custom-select form-control" id="categoria_delivery_id" name="categoria_delivery_id">
													@foreach($categoriasDelivery as $cat)
													<option value="{{$cat->id}}" @isset($produto->delivery)@if($cat->id == $produto->delivery->categoria_id)
														selected=""
														@endif
														@endisset >{{$cat->nome}}
													</option>

													@endforeach
												</select>

											</div>

										</div>

										<div class="row">
											<div class="form-group validated col-sm-6 col-lg-6">
												<label class="col-form-label">Descrição</label>
												<div class="">
													<textarea class="form-control" name="descricao" placeholder="Descrição" rows="3">{{{ isset($produto->delivery->descricao) ? $produto->delivery->descricao : old('descricao') }}}</textarea>
													@if($errors->has('descricao'))
													<div class="invalid-feedback">
														{{ $errors->first('descricao') }}
													</div>
													@endif
												</div>
											</div>
											<div class="form-group validated col-sm-6 col-lg-6">
												<label class="col-form-label">Ingredientes</label>
												<div class="">
													<textarea class="form-control" name="ingredientes" placeholder="Enter a menu" rows="3">{{{ isset($produto->delivery->ingredientes) ? $produto->delivery->ingredientes : old('ingredientes') }}}</textarea>
													@if($errors->has('ingredientes'))
													<div class="invalid-feedback">
														{{ $errors->first('ingredientes') }}
													</div>
													@endif
												</div>
											</div>
										</div>


									</div>
									@endif

								</div>
							</div>
							<div class="card-footer">

								<div class="row">
									<div class="col-xl-2">

									</div>
									<div class="col-lg-3 col-sm-6 col-md-4">
										<a style="width: 100%" class="btn btn-danger" href="">
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
						</div>
					</div>
					
				</form>
			</div>
		</div>
	</div>
</div>


@endsection