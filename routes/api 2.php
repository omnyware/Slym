<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'appUser'],function(){
	Route::post('/signup', 'AppUserController@signup');
	Route::post('/login', 'AppUserController@login');
	Route::post('/novoEndereco', 'AppUserController@novoEndereco')->middleware('token');
	Route::get('/testeConn', 'AppUserController@testeConn');
	Route::get('/enderecos', 'AppUserController@enderecos')->middleware('token');

	Route::post('/saveToken', 'AppUserController@saveToken');
	Route::post('/atualizaToken', 'AppUserController@atualizaToken');
	Route::post('/appComToken', 'AppUserController@appComToken');
	Route::post('/refreshToken', 'AppUserController@refreshToken');
	Route::post('/validaToken', 'AppUserController@validaToken');
	Route::post('/validaCupom', 'AppUserController@validaCupom')->middleware('token');
	Route::post('/redefinirSenha', 'AppUserController@redefinirSenha');
	
});

Route::group(['prefix' => 'appProduto'],function(){
	Route::get('/categorias/{usuario_id}', 'AppProdutoController@categorias');
	Route::get('/destaques/{usuario_id}', 'AppProdutoController@destaques');
	Route::get('/adicionais/{produto_id}', 'AppProdutoController@adicionais');

	Route::get('/pesquisaProduto', 'AppProdutoController@pesquisaProduto');
	
	Route::post('/favorito', 'AppProdutoController@favorito')->middleware('token');
	Route::post('/enviaProduto', 'AppProdutoController@enviaProduto')->middleware('token');

	Route::get('/tamanhosPizza', 'AppProdutoController@tamanhosPizza');
	Route::post('/pizzaValorPorTamanho', 'AppProdutoController@pizzaValorPorTamanho');
	Route::post('/saboresPorTamanho', 'AppProdutoController@saboresPorTamanho');
	Route::get('/dividePizza', 'ProdutoRestController@dividePizza');

});

Route::group(['prefix' => 'appCarrinho'],function(){
	Route::get('/index', 'AppCarrinhoController@index')->middleware('token');
	Route::get('/historico', 'AppCarrinhoController@historico')->middleware('token');
	Route::get('/itensCarrinho', 'AppCarrinhoController@itensCarrinho')->middleware('token');
	Route::post('/pedirNovamente', 'AppCarrinhoController@pedirNovamente')->middleware('token');
	Route::post('/removeItem', 'AppCarrinhoController@removeItem')->middleware('token');
	Route::get('/validaPedidoEmAberto', 'AppCarrinhoController@validaPedidoEmAberto')
	->middleware('token');
	Route::get('/valorEntrega', 'AppCarrinhoController@valorEntrega');
	Route::post('/finalizar', 'AppCarrinhoController@finalizar')->middleware('token');
	Route::get('/config', 'AppCarrinhoController@config');
	Route::post('/cancelar', 'AppCarrinhoController@cancelar')->middleware('token');
	Route::get('/funcionamento', 'AppCarrinhoController@funcionamento');

	Route::get('/getBairros', 'AppCarrinhoController@getBairros');
	Route::get('/getValorBairro/{id}', 'AppCarrinhoController@getValorBairro');
	

});

// App Gargom
Route::group(['prefix' => 'pedidoProduto'],function(){
	Route::get('/maisPedidos', 'ProdutoRestController@maisPedidos');
	Route::get('/adicionais', 'ProdutoRestController@adicionais');
	Route::get('/tamanhosPizza', 'ProdutoRestController@tamanhosPizza');
	Route::get('/saboresPorTamanho', 'ProdutoRestController@saboresPorTamanho');
	Route::get('/pizzaValorPorTamanho', 'ProdutoRestController@pizzaValorPorTamanho');
	Route::get('/pesquisaRest', 'ProdutoRestController@pesquisa');
	Route::get('/dividePizza', 'ProdutoRestController@dividePizza');

});

Route::group(['prefix' => 'pedidos'],function(){
	Route::get('/comandasAberta', 'PedidoRestController@comandasAberta');
	Route::get('/mesas', 'PedidoRestController@mesas');
	Route::get('/mesasTodas', 'PedidoRestController@mesasTodas');
	Route::get('/abrirComanda', 'PedidoRestController@abrirComanda');
	Route::get('/addProduto', 'PedidoRestController@addProduto');
	Route::get('/deleteItem', 'PedidoRestController@deleteItem');
	Route::get('/emAberto', 'PedidoRestController@emAberto');

});

//pagseguro

Route::group(['prefix' => '/pagseguro'], function(){
	Route::get('/getSessao', 'PagSeguroController@getSessao');
	Route::get('/getFuncionamento', 'PagSeguroController@getFuncionamento');
	Route::post('/cartoes', 'PagSeguroController@cartoes')->middleware('token');
	
	Route::post('/efetuaPagamento', 'PagSeguroController@efetuaPagamentoApp');
	Route::get('/consultaJS', 'PagSeguroController@consultaJS');
});

//fim pagseguro

Route::group(['prefix' => 'appFiscal'],function(){

	Route::group(['prefix' => 'clientes'],function(){
		Route::get('/', 'AppFiscal\\ClienteController@clientes')->middleware('authApp');
		Route::post('/salvar', 'AppFiscal\\ClienteController@salvar');
		Route::post('/delete', 'AppFiscal\\ClienteController@delete');
	});

	Route::group(['prefix' => 'fornecedores'],function(){
		Route::get('/', 'AppFiscal\\FornecedorController@fornecedores')->middleware('authApp');
		Route::post('/salvar', 'AppFiscal\\FornecedorController@salvar');
		Route::post('/delete', 'AppFiscal\\FornecedorController@delete');
	});

	Route::group(['prefix' => 'usuario'],function(){
		Route::post('/', 'AppFiscal\\UsuarioController@index');
		Route::post('/salvarImagem', 'AppFiscal\\UsuarioController@salvarImagem');
	});

	Route::group(['prefix' => 'configEmitente'],function(){
		Route::get('/', 'AppFiscal\\ConfigEmitenteController@index')->middleware('authApp');
		Route::get('/dadosCertificado', 'AppFiscal\\ConfigEmitenteController@dadosCertificado')->middleware('authApp');
		Route::post('/salvar', 'AppFiscal\\ConfigEmitenteController@salvar');
		Route::post('/salvarCertificado', 'AppFiscal\\ConfigEmitenteController@salvarCertificado');
	});

	Route::get('/cidades', 'AppFiscal\\ClienteController@cidades')->middleware('authApp');
	Route::get('/ufs', 'AppFiscal\\ClienteController@ufs')->middleware('authApp');

	Route::group(['prefix' => 'categorias'],function(){
		Route::get('/', 'AppFiscal\\CategoriaController@all')->middleware('authApp');
		Route::get('/isDelivery', 'AppFiscal\\CategoriaController@isDelivery')->middleware('authApp');
		Route::post('/salvar', 'AppFiscal\\CategoriaController@salvar');
		Route::post('/delete', 'AppFiscal\\CategoriaController@delete');
	});

	Route::group(['prefix' => 'produtos'],function(){
		Route::get('/', 'AppFiscal\\ProdutoController@all')->middleware('authApp');
		Route::post('/salvar', 'AppFiscal\\ProdutoController@salvar');
		Route::post('/delete', 'AppFiscal\\ProdutoController@delete');
		Route::get('/dadosParaCadastro', 'AppFiscal\\ProdutoController@dadosParaCadastro')->middleware('authApp');
		Route::get('/tributosPadrao', 'AppFiscal\\ProdutoController@tributosPadrao')->middleware('authApp');
		Route::post('/salvarImagem', 'AppFiscal\\ProdutoController@salvarImagem');
		
	});

	Route::group(['prefix' => 'naturezas'],function(){
		Route::get('/', 'AppFiscal\\NaturezaController@index')->middleware('authApp');
	});

	Route::group(['prefix' => 'transportadoras'],function(){
		Route::get('/', 'AppFiscal\\TransportadoraController@index')->middleware('authApp');
	});

	Route::group(['prefix' => 'vendas'],function(){
		Route::get('/', 'AppFiscal\\VendaController@index')->middleware('authApp');
		Route::get('/find/{id}', 'AppFiscal\\VendaController@getVenda')->middleware('authApp');
		Route::post('/filtroVendas', 'AppFiscal\\VendaController@filtroVendas');
		Route::get('/tiposDePagamento', 'AppFiscal\\VendaController@tiposDePagamento')->middleware('authApp');
		Route::get('/listaDePrecos', 'AppFiscal\\VendaController@listaDePrecos')->middleware('authApp');
		Route::post('/salvar', 'AppFiscal\\VendaController@salvar');
		Route::post('/salvarOrcamento', 'AppFiscal\\VendaController@salvarOrcamento');
		Route::post('/delete', 'AppFiscal\\VendaController@delete');
		Route::get('/renderizarDanfe/{id}', 'AppFiscal\\VendaController@renderizarDanfe')->middleware('authApp');
		Route::get('/renderizarXml/{id}', 'AppFiscal\\VendaController@renderizarXml')->middleware('authApp');
		Route::get('/ambiente', 'AppFiscal\\VendaController@ambiente')->middleware('authApp');
	});

	Route::group(['prefix' => 'notaFiscal'],function(){
		Route::post('/transmitir', 'AppFiscal\\NotaFiscalAppController@transmitir');
		Route::post('/cancelar', 'AppFiscal\\NotaFiscalAppController@cancelar');
		Route::post('/corrigir', 'AppFiscal\\NotaFiscalAppController@corrigir');
		Route::post('/consultar', 'AppFiscal\\NotaFiscalAppController@consultar');
		Route::get('/imprimir/{id}', 'AppFiscal\\NotaFiscalAppController@imprimir')->middleware('authApp');
		Route::get('/imprimirCorrecao/{id}', 'AppFiscal\\NotaFiscalAppController@imprimirCorrecao')->middleware('authApp');
		Route::get('/imprimirCancelada/{id}', 'AppFiscal\\NotaFiscalAppController@imprimirCancelada')->middleware('authApp');
		Route::get('/getXml/{id}', 'AppFiscal\\NotaFiscalAppController@getXml')->middleware('authApp');
		Route::get('/renderizarDanfe/{id}', 'AppFiscal\\NotaFiscalAppController@renderizarDanfe');

	});

	Route::group(['prefix' => 'vendasCaixa'],function(){
		Route::get('/', 'AppFiscal\\VendaCaixaController@index')->middleware('authApp');
		Route::post('/salvar', 'AppFiscal\\VendaCaixaController@salvar');
		Route::get('/find/{id}', 'AppFiscal\\VendaCaixaController@getVenda')->middleware('authApp');
		Route::get('/renderizarDanfe/{id}', 'AppFiscal\\VendaCaixaController@renderizarDanfe')->middleware('authApp');
		Route::get('/ambiente', 'AppFiscal\\VendaCaixaController@ambiente')->middleware('authApp');
		Route::post('/filtroVendas', 'AppFiscal\\VendaCaixaController@filtroVendas');
		Route::post('/delete', 'AppFiscal\\VendaCaixaController@delete');
		Route::get('/cupomNaoFiscal/{id}', 'AppFiscal\\VendaCaixaController@cupomNaoFiscal')->middleware('authApp');

	});

	Route::group(['prefix' => 'nfce'],function(){
		Route::post('/transmitir', 'AppFiscal\\NfceAppController@transmitir');
		Route::get('/imprimir/{id}', 'AppFiscal\\NfceAppController@imprimir')->middleware('authApp');
		Route::post('/cancelar', 'AppFiscal\\NfceAppController@cancelar');
		Route::post('/consultar', 'AppFiscal\\NfceAppController@consultar');
		Route::get('/imprimir/{id}', 'AppFiscal\\NfceAppController@imprimir')->middleware('authApp');
		Route::get('/getXml/{id}', 'AppFiscal\\NfceAppController@getXml')->middleware('authApp');

	});

	Route::group(['prefix' => 'dfe'],function(){
		Route::get('/', 'AppFiscal\\DFeController@index')->middleware('authApp');
		Route::post('/manifestar', 'AppFiscal\\DFeController@manifestar');
		Route::get('/novosDocumentos', 'AppFiscal\\DFeController@novosDocumentos')->middleware('authApp');
		Route::post('/filtroManifestos', 'AppFiscal\\DFeController@filtroManifestos');
		Route::get('/renderizarDanfe/{id}', 'AppFiscal\\DFeController@renderizarDanfe')->middleware('authApp');
		Route::get('/find/{id}', 'AppFiscal\\DFeController@find')->middleware('authApp');
	});

	Route::group(['prefix' => 'home'],function(){
		Route::get('/dadosGrafico', 'AppFiscal\\HomeController@dadosGrafico')->middleware('authApp');
	});

});






