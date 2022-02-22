@extends('default.layout')
@section('content')
<div class="card card-custom gutter-b">

	<div class="card-body">
		<div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
			<h4>Atualizar Preço</h4>

			<h5>Produto: <strong class="text-danger">{{$produto->produto->nome}}</strong></h5>

			<form method="post" action="/listaDePrecos/salvarPreco">
				<input type="hidden" name="id" value="{{$produto->id}}">
				@csrf
				<div class="row">
					<div class="form-group validated col-sm-3 col-lg-3">
						<label class="col-form-label">Valor</label>
						<div class="">
							<input type="text" id="novo_valor" class="form-control @if($errors->has('novo_valor')) is-invalid @endif money" name="novo_valor" value="{{{ isset($produto->valor) ? $produto->valor : old('novo_valor') }}}">
							@if($errors->has('novo_valor'))
							<div class="invalid-feedback">
								{{ $errors->first('novo_valor') }}
							</div>
							@endif
						</div>
					</div>
				</div>

				<div class="row">
					<a class="btn btn-light-danger" href="/listaDePrecos">Cancelar</a>
					<input style="margin-left: 5px;" type="submit" value="Salvar" class="btn btn-light-success">
				</div>
			</form>
		</div>
	</div>
</div>

@endsection