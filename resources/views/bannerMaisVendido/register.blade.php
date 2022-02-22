@extends('default.layout')
@section('content')
<div class="row">
	<div class="col s12">
		<h4>{{{ isset($banner) ? "Editar": "Cadastrar" }}} Banner </h4>
		<p class="red-text">*Para Delivery do tipo mercado</p>
		<form method="post" action="{{{ isset($banner) ? '/bannerMaisVendido/update': '/bannerMaisVendido/save' }}}" enctype="multipart/form-data">
			<input type="hidden" name="id" value="{{{ isset($banner->id) ? $banner->id : 0 }}}">

			<div class="row">
				<div class="input-field col s6">
					<input value="{{{ isset($banner->texto_primario) ? $banner->texto_primario : old('texto_primario') }}}" id="texto_primario" name="texto_primario" type="text" class="validate" data-length="20">
					<label for="texto_primario">Texto Primário</label>

					@if($errors->has('texto_primario'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('texto_primario') }}</span>
					</div>
					@endif
				</div>
			</div>

			<div class="row">
				<div class="input-field col s10">

					<input value="{{{ isset($banner->texto_secundario) ? $banner->texto_secundario : old('texto_secundario') }}}" id="texto_secundario" name="texto_secundario" type="text" class="validate" data-length="30">

					<label for="texto_secundario">Texto Secundário</label>

					@if($errors->has('texto_secundario'))
					<div class="center-align red lighten-2">
						<span class="white-text">{{ $errors->first('texto_secundario') }}</span>
					</div>
					@endif
				</div>				
			</div>

			<div class="row">
				<div class="col s6">
					<div class="file-field input-field">
						<div class="btn black">
							<span>Imagem 570x715px</span>
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
					<img src="/banner_mais_vendido/{{$banner->path}}">
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
				<a class="btn-large red lighten-2" href="/bannerMaisVendido">Cancelar</a>
				<input type="submit" value="Salvar" class="btn-large green accent-3">
			</div>
		</form>
	</div>
</div>
@endsection