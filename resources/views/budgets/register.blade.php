@extends('default.layout')
@section('content')
	<div class="row">
		<div class="col s12">
			<h4>Gerar Novo Orçamento</h4>
			<form method="post" action="/orcamento/save">
				
				<div class="row">
					<div class="col s12">
				        <div class="input-field col s6">
				          <i class="material-icons prefix">person</i>
				          <input autocomplete="off" type="text" name="client" id="autocomplete-cliente" class="autocomplete-cliente">
				          <label for="autocomplete-cliente">Cliente</label>

				          @if(session()->has('message_error_client'))
					          <div class="center-align red lighten-2">
					          	<span class="white-text">{{ session()->get('message_error_client') }}</span>
					          </div>
				          @endif
				        </div>
				    </div>
			    </div>

			    <div class="row">
					<div class="input-field col s6">
					  <i class="material-icons prefix">text_format</i>
			          <textarea class="materialize-textarea validate" id="description" name="description">
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
					<h5 class="center-align">ITENS DO ORÇAMENTO</h5>
					<br>
					<div class="col s6">
						<h6 class="center-align">PRODUTOS</h6>

						<br>

						<div class="row">
							<div class="col s12">
						        <div class="input-field col s10">
						          <i class="material-icons prefix">shopping_cart</i>
						          <input autocomplete="off" type="text" id="autocomplete-produto" class="autocomplete-produto">
						          <label for="autocomplete-produto">Produto</label>
						        </div>
						    </div>
					    </div>
					    <div class="row">
					    	<div class="input-field col s4">
					    		<i class="material-icons prefix">plus_one</i>
						        <input type="number" id="quantidade-produto" value="1">
						        <label for="quantidade-produto">Quantidade</label>
					    	</div>
					    	<div class="input-field col s4">
					    		<i class="material-icons prefix">attach_money</i>
						        <input type="number" id="valor-produto" value="1">
						        <label for="valor-produto">valor</label>
					    	</div>

					    	<div class="input-field col s4">
					    		<a id="adicionar-produto" class="btn black">
					    			Adicionar
					    		</a>
					    	</div>
					    </div>
					    <input type="hidden" id="data-produtos" name="products">

						<table>
							<thead class="blue">
								<tr>
									<th>Produto</th>
									<th>Quantidade</th>
									<th>valor</th>
									<th>Subtotal</th>
								</tr>
							</thead>
							<tbody id="tbody-produto">

							</tbody>
						</table>
					</div>
					<!-- SEGUNDA COLUNA -->
					<div class="col s6">
						<h6 class="center-align">SERVIÇOS</h6>
						<br>

						<div class="row">
							<div class="col s12">
						        <div class="input-field col s10">
						          <i class="material-icons prefix">build</i>
						          <input autocomplete="off" type="text" id="autocomplete-servico" class="autocomplete-servico">
						          <label for="autocomplete-servico">Serviço</label>
						        </div>
						    </div>
					    </div>
					    <div class="row">
					    	<div class="input-field col s4">
					    		<i class="material-icons prefix">plus_one</i>
						        <input type="number" id="quantidade-servico" value="1">
						        <label for="quantidade-servico">Quantidade</label>
					    	</div>
					    	<div class="input-field col s4">
					    		<i class="material-icons prefix">attach_money</i>
						        <input type="number" id="valor-servico" value="1">
						        <label for="valor-servico">valor</label>
					    	</div>

					    	<div class="input-field col s4">
					    		<a id="adicionar-servico" class="btn black">
					    			Adicionar
					    		</a>
					    	</div>
					    </div>

					    <input type="hidden" id="data-servicos" name="services">

						<table>
							<thead class="green">
								<tr>
									<th>Serviço</th>
									<th>Quantidade</th>
									<th>valor</th>
									<th>Subtotal</th>
								</tr>
							</thead>
							<tbody id="tbody-servico">

							</tbody>
						</table>
					</div>
					
				</div>
				@if(session()->has('message_error_itens'))
					<div class="center-align red lighten-2">
					    <span class="white-text">{{session()->get('message_error_itens')}}</span>
					</div>
				@endif
				<br>
				<div class="row">
					<div class="input-field col s3">

						<i class="material-icons prefix">attach_money</i>
				          <input readonly id="value" name="value" value="0" type="text" class="validate">
				          <label for="value">Valor Total Serviços e Produtos</label>
			          	@if($errors->has('value'))
				          <div class="center-align red lighten-2">
				          	<span class="white-text">{{ $errors->first('value') }}</span>
				          </div>
				        @endif
			        </div><br>
			        
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