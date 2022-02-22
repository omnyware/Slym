

var ITENS = [];
var FATURA = [];
var TOTAL = 0;

$(function () {
	getFornecedores(function (data) {
		// $('input.autocomplete-fornecedor').autocomplete({
		// 	data: data,
		// 	limit: 20, 
		// 	onAutocomplete: function(val) {
		// 		var fornecedor = $('#autocomplete-fornecedor').val().split('-');
		// 		getFornecedor(fornecedor[0], (d) => {
		// 			console.log(d)
		// 			habilitaBtnSalarVenda();
		// 			$('#fornecedor').css('display', 'block');
		// 			$('#razao_social').html(d.razao_social)
		// 			$('#nome_fantasia').html(d.nome_fantasia)
		// 			$('#logradouro').html(d.rua)
		// 			$('#numero').html(d.numero)

		// 			$('#cnpj').html(d.cpf_cnpj)
		// 			$('#ie').html(d.ie_rg)
		// 			$('#fone').html(d.telefone)
		// 			$('#cidade').html(d.nome_cidade)

		// 		})
		// 	},
		// 	minLength: 1,
		// });
	});


	getProdutos(function (data) {
		// $('input.autocomplete-produto').autocomplete({
		// 	data: data,
		// 	limit: 20, 
		// 	onAutocomplete: function(val) {
		// 		$('#preloader1').css('display', 'block');
		// 		var prod = $('#autocomplete-produto').val().split('-');
		// 		console.log(prod)
		// 		getProduto(prod[0], (d) => {
		// 			console.log(d)
		// 			$('#valor').val(d.valor_venda)
		// 			$('#quantidade').val('1,000')
		// 			$('#preloader1').css('display', 'none');

		// 			getLastPurchase(d.id, (res) => {

		// 				if(res != 'null'){
		// 					let js = JSON.parse(res);
		// 					console.log(js)

		// 					$('#last-purchase').css('display', 'block')
		// 					$('#last-valor').html(js.valor)
		// 					$('#last-fornecedor').html(js.fornecedor)
		// 					$('#last-data').html(js.data)
		// 					$('#last-quantidade').html(js.quantidade)


		// 					$('#valor').val(js.valor)
		// 					calcSubtotal();
		// 				}
		// 			})
		// 			calcSubtotal();

		// 		})
		// 	},
		// 	minLength: 1,
		// });
	});
});

$('.fornecedor').change(() => {
	let fornecedor = $('.fornecedor').val()

	if (fornecedor != '--') {
		getFornecedor(fornecedor, (d) => {
			console.log(d)
			habilitaBtnSalarVenda();
			$('#fornecedor').css('display', 'block');
			$('#razao_social').html(d.razao_social)
			$('#nome_fantasia').html(d.nome_fantasia)
			$('#logradouro').html(d.rua)
			$('#numero').html(d.numero)

			$('#cnpj').html(d.cpf_cnpj)
			$('#ie').html(d.ie_rg)
			$('#fone').html(d.telefone)
			$('#cidade').html(d.nome_cidade)

		})
	}
})

function getLastPurchase(produto_id, call) {
	$('#preloader-last-purchase').css('display', 'block')
	$.get(path + 'compraManual/ultimaCompra/' + produto_id)
		.done((success) => {
			call(success)
			$('#preloader-last-purchase').css('display', 'none')
		})
		.fail((err) => {
			call(err)
			$('#preloader-last-purchase').css('display', 'none')
		})
}


function getFornecedores(data) {
	$.ajax
		({
			type: 'GET',
			url: path + 'fornecedores/all',
			dataType: 'json',
			success: function (e) {
				data(e)
			}, error: function (e) {
				console.log(e)
			}

		});
}

function getFornecedor(id, data) {
	$.ajax
		({
			type: 'GET',
			url: path + 'fornecedores/find/' + id,
			dataType: 'json',
			success: function (e) {
				data(e)

			}, error: function (e) {
				console.log(e)
			}

		});
}

function getProdutos(data) {
	$.ajax
		({
			type: 'GET',
			url: path + 'produtos/naoComposto',
			dataType: 'json',
			success: function (e) {
				data(e)

			}, error: function (e) {
				console.log(e)
			}

		});
}

function getProduto(id, data) {
	console.log(id)
	$.ajax
		({
			type: 'GET',
			url: path + 'produtos/getProduto/' + id,
			dataType: 'json',
			success: function (e) {
				data(e)

			}, error: function (e) {
				console.log(e)
			}

		});
}

function habilitaBtnSalarVenda() {
	var fornecedor = $('.fornecedor').val().split('-');
	if (ITENS.length > 0 && FATURA.length > 0 && TOTAL > 0 && parseInt(fornecedor[0]) > 0) {
		$('#salvar-venda').removeClass('disabled')
	}
}

$('#valor').on('keyup', () => {
	calcSubtotal()
})

function calcSubtotal() {
	let quantidade = $('#quantidade').val();
	let valor = $('#valor').val();
	let subtotal = parseFloat(valor.replace(',', '.')) * (quantidade.replace(',', '.'));
	let sub = maskMoney(subtotal)
	$('#subtotal').val(sub)
}

function maskMoney(v) {
	return v.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

$('#autocomplete-produto').on('keyup', () => {
	$('#last-purchase').css('display', 'none')
})

$('#addProd').click(() => {
	$('#last-purchase').css('display', 'none')
	let prod = $('.produto').val().split('-');
	let codigo = prod[0];
	let nome = prod[1];
	let quantidade = $('#quantidade').val();
	let valor = $('#valor').val();
	

	console.log(parseFloat(valor.replace(',', '.')))
	if (codigo.length > 0 && nome.length > 0 && quantidade.length > 0
		&& parseFloat(quantidade.replace(',', '.')) &&
		valor.length > 0 && parseFloat(valor.replace(',', '.')) > 0) {
		if (valor.length > 6) valor = valor.replace(".", "");
		valor = valor.replace(",", ".");

		addItemTable(codigo, nome, quantidade, valor);
	} else {
		swal(
			{
				title: "Erro",
				text: "Informe corretamente os campos para continuar!",
				type: "warning",
			}
		)

	}
});

function addItemTable(codigo, nome, quantidade, valor) {
	if (!verificaProdutoIncluso()) {
		limparDadosFatura();
		TOTAL += parseFloat(valor.replace(',', '.')) * parseFloat(quantidade.replace(',', '.'));
		console.log(TOTAL)
		ITENS.push({
			id: (ITENS.length + 1), codigo: codigo, nome: nome,
			quantidade: quantidade, valor: valor
		})
		// apagar linhas tabela
		$('.prod tbody').html("");


		atualizaTotal();
		limparCamposFormProd();
		let t = montaTabela();
		$('.prod tbody').html(t)
	}
}

function verificaProdutoIncluso() {
	if (ITENS.length == 0) return false;
	if ($('#prod tbody tr').length == 0) return false;
	let cod = $('#autocomplete-produto').val().split('-')[0];
	let duplicidade = false;

	ITENS.map((v) => {
		if (v.codigo == cod) {
			duplicidade = true;
		}
	})

	let c;
	if (duplicidade) c = !confirm('Produto já adicionado, deseja incluir novamente?');
	else c = false;
	console.log(c)
	return c;
}

function limparCamposFormProd() {
	$('#autocomplete-produto').val('');
	$('#quantidade').val('0');
	$('#valor').val('0');
}

function limparDadosFatura() {
	$('#fatura tbody').html('')
	$(".data-input").val("");
	$("#valor_parcela").val("");
	$('#add-pag').removeClass("disabled");
	FATURA = [];

}

function atualizaTotal() {

	$('#total').html(formatReal(TOTAL));
}

function formatReal(v) {
	return v.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });;
}

function montaTabela() {
	let t = "";
	ITENS.map((v) => {
		t += "<tr class='datatable-row' style='left: 0px;'>";
		t += "<td class='datatable-cell'><span class='' style='width: 60px;'>" + v.id + "</span></td>";
		t += "<td class='datatable-cell cod'><span class='codigo' style='width: 60px;'>" + v.codigo + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 120px;'>" + v.nome + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + v.valor + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + v.quantidade + "</span></td>";
		t += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + formatReal(v.valor.replace(',', '.') * v.quantidade.replace(',', '.')) + "</span></td>";
		t += "<td class='datatable-cell'><span class='svg-icon svg-icon-danger' style='width: 80px;'><a class='btn btn-danger' href='#prod tbody' onclick='deleteItem(" + v.id + ")'>"
		t += "<i class='la la-trash'></i></a></span></td>";
		t += "</tr>";
	});
	return t
}

function deleteItem(id) {
	let temp = [];
	ITENS.map((v) => {
		if (v.id != id) {
			temp.push(v)
		} else {
			TOTAL -= parseFloat(v.valor.replace(',', '.')) * (v.quantidade.replace(',', '.'));
		}
	});
	ITENS = temp;
	let t = montaTabela(); // para remover
	$('.prod tbody').html(t)
	atualizaTotal();
}

$('#formaPagamento').change(() => {

	limparDadosFatura();
	let now = new Date();
	let data = (now.getDate() < 10 ? "0" + now.getDate() : now.getDate()) +
		"/" + ((now.getMonth() + 1) < 10 ? "0" + (now.getMonth() + 1) : (now.getMonth() + 1)) +
		"/" + now.getFullYear();

	var date = new Date(new Date().setDate(new Date().getDate() + 30));
	let data30 = (date.getDate() < 10 ? "0" + date.getDate() : date.getDate()) +
		"/" + ((date.getMonth() + 1) < 10 ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1)) +
		"/" + date.getFullYear();

	$("#qtdParcelas").attr("disabled", true);
	$(".data-input").attr("disabled", true);
	$("#valor_parcela").attr("disabled", true);
	$("#qtdParcelas").val('1');

	if ($('#formaPagamento').val() == 'a_vista') {
		$("#qtdParcelas").val(1)
		$('#valor_parcela').val(formatReal(TOTAL));
		$('.data-input').val(data);
	} else if ($('#formaPagamento').val() == '30_dias') {
		$("#qtdParcelas").val(1)
		$('#valor_parcela').val(formatReal(TOTAL));
		$('.data-input').val(data30);
	} else if ($('#formaPagamento').val() == 'personalizado') {
		$("#qtdParcelas").removeAttr("disabled");
		$(".data-input").removeAttr("disabled");
		$("#valor_parcela").removeAttr("disabled");
		$(".data-input").val("");
		$("#valor_parcela").val(formatReal(TOTAL));
	}
})

$('#qtdParcelas').on('keyup', () => {
	limparDadosFatura();

	if ($("#qtdParcelas").val()) {
		let qtd = $("#qtdParcelas").val();
		console.log(TOTAL)
		$('#valor_parcela').val(formatReal(TOTAL / qtd));
	}
})

$('#add-pag').click(() => {

	if (!verificaValorMaiorQueTotal()) {
		let data = $('.data-input').val();
		let valor = $('#valor_parcela').val();
		let cifrao = valor.substring(0, 2);
		if (cifrao == 'R$') valor = valor.substring(3, valor.length)
		if (data.length > 0 && valor.length > 0 && parseFloat(valor.replace(',', '.')) > 0) {
			addpagamento(data, valor);
		} else {
			swal(
				{
					title: "Erro",
					text: "Informe corretamente os campos para continuar!",
					type: "warning",
				}
			)

		}
	}
})

function verificaValorMaiorQueTotal(data) {
	let retorno;
	let valorParcela = $('#valor_parcela').val();
	let qtdParcelas = $('#qtdParcelas').val();

	if (valorParcela <= 0) {

		retorno = true;


		swal(
			{
				title: "Erro",
				text: "Valor deve ser maior que 0",
				type: "warning",
			}
		)
	}

	else if (valorParcela > TOTAL) {

		swal(
			{
				title: "Erro",
				text: "Valor da parcela maior que o total da venda!",
				type: "warning",
			}
		)
		retorno = true;
	}

	else if (qtdParcelas > 1) {
		somaParcelas((v) => {
			console.log(FATURA.length, parseInt(qtdParcelas))

			if (v + parseFloat(valorParcela) > TOTAL) {

				swal(
					{
						title: "Erro",
						text: "Valor ultrapassaou o total!",
						type: "warning",
					}
				)
				retorno = true;
			}
			else if (v + parseFloat(valorParcela) == TOTAL && (FATURA.length + 1) < parseInt(qtdParcelas)) {

				swal(
					{
						title: "Erro",
						text: "Respeite a quantidade de parcelas pré definido!",
						type: "warning",
					}
				)
				retorno = true;

			}
			else if (v + parseFloat(valorParcela) < TOTAL && (FATURA.length + 1) == parseInt(qtdParcelas)) {

				swal(
					{
						title: "Erro",
						text: "Somátoria incorreta!",
						type: "warning",
					}
				)
				let dif = TOTAL - v;
				$('#valor_parcela').val(formatReal(dif))
				retorno = true;

			}
			else {
				retorno = false;

			}
		})
	}
	else {
		retorno = false;
	}

	return retorno;
}

function somaParcelas(call) {
	let soma = 0;
	FATURA.map((v) => {
		console.log(v.valor)
		// if(v.valor.length > 6){
		// 	v = v.valor.replace('.','');
		// 	v = v.replace(',','.');
		// 	soma += parseFloat(v);

		// }else{
		// 	soma += parseFloat(v.valor.replace(',','.'));
		// }
		soma += parseFloat(v.valor.replace(',', '.'));

	})
	call(soma)
}

function addpagamento(data, valor) {
	let result = verificaProdutoIncluso();
	if (!result) {
		FATURA.push({ data: data, valor: valor, numero: (FATURA.length + 1) })

		$('.fatura tbody').html(""); // apagar linhas da tabela
		let t = "";
		FATURA.map((v) => {
			t += "<tr class='datatable-row' style='left: 0px;'>";
			t += "<td class='datatable-cell'><span class='numero' style='width: 160px;'>" + v.numero + "</span></td>";
			t += "<td class='datatable-cell'><span class='' style='width: 160px;'>" + v.data + "</span></td>";
			t += "<td class='datatable-cell'><span class='' style='width: 160px;'>" + v.valor.replace(',', '.') + "</span></td>";
			t += "</tr>";
		});

		$('.fatura tbody').html(t)
		verificaValor();
	}
	habilitaBtnSalarVenda();
}

function verificaValor() {
	let soma = 0;
	FATURA.map((v) => {
		soma += parseFloat(v.valor.replace(',', '.'));
	})
	if (soma >= TOTAL) {
		$('#add-pag').addClass("disabled");
	}
}


function salvarCompra() {

	$('#preloader2').css('display', 'block');

	var fornecedor = $('.fornecedor').val();
	if (fornecedor == '--') {
		swal(
			{
				title: "Erro",
				text: "Selecione um fornecedor para continuar!",
				type: "warning",
			}
		)
	} else {
		let js = {
			fornecedor: fornecedor,
			formaPagamento: $('#formaPagamento').val(),
			itens: ITENS,
			fatura: FATURA,
			total: TOTAL,
			desconto: $('#desconto').val(),
			observacao: $('#obs').val()
		}

		let token = $('#_token').val();
		console.log(js)
		$.ajax
			({
				type: 'POST',
				data: {
					compra: js,
					_token: token
				},
				url: path + 'compraManual/salvar',
				dataType: 'json',
				success: function (e) {
					$('#preloader2').css('display', 'none');
					sucesso(e)

				}, error: function (e) {
					console.log(e)
					$('#preloader2').css('display', 'none');
				}
			});
	}
}

function sucesso() {
	$('#content').css('display', 'none');
	$('#anime').css('display', 'block');
	setTimeout(() => {
		location.href = path + 'compras';
	}, 4000)
}

