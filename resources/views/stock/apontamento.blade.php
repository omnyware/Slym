@extends('default.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="/estoque/saveApontamento" enctype="multipart/form-data">

					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">Apontamento de produção</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">

							<div class="kt-section kt-section--first">
								<div class="kt-section__body">

									<div class="row">
										<div class="form-group validated col-lg-8 col-md-8 col-sm-10">
											<label class="col-form-label text-left col-lg-4 col-sm-12">Produto</label>
											<select class="form-control select2" id="kt_select2_2" name="produto">
												@foreach($produtos as $p)
												<option value="{{$p->id}}">{{$p->id}} - {{$p->nome}}</option>
												@endforeach
											</select>
											@if($errors->has('produto'))
											<div class="invalid-feedback">
												{{ $errors->first('produto') }}
											</div>
											@endif
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-6 col-lg-4">
											<label class="col-form-label">Quantiade</label>
											<div class="">
												<input type="text" id="quantidade" class="form-control @if($errors->has('quantidade')) is-invalid @endif" name="quantidade" value="{{{ old('quantidade') }}}">
												@if($errors->has('quantidade'))
												<div class="invalid-feedback">
													{{ $errors->first('quantidade') }}
												</div>
												@endif
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
				</form>
			</div>
		</div>

		<div class="card card-custom gutter-b">

			<div class="card-body">

				<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<div class="col-xl-12">
								<div class="row">
									<div class="col-xl-12">
										<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">
											<br>
											<h4>Ultimos 5 Apontamentos</h4>

											<table class="datatable-table" style="max-width: 100%; overflow: scroll">
												<thead class="datatable-head">
													<tr class="datatable-row" style="left: 0px;">

														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Produto</span></th>
														<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Quantidade</span></th>
														<th data-field="Country" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Data de registro</span></th>
														

														<th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Usuário</span></th>
														

														<!-- <th data-field="ShipDate" class="datatable-cell datatable-cell-sort"><span style="width: 80px;">Ações</span></th> -->

													</tr>
												</thead>
												<tbody class="datatable-body">
													
													@foreach($apontamentos as $a)
													<tr class="datatable-row" style="left: 0px;">
														<td class="datatable-cell"><span class="codigo" style="width: 150px;">
															{{$a->produto->nome}}
														</span></td>
														<td class="datatable-cell"><span class="codigo" style="width: 80px;">
															{{$a->quantidade}}
														</span></td>
														<td class="datatable-cell"><span class="codigo" style="width: 80px;">
															{{ \Carbon\Carbon::parse($a->data_registro)->format('d/m/Y H:i:s')}}
														</span></td>
														<td class="datatable-cell"><span class="codigo" style="width: 80px;">
															{{$a->usuario->nome}}
														</span></td>

														<!-- <td class="datatable-cell">
															<span class="codigo" style="width: 80px;">
																<a onclick='swal("Atenção!", "Deseja excluir este registro? O estoque de produtos será alterado!", "warning").then((sim) => {if(sim){ location.href="/estoque/deleteApontamento/{{$a->id}}" }else{return false} })' href="#!">
																	<span class="label label-xl label-inline label-light-danger">Remover</span>
																</a>
															</span>
														</td>	 -->													
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
					<a href="/estoque/todosApontamentos">
						<span class="label label-xl label-inline label-light-primary">Ver todos</span>
					</a>
				</div>
			</div>

		</div>

	</div>
</div>

@endsection


