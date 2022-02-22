@extends('default.layout')
@section('content')

<style type="text/css">
	.btn{
		margin-left: 5px;
	}
</style>
<div class="card card-custom gutter-b">

	<div class="card-body">
		<h5>Para gerar uma venda é necessario ter cadastrado:</h5>
		<h4>* Emitente fiscal com certificado digital</h4>
		<h4>* Natureza de operação cadastrado</h4>
		<h4>* Categorias</h4>
		<h4>* Produtos</h4>
		<h4>* Tributção</h4>

		<div class="row">
			@if(count($naturezas) == 0)
			<a href="/naturezaOperacao" class="btn btn-danger">ir para naturezas de operação</a>
			@endif

			@if($clientes == 0)
			<a href="/clientes" class="btn btn-danger">ir para clientes</a>
			@endif

			@if($config == null)
			<a href="/configNF" class="btn btn-danger">ir para emitente fiscal</a>
			@endif

			@if($tributacao == null)
			<a href="/tributos" class="btn btn-danger">ir para tributação</a>
			@endif

			@if($categorias == 0)
			<a href="/categorias" class="btn btn-danger">ir para categorias</a>
			@endif

			@if($produtos == 0)
			<a href="/produtos" class="btn btn-danger">ir para produtos</a>
			@endif

			
		</div>
	</div>
</div>
@endsection	