
var TOTAL = 0;
var ITENS = [];
var caixaAberto = false;
var PRODUTO = null;
var CLIENTE = null;
var TOTALEMABERTOCLIENTE = null;
var COMANDA = 0;
var VALORBAIRRO = 0;
var VALORACRESCIMO = 0;
var OBSERVACAO = "";
var OBSERVACAOITEM = "";
var DESCONTO = 0;
var LISTAID = 0;
var PDV_VALOR_RECEBIDO = 0;

var VALORPAG1 = 0
var VALORPAG2 = 0
var VALORPAG3 = 0
var TIPOPAG1 = ''
var TIPOPAG2 = ''
var TIPOPAG3 = ''
var PRODUTOS = [];
var CATEGORIAS = [];
var CLIENTES = [];
$(function () {
	var w = window.innerWidth
	if(w < 900){
		$('#grade').trigger('click')
	}
	
	novaHora();
	novaData();
	$('#codBarras').val('')
	PRODUTOS = JSON.parse($('#produtos').val())

	CATEGORIAS = JSON.parse($('#categorias').val())
	CLIENTES = JSON.parse($('#clientes').val())
	let semCertificado = $('#semCertificado').val()
	if(semCertificado){
		swal("Aviso", "Para habilitar o cupom fiscal, realize o upload do certificado digital!!", "warning")
	}

	PDV_VALOR_RECEBIDO = $('#PDV_VALOR_RECEBIDO').val()

	let valor_entrega = $('#valor_entrega').val();

	VALORACRESCIMO = parseFloat(valor_entrega);
	let obs = $('#obs').val();
	if(obs) OBSERVACAO = obs;

	verificaCaixa((v) => {
		console.log(v)
		caixaAberto = v >= 0 ? true : false;
		if(v < 0){
			$('#modal1').modal('show');
		}
	})

	let itensPedido = $('#itens_pedido').val();

	//Verifica se os dados estao vindo da comanda
	//Controller Pedido
	if(itensPedido){
		itensPedido = JSON.parse(itensPedido);

		if($('#bairro').val() != 0){
			console.log($('#bairro').val())
			let bairro = JSON.parse($('#bairro').val());

			VALORBAIRRO = parseFloat(bairro.valor_entrega);
		}
		let cont = 1;
		itensPedido.map((v) => {
			console.log(v)
			let nome = '';
			let valorUnit = 0;
			if(v.sabores && v.sabores.length > 0){

				let cont = 0;
				v.sabores.map((sb) => {
					cont++;
					valorUnit = v.valor;
					nome += sb.produto.produto.nome + 
					(cont == v.sabores.length ? '' : ' | ')
				})
				valorUnit = v.maiorValor

			}else{
				if (typeof v.produto !== 'undefined') {
					nome = v.produto.nome;
					valorUnit = v.produto.valor_venda
				}else{
					nome = v.nome;
					valorUnit = v.valor_venda
				}
			}

			let item = null
			if (typeof v.produto !== 'undefined') {
				item = {
					cont: cont++,
					id: v.produto_id,
					nome: nome,
					quantidade: v.quantidade,
					valor: parseFloat(valorUnit) + parseFloat(v.valorAdicional),
					pizza: v.maiorValor ? true : false,
					itemPedido: v.item_pedido
				}
			}else{
				item = {
					cont: cont++,
					id: v.id,
					nome: nome,
					quantidade: 1,
					valor: parseFloat(valorUnit),
					pizza: false,
					itemPedido: null
				}
			}


			ITENS.push(item)


			TOTAL += parseFloat((item.valor * item.quantidade));

		});
		let t = montaTabela();

		let valor_total = $('#valor_total').val();
		if(valor_total > TOTAL){ 
			TOTAL = valor_total
			VALORACRESCIMO = 0;
		}


		atualizaTotal();
		$('#body').html(t);
		let codigo_comanda = $('#codigo_comanda_hidden').val();

		COMANDA = codigo_comanda;
	}

});

$('#desconto').keyup( () => {
	$('#acrescimo').val('0')
	let desconto = $('#desconto').val();
	// if(!desconto){ $('#desconto').val('0'); desconto = 0}

	if(desconto){
		desconto = parseFloat(desconto.replace(",", "."))
		DESCONTO = 0;
		if(desconto > TOTAL && $('#desconto').val().length > 2){
			// Materialize.toast('ERRO, Valor desconto maior que o valor total', 4000)
			$('#desconto').val("");
		}else{
			DESCONTO = desconto;

			atualizaTotal();
		}
	}
})

function pad(s) {
	return (s < 10) ? '0' + s : s;
}

function categoria(cat){

	desmarcarCategorias(() => {
		$('#cat_' + cat).addClass('ativo')
	})
	
	produtosDaCategoria(cat, (res) => {
		console.log(res)
		montaProdutosPorCategoria(res, (html) => {
			$('#prods').html(html)
		})
	})
}

function desmarcarCategorias(call){
	CATEGORIAS.map((v) => {
		$('#cat_' + v.id).removeClass('ativo')
		$('#cat_' + v.id).removeClass('desativo')
	})
	$('#cat_todos').removeClass('desativo')
	$('#cat_todos').removeClass('ativo')

	call(true)
}

function produtosDaCategoria(cat, call){
	let lista_id = $('#lista_id').val();
	$('#codBarras').focus()
	temp = [];
	if(cat != 'todos'){
		PRODUTOS.map((v) => {
			if(v.categoria_id == cat){
				temp.push(v)
			}
		})
	}else{
		temp = PRODUTOS
	}
	call(temp)
}

function montaProdutosPorCategoria(produtos, call){
	$('#prods').html('')
	let lista_id = $('#lista_id').val();

	let html = '';
	produtos.map((p) => {
		console.log(p)
		html += '<div class="col-sm-12 col-lg-6 col-md-6 col-xl-4" id="atalho_add" '
		html += 'onclick="adicionarProdutoRapido2(\''+ p.id +'\')">'
		html += '<div class="card card-custom gutter-b example example-compact">'
		html += '<div class="card-header" style="height: 180px;">'
		html += '<div class="symbol symbol-circle symbol-lg-100">'
		if(p.imagem == ''){
			html += '<img class="img-prod" src="/imgs/no_image.png">'
		}else{
			html += '<img class="img-prod" src="/imgs_produtos/'+p.imagem+'">'
		}
		html += '</div>'
		html += '<h6 style="font-size: 12px; width: 100%" class="kt-widget__label">'
		html += p.nome + '</h6>'
		html += '<h6 style="font-size: 12px;" class="text-danger" class="kt-widget__label">'
		if(lista_id == 0){
			html += formatReal(p.valor_venda) + '</h6>'
		}else{
			let v = 0;
			p.lista_preco.map((l) => {
				if(lista_id == l.lista_id){
					html += formatReal(l.valor) + '</h6>'

				}
			})
		}

		html += '<h6 style="font-size: 10px; margin-right: -15px;" class="text-info" class="kt-widget__label">';
		html += 'Estoque: '
		html += p.estoque_atual
		html += '</h6>'

		html += '</div></div></div>'
	})

	call(html)
}

function adicionarProdutoRapido(produto){
	console.log(produto)
	console.log(produto.nome)
	produto = JSON.parse(produto)
	PRODUTO = produto
	console.log(produto.valor_venda)
	$('#valor_item').val(produto.valor_venda)
	$('#quantidade').val(1)
	addItem()
}

function adicionarProdutoRapido2(id){
	PRODUTOS.map((p) => {
		if(p.id == id){
			PRODUTO = p
			$('#valor_item').val(p.valor_venda)
			$('#quantidade').val(1)
			addItem()
		}
	})
}

function novaHora() {

	var date = new Date();
	let v = [date.getHours(), date.getMinutes()].map(pad).join(':');
	$('#horas').html(v);
}

function novaData() {
	var date = new Date();
	let v = [date.getDate(), date.getMonth()+1, date.getFullYear()].map(pad).join('/');
	$('#data').html(v);
}

function apontarObs(){
	let obs = $('#obs').val();
	OBSERVACAO = obs;

	$('#modal-obs').modal('hide')
}

function setarObservacaoItem(){
	let obs = $('#obs-item').val();
	OBSERVACAOITEM = obs;

	$('#modal-obs-item').modal('hide')
}

$('#autocomplete-cliente').on('keyup', () => {
	$('#cliente-nao').css('display', 'block');
	CLIENTE = null;
})


function formatReal(v){
	return v.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});;
}

function getProdutos(data){
	$.ajax
	({
		type: 'GET',
		url: path + 'produtos/all',
		dataType: 'json',
		success: function(e){
			data(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

function getClientes(data){
	$.ajax
	({
		type: 'GET',
		url: path + 'clientes/all',
		dataType: 'json',
		success: function(e){
			data(e)
		}, error: function(e){
			console.log(e)
		}

	});
}

function getCliente(id, data){
	$.ajax
	({
		type: 'GET',
		url: path + 'clientes/find/'+id,
		dataType: 'json',
		success: function(e){
			data(e)
		}, error: function(e){
			console.log(e)
		}

	});
}

function getVendasEmAbertoContaCredito(id, data){
	$.ajax
	({
		type: 'GET',
		url: path + 'vendasEmCredito/somaVendas/'+id,
		dataType: 'json',
		success: function(e){
			data(e)
		}, error: function(e){
			console.log(e)
		}

	});
}

$('#codBarras').keyup((v) => {
	let cod = v.target.value

	if(cod.length == 13){
		$('#codBarras').val('')
		getProdutoCodBarras(cod, (data) => {
			if(data){
				setTimeout(() => {
					addItem();

				}, 400)
			}else{
				let id = parseInt(cod.substring(1,5));

				console.log(id)

				$.get(path+'produtos/getProduto/'+id)
				.done((res) => {

					let valor = cod.substring(7,12);

					let temp = valor.substring(0,3) + '.' +valor.substring(3,5);
					valor = parseFloat(temp)
					console.log(valor)

					PRODUTO = JSON.parse(res);

					$('#nome-produto').html(PRODUTO.nome);
					let quantidade = 1;
					if(PRODUTO.unidade_venda == 'KG'){
						let valor_venda = PRODUTO.valor_venda;
						quantidade = valor/valor_venda;
						quantidade = quantidade.toFixed(3);
						valor = valor_venda;
					}
					$('#valor_item').val(valor);
					$('#quantidade').val(quantidade);
					let tamanho2 = ITENS.length;
					if(tamanho2 == tamanho){
						console.log("inserindo");
						$('#adicionar-item').trigger('click');
					}

				})
				.fail((err) => {

					swal("Erro", 'Produto nao encontrado!', "warning").then(() => {
						$('#codBarras').focus()

					})



				})
			}
		})

	}
})

$('#focus-codigo').click(() => {
	$('#codBarras').focus()
})


$('#lista_id').change(() => {
	let lista = $('#lista_id').val();
	categoria('todos')
})

function getProduto(id, data){

	console.log(LISTAID)
	$.ajax
	({
		type: 'GET',
		url: path + 'produtos/getProdutoVenda/' + id + '/' + LISTAID,
		dataType: 'json',
		success: function(e){
			data(e)
		}, error: function(e){
			console.log(e)
		}
	});
}

$('#kt_select2_1').change(() => {
	let id = $('#kt_select2_1').val()
	let lista_id = $('#lista_id').val()
	PRODUTOS.map((p) => {
		if(p.id == id){
			PRODUTO = p
			if(lista_id == 0){
				$('#valor_item').val(p.valor_venda)
			}else{
				p.lista_preco.map((l) => {
					if(lista_id == l.lista_id){
						$('#valor_item').val(l.valor)
					}
				})
			}

			$('#quantidade').val(1)
		}
	})
})

$('#finalizar-venda').click(() => {
	$('#modal-venda').modal('show')
})

function addItem(){
	if(caixaAberto){
		$('#codBarras').focus();
		if(PRODUTO != null && $('#valor_item').val() > 0){
			verificaProdutoIncluso((call) => {

				console.log("cal", call)
				$('#codBarras').val('')
				if(call >= 0){
					let quantidade = $('#quantidade').val() ? $('#quantidade').val() :  '1.00';
					quantidade = quantidade.replace(",", ".");
					let valor = $('#valor_item').val();
					console.log("teste", (parseFloat(quantidade) + parseFloat(call)));

					if(PRODUTO.gerenciar_estoque == 1 && (parseFloat(quantidade) + parseFloat(call)) > PRODUTO.estoque_atual){
						swal("Erro", 'O estoque atual deste produto é de ' + PRODUTO.estoque_atual, "warning")
						$('#quantidade').val('1')

					}else{

						if(quantidade.length > 0 && parseFloat(quantidade.replace(",", ".")) > 0 && valor.length > 0 && parseFloat(valor.replace(",", ".")) > 0 && PRODUTO != null){
							TOTAL += parseFloat(valor.replace(',','.'))*(quantidade.replace(',','.'));

							let item = {
								cont: (ITENS.length+1),
								obs: OBSERVACAOITEM,
								id: PRODUTO.id,
								nome: PRODUTO.nome,
								quantidade: $('#quantidade').val(),
								valor: $('#valor_item').val()
							}

							console.log(item)

							$('#body').html("");
							ITENS.push(item);

							console.log(ITENS)

							limparCamposFormProd();
							atualizaTotal();

							let v = $('#valor_recebido').val();
							v = v.replace(",", ".");

							if(PDV_VALOR_RECEBIDO == 0){
								$('#valor_recebido').val(TOTAL)
								// Materialize.updateTextFields();
							}

							if(ITENS.length > 0 && ((parseFloat(v) >= TOTAL))){
								$('#finalizar-venda').removeClass('disabled');
							}else{
								$('#finalizar-venda').addClass('disabled');
							}

							let t = montaTabela();

							$('#body').html(t);


							PRODUTO = null;
							$('#obs-item').val('');
							OBSERVACAOITEM = "";

						}
					}
				}else{
					swal('Cuidado', 'Informe corretamente para continuar', 'warning')
				}
			});
		}else{
			swal('Cuidado', 'Informe corretamente para continuar', 'warning')
		}
	}else{
		swal("Erro", "Abra o caixa para vender!!", "error")
	}
}

function setaObservacao(){
	$('#modal-obs').modal('show')
}

function setaDesconto(){
	swal({
		title: 'Valor desconto?',
		text: 'Ultiliza ponto(.) ao invés de virgula!',
		content: "input",
		button: {
			text: "Ok",
			closeModal: false,
			type: 'error'
		}
	}).then(v => {
		if(v) {
			DESCONTO = parseFloat(v)
			$('#valor_desconto').html(formatReal(DESCONTO))
			atualizaTotal()
		}
		swal.close()

	});
}

function setaAcresicmo(){
	swal({
		title: 'Valor acrescimo?',
		text: 'Ultiliza ponto(.) ao invés de virgula!',
		content: "input",
		button: {
			text: "Ok",
			closeModal: false,
			type: 'error'
		}
	}).then(v => {
		if(v) {

			let acrescimo = v;
			if(acrescimo > 0){
				DESCONTO = 0;
				$('#valor_desconto').html(formatReal(DESCONTO))
			}

			let total = TOTAL+VALORBAIRRO;

			if(acrescimo.substring(0, 1) == "%"){

				let perc = acrescimo.substring(1, acrescimo.length);

				VALORACRESCIMO = total * (perc/100);


			}else{
				acrescimo = acrescimo.replace(",", ".")
				VALORACRESCIMO = parseFloat(acrescimo)
			}

			if(acrescimo.length == 0) VALORACRESCIMO = 0;
			atualizaTotal();
			VALORACRESCIMO = parseFloat(VALORACRESCIMO)
			$('#valor_acrescimo').html(formatReal(VALORACRESCIMO))

			atualizaTotal()
		}
		swal.close()

	});
}

$('#adicionar-item').click(() => {
	addItem();
})

function atualizaTotal(){

	let valor_recebido = $('#valor_recebido').val();
	if(!valor_recebido) valor_recebido = 0;
	if(valor_recebido > 0){
		valor_recebido = valor_recebido.replace(",", ".");
		valor_recebido = parseFloat(valor_recebido)
	}
	console.log(TOTAL + VALORBAIRRO + VALORACRESCIMO - DESCONTO)
	if((TOTAL + VALORBAIRRO + VALORACRESCIMO - DESCONTO) > valor_recebido){
		$('#finalizar-venda').addClass('disabled')
	}else{
		$('#finalizar-venda').removeClass('disabled')
	}
	console.log(valor_recebido)
	if(!$('#valor_recebido').val()){
		$('#finalizar-venda').addClass('disabled')
	}
	// $('#total-venda').html(formatReal(TOTAL + VALORBAIRRO + VALORACRESCIMO - DESCONTO));
	console.log(VALORACRESCIMO)
	$('#total-venda').html(formatReal(TOTAL + VALORBAIRRO + VALORACRESCIMO - DESCONTO));
}

function montaTabela(){
	let t = ""; 
	let quantidades = 0;


	ITENS.map((v) => {
		console.log(v)

		t += '<tr class="datatable-row" style="left: 0px;">'
		t += '<td class="datatable-cell">'
		t += '<span class="codigo" style="width: 50px;">'
		t += v.cont + '</span>'
		t += '</td>'

		t += '<td class="datatable-cell">'
		t += '<span class="codigo" style="width: 50px;">'
		t += v.id
		t += '</span></td>'

		t += '<td class="datatable-cell">'
		t += '<span class="codigo" style="width: 200px;">'
		t += v.nome + (v.obs ? " [OBS: "+v.obs+"]" : "")
		t += '</span></td>'

		t += '<td class="datatable-cell">'
		t += '<span class="codigo" style="width: 120px;">'
		t += '<div class="form-group mb-2">'
		t += '<div class="input-group">'
		t += '<div class="input-group-prepend">'
		t += '<button onclick="subtraiItem('+v.cont+')" class="btn btn-danger" type="button">-</button>'
		t += '</div>'
		t += '<input type="text" readonly class="form-control" value="'+v.quantidade+'">'
		t += '<div class="input-group-append">'
		t += '<button onclick="incrementaItem('+v.cont+')" class="btn btn-success" type="button">+</button>'
		t += '</div></div></div></span></td>'

		t += '<td class="datatable-cell">'
		t += '<span class="codigo" style="width: 120px;">'
		t += formatReal(v.valor)
		t += '</span></td>'

		t += '<td class="datatable-cell">'
		t += '<span class="codigo" style="width: 120px;">'
		t += formatReal(v.valor*v.quantidade)
		t += '</span></td>'
		t += '</tr>'

		quantidades += parseInt(v.quantidade);
	});

	$('#qtd-itens').html(ITENS.length);
	$('#_qtd').html(quantidades);
	return t
}

function subtraiItem(id){
	let temp = [];
	let soma = 0
	ITENS.map((v) => {
		if(v.cont != id){
			temp.push(v)
			soma += parseFloat(v.valor.replace(',','.'))*(v.quantidade);
		}else{
			if(v.quantidade > 1){
				v.quantidade = parseFloat(v.quantidade) - 1;
				soma += parseFloat(v.valor.replace(',','.')*v.quantidade);
				temp.push(v)
			}
		}
	});
	TOTAL = soma
	ITENS = temp
	let t = montaTabela();
	atualizaTotal();
	$('#body').html(t);
}

$('#click-client').click(() => {
	$('#modal-cliente').modal('show')
})

function selecionarCliente(){
	let cliente = $('#kt_select2_3').val();
	CLIENTES.map((c) => {
		if(c.id == cliente){
			CLIENTE = c
		}
	})
	$('#conta_credito-btn').removeClass('disabled')
	$('#modal-cliente').modal('hide')
}

function incrementaItem(id){
	let temp = [];
	let soma = 0
	console.log(ITENS)
	ITENS.map((v) => {
		if(v.cont != id){
			temp.push(v)
			soma += parseFloat(v.valor.replace(',','.'))*(v.quantidade);
		}else{
			v.quantidade = parseFloat(v.quantidade) + 1;
			soma += parseFloat(v.valor.replace(',','.')*v.quantidade);
			temp.push(v)
		}
	});
	TOTAL = soma
	ITENS = temp
	let t = montaTabela();
	atualizaTotal();
	$('#body').html(t);
}

function limparCamposFormProd(){
	$('#autocomplete-produto').val('');
	$('#quantidade').val('1');
	$('#valor_item').val('0,00');
}

function verificaProdutoIncluso(call){
	let cont = 0;
	ITENS.map((rs) => {
		if(PRODUTO.id == rs.id){
			cont += parseFloat(rs.quantidade);
		}
	})
	call(cont);
}

function getProdutoCodBarras(cod, data){
	let tamanho = ITENS.length;
	console.log(tamanho)
	$.ajax
	({
		type: 'GET',
		url: path + 'produtos/getProdutoCodBarras/'+cod,
		dataType: 'json',
		success: function(e){
			data(e)
			if(e){
				PRODUTO = e;
				$('#nome-produto').html(e.nome);
				$('#valor_item').val(e.valor_venda);
			}else{
				if(cod.length == 13){
					//validar pelo cod balança

					let id = parseInt(cod.substring(1,5));

					console.log(id)

					$.get(path+'produtos/getProduto/'+id)
					.done((res) => {

						let valor = cod.substring(7,12);

						let temp = valor.substring(0,3) + '.' +valor.substring(3,5);
						valor = parseFloat(temp)
						console.log(valor)

						PRODUTO = JSON.parse(res);

						$('#nome-produto').html(PRODUTO.nome);
						let quantidade = 1;
						if(PRODUTO.unidade_venda == 'KG'){
							let valor_venda = PRODUTO.valor_venda;
							quantidade = valor/valor_venda;
							quantidade = quantidade.toFixed(3);
							valor = valor_venda;
						}
						$('#valor_item').val(valor);
						$('#quantidade').val(quantidade);
						let tamanho2 = ITENS.length;
						if(tamanho2 == tamanho){
							console.log("inserindo");
							$('#adicionar-item').trigger('click');
						}

					})
					.fail((err) => {
						// alert('Produto nao encontrado!')
						swal("Erro", 'Produto nao encontrado!', "warning")

						$('#autocomplete-produto').val('')

					})
					
					

				}
			}

		}, error: function(e){
			console.log(e)
		}

	});
}

function verificaCaixa(data){
	$.ajax
	({
		type: 'GET',
		url: path + 'aberturaCaixa/verificaHoje',
		dataType: 'json',
		success: function(e){
			console.log(e)
			data(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

function abrirCaixa(){
	let token = $('#_token').val();
	let valor = $('#valor').val();

	valor = valor.length >= 0 ? valor.replace(",", ".") : 0 ;
	if(parseFloat(valor) >= 0){
		$.ajax
		({
			type: 'POST',
			url: path + 'aberturaCaixa/abrir',
			dataType: 'json',
			data: {
				valor: $('#valor').val(),
				_token: token
			},
			success: function(e){
				caixaAberto = true;
				$('#modal1').modal('hide');
				swal("Sucesso", "Caixa aberto", "success")


			}, error: function(e){
				$('#modal1').modal('hide');
				swal("Erro", "Erro ao abrir caixa", "error")
				console.log(e)
			}

		});
	}else{
		// alert('Insira um valor válido')
		swal("Erro", 'Insira um valor válido', "warning")

	}
	
}

function sangriaCaixa(){
	let token = $('#_token').val();

	$.ajax
	({
		type: 'POST',
		url: path + 'sangriaCaixa/save',
		dataType: 'json',
		data: {
			valor: $('#valor_sangria').val(),
			_token: token
		},
		success: function(e){

			caixaAberto = true;
			$('#modal2').modal('hide');
			$('#valor_sangria').val('');
			swal("Sucesso", "Sangria realizada!", "success")


		}, error: function(e){
			console.log(e)
			swal("Erro", "Erro ao realizar sangria!", "error")

		}

	});
}

function suprimentoCaixa(){
	let token = $('#_token').val();

	$.ajax
	({
		type: 'POST',
		url: path + 'suprimentoCaixa/save',
		dataType: 'json',
		data: {
			valor: $('#valor_suprimento').val(),
			obs: $('#obs_suprimento').val(),
			_token: token
		},
		success: function(e){

			$('#modal-supri').modal('hide');
			$('#valor_suprimento').val('');
			$('#obs_suprimento').val('');
			swal("Sucesso", "suprimento realizado!", "success")

		}, error: function(e){
			console.log(e)
			swal("Erro", "Erro ao realizar suprimento de caixa!", "error")

		}

	});
}

function getSangriaDiaria(data){
	$.ajax
	({
		type: 'GET',
		url: path + 'sangriaCaixa/diaria',
		dataType: 'json',
		success: function(e){
			data(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

function getSuprimentoDiario(data){
	$.ajax
	({
		type: 'GET',
		url: path + 'suprimentoCaixa/diaria',
		dataType: 'json',
		success: function(e){
			data(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

function getAberturaDiaria(data){

	$.ajax
	({
		type: 'GET',
		url: path + 'aberturaCaixa/verificaHoje',
		dataType: 'json',
		success: function(e){
			console.log(e)
			data(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

function getVendaDiaria(data){
	$.ajax
	({
		type: 'GET',
		url: path + 'vendasCaixa/diaria',
		dataType: 'json',
		success: function(e){
			data(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

function fluxoDiario(){
	$('#preloader1').css('display', 'block');
	getSangriaDiaria((sangrias) => {
		getSuprimentoDiario((suprimentos) => {

			let elem = "";
			let totalSangria = 0;
			let totalSuprimento = 0;
			sangrias.map((v) => {

				elem += "<p> Horario: "
				elem += "<strong>" + v.data_registro.substring(10, 16) + "</strong>, Valor: "
				elem += "<strong> R$ " + formatReal(v.valor) + "</strong>, Usuario: "
				elem += "<strong>" + v.nome_usuario + "</strong>"
				elem += "</p>";
				totalSangria += parseFloat(v.valor);
			})

			elem += "<h6>Total: <strong class='text-danger'>" + formatReal(totalSangria) + "</strong></h6>";
			elem += "<hr>"
			$('#fluxo_sangrias').html(elem)
			elem = ""
			suprimentos.map((v) => {

				elem += "<p> Horario: "
				elem += "<strong>" + v.created_at.substring(10, 16) + "</strong>, Valor: "
				elem += "<strong> R$ " + formatReal(v.valor) + "</strong>, Usuario: "
				elem += "<strong class='text-info'>" + v.nome_usuario + "</strong>, Obs: "
				elem += "<strong class='text-info'>" + v.observacao + "</strong>"
				elem += "</p>";
				totalSuprimento += parseFloat(v.valor);
			})
			elem += "<h6>Total: <strong class='text-danger'>" + formatReal(totalSuprimento) + "</strong></h6>";
			elem += "<hr>"
			
			$('#fluxo_suprimentos').html(elem)

			getAberturaDiaria((abertura) => {
				abertura = abertura.replace(",", ".")
				elem = "<p> Valor: ";
				elem += "<strong class='text-danger'>R$ "+formatReal(abertura)+"</strong>";
				elem += "</p>";
				elem += "<hr>"

				$('#fluxo_abertura_caixa').html(elem);
				getVendaDiaria((vendas) => {

					elem = "";
					let totalVendas = 0;
					vendas.map((v) => {
						console.log(v)
						elem += "<p> Horario: "
						elem += "<strong>" + v.data_registro.substring(10, 16) + "</strong>, Valor: "
						elem += "<strong> R$ " + formatReal(parseFloat(v.valor_total) + parseFloat(v.acrescimo) - 
							parseFloat(v.desconto)) + "</strong>, Tipo Pagamento: "
						elem += "<strong>" + v.tipo_pagamento + "</strong>"
						elem += "</p>";
						totalVendas += parseFloat(parseFloat(v.valor_total) + parseFloat(v.acrescimo) - 
							parseFloat(v.desconto));
					})
					elem += "<h6>Total: <strong class='text-primary'>" + formatReal(totalVendas) + "</strong></h6>";
					elem += "<hr>";
					$('#fluxo_vendas').html(elem);
					$('#total_caixa').html(formatReal((totalVendas+parseFloat(abertura)) - totalSangria + totalSuprimento));

					$('#preloader1').css('display', 'none');
				});
			})
		})
	})
	if(caixaAberto){
		$('#modal3').modal('open');
	}else{

		// var $toastContent = $('<span>Por favor abra o caixa!</span>').add($('<button class="btn-flat toast-action">OK</button>'));
		// Materialize.toast($toastContent, 5000);
		swal('Erro', 'Por favor abra o caixa!', 'error')
		.then(() => {
			location.reload();
		})
	}
}

function esconderTodasMoedas(){
	$('.50_reais').css('display', 'none');
	$('.20_reais').css('display', 'none');
	$('.10_reais').css('display', 'none');
	$('.5_reais').css('display', 'none');
	$('.2_reais').css('display', 'none');
	$('.1_real').css('display', 'none');
	$('.50_centavo').css('display', 'none');
	$('.25_centavo').css('display', 'none');
	$('.50_centavo').css('display', 'none');
	$('.5_centavo').css('display', 'none');
}

$('#valor_recebido').on('keyup', (event) => {
	esconderTodasMoedas();
	let t = TOTAL;
	let v = $('#valor_recebido').val();
	v = v.replace(",", ".");

	let troco = v - TOTAL;
	if(troco > 0){

		$('#valor-troco').html(formatReal(troco))
	}else{
		$('#valor-troco').html('R$ 0,00')

	}
	if(ITENS.length > 0 && (parseFloat(v) >= (TOTAL + VALORBAIRRO + VALORACRESCIMO - DESCONTO))){
		$('#finalizar-venda').removeClass('disabled');
	}else{
		$('#finalizar-venda').addClass('disabled');
	}

	console.log(TOTAL)

	if(v.length > 0 && parseFloat(v) > TOTAL && TOTAL > 0){
		v = parseFloat(v);

		if (event.keyCode === 13) {

			let troco = v - (t - DESCONTO + VALORACRESCIMO);
			$("#valor_troco").html(formatReal(troco))
			$('#modal4').modal('show');

			let resto = troco;
			notas = [];

			if(parseInt(troco / 50) > 0 && resto > 0){

				resto = troco % 50;
				$('#qtd_50_reais').html(' X'+1);
				$('.50_reais').css('display', 'block');

			}
			if(parseInt(resto / 20) > 0){
				numeroNotas = parseInt(resto/20);
				$('#qtd_20_reais').html(' X'+numeroNotas);
				resto = resto%(20*numeroNotas);
				$('.20_reais').css('display', 'block');

			}
			if(parseInt(resto / 10) > 0){
				numeroNotas = parseInt(resto/10);
				$('#qtd_10_reais').html(' X'+numeroNotas);
				resto = resto%(10*numeroNotas);
				$('.10_reais').css('display', 'block');

			}
			if(parseInt(resto / 5) > 0){
				numeroNotas = parseInt(resto/5);
				$('#qtd_5_reais').html(' X'+numeroNotas);
				resto = duasCasas(resto%(5*numeroNotas));
				$('.5_reais').css('display', 'block');

			}
			if(parseInt(resto / 2) > 0){
				numeroNotas = parseInt(resto/2);
				$('#qtd_2_reais').html(' X'+numeroNotas);
				resto = duasCasas(resto%(2*numeroNotas));
				$('.2_reais').css('display', 'block');

			}

			if(parseInt(resto / 1) > 0){
				numeroNotas = parseInt(resto/1);
				$('#qtd_1_real').html(' X'+numeroNotas);
				resto = duasCasas(resto%(1*numeroNotas));
				$('.1_real').css('display', 'block');

			}

			if(parseInt(resto / 0.5) > 0){
				numeroNotas = parseInt(resto/0.5);
				$('#qtd_50_centavos').html(' X'+numeroNotas);
				resto = duasCasas(resto%(0.5*numeroNotas));
				$('.50_centavo').css('display', 'block');

			}

			if(parseInt(resto / 0.25) > 0){
				numeroNotas = parseInt(resto/0.25);
				$('#qtd_25_centavos').html(' X'+numeroNotas);
				resto = duasCasas(resto%(0.25*numeroNotas));
				$('.25_centavo').css('display', 'block');

			}

			if(parseInt(resto / 0.10) > 0){
				numeroNotas = parseInt(resto/0.10);
				$('#qtd_10_centavos').html(' X'+numeroNotas);
				resto = duasCasas(resto%(0.10*numeroNotas));
				$('.10_centavo').css('display', 'block');

			}


			if(parseInt(resto / 0.05) > 0){
				numeroNotas = parseInt(resto/0.05);
				$('#qtd_5_centavos').html(' X'+numeroNotas);
				resto = resto%(0.05*numeroNotas);
				$('.5_centavo').css('display', 'block');

			}

		}
	}
})

function duasCasas(valor){
	return parseFloat(valor.toFixed(2));
}

$('#autocomplete-produto').on('keyup', () => {
	let val = $('#autocomplete-produto').val();
	if($.isNumeric(val) && val.length > 6){
		getProdutoCodBarras(val, (data) => {
			setTimeout(() => {
				addItem();
				
			}, 400)
		})
	}
})

function verificaCliente(){

	if(CLIENTE == null){
		$('#modal-venda').modal('hide');
		$('#modal-cpf-nota').modal('show');
	} 
	else{ 
		finalizarVenda('fiscal')
	}
}

function validaCpf(){

	if(CLIENTE != null) return true;

	let strCPF = $('#cpf').val();
	let nome = $('#nome').val();
	if(strCPF.length == 0) return true;

	// if(nome == '' || nome == null || nome.length == 0) return false;
	
	strCPF = strCPF.replace(".", "");
	strCPF = strCPF.replace(".", "");
	strCPF = strCPF.replace("-", "");
	var Soma;
	var Resto;
	Soma = 0;
	if (strCPF == "00000000000") return false;

	for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
		Resto = (Soma * 10) % 11;

	if ((Resto == 10) || (Resto == 11))  Resto = 0;
	if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;;

	Soma = 0;
	for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
		Resto = (Soma * 10) % 11;

	if ((Resto == 10) || (Resto == 11))  Resto = 0;
	if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;;
	
	return true;
}

$('#tipo-pagamento').change(() => {
	$('#valor_recebido').val('');

	let tipo = $('#tipo-pagamento').val();

	if(tipo == '01'){
		$('#valor_recebido').removeAttr('disabled');
		$('#finalizar-venda').addClass('disabled');

	}else{
		$('#valor_recebido').attr('disabled', 'true');
		$('#finalizar-venda').removeClass('disabled');

	}
})

function finalizarVenda(acao) {

	let validCpf = validaCpf();
	if(validCpf == true || acao != 'fiscal'){

		let valorRecebido = $('#valor_recebido').val();
		let troco = 0;
		if(valorRecebido.length > 0 && parseFloat(valorRecebido) > (TOTAL + VALORACRESCIMO + VALORBAIRRO - DESCONTO)){
			troco = parseFloat(valorRecebido) - (TOTAL + VALORACRESCIMO + VALORBAIRRO - DESCONTO);
		}

		let desconto = DESCONTO;

		let obs = $('#obs').val();

		let js = { 
			itens: ITENS,
			cliente: CLIENTE != null ? CLIENTE.id : null,
			valor_total: TOTAL,
			acrescimo: VALORBAIRRO + VALORACRESCIMO,
			troco: troco,
			tipo_pagamento: $('#tipo-pagamento').val(),
			forma_pagamento: '',
			dinheiro_recebido: valorRecebido ? valorRecebido : TOTAL,
			acao: acao,
			nome: $('#nome').val(),
			cpf: $('#cpf').val(),
			delivery_id: $('#delivery_id').val(),
			pedido_local: $('#pedidoLocal').val() ? true : false,
			codigo_comanda: COMANDA,
			desconto: desconto ? desconto : 0,
			observacao: obs,
			tipo_pagamento_1: TIPOPAG1,
			tipo_pagamento_2: TIPOPAG2,
			tipo_pagamento_3: TIPOPAG3,
			valor_pagamento_1: VALORPAG1,
			valor_pagamento_2: VALORPAG2,
			valor_pagamento_3: VALORPAG3,
			agendamento_id: $('#agendamento_id').val()
		}

		console.log(js)
		let token = $('#_token').val();

		if(acao != 'credito'){
			$('#btn_nao_fiscal').addClass('disabled')
			$.ajax
			({
				type: 'POST',
				url: path + 'vendasCaixa/save',
				dataType: 'json',
				data: {
					venda: js,
					_token: token
				},
				success: function(e){
					if(acao == 'fiscal'){
						$('#preloader2').css('display', 'block');
						$('#preloader9').css('display', 'block');
						emitirNFCe(e.id);	
					} else{
						swal({
							title: "Sucesso",
							text: "Deseja imprimir comprovante?",
							icon: "success",
							buttons: ["Não", 'Imprimir'],
							dangerMode: true,
						})
						.then((v) => {
							if (v) {
								window.open(path + 'nfce/imprimirNaoFiscal/'+e.id, '_blank');
								location.href=path+'frenteCaixa';
							} else {
								location.href=path+'frenteCaixa';
							}
						});
						
					}

				}, error: function(e){
					console.log(e)
					$('#preloader2').css('display', 'none');
					$('#preloader9').css('display', 'none');
					$('#modal-venda').modal('hide')
				}

			});
		}else{
			// let valorUltrapassadoConfirma = true;
			// if(CLIENTE.limite_venda < TOTALEMABERTOCLIENTE+TOTAL){
			// 	valorUltrapassadoConfirma = confirm("Valor do limite de conta crédito ultrapassado, confirma venda?!");
			// }
			if(CLIENTE == null){
				swal("Alerta", "Informe um cliente para conta crédito", "warning")
			}else{
				if(CLIENTE.limite_venda < TOTALEMABERTOCLIENTE+TOTAL){
					swal({
						text: "Valor do limite de conta crédito ultrapassado, confirma a venda?!",
						title: 'Cuidado',
						icon: 'warning',
						buttons: ["Não", "Vender"],
					}).then(sim => {
						if (sim) {
							salvarCredito(js, token)
						}else{
							$('#preloader2').css('display', 'none');
							$('#preloader9').css('display', 'none');
							$('#modal-venda').modal('hide')
						}
					});

				}else{
					salvarCredito(js, token)
				}
			}
			
		}
	}else{
		// Materialize.toast('CPF Inválido!', 5000);
		swal('Erro', 'CPF Inválido!', 'error')
	}

}

function salvarCredito(js, token){
	$.ajax
	({
		type: 'POST',
		url: path + 'vendas/salvarCrediario',
		dataType: 'json',
		data: {
			venda: js,
			_token: token
		},
		success: function(e){
			$('#modal-venda').modal('hide')

			window.open(path + 'nfce/imprimirNaoFiscalCredito/'+e.id, '_blank');
			// $('#modal-credito').modal('open');
			// $('#evento-conta-credito').html('Venda salva na conta crédito do cliente ' +
			// 	CLIENTE.razao_social)
			swal("Sucesso", "Venda salva na conta crédito do cliente " + CLIENTE.razao_social, "success")
			.then(() => {
				location.reload()
			})

		}, error: function(e){
			console.log(e)
			$('#preloader2').css('display', 'none');
			$('#preloader9').css('display', 'none');
			$('#modal-venda').modal('hide')
		}

	});
}

function emitirNFCe(vendaId){
	// $('#modal-venda').modal('close')
	// $('#preloader_'+vendaId).css('display', 'inline-block');
	$('#btn-cpf').addClass('spinner')
	$('#btn-cpf').addClass('disabled')
	$('#btn_envia_'+vendaId).addClass('spinner')
	$('#btn_envia_'+vendaId).addClass('disabled')
	$('#btn_envia_grid_'+vendaId).addClass('spinner')
	$('#btn_envia_grid_'+vendaId).addClass('disabled')

	let token = $('#_token').val();
	$.ajax
	({
		type: 'POST',
		url: path + 'nfce/gerar',
		dataType: 'json',
		data: {
			vendaId: vendaId,
			_token: token
		},
		success: function(e){
			$('#modal-cpf-nota').modal('hide')
			// $('#preloader_'+vendaId).css('display', 'none');
			$('#btn-cpf').removeClass('spinner')
			$('#btn-cpf').removeClass('disabled')
			$('#btn_envia_'+vendaId).removeClass('spinner')
			$('#btn_envia_'+vendaId).removeClass('disabled')
			$('#btn_envia_grid_'+vendaId).removeClass('spinner')
			$('#btn_envia_grid_'+vendaId).removeClass('disabled')


			let recibo = e;
			let retorno = recibo.substring(0,4);
			let mensagem = recibo.substring(5,recibo.length);
			if(retorno == 'Erro'){
				try{
					let m = JSON.parse(mensagem);
					// $('#modal-alert-erro').modal('open');
					// $('#evento-erro').html("[" + m.protNFe.infProt.cStat + "] : " + m.protNFe.infProt.xMotivo)
					swal("Algo deu errado!", "[" + m.protNFe.infProt.cStat + "] : " + m.protNFe.infProt.xMotivo, "error")
					.then(() => {
						location.reload()
					})
				}catch(e){
					// $('#modal-alert-erro').modal('open');
					// $('#evento-erro').html(e)
					swal("Algo deu errado!", e, "error").then(() => {
						location.reload()
					})
				}


			}
			else if(retorno == 'erro'){
				// $('#modal-alert-erro').modal('show');
				// $('#evento-erro').html("WebService sefaz em manutenção, falha de comunicação SOAP")
				swal("Algo deu errado!", "WebService sefaz em manutenção, falha de comunicação SOAP", "error").then(() => {
					location.reload()
				})


			}
			else if(e == 'Apro'){
				swal("Cuidado", "Esta NF já esta aprovada, não é possível enviar novamente!", "warning").then(() => {
					location.reload()
				})
				// var $toastContent = $('<span>Esta NF já esta aprovada, não é possível enviar novamente!</span>').add($('<button class="btn-flat toast-action">OK</button>'));
				// Materialize.toast($toastContent, 5000);
			}
			else{
				$('#modal-venda').modal('hide')
				swal("Sucesso", "NFCe gerada com sucesso RECIBO: " +recibo, "success")
				.then(() => {
					window.open(path + 'nfce/imprimir/'+vendaId, '_blank');
					location.reload()
				})
				// $('#evento').html("NFCe gerada com sucesso RECIBO: " +recibo)
				
			}
			$('#btn_envia_'+vendaId).removeClass('spinner')
			$('#btn_envia_grid_'+vendaId).removeClass('spinner')
			// $('#preloader2').css('display', 'none');
			// $('#preloader9').css('display', 'none');
			// $('#preloader1').css('display', 'none');
		}, error: function(err){
			console.log(err)
			// $('#preloader_'+vendaId).css('display', 'none');
			$('#btn-cpf').removeClass('spinner')
			$('#btn-cpf').removeClass('disabled')
			$('#btn_envia_'+vendaId).removeClass('spinner')
			$('#btn_envia_'+vendaId).removeClass('disabled')
			$('#btn_envia_grid_'+vendaId).removeClass('spinner')
			$('#btn_envia_grid_'+vendaId).removeClass('disabled')


			// deletarVenda(vendaId)
			swal("Algo errado", "Erro ao enviar NFC-e", "error").then(() => {
				location.reload()
			})
			// var $toastContent = $('<span>Erro ao enviar NFC-e</span>').add($('<button class="btn-flat toast-action">OK</button>'));
			// Materialize.toast($toastContent, 5000);
			// $('#preloader2').css('display', 'none');
			// $('#preloader9').css('display', 'none');

			let js = err.responseJSON;
			console.log(js)
			if(js.message){
				swal("Algo errado", js.message, "error")

			}else{
				let err = "";
				js.map((v) => {
					err += v + "\n";
				});
				// alert(err);
				swal("Erro", err, "warning")

			}
			$('#btn-cpf').removeClass('spinner')
			

			// $('#preloader1').css('display', 'none');
			
		}
	})

}

function deletarVenda(id){
	$.get(path + 'nfce/deleteVenda/'+id)
	.done((data) => {
		console.log(data)
	})
	.fail((err) => {
		console.log(err)
	})
	
}

function redireciona(){
	location.href=path+'frenteCaixa';
}

function modalCancelar(id){
	$('#modal').modal('show');
	$('#venda_id').val(id)
}


function cancelar(){

	$('#btn_cancelar_nfce').addClass('spinner');

	let justificativa = $('#justificativa').val();
	let id = $('#venda_id').val();
	let token = $('#_token').val();
	$.ajax
	({
		type: 'POST',
		data: {
			id: id,
			justificativa: justificativa,
			_token: token
		},
		url: path + 'nfce/cancelar',
		dataType: 'json',
		success: function(e){
			$('#btn_cancelar_nfce').removeClass('spinner');
			
			// alert(e.retEvento.infEvento.xMotivo)
			swal("Sucesso", e.retEvento.infEvento.xMotivo, "success")
			.then((v) => {
				location.reload()
			})

		}, error: function(e){
			$('#btn_cancelar_nfce').removeClass('spinner');

			console.log(e)
			let js = e.responseJSON;
			if(e.status == 404){
				// alert(js.mensagem)
				swal("Erro", js.mensagem, "warning")

			}else{
				// alert(js.retEvento.infEvento.xMotivo)
				swal("Erro", js.retEvento.infEvento.xMotivo, "warning")

				// Materialize.toast('Erro de comunicação contate o desenvolvedor', 5000)
				
			}
		}
	});
}

function verItens(){
	$('#modal-itens').modal('open');
	let t = montaTabela();
	$('#body-modal').html(t);

}

function modalWhatsApp(){
	$('#modal-whatsApp').modal('show')
}

function enviarWhatsApp(){
	let celular = $('#celular').val();
	let texto = $('#texto').val();

	let mensagem = texto.split(" ").join("%20");

	let celularEnvia = '55'+celular.replace(' ', '');
	celularEnvia = celularEnvia.replace('-', '');
	let api = 'https://api.whatsapp.com/send?phone='+celularEnvia
	+'&text='+mensagem;
	window.open(api)
}

function apontarComanda(){
	let cod = $('#cod-comanda').val()
	$.get(path+'pedidos/itensParaFrenteCaixa', {cod: cod})
	.done((success) => {
		montarComanda(success, (rs) => {
			if(rs){
				COMANDA = cod;
				$('#modal-comanda').modal('hide')
				swal("", "Comanda setada!!!", "success")


			}
		})
	})
	.fail((err) => {
		if(err.status == 401){
			swal("", "Nada encontrado!!!", "error")
		}
		console.log(err)
	})
}

function montarComanda(itens, call){
	let cont = 0;
	itens.map((v) => {
		let nome = '';
		let valorUnit = 0;
		if(v.sabores.length > 0){

			let cont = 0;
			v.sabores.map((sb) => {
				cont++;
				valorUnit = v.maiorValor;
				nome += sb.produto.produto.nome + 
				(cont == v.sabores.length ? '' : ' | ')
			})


		}else{
			nome = v.produto.nome;
			valorUnit = v.produto.valor_venda
		}

		let item = {
			cont: cont+1,
			id: v.produto_id,
			nome: nome,
			quantidade: v.quantidade,
			valor: parseFloat(valorUnit) + parseFloat(v.valorAdicional),
			pizza: v.maiorValor ? true : false,
			itemPedido: v.item_pedido
		}

		ITENS.push(item)
		TOTAL += parseFloat(item.valor)*(item.quantidade);
	});
	let t = montaTabela();

	atualizaTotal();
	$('#body').html(t);
	call(true)
}

$('#acrescimo').keyup(() => {
	let acrescimo = $('#acrescimo').val();
	if(acrescimo > 0) $('#desconto').val('0')

		let total = TOTAL+VALORBAIRRO;
	
	if(acrescimo.substring(0, 1) == "%"){

		let perc = acrescimo.substring(1, acrescimo.length);

		VALORACRESCIMO = total * (perc/100);


	}else{
		acrescimo = acrescimo.replace(",", ".")
		VALORACRESCIMO = parseFloat(acrescimo)
	}

	if(acrescimo.length == 0) VALORACRESCIMO = 0;
	atualizaTotal();


})

function consultarNFCe(id){
	$('#btn_consulta_' + id).addClass('spinner')
	$('#btn_consulta_grid_' + id).addClass('spinner')
	$.get(path + 'nfce/consultar/'+id)
	.done((data) => {
		$('#btn_consulta_' + id).removeClass('spinner')
		$('#btn_consulta_grid_' + id).removeClass('spinner')

		console.log(data)
		let js = JSON.parse(data)
		console.log(js)
		swal("Consulta", "[" + js.protNFe.infProt.cStat + "] " + js.protNFe.infProt.xMotivo ,"success");
	})
	.fail((err) => {
		$('#btn_consulta_' + id).removeClass('spinner')
		$('#btn_consulta_grid_' + id).removeClass('spinner')
		console.log(err)
	})
}

$('#btn-plus').click((target) => {
	let quantidade = parseInt($('#quantidade').val());
	$('#quantidade').val(quantidade+1)
})

$('#click-multi').click(() => {
	$('#modal-pag-mult').modal('show')
	$('#v-multi').html(formatReal(TOTAL))

	if(TOTAL <= 0){
		swal("Erro", "Valor da venda deve ser maior que Zero!!", "error")
		.then(() => {
			$('#modal-pag-mult').modal('hide')
		})
	}
	$('#total-multi').html(formatReal(TOTAL))
})

$('#btn-ok-multi').click(() => {

	VALORPAG1 = $('#valor_pagamento_1').val() ? parseFloat($('#valor_pagamento_1').val()) : 0;
	VALORPAG2 = $('#valor_pagamento_2').val() ? parseFloat($('#valor_pagamento_2').val()) : 0;
	VALORPAG3 = $('#valor_pagamento_3').val() ? parseFloat($('#valor_pagamento_3').val()) : 0;

	TIPOPAG1 = $('#tipo_pagamento_1').val()
	TIPOPAG2 = $('#tipo_pagamento_2').val()
	TIPOPAG3 = $('#tipo_pagamento_3').val()

	$('#modal-pag-mult').modal('hide')
	console.log(VALORPAG1, VALORPAG2, VALORPAG3)
	console.log(TIPOPAG1, TIPOPAG2, TIPOPAG3)
	$('#modal-venda').modal('show')
})

$('#valor_pagamento_1').keyup((target) => {
	somaMultiplo();
})
$('#valor_pagamento_2').keyup((target) => {
	somaMultiplo();
})
$('#valor_pagamento_3').keyup((target) => {
	somaMultiplo();
})

function somaMultiplo(){
	let v1 = $('#valor_pagamento_1').val() ? parseFloat($('#valor_pagamento_1').val()) : 0;
	let v2 = $('#valor_pagamento_2').val() ? parseFloat($('#valor_pagamento_2').val()) : 0;
	let v3 = $('#valor_pagamento_3').val() ? parseFloat($('#valor_pagamento_3').val()) : 0;

	let soma = v1 + v2 + v3;
	if(soma == TOTAL){
		$('#btn-ok-multi').removeAttr('disabled')
	}else if(soma > TOTAL){
		// swal("Alerta", "Valor de pagamentos ultrapassou o valor da venda", "warning")
		$('#btn-ok-multi').attr('disabled')
	}else{
		$('#btn-ok-multi').attr('disabled')
	}
}

$('#close-multi').click(() => {
	$('#modal-pag-mult').modal('hide')
	VALORPAG1 = 0
	VALORPAG2 = 0
	VALORPAG3 = 0
	TIPOPAG1 = ''
	TIPOPAG2 = ''
	TIPOPAG3 = ''
})
//modal-venda



