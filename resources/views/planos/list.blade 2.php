@extends('default.layout')
@section('content')
<div class="card card-custom gutter-b">
	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<input type="hidden" id="_token" value="{{ csrf_token() }}">
			

			<h4>Lista de Planos</h4>

			<label>Registros: <strong class="text-success">{{sizeof($planos)}}</strong></label>
			<div class="row">
				<div class="form-group col-lg-3 col-md-4 col-sm-6">
					<a href="/planos/new" class="btn btn-success">
						<i class="la la-plus"></i>
						Novo Plano
					</a>
				</div>
			</div>

			<div class="col-xl-12">

				<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded">

					<table class="datatable-table" style="max-width: 100%; overflow: scroll">
						<thead class="datatable-head">
							<tr class="datatable-row" style="left: 0px;">
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 70px;">#</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">Nome</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Valor</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Max clientes</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Max produtos</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 120px;">Max fornecedores</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Max NFe</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Max NFCe</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Max CTe</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Max MDFe</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Ações</span></th>
							</tr>
						</thead>

						<tbody class="datatable-body">
							@foreach($planos as $p)

							<tr class="datatable-row">
								<td class="datatable-cell">
									<span class="codigo" style="width: 70px;">
										{{$p->id}}
									</span>
								</td>
								<td class="datatable-cell">
									<span class="codigo" style="width: 150px;">
										{{$p->nome}}
									</span>
								</td>

								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										{{number_format($p->valor, 2)}}
									</span>
								</td>

								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										{{$p->maximo_clientes}}
									</span>
								</td>

								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										{{$p->maximo_produtos}}
									</span>
								</td>

								<td class="datatable-cell">
									<span class="codigo" style="width: 120px;">
										{{$p->maximo_fornecedores}}
									</span>
								</td>

								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										{{$p->maximo_nfes}}
									</span>
								</td>

								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										{{$p->maximo_nfces}}
									</span>
								</td>

								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										{{$p->maximo_cte}}
									</span>
								</td>

								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										{{$p->maximo_mdfe}}
									</span>
								</td>


								<td class="datatable-cell">
									<span class="codigo" style="width: 200px;">
										<a href="/planos/editar/{{$p->id}}" class="btn btn-sm btn-primary">
											<i class="la la-edit"></i>
										</a>
										<a onclick='swal("Atenção!", "Deseja remover esta registro?", "warning").then((sim) => {if(sim){ location.href="/planos/delete/{{ $p->id }}" }else{return false} })' href="#!"  class="btn btn-sm btn-danger">
											<i class="la la-trash"></i>
										</a>
									</span>
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

@endsection	
