@extends('default.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="{{{ isset($push) ? '/push/update': '/push/save' }}}">

					<input type="hidden" name="id" value="{{{isset($push) ? $push->id : 0}}}">
					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{isset($push) ? 'Editar' : 'Cadastrar'}} Notificação Push</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">
									@if(!isset($titulo) && !isset($mensagem))
									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-8">
											<label class="col-form-label">Título</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('titulo')) is-invalid @endif" name="titulo" value="{{{ isset($titulo) ? $titulo : old('titulo') }}}">
												@if($errors->has('titulo'))
												<div class="invalid-feedback">
													{{ $errors->first('titulo') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-12 col-lg-12">
											<label class="col-form-label">Texto</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('mensagem')) is-invalid @endif" name="texto" value="{{{ isset($mensagem) ? $mensagem : old('texto') }}}">
												@if($errors->has('texto'))
												<div class="invalid-feedback">
													{{ $errors->first('texto') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-8">
											<label class="col-form-label">Endereço da Imagem (opcional)</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('mensagem')) is-invalid @endif" id="path_img" name="path_img" value="{{{ isset($imagem) ? getenv('PATH_URL').'/imagens_produtos/'.$imagem : old('path_img') }}}">
												@if($errors->has('path_img'))
												<div class="invalid-feedback">
													{{ $errors->first('path_img') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">Código do Produto (opcional)</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('referencia')) is-invalid @endif" name="referencia_produto" value="{{{ isset($referencia) ? $referencia : old('referencia_produto') }}}" 
												@if($errors->has('referencia_produto'))
												<div class="invalid-feedback">
													{{ $errors->first('referencia_produto') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									@else

									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-8">
											<label class="col-form-label">Título</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('titulo')) is-invalid @endif" name="titulo" value="{{{ isset($titulo) ? $titulo : old('titulo') }}}">
												@if($errors->has('titulo'))
												<div class="invalid-feedback">
													{{ $errors->first('titulo') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-12 col-lg-12">
											<label class="col-form-label">Texto</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('mensagem')) is-invalid @endif" name="texto" value="{{{ isset($mensagem) ? $mensagem : old('texto') }}}">
												@if($errors->has('texto'))
												<div class="invalid-feedback">
													{{ $errors->first('texto') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-8">
											<label class="col-form-label">Endereço da Imagem (opcional)</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('mensagem')) is-invalid @endif" id="path_img" name="path_img" value="{{{ $imagem != '' ? getenv('PATH_URL').'/imagens_produtos/'.$imagem : old('path_img') }}}">
												@if($errors->has('path_img'))
												<div class="invalid-feedback">
													{{ $errors->first('path_img') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-4 col-lg-4">
											<label class="col-form-label">Código do Produto (opcional)</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('referencia')) is-invalid @endif" name="referencia_produto" value="{{{ isset($referencia) ? $referencia : old('referencia_produto') }}}" 
												@if($errors->has('referencia_produto'))
												<div class="invalid-feedback">
													{{ $errors->first('referencia_produto') }}
												</div>
												@endif
											</div>
										</div>
									</div>

									@endif

									<div id="div-img" style="display: none">
										<div class="row">
											<div class="col s12">
												<img src="" style="width: 300px; height: 200px" id="img-view">
											</div>
										</div>
									</div>

									<div class="row">
										@isset($push)
										@if($push->cliente)
										<p class="red-text">Notificaçao para cliente 
											<strong>{{$push->cliente->nome}}</strong></p><br>

											@else
											<p class="red-text">Notificaçao para todos os clientes</p><br>
											@endif
											@endisset
										</div>
										@if(!isset($push))
										<div class="col-sm-3 col-lg-3">
											Todos os Clientes
											<div class="switch switch-outline switch-info">
												<label class="">
													<input id="todos" name="todos" class="red-text" type="checkbox">
													<span class="lever"></span>
												</label>
											</div>
										</div>

										<div class="col-sm-9 col-lg-9" id="cliente">
											<div class="form-group validated col-sm-8 col-lg-8 col-12">
												<label class="col-form-label" id="">Cliente</label><br>
												<select class="form-control select2" style="width: 100%" id="kt_select2_1" name="cli">
													<option value="null">Selecione o cliente</option>
													@foreach($clientes as $c)
													<option 
													value="{{$c->id}}">{{$c->id}} - {{$c->nome}}</option>
													@endforeach
												</select>
												
											</div>
										</div>
										


										@endisset
										<br>
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
								<a style="width: 100%" class="btn btn-danger" href="/deliveryProduto">
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
	</div>
</div>
@endsection	