@extends('default.layout')
@section('content')
<div class="row">
	<div class="col s12">
		<h4>{{{ isset($banner) ? "Editar": "Cadastrar" }}} Banner do Topo</h4>
		<p class="red-text">*Para Delivery do tipo mercado</p>
		<form method="post" action="{{{ isset($banner) ? '/bannerTopo/update': '/bannerTopo/save' }}}" enctype="multipart/form-data">
			<input type="hidden" name="id" value="{{{ isset($banner->id) ? $banner->id : 0 }}}">

			<div class="row">
				<div class="input-field col s6">
					<input value="{{{ isset($banner->titulo) ? $banner->titulo : old('titulo') }}}" id="titulo" name="titulo" type="text" class="validate" data-length="20">
					<label for="titulo">Titulo</label>

					@if($errors->has('titulo'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('titulo') }}</span>
					</div>
					@endif
				</div>
			</div>

			<div class="row">
				<div class="input-field col s10">

					<input value="{{{ isset($banner->descricao) ? $banner->descricao : old('descricao') }}}" id="descricao" name="descricao" type="text" class="validate" data-length="100">

					<label for="descricao">Descrição</label>

					@if($errors->has('descricao'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('descricao') }}</span>
					</div>
					@endif
				</div>				
			</div>

			<div class="row">
				<div class="col s6">
					<div class="file-field input-field">
						<div class="btn black">
							<span>Imagem 1920x730px</span>
							<input value="{{{ isset($banner->path) ? $banner->path : old('path') }}}" name="file" accept=".png, .jpg, .jpeg" type="file">
						</div>
						<div class="file-path-wrapper">

							<input class="file-path validate" type="text">
						</div> 

						@if($errors->has('file'))
						<div class="center-align red lighten-2">
							<span class="white-text">{{ $errors->first('file') }}</span>
						</div>
						@endif
					</div>
				</div>
				<div class="col s6">
					@if(isset($banner))
					<img style="width: 300px;" src="/banner_topo/{{$banner->path}}">
					<label>Imagem atual</label>
					@endif
				</div>
			</div>

			<div class="row">
				<div class="input-field col s4">
					<i class="material-icons prefix">inbox</i>
					<input autocomplete="off" type="text" name="produto" id="autocomplete-produto" value="{{{ isset($banner) && $banner->produto_delivery_id != null ? $banner->produto->id .' - '. $banner->produto->produto->nome : old('produto') }}}" class="autocomplete-produto">
					<label for="autocomplete-produto">Produto de Delivery</label>
					@if($errors->has('produto'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('produto') }}</span>
					</div>
					@endif
				</div>

				<div class="col s3"><br>
					<p>
						<input 
						@if(isset($banner) && $banner->ativo) checked 
						@endif type="checkbox" id="status" name="status" />
						<label for="status">Ativo</label>
					</p>
				</div>
			</div>

			@csrf


			<br>
			<div class="row">
				<a class="btn-large red lighten-2" href="/bannerTopo">Cancelar</a>
				<input type="submit" value="Salvar" class="btn-large green accent-3">
			</div>
		</form>
	</div>
</div>
@endsection