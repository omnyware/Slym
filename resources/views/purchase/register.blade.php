@extends('default.layout')
@section('content')
	<div class="row">
		<div class="col s12">
			<h4>Nova Compra</h4>
			<form method="post" action="/compras/save">
				
				<div class="row">
					<div class="col s12">
				        <div class="input-field col s6">
				          <i class="material-icons prefix">person</i>
				          <input autocomplete="off" type="text" name="provider" id="autocomplete-fornecedor" class="autocomplete-fornecedor">
				          <label for="autocomplete-fornecedor">Fornecedor</label>

				          @if(session()->has('message_error_provider'))
					          <div class="center-align red lighten-2">
					          	<span class="white-text">{{ session()->get('message_error_provider') }}</span>
					          </div>
				          @endif
				        </div>
				    </div>
			    </div>

			    <div class="card blue lighten-4">
			    	<div class="row">
						<div class="col s12">
					        <div class="input-field col s5">
					          <i class="material-icons prefix">shopping_cart</i>
					          <input autocomplete="off" type="text" name="client" id="autocomplete-produto" class="autocomplete-produto">
					          <label for="autocomplete-produto">Produto</label>
					   
					        </div>

					        <div class="input-field col s2">
								<i class="material-icons prefix">attach_money</i>
						          <input id="valor" name="valor" value="0" type="text" class="validate">
						          <label for="valor">Valor Unitário</label>
					          	
					        </div>

					        <div class="input-field col s2">
								<i class="material-icons prefix">filter_1</i>
						          <input id="quantidade" name="quantidade" value="1" type="text" class="validate">
						          <label for="quantidade">Quantidade</label>
					          	
					        </div>
					        <div class="input-field col s2">
					        	<a class="btn" id="adicionar">
					        		<i class="material-icons left">playlist_add</i>
					        		Adicionar
					        	</a>
					        </div>
					    </div>
				    </div>
				    <input type="hidden" name="products" id="data-produtos">
				    <div class="row">
				    	<div class="vol s12">
					    	<table class="striped">
					    		<thead>
					    			<tr>
					    				<th>PRODUTO</th>
					    				<th>QUANTIDADE</th>
					    				<th>VALOR</th>
					    				<th>SUBTOTAL</th>
					    				<th>ACAO</th>
					    			</tr>
					    		</thead>

					    		<tbody id="tbody-produto">
					    		</tbody>
					    	</table>
					    </div>
				    </div>
			    </div>

			    @if(session()->has('message_error_product'))
					<div class="center-align red lighten-2">
					     <span class="white-text">{{ session()->get('message_error_product') }}</span>
					</div>
				@endif
				<br>
			    
				<div class="row">
					<div class="input-field col s3">

						<i class="material-icons prefix">attach_money</i>
				          <input readonly id="value" name="value" value="0" type="text" class="validate">
				          <label for="value">Valor Total da Compra</label>
			        </div>

					<div class="input-field col s3">

						<i class="material-icons prefix">money_off</i>
				          <input id="discount" name="discount" value="0" type="text" class="validate">
				          <label for="discount">Desconto</label>
			        </div><br>
				</div>

				<div class="row">
					<div class="input-field col s6">
						<i class="material-icons prefix">text_format</i>
			          <textarea class="materialize-textarea validate" id="note" name="note">
			          	{{old('note')}}
			          </textarea>
			          <label for="note">Observação</label>
			        </div>
				</div>

				<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

				
				<br>
				<div class="row">
					<a class="btn red" href="/budget">Cancelar</a>
					<input type="submit" value="Salvar" class="btn green">
				</div>
			</form>
		</div>
	</div>
@endsection