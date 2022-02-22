@extends('default.layout')
@section('content')
	<div class="row">
		<div class="col s12">
			<h4>Cadastrar Serviço</h4>
			<form method="post" action="/servicos/save" enctype="multipart/form-data">
				
				<div class="row">
					<div class="col s12">
				        <div class="input-field col s6">
				          <i class="material-icons prefix">tablet_mac</i>
				          <input autocomplete="off" type="text" name="model" id="autocomplete-modelo" class="autocomplete-modelo">
				          <label for="autocomplete-modelo">Modelo</label>

				          @if(session()->has('message_error_model'))
					          <div class="center-align red lighten-2">
					          	<span class="white-text">{{ session()->get('message_error_model') }}</span>
					          </div>
				          @endif
				        </div>
				    </div>
			    </div>

			    <div class="row">
					<div class="col s12">
				        <div class="input-field col s6">
				          <i class="material-icons prefix">build</i>
				          <input autocomplete="off" type="text" name="product" id="autocomplete-produto" class="autocomplete-produto">
				          <label for="autocomplete-produto">Peça/Produto utilizado</label>

				          @if(session()->has('message_error_product'))
					          <div class="center-align red lighten-2">
					          	<span class="white-text">{{ session()->get('message_error_product') }}</span>
					          </div>
				          @endif
				        </div>
				    </div>
			    </div>

			    <div class="row">
					<div class="input-field col s6">
						<i class="material-icons prefix">text_format</i>
			          <textarea class="materialize-textarea validate" id="description" name="description">
			          	{{old('description')}}
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
						<i class="material-icons prefix">storage</i>
			        	<select name="type_id">
			        		@foreach($types as $t)
			        		<option value="{{$t->id}}">{{$t->name}}</option>
			        		@endforeach
			        	</select>
			        </div>
				</div>

				<div class="row">
					<div class="input-field col s4">
						<i class="material-icons prefix">attach_money</i>
				          <input id="value" name="value" type="text" class="validate">
				          <label for="value">Valor</label>
			          	@if($errors->has('value'))
				          <div class="center-align red lighten-2">
				          	<span class="white-text">{{ $errors->first('value') }}</span>
				          </div>
				        @endif
			        </div>			        
				</div>

				<div class="row">
					<div class="input-field col s4">
					  <i class="material-icons prefix">assignment</i>
			          <input id="warranty" name="warranty" type="text" class="validate">
			          <label for="warranty">Garantia</label>

			          	@if($errors->has('warranty'))
				          <div class="center-align red lighten-2">
				          	<span class="white-text">{{ $errors->first('warranty') }}</span>
				          </div>
				        @endif
			        </div>
				</div>
				


				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				
				<br>
				<div class="row">
					<a class="btn red" href="/produtos">Cancelar</a>
					<input type="submit" value="Salvar" class="btn green">
				</div>
			</form>
		</div>
	</div>
@endsection