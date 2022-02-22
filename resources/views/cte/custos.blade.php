@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="content d-flex flex-column flex-column-fluid" id="kt_content" >

			<div class="col-lg-12" id="content">

				<div class="row">
					<div class="col-sm-6 col-lg-6 col-md-6">

						<div class="card card-custom gutter-b">
							<div class="card-header">
								<h3 class="card-title">DESPESAS</h3>
							</div>
							<div class="card-body">
								<form method="post" action="/cte/saveDespesa">
									@csrf
									<input type="hidden" name="cte_id" value="{{$cte->id}}">
									<div class="row">

										<div class="form-group col-xl-12 col-12">
											<label class="col-form-label">Descrição</label>
											<div class="">
												<div class="input-group">
													<input type="text" name="descricao" required class="form-control" value=""/>
												</div>
											</div>
										</div>

										<div class="form-group col-xl-6 col-12">
											<label class="col-form-label">Categoria</label>
											<div class="">
												<div class="input-group">
													<select class="custom-select form-control" id="" name="categoria_id">
														@foreach($categorias as $c)
														<option value="{{$c->id}}">{{$c->nome}}</option>
														@endforeach
													</select>
												</div>
											</div>
										</div>

										<div class="form-group col-xl-6 col-12">
											<label class="col-form-label">Valor</label>
											<div class="">
												<div class="input-group">
													<input type="text" name="valor" required id="valor" class="form-control" value=""/>

												</div>
											</div>
										</div>

										<div class="form-group col-12">
											<button style="width: 100%" type="submit" class="btn btn-lg btn-light-danger">Salvar</button>
										</div>
									</div>

								</form>
							</div>

							<div class="card-footer">
								<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

									<table class="datatable-table" style="max-width: 100%; overflow: scroll">
										<thead class="datatable-head">
											<tr class="datatable-row" style="left: 0px;">
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Descrição</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Categoria</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Ações</span></th>

											</tr>
										</thead>
										<tbody id="body" class="datatable-body">
											@foreach($cte->despesas as $d)
											<tr class="datatable-row">
												<td class="datatable-cell">
													<span class="codigo" style="width: 120px;" id="id">
														{{$d->descricao}}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;" id="id">
														{{$d->categoria->nome}}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;" id="id">
														{{$d->valor}}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;" id="id">
														<a href="/cte/deleteDespesa/{{$d->id}}" class="btn btn-sm btn-light-danger">
															<i class="la la-trash"></i>
														</a>
													</span>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
									<br>
									<h3 class="text-danger">Total: R$ {{number_format($cte->somaDespesa(), 2)}}</h3>

								</div>
							</div>
						</div>
					</div>



					<div class="col-sm-6 col-lg-6 col-md-6">

						<div class="card card-custom gutter-b">
							<div class="card-header">
								<h3 class="card-title">RECEITAS</h3>
							</div>
							<div class="card-body">
								<form method="post" action="/cte/saveReceita">
									@csrf
									<input type="hidden" name="cte_id" value="{{$cte->id}}">
									<div class="row">

										<div class="form-group col-xl-12 col-12">
											<label class="col-form-label">Descrição</label>
											<div class="">
												<div class="input-group">
													<input type="text" name="descricao" required class="form-control" value=""/>
												</div>
											</div>
										</div>

										<div class="form-group col-xl-6 col-12">
											<label class="col-form-label">Valor</label>
											<div class="">
												<div class="input-group">
													<input type="text" name="valor" required id="valor" class="form-control" value=""/>

												</div>
											</div>
										</div>

										<div class="form-group col-12">
											<button style="width: 100%" type="submit" class="btn btn-lg btn-light-success">Salvar</button>
										</div>
									</div>

								</form>
							</div>
							<div class="card-footer">
								<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

									<table class="datatable-table" style="max-width: 100%; overflow: scroll">
										<thead class="datatable-head">
											<tr class="datatable-row" style="left: 0px;">
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Descrição</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>
												<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Ações</span></th>

											</tr>
										</thead>
										<tbody id="body" class="datatable-body">
											@foreach($cte->receitas as $d)

											<tr class="datatable-row">
												<td class="datatable-cell">
													<span class="codigo" style="width: 120px;" id="id">
														{{$d->descricao}}
													</span>
												</td>

												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;" id="id">
														{{$d->valor}}
													</span>
												</td>
												<td class="datatable-cell">
													<span class="codigo" style="width: 100px;" id="id">
														<a href="/cte/deleteReceita/{{$d->id}}" class="btn btn-sm btn-light-danger">
															<i class="la la-trash"></i>
														</a>
													</span>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
									<br>
									<h3 class="text-success">Total: R$ {{number_format($cte->somaReceita(), 2)}}</h3>

								</div>
							</div>
						</div>
					</div>

				</div>

				<div class="row">
					<h2>Saldo: R$ 
						<strong class=" @if($cte->somaReceita()>$cte->somaDespesa()) text-success
							@elseif($cte->somaReceita()==$cte->somaDespesa()) text-primary
							@else text-danger @endif">{{number_format($cte->somaReceita()-$cte->somaDespesa(), 2)}}</strong>
						</h2>
					</div>

				</div>
			</div>
		</div>
	</div>

	@endsection	