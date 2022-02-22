@extends('default.layout')
@section('content')

<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="row">

			@if(sizeof($mesasFechadas) > 0)
			<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
				<div class="row">
					<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
						<h4>Mesas com pedido de fechamento:</h4>

						@foreach($mesasFechadas as $m)
						<a href="/pedidos/verMesa/{{$m->mesa->id}}" target="_blank" class="btn btn-danger">Ver {{$m->mesa->nome}}</a>
						@endforeach
					</div>
				</div>
			</div>
			@endif

			@if(sizeof($mesasParaAtivar) > 0)
			<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
				<div class="row">
					<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">

						<h4>Mesas a serem ativadas:</h4>
						@foreach($mesasParaAtivar as $m)
						<a onclick='swal("Atenção!", "Deseja ativar esta mesa?", "warning").then((sim) => {if(sim){ location.href="/pedidos/ativarMesa/{{ $m->id }}" }else{return false} })' href="#!" class="btn btn-success">Ativar {{$m->mesa->nome}}</a>
						@endforeach

					</div>
				</div>
			</div>
			@endif
		</div>
		<hr>

		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			<div class="row">
					<a class="btn btn-lg btn-success" style="width: 100%;" data-toggle="modal" data-target="#modal1">Abrir Comanda</a>
			</div>

		</div>

		<hr>


		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			@if(count($pedidos) > 0)
			<h5 class="text-success">Comandas em verde já finalizadas</h5>

			<div class="row">
				@foreach($pedidos as $p)
				<div class="col-sm-4 col-lg-4 col-md-6">

					<div class="card card-custom gutter-b @if($p->status) green lighten-4 @endif">
						<div class="card-header">
							<h3 style="margin-top: 20px;">COMANDA:
								@if($p->comanda == '')
								<a class="btn btn-light-info" onclick="atribuir('{{$p->id}}', '{{$p->mesa->nome}}')" data-toggle="modal" data-target="#modal-comanda">Atribuir comanda</a>
								<h2><br></h2>
								@else
								<span>{{$p->comanda}}</span>
								@endif
							</h3>
						</div>
						<div class="card-body" style="height: 200px;">

							<h5>Total: <strong class="text-info">R$ {{number_format($p->somaItems(),2 , ',', '.')}}</strong></h5>
							<h5>Horário Abertura: <strong class="text-info">{{ \Carbon\Carbon::parse($p->data_registro)->format('H:i')}}</strong></h5>
							<h5>Total de itens: <strong class="text-info">{{count($p->itens)}}</strong></h5>
							<h5>Itens Pendentes: <strong class="text-info">{{$p->itensPendentes()}}</strong></h5>
							<h5>Mesa: 
								@if($p->mesa != null)
								<strong class="text-info">{{$p->mesa->nome}}</strong>
								@else
								<strong class="text-info">AVULSA</strong> 
								<a onclick="setarMesa('{{$p->id}}', '{{$p->comanda}}')" class="btn btn-primary" data-toggle="modal" data-target="#modal-set-mesa">
									setar
								</a>
								@endif
							</h5>

							@if($p->referencia_cliete != '')
							<h5 class="text-danger">Mesa QrCode</h5>
							@else
							<h5><br></h5>
							@endif

							
						</div>

						<div class="card-footer">
							<a class="btn btn-danger" style="width: 100%;" 
							onclick='swal("Atenção!", "Deseja desativar esta comanda? os dados não poderam ser retomados!", "warning").then((sim) => {if(sim){ location.href="/pedidos/desativar/{{ $p->id }}" }else{return false} })' href="#!"><i class="la la-times"></i> Desativar</a>
							<a href="/pedidos/ver/{{$p->id}}" style="width: 100%; margin-top: 5px;" class="btn btn-info">
								<i class="la la-list"></i>Ver Itens
							</a>
							
						</div>

					</div>


				</div>

				@endforeach


			</div>
			<div class="row">
				<div class="col s6 offset-s3">
					<a href="/pedidos/mesas" class="btn btn-lg btn-light-info">VER MESAS</a>
				</div>

			</div>
			@else

			<div class="col s12">
				<h4 class="center-align">Nenhuma comanda aberta!</h4>
				<a class="btn btn-lg btn-success" data-toggle="modal" data-target="#modal1">Abrir Comanda</a>
			</div>

			@endif

		</div>
	</div>
</div>


<div class="modal fade" id="modal1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<form method="post" action="/pedidos/abrir">
		@csrf
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">ABRIR COMANDA</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						x
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group validated col-sm-3 col-lg-3">
							<label class="col-form-label" id="">Código da comanda</label>
							<div class="">
								<input type="text" id="comanda" name="comanda" class="form-control" value="">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-lg-4 col-md-4 col-sm-6">
							<label class="col-form-label">Mesa</label>
							<div class="">
								<div class="input-group date">
									<select class="custom-select form-control" id="mesa_id" name="mesa_id">
										<option value="null">*</option>
										@foreach($mesas as $m)
										<option value="{{$m->id}}">{{$m->nome}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group validated col-sm-12 col-lg-12">
							<label class="col-form-label" id="">Observação</label>

							<div class="">
								<input type="text" id="observacao" name="observacao" class="form-control" value="">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
					<button type="submit" id="btn-corrigir-2-aux" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Abrir</button>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="modal fade" id="modal-comanda" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<form method="post" action="/pedidos/atribuirComanda">

		@csrf
		<input type="hidden" id="pedido_id" name="pedido_id">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">ATRIBUIR COMANDA</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						x
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group validated col-sm-3 col-lg-3">
							<label class="col-form-label" id="">Código da comanda</label>
							<div class="">
								<input type="text" id="comanda" name="comanda" class="form-control" value="">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-lg-4 col-md-4 col-sm-6">
							<label class="col-form-label">Mesa</label>
							<div class="">

								<input type="text" name="mesa" id="mesa_atribuida" class="form-control" disabled>

							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group validated col-sm-12 col-lg-12">
							<label class="col-form-label" id="">Observação</label>

							<div class="">
								<input type="text" id="observacao" name="observacao" class="form-control" value="">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
					<button type="submit" id="btn-corrigir-2-aux" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Ok</button>
				</div>
			</div>
		</div>
	</form>
</div>


<div class="modal fade" id="modal-set-mesa" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<form method="post" action="/pedidos/atribuirMesa">

		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" id="pedido_id_mesa" name="pedido_id">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">SETAR MESA COMANDA</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						x
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group validated col-sm-3 col-lg-3">
							<label class="col-form-label" id="">Código da comanda</label>
							<div class="">
								<input type="text" id="comanda_mesa" name="comanda" class="form-control" disabled value="">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-lg-4 col-md-4 col-sm-6">
							<label class="col-form-label">Mesa</label>
							<div class="">
								<div class="input-group date">
									<select class="custom-select form-control" id="mesa" name="mesa">
										@foreach($mesas as $m)
										<option value="{{$m->id}}">{{$m->nome}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
					<button type="submit" id="btn-corrigir-2-aux" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Abrir</button>
				</div>
			</div>
		</div>
	</form>
</div>


@endsection	