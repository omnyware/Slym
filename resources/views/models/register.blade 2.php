@extends('default.layout')
@section('content')
	<div class="row">
		<div class="col s12">
			<h4>{{{ isset($model) ? "Editar": "Cadastrar" }}} Modelo</h4>
			<form method="post" action="{{{ isset($model) ? '/modelos/update': '/modelos/save' }}}" 
			enctype="multipart/form-data">
				<input type="hidden" name="id" value="{{{ isset($model->id) ? $model->id : 0 }}}">
				<div class="row">
					<div class="col s9">
						<div class="row">
							<div class="input-field col s8">
				          		<input value="{{{ isset($model->name) ? $model->name : old('name') }}}" id="name" name="name" type="text" class="validate">
				          		<label for="name">Nome</label>
				          
				          		@if($errors->has('name'))
				          		<div class="center-align red lighten-2">
				          			<span class="white-text">{{ $errors->first('name') }}</span>
				          		</div>
				          		@endif
				        	</div>
						</div>

						<div class="row">
							<div class="input-field col s8">
					          	<textarea class="materialize-textarea validate" id="description" name="description">
					          	{{{ isset($model->description) ? $model->description : old('description') }}}
					          	</textarea>
				          		<label for="description">Descrição</label>
				          
				          		@if($errors->has('description'))
				          			<div class="center-align red lighten-2">
				          				<span class="white-text">{{ $errors->first('description') }}</span>
				          			</div>
				          		@endif
				        	</div>
						</div>

						<div class="row">
							<div class="input-field col s6">

								<select name="brand_id">
								@foreach($brands as $b)
									<option
									value = "{{$b->id}}"
									@isset($model)
										@if($b->id == $model->id)
											echo 'selected'
										@endif
									@endisset

									>{{$b->name}}</option>
								@endforeach
								</select>
				          
				          		@if($errors->has('brand_id'))
						          	<div class="center-align red lighten-2">
						          		<span class="white-text">{{ $errors->first('brand_id') }}</span>
						          	</div>
				          		@endif
				        	</div>
						</div>

						<div class="row">
							<div class="col s8 file-field input-field">
				      			<div class="btn">
				        			<span>Imagem</span>
				        			<input name="img" type="file" multiple>
				      			</div>
				      			<div class="file-path-wrapper">
				        			<input class="file-path validate" type="text" 
				        			placeholder="Nome do arquivo">
				      			</div>
				      			@if($errors->has('img'))
					          	<div class="center-align red lighten-2">
					          		<span class="white-text">{{ $errors->first('img') }}</span>
					          	</div>
					        	@endif
				    		</div>
						</div>
					</div>

					<div class="col s3">
						@isset($model)
						<img style="width: 300px; height: 250px;" src="{{ url("imagens/modelos/{$model->img}")}}">
						@endisset
					</div>

				</div>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<br>
				
				<br>
				<div class="row">
					<a class="btn red" href="/produtos">Cancelar</a>
					<input type="submit" value="Salvar" class="btn green">
				</div>
			</form>
		</div>
	</div>
@endsection