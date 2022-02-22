@extends('default.layout')
@section('content')
<div class="card card-custom gutter-b">
	<div class="card-body">

		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<input type="hidden" id="_token" value="{{ csrf_token() }}">
			<form method="get" action="/empresas/filtro">
				<div class="row align-items-center">

					<div class="form-group col-lg-4 col-md-6 col-sm-6">
						<label class="col-form-label">Nome</label>
						<div class="">
							<div class="input-group date">
								<input type="text" name="nome" class="form-control" value="{{{isset($nome) ? $nome : ''}}}" />
								
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
						<button style="margin-top: 15px;" class="btn btn-light-primary px-6 font-weight-bold">Pesquisa</button>
					</div>
				</div>
			</form>

			<h4>Lista de Empresas</h4>

			<label>Registros: <strong class="text-success">{{sizeof($empresas)}}</strong></label>
			<div class="row">
				<div class="form-group col-lg-3 col-md-4 col-sm-6">
					<a href="/empresas/nova" class="btn btn-success">
						<i class="la la-plus"></i>
						Nova Empresa
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
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 250px;">Endereço</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Cidade</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">Status</span></th>
								<th data-field="OrderID" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">Ações</span></th>
							</tr>
						</thead>

						<tbody class="datatable-body">
							@foreach($empresas as $e)

							<tr class="datatable-row">
								<td class="datatable-cell">
									<span class="codigo" style="width: 70px;">
										{{$e->id}}
									</span>
								</td>
								<td class="datatable-cell">
									<span class="codigo" style="width: 150px;">
										{{$e->nome}}
									</span>
								</td>

								<td class="datatable-cell">
									<span class="codigo" style="width: 250px;">
										{{$e->rua}}, {{$e->numero}} - {{$e->bairro}}
									</span>
								</td>

								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										{{$e->cidade}}
									</span>
								</td>

								<td class="datatable-cell">
									<span class="codigo" style="width: 100px;">
										@if($e->status() == -1)
										<span class="label label-xl label-inline label-light-info">
											MASTER
										</span>

										@elseif($e->status())
										<span class="label label-xl label-inline label-light-success">
											ATIVO
										</span>
										@else
										<span class="label label-xl label-inline label-light-danger">
											DESATIVADO
										</span>
										@endif
									</span>
								</td>

								<td class="datatable-cell">
									<span class="codigo" style="width: 200px;">
										<a href="/empresas/detalhes/{{$e->id}}" class="btn btn-sm btn-primary">
											Detalhes
										</a>
										<a onclick='swal("Atenção!", "Deseja remover esta empresa?", "warning").then((sim) => {if(sim){ location.href="/empresas/delete/{{ $e->id }}" }else{return false} })' href="#!"  class="btn btn-sm btn-danger">
											Remover
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
