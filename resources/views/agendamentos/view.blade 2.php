@extends('default.layout')
@section('content')
<style type="text/css">
	#calendar{
		margin-top: 10px;
	}

	.categorias{
		overflow: auto;
		white-space: nowrap;
		height: 100px;
	}
	.categorias button{
		width: 200px;
		display: inline-block;
	}
	.servico{
		margin-left: 5px;
	}
</style>
<div class="card card-custom gutter-b">
	<div class="card-body">
		<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">

			<a href="" class="btn btn-success" onclick="modalOpen()" data-toggle="modal" data-target="#modal1">
				<i class="la la-plus"></i>
				Novo agendamento
			</a>
			<a target="_blank" href="/agendamentos/comissao" class="btn btn-info">
				<i class="las la-percent"></i>
				Comissão atendente
			</a>

			<a target="_blank" href="/agendamentos/servicos" class="btn btn-primary">
				<i class="la la-list"></i>
				Serviços executados
			</a>

			<div class="" id="kt_user_profile_aside" style="margin-left: 10px; margin-right: 10px;">


				<div class="row align-items-center">

					<div class="form-group col-lg-6 col-xl-6">
						<div class="row align-items-center">

							<div class="col-md-12 my-2 my-md-0">
								<label class="col-form-label">Atendente</label>


								<select required class="form-control select2" style="width: 100%" id="kt_select2_1">
									<option value="null">Selecione o atendente</option>
									@foreach($funcionarios as $f)
									<option value="{{$f->id}}">{{$f->id}} - {{$f->nome}}</option>
									@endforeach
								</select>

							</div>

						</div>
					</div>

					<div class="form-group col-lg-6 col-xl-6">
						<div class="row align-items-center">

							<div class="col-md-12 my-2 my-md-0">
								<label class="col-form-label">Cliente</label>


								<select required class="form-control select2" style="width: 100%" id="kt_select2_7">
									<option value="null">Selecione o cliente</option>
									@foreach($clientes as $c)
									<option value="{{$c->id}}">{{$c->id}} - {{$c->razao_social}}</option>
									@endforeach
								</select>

							</div>

						</div>
					</div>

					<div class="form-group col-lg-2 col-md-4 col-sm-6">
						<label class="col-form-label">Data Inicial</label>
						<div class="">
							<div class="input-group date">
								<input type="text" class="form-control data_inicial" readonly value="{{{ isset($dataInicial) ? $dataInicial : '' }}}" id="kt_datepicker_3" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group col-lg-2 col-md-4 col-sm-6">
						<label class="col-form-label">Data Final</label>
						<div class="">
							<div class="input-group date">
								<input type="text" class="form-control data_final" readonly value="{{{ isset($dataFinal) ? $dataFinal : '' }}}" id="kt_datepicker_3" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group col-lg-2 col-md-4 col-sm-6">
						<label class="col-form-label text-left col-lg-12 col-sm-12">Estado</label>

						<select class="custom-select form-control" id="status" name="status">
							<option @if(isset($stats) && $status == 'todos') selected @endif value="todos">TODOS</option>
							<option @if(isset($stats) && $status == 'finaizado') selected @endif value="1">FINALIZADO</option>
							<option @if(isset($stats) && $status == 'pendente') selected @endif value="0">PENDENTE</option>
						</select>

					</div>

					<div class="col-lg-4 col-xl-4 mt-4 mt-lg-0">
						<button id="filtrar" style="margin-top: 14px;" class="btn btn-light-primary spinner-white spinner-right">Pesquisa</button>
					</div>

				</div>

			</div>
			<div id='calendar'></div>

			<input type="hidden" value="{{json_encode($categorias)}}" id="categorias" name="">
			<input type="hidden" value="{{json_encode($servicos)}}" id="servicos" name="">
		</div>
	</div>
</div>

<div class="modal fade" id="modal1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Agendamento</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>


			<div class="modal-body">
				<div class="row">
					<div class="form-group validated col-sm-9 col-lg-9 col-9">
						<label class="col-form-label" id="">Cliente</label><br>
						<select required class="form-control select2" style="width: 100%" id="kt_select2_3" name="cliente">
							<option value="null">Selecione o cliente</option>
							@foreach($clientes as $c)
							<option value="{{$c->id}}">{{$c->id}} - {{$c->razao_social}}</option>
							@endforeach
						</select>
					</div>
					<div class="col-sm-3 col-lg-3 col-3"><br><br>
						<a data-toggle="modal" data-target="#modal-cliente" class="btn btn-success">
							<i class="la la-plus"></i>
						</a>
					</div>

					<div class="form-group validated col-sm-9 col-lg-9 col-9">
						<label class="col-form-label" id="">Atendente</label><br>
						<select required class="form-control select2" style="width: 100%" id="kt_select2_4" name="cliente">
							<option value="null">Selecione o atendente</option>
							@foreach($funcionarios as $f)
							<option value="{{$f->id}}">{{$f->id}} - {{$f->nome}}</option>
							@endforeach
						</select>
					</div>

				</div>

				<div class="row">

					<div class="col-lg-4 col-md-9 col-sm-12">
						<label class="col-form-label" id="">Data</label><br>

						<div class="input-group date">
							<input type="text" name="data" class="form-control data_inicio_servico" readonly  id="kt_datepicker_3" />
							<div class="input-group-append">
								<span class="input-group-text">
									<i class="la la-calendar"></i>
								</span>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-9 col-sm-12">
						<label class="col-form-label" id="">Horário de início</label><br>

						<div class="input-group timepicker">

							<input class="form-control" id="kt_timepicker_2" readonly="readonly" placeholder="Selecione o início" type="text">
							<div class="input-group-append">
								<span class="input-group-text">
									<i class="la la-clock-o"></i>
								</span>
							</div>
						</div>
					</div>
				</div>

				@if(sizeof($categorias) > 1)
				<div class="categorias" style="margin-top: 15px;">
					<h3>Categorias</h3>
					@foreach($categorias as $key => $c)
					<button @if($key == 0) class="btn btn-info" @else class="btn btn-light" @endif id="cat_{{$c->id}}" onclick="filtraServicos('{{$c->id}}')">
						{{$c->nome}}
					</button>
					@endforeach
				</div>
				@endif

				<h3>Serviços</h3>

				<div class="servicos">
				</div>

				<div class="row" style="margin-top: 10px;">
					<div class="col-sm-12">
						<h3>Total: R$ <strong class="text-success" id="somaValor">0</strong></h3>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<h3>Tempo de Serviço: <strong class="text-danger" id="tempoServico">0</strong> Min.</h3>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-4 col-md-9 col-sm-12">
						<label class="col-form-label" id="">Horário de término</label><br>

						<div class="input-group timepicker ipt_aux">

							<input class="form-control ipt" id="kt_timepicker_2" placeholder="Selecione o término" type="text">
							<div class="input-group-append">
								<span class="input-group-text">
									<i class="la la-clock-o"></i>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group validated col-sm-6 col-lg-6 col-12">
						<label class="col-form-label" id="">Observação</label><br>
						<input id="obs" class="form-control" type="text" name="obs">
					</div>

					<div class="form-group validated col-sm-4 col-lg-3 col-12">
						<label class="col-form-label" id="">Desconto</label><br>
						<input id="desconto" class="form-control money" type="text" name="desconto">
					</div>

					<div class="form-group validated col-sm-4 col-lg-3 col-12">
						<label class="col-form-label" id="">Acrescimo</label><br>
						<input id="acrescimo" class="form-control money" type="text" name="acrescimo">
					</div>

				</div>



			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="submit" id="btn-send" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Salvar</button>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="modal-cliente" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Novo Cliente</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					x
				</button>
			</div>

			<input type="hidden" id="_token" value="{{csrf_token()}}" name="">

			<div class="modal-body">
				<div class="row">
					<div class="form-group validated col-sm-9 col-lg-9 col-12">
						<label class="col-form-label" id="">Nome</label><br>
						<input id="nome" class="form-control" type="text" name="nome">
					</div>
				</div>

				<div class="row">
					<div class="form-group validated col-sm-6 col-lg-6 col-12">
						<label class="col-form-label" id="">Telefone</label><br>
						<input id="telefone" class="form-control" type="text" name="telefone">
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Fechar</button>
				<button type="button" id="btn-send-cliente" class="btn btn-light-success font-weight-bold spinner-white spinner-right">Salvar</button>
			</div>

		</div>
	</div>
</div>

@endsection	