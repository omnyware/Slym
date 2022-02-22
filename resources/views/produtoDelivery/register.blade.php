@extends('default.layout')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container">
		<div class="card card-custom gutter-b example example-compact">
			<div class="col-lg-12">
				<!--begin::Portlet-->

				<form method="post" action="{{{ isset($produto) ? '/deliveryProduto/update': '/deliveryProduto/save' }}}" enctype="multipart/form-data">
					<input type="hidden" name="id" value="{{{ isset($produto->id) ? $produto->id : 0 }}}">


					<div class="card card-custom gutter-b example example-compact">
						<div class="card-header">

							<h3 class="card-title">{{isset($categoria) ? 'Editar' : 'Novo'}} Produto</h3>
						</div>

					</div>
					@csrf

					<div class="row">
						<div class="col-xl-2"></div>
						<div class="col-xl-8">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">
									<p class="text-danger">O produto de delivery depende do produto principal, isso é necessário para baixa de estoque</p>
									<div class="row">
										<div class="form-group validated col-sm-8 col-lg-8 col-12">
											<label class="col-form-label" id="">Produto</label><br>
											<select class="form-control select2" style="width: 100%" id="kt_select2_1" name="produto">
												<option value="null">Selecione o produto</option>
												@foreach($produtos as $p)
												<option 
												@if(isset($produto))
												@if($p->id == $produto->produto->id)
												selected
												@endif
												@endif
												value="{{$p->id}}">{{$p->id}} - {{$p->nome}}</option>
												@endforeach
											</select>
											@if($errors->has('produto'))
											<div class="invalid-feedback">
												{{ $errors->first('produto') }}
											</div>
											@endif
										</div>

										<div class="form-group validated col-lg-4 col-md-4 col-sm-10">
											<label class="col-form-label ">Categoria</label>

											<select id="categoria-select" class="custom-select form-control" name="categoria_id">
												@foreach($categorias as $c)
												<option


												@if($c->id == old('categoria_id'))
												selected=""
												@endif


												@isset($produto)
												@if($c->id == $produto->categoria_id)
												selected=""
												@endif
												@endisset
												value="{{$c->id}}">{{$c->nome}}</option>
												@endforeach
											</select>

											@if($errors->has('categoria'))
											<div class="invalid-feedback">
												{{ $errors->first('categoria') }}
											</div>
											@endif
										</div>
									</div>
								</div>


								<div id="produto-comum">
									<div class="row">

										<div class="form-group validated col-sm-2 col-lg-4">
											<label class="col-form-label">Valor de Venda</label>
											<div class="">
												<input type="text" class="form-control @if($errors->has('valor')) is-invalid @endif" name="valor" id="valor" value="{{{ isset($produto) ? $produto->valor : old('valor') }}}">
												@if($errors->has('valor'))
												<div class="invalid-feedback">
													{{ $errors->first('valor') }}
												</div>
												@endif
											</div>
										</div>

										<div class="form-group validated col-sm-2 col-lg-4">
											<label class="col-form-label">Valor Anterior</label>
											<div class="">
												<input type="text" id="valor_anterior" class="form-control @if($errors->has('valor_anterior')) is-invalid @endif" name="valor_anterior" value="{{{ isset($produto) ? $produto->valor_anterior : old('valor_anterior') }}}">
												@if($errors->has('valor_anterior'))
												<div class="invalid-feedback">
													{{ $errors->first('valor_anterior') }}
												</div>
												@endif
											</div>
										</div>
									</div>

								</div>


								<?php $controleEdit = []; ?>

								<div id="produto-pizza" style="display: none">
									<div class="row">
										@foreach($tamanhos as $key => $t)

										<div class="form-group validated col-sm-2 col-lg-3">
											<label class="col-form-label">Valor {{$t->nome}}</label>

											@if(isset($produto) && count($produto->pizza) > 0)
											@foreach($produto->pizza as $pp)

											@if($pp->tamanho_id == $t->id)
											<input type="text" class="form-control valor_pizza" value="{{{ isset($pp->valor) ? $pp->valor : old('valor_{{$t->nome}}') }}}" name="valor_{{$t->nome}}">
											@else

											@if(!$pp->tamanhoNaoCadastrado($t->id, $pp->produto) && !in_array($t->id, $controleEdit))
											<input type="text" class="form-control valor_pizza" 
											value="" name="valor_{{$t->nome}}">

											<?php array_push($controleEdit, $t->id); ?>

											@endif
											@endif
											@endforeach

											@else
											<input type="text" class="form-control valor_pizza" value="{{{ isset($pp->valor) ? $pp->valor : old('valor_'.$t->nome) }}}" name="valor_{{$t->nome}}">
											@endif


											@if($errors->has('valor_'.$t->nome))
											<div class="invalid-feedback">
												{{ $errors->first('valor_'.$t->nome) }}
											</div>
											@endif
										</div>

										@endforeach

									</div>
								</div>



								<div class="row">
									<div class="form-group validated col-sm-12 col-lg-12">
										<label class="col-form-label">Descrição</label>
										<div class="">

											<textarea class="form-control" name="descricao" placeholder="Descrição" rows="3">{{{ isset($produto->descricao) ? $produto->descricao : old('descricao') }}}</textarea>
											@if($errors->has('descricao'))
											<div class="invalid-feedback">
												{{ $errors->first('descricao') }}
											</div>
											@endif
										</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group validated col-sm-12 col-lg-12">
										<label class="col-form-label">Ingredientes</label>
										<div class="">

											<textarea class="form-control" name="ingredientes" placeholder="Descrição" rows="3">{{{ isset($produto->ingredientes) ? $produto->ingredientes : old('ingredientes') }}}</textarea>
											@if($errors->has('ingredientes'))
											<div class="invalid-feedback">
												{{ $errors->first('ingredientes') }}
											</div>
											@endif
										</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group validated col-sm-3 col-lg-3">
										<label class="col-form-label">Limite diário de venda</label>
										<div class="">
											<input type="text" id="ncm" class="form-control @if($errors->has('limite_diario')) is-invalid @endif" name="limite_diario" value="{{{ isset($produto->limite_diario) ? $produto->limite_diario : old('limite_diario') }}}">
											@if($errors->has('limite_diario'))
											<div class="invalid-feedback">
												{{ $errors->first('limite_diario') }}
											</div>
											@endif
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col s2">
										<label>Destaque:</label>

										<div class="switch switch-outline switch-success">
											<label class="">
												<input @if(isset($produto->destaque) && $produto->destaque) checked @endisset value="true" name="destaque" class="red-text" type="checkbox">
												<span class="lever"></span>
											</label>
										</div>
									</div>

									<div class="col s2">
										<label>Ativo:</label>

										<div class="switch switch-outline switch-info">
											<label class="">
												<input @if(isset($produto->status) && $produto->status) checked @endisset value="true" name="status" class="red-text" type="checkbox">
												<span class="lever"></span>
											</label>
										</div>
									</div>
								</div><br>



							</div>



						</div>
					</div>
					<div class="card-footer">

						<div class="row">
							<div class="col-xl-2">

							</div>
							<div class="col-lg-3 col-sm-6 col-md-4">
								<a style="width: 100%" class="btn btn-danger" href="/deliveryCategoria">
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