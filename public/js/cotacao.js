
var ITENS = [];
var TOTAL = 0;

$(function () {
	// getFornecedores(function(data){
	// 	$('input.autocomplete-fornecedor').autocomplete({
	// 		data: data,
	// 		limit: 20, 
	// 		onAutocomplete: function(val) {
	// 			var fornecedor = $('#autocomplete-fornecedor').val().split('-');

	// 		},
	// 		minLength: 1,
	// 	});
	// });


	// getProdutos(function(data){
	// 	$('input.autocomplete-produto').autocomplete({
	// 		data: data,
	// 		limit: 20, 
	// 		onAutocomplete: function(val) {
	// 			console.log(val)
	// 		},
	// 		minLength: 1,
	// 	});
	// });
});


function getFornecedores(data){
	$.ajax
	({
		type: 'GET',
		url: path + 'fornecedores/all',
		dataType: 'json',
		success: function(e){
			data(e)
		}, error: function(e){
			console.log(e)
		}

	});
}

function getFornecedor(id, data){
	$.ajax
	({
		type: 'GET',
		url: path + 'fornecedores/find/'+id,
		dataType: 'json',
		success: function(e){
			data(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

function getProdutos(data){
	$.ajax
	({
		type: 'GET',
		url: path + 'produtos/naoComposto',
		dataType: 'json',
		success: function(e){
			data(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

$('#addProd').click(() => {
	let prod = $('.produto').val().split('-');
	let codigo = prod[0];
	let nome = prod[1];
	let quantidade = $('#quantidade').val();

	if(codigo.length > 0 && nome.length > 0 && quantidade.length > 0 && parseFloat(quantidade.replace(',','.')) ) {

		addItemTable(codigo, nome, quantidade);
	}else{
		swal(
			{
				title: "Erro",
				text: "Informe corretamente os campos para continuar!",
				type: "warning",
			}
		)

	}
});

function addItemTable(codigo, nome, quantidade){
	if(!verificaProdutoIncluso()) {
		TOTAL += parseFloat(quantidade.replace(',','.'));
		console.log(TOTAL)
		ITENS.push({id: (ITENS.length+1), codigo: codigo, nome: nome, 
			quantidade: quantidade})
	// apagar linhas tabela
	$('#body').html("");
	
	let t = montaTabela();

	$('#total_itens').html(ITENS.length)
	$('table #body').html(t)

	$('#quantidade').val('');
}
}

function montaTabela(){
	let t = ""; 

	ITENS.map((v) => {
		t += '<tr class="datatable-row" style="left: 0px;">';
		t += '<td class="datatable-cell"><span style="width: 80px;">' + v.id + '</span></td>';
		t += '<td class="datatable-cell"><span style="width: 150px;">' + v.codigo + '</span></td>';
		t += '<td class="datatable-cell"><span style="width: 550px;">' + v.nome + '</span></td>';
		t += '<td class="datatable-cell"><span style="width: 200px;">' + v.quantidade + '</span></td>';
		t += '<td class="datatable-cell"><span style="width: 200px;">';
		t += '<a href="#prod tbody" onclick="deleteItem('+v.id+')">';
		t += 'remover'
		t += '</a>';
		t += '</span></td>';
		
		// t += "<td>"+v.id+"</td>";
		// t += "<td class='cod'>"+v.codigo+"</td>";
		// t += "<td>"+v.nome+"</td>";
		// t += "<td>"+v.quantidade+"</td>";
		// t += "<td><a href='#prod tbody' onclick='deleteItem("+v.id+")'>"
		// t += "<i class=' material-icons red-text'>delete</i></a></td>";
		t+= '</tr>';
	});
	return t
}

function verificaProdutoIncluso(){
	if(ITENS.length == 0) return false;
	if($('#body tr').length == 0) return false;
	let cod = $('.produto').val().split('-')[0];
	let duplicidade = false;

	ITENS.map((v) => {
		if(v.codigo == cod){
			duplicidade = true;
		}
	})

	let c;
	if(duplicidade) c = !confirm('Produto já adicionado, deseja incluir novamente?');
	else c = false;
	console.log(c)
	return c;
}

function deleteItem(id){
	let temp = [];
	ITENS.map((v) => {
		if(v.id != id){
			temp.push(v)
		}else{
			TOTAL -= (v.quantidade.replace(',','.'));
		}
	});
	ITENS = temp;
	let t = montaTabela(); // para remover
	$('#body').html(t)
	$('#total_itens').html(TOTAL)
}


$('#salvar-cotacao').click(() => {
	valida((msg) => {
		if(msg == ""){
			let fornecedor = $('.fornecedor').val();
			let js = {
				obsevacao: $('#obs').val(),
				referencia: $('#referencia').val(),
				itens: ITENS,
				fornecedor: parseInt(fornecedor),
			}
			let token = $('#_token').val();
			$.ajax
			({
				type: 'POST',
				data: {
					cotacao: js,
					_token: token
				},
				url: path + 'cotacao/salvar',
				dataType: 'json',
				success: function(e){
					console.log(e)
					sucesso();

				}, error: function(e){
					console.log(e)
				}
			});
		}else{
			swal(
				{
					title: "Erro",
					text: msg,
					type: "warning",
				}
			)

		}
	})

})

function valida(call){
	let msg = "";

	let fornecedor = $('.fornecedor').val();
	if(!fornecedor){
		msg = "Informe o Fornecedor";
	}

	if(ITENS.length == 0){
		msg = "Informe os Itens";
	}

	call(msg)
}

function sucesso(){
	$('#content').css('display', 'none');
	$('#anime').css('display', 'block');
	setTimeout(() => {
		location.href = path+'cotacao';
	}, 4000)
}

