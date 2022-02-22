@extends('default.layout')
@section('content')
	
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	@if(!$produto->receita)
	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/receita/save">


					<input type="hidden" name="id" value="{{{ isset($categoria) ? $categoria->id : 0 }}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">Receita do produto {{$produto->nome}}</h3>
						</div>

					</div>
					@csrf
					<input type="hidden" name="produto_id" name="" value="{{$produto->id}}">


					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">
										<div class="form-group validated col-sm-12 col-lg-12">
											<label class="col-form-label">Descrição</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('descricao')) is-invalid @endif" name="descricao">
												@if($errors->has('descricao'))
												<div class="invalid-feedback">
													{{ $errors->first('descricao') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-6 col-lg-6">
											<label class="col-form-label">Rendimento</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('rendimento')) is-invalid @endif" name="rendimento" value="{{old('rendimento')}}">
												@if($errors->has('rendimento'))
												<div class="invalid-feedback">
													{{ $errors->first('rendimento') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-sm-6 col-lg-6">
											<label class="col-form-label">Tempo de Preparo (Minutos)</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('tempo_preparo')) is-invalid @endif" name="tempo_preparo" value="{{old('tempo_preparo')}}">
												@if($errors->has('tempo_preparo'))
												<div class="invalid-feedback">
													{{ $errors->first('tempo_preparo') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-6 col-lg-6">
											<label class="col-form-label">Quantidade de Pedaços (opcional)</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('pedacos')) is-invalid @endif" name="pedacos" value="{{old('pedacos')}}">
												@if($errors->has('pedacos'))
												<div class="invalid-feedback">
													{{ $errors->first('pedacos') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group validated col-sm-6 col-lg-6">
											<br><br>
											<p class="text-danger">Informe um valor no campo pedaços, se seu produto for uma pizza</p>
										</div>
									</div>

								</div>
								<div class="card-footer">

									<div class="row">
										<div class="col-xl-2">

										</div>
										<div class="col-lg-3 col-sm-6 col-md-4">
											<button style="width: 100%" class="btn btn-danger" type="reset">
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
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	@else

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<div class="container">
					<br>
					<div class="accordion accordion-toggle-arrow" id="accordionExample1">
						<div class="card">
							<div class="card-header">
								<div class="card-title" data-toggle="collapse" data-target="#collapseOne1">
									Receita
								</div>
							</div>
							<div id="collapseOne1" class="collapse" data-parent="#accordionExample1">
								<form method="post" action="/receita/update">
									<input type="hidden" value="{{$produto->receita->id}}" name="receita_id">
									<div class="container">

										<div class="row">
											<div class="form-group validated col-sm-12 col-lg-12">
												<label class="col-form-label">Descrição</label>
												<div class="">
													<input type="text" value="{{$produto->receita->descricao}}" class="form-control @if($errors->has('descricao')) is-invalid @endif" name="descricao">
													@if($errors->has('descricao'))
													<div class="invalid-feedback">
														{{ $errors->first('descricao') }}
													</div>
													@endif
												</div>
											</div>
										</div>

										<div class="row">
											<div class="form-group validated col-sm-6 col-lg-6">
												<label class="col-form-label">Rendimento</label>
												<div class="">
													<input type="text" class="form-control @if($errors->has('rendimento')) is-invalid @endif" name="rendimento" value="{{$produto->receita->rendimento}}">
													@if($errors->has('rendimento'))
													<div class="invalid-feedback">
														{{ $errors->first('rendimento') }}
													</div>
													@endif
												</div>
											</div>
											<div class="form-group validated col-sm-6 col-lg-6">
												<label class="col-form-label">Tempo de Preparo (Minutos)</label>
												<div class="">
													<input type="text" class="form-control @if($errors->has('tempo_preparo')) is-invalid @endif" name="tempo_preparo" value="{{$produto->receita->tempo_preparo}}">
													@if($errors->has('tempo_preparo'))
													<div class="invalid-feedback">
														{{ $errors->first('tempo_preparo') }}
													</div>
													@endif
												</div>
											</div>
										</div>

										<div class="row">
											<div class="form-group validated col-sm-6 col-lg-6">
												<label class="col-form-label">Quantidade de Pedaços (opcional)</label>
												<div class="">
													<input type="text" class="form-control @if($errors->has('pedacos')) is-invalid @endif" name="pedacos" value="{{$produto->receita->pedacos}}">
													@if($errors->has('pedacos'))
													<div class="invalid-feedback">
														{{ $errors->first('pedacos') }}
													</div>
													@endif
												</div>
											</div>
											<div class="form-group validated col-sm-6 col-lg-6">
												<br><br>
												<p class="text-danger">Informe um valor no campo pedaços, se seu produto for uma pizza</p>
											</div>
										</div>
										@csrf
										<div class="row">

											<div class="col-lg-3 col-sm-6 col-md-4">
												<button style="width: 100%" type="submit" class="btn btn-success">
													<i class="la la-refresh"></i>
													<span class="">ATUALIZAR</span>
												</button>
											</div>
										</div>
										<br>
									</div>

								</form>
							</div>
						</div>

					</div>
					<div class="row">

						<div class="col-sm-12 col-lg-6 col-md-12">

							<form method="post" action="/receita/saveItem">
								@csrf
								<input type="hidden" name="produto_id" name="" value="{{$produto->id}}">
								<input type="hidden" value="{{$produto->receita->id}}" name="receita_id">
								<div class="card-body">
									<div class="form-group col-sm-12 col-lg-12">
										<label class="col-form-label text-left col-lg-12 col-sm-12">Produto</label>

										<select class="form-control select2" id="kt_select2_1" name="produto">

											@foreach($produtos as $p)
											<option value="{{$p->id}}">{{$p->id}} - {{$p->nome}}</option>
											@endforeach
										</select>
									</div>

									<div class="form-group validated col-sm-6 col-lg-6">
										<label class="col-form-label">Quatidade</label>
										<div class="">
											<input type="text" id="quantidade" class="form-control @if($errors->has('quantidade')) is-invalid @endif" name="quantidade">
											@if($errors->has('quantidade'))
											<div class="invalid-feedback">
												{{ $errors->first('quantidade') }}
											</div>
											@endif
										</div>
									</div>

									<div class="form-group validated col-sm-6 col-lg-6">
										<label class="col-form-label text-left col-lg-12 col-sm-12">Unidade de Quantidade</label>

										<select class="custom-select form-control" name="medida">
											<option value="Kilo">Kilo</option>
											<option value="Unidade">Unidade</option>
											<option value="Litro">Litro</option>
										</select>
									</div>

								</div>
								<div class="card-footer">
									<button type="reset" class="btn btn-secondary">Limpar</button>
									<button type="submit" class="btn btn-primary mr-2">Adicionar</button>
								</div>
							</form>
						</div>


						<div class="col-sm-12 col-lg-6 col-md-12">
							<div id="kt_datatable1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

								<div class="row">
									<div class="col-sm-12">
										<div class="dataTables_scroll">
											<div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px none; width: 100%;">
												<div class="dataTables_scrollHeadInner" style="box-sizing: content-box;padding-right: 0px;">
													<table class="table table-separate table-head-custom table-checkable dataTable no-footer" role="grid" style="margin-left: 0px">
														<thead>
															<tr role="row">
																<th class="sorting_asc" tabindex="0" aria-controls="kt_datatable1" rowspan="1" colspan="1"  aria-sort="ascending">PRODUTO</th>
																<th class="sorting" tabindex="0" aria-controls="kt_datatable1" rowspan="1" colspan="1" >QUANTIDADE</th>
																<th class="sorting" tabindex="0" aria-controls="kt_datatable1" rowspan="1" colspan="1">AÇÕES</th>

															</tr>
														</thead>
													</table>
												</div>
											</div>
											<div class="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%; max-height: 50vh;">
												<table class="table table-separate table-head-custom table-checkable dataTable no-footer" id="kt_datatable1" role="grid" aria-describedby="kt_datatable1_info" style="">


													<tbody>
														@foreach($produto->receita->itens as $i)
														<tr role="row" class="odd">
															<td class="sorting_1">{{$i->produto->nome}}</td>
															<td class="sorting_1">{{$i->quantidade}}/{{$i->medida}}</td>
															<td nowrap="nowrap">
																<div class="dropdown dropdown-inline">

																</div>
																<a href="/receita/deleteItem/{{$i->id}}" class="btn btn-sm btn-clean btn-icon" title="Delete"> <span class="svg-icon svg-icon-md">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24"></rect>
																				<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
																				<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
																			</g>
																		</svg>
																	</span>
																</a>
															</td>
														</tr>
														@endforeach

													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>


					</div>
					<br>
				</div>
			</div>
		</div>


	</div>



	@endif
</div>


@endsection