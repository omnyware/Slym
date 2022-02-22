@extends('default.layout')
@section('content')
<style type="text/css">
	.btn{
		margin-left: 5px;
	}
</style>
<div class="card card-custom gutter-b">
	<div class="card-body">
		<h5>Para emissão do MDF-e é necessario ter cadastrado:</h5>
		<h5>* Emitente fiscal com certificado digital</h5>
		<h5>* Veiculo cadastrado</h5>
		<h5>* Natureza de operação cadastrado</h5>
		<h5>* Cliente destinatário cadastrado</h5>

		<div class="row">
			

			@if(count($veiculos) == 0)
			<a href="/veiculos" class="btn btn-danger">ir para veiculos</a>
			@endif

			@if($config == null)
			<a href="/configNF" class="btn btn-danger">ir para emitente fiscal</a>
			@endif

			@if($clienteCadastrado == null)
			<a href="/clientes" class="btn btn-danger">ir para clientes</a>
			@endif
		</div>
	</div>
</div>
@endsection	