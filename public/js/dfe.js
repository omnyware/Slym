var array = [];

var codigo = "";
var nome = "";
var ncm = "";
var cfop = "";
var unidade = "";
var valor = "";
var valorCompra = "";
var quantidade = "";
var codBarras = "";
var nNf = 0;
var semRegitro;

$(function () {
	let uri = window.location.pathname;
	if(uri.split('/')[2] == 'novaConsulta'){
		filtrar();
	}else {

		array = JSON.parse($('#docs').val());
	}
});

$('#tipo_evento').change(() => {
	let tipo = $('#tipo_evento').val();
	if(tipo == 3 || tipo == 4){
		$('#div-just').css('display', 'block')
	}else{
		$('#div-just').css('display', 'none')
	}
})

function filtrar(){
	$.get(path + 'dfe/getDocumentosNovos')
	.done(value => {
		console.log(value)
		$('#preloader1').css('display', 'none')
		$('#aguarde').css('display', 'none')

		if(value.length > 0){
			montaTabela(value, (html) => {
				console.log(html)
				$('table tbody').html(html)
				$('#table').css('display', 'block')
			})
			swal("Sucesso", "Foram encontrados " + value.length + " novos registros!", "success")
		}else{
			swal("Sucesso", "A requisição obteve sucesso, porém sem novos registros!!", "success")
			$('#sem-resultado').css('display', 'block')

		}

	})
	.fail(err => {
		console.log(err)
		$('#preloader1').css('display', 'none')
		$('#aguarde').css('display', 'none')
		swal("Erro", "Erro ao realizar consulta", "warning")
	})
}

function montaTabela(array, call){
	let html = '';
	array.map(v => {
		console.log(v)
		html += '<tr class="datatable-row">';
		html += '<td class="datatable-cell"><span class="codigo" style="width: 300px;" id="id">'
		+ v.nome[0] + '</span></td>'
		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		+ v.documento[0] + '</span></td>'
		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		+ v.valor[0] + '</span></td>'
		html += '<td class="datatable-cell"><span class="codigo" style="width: 200px;" id="id">'
		+ v.chave[0] + '</span></td>'
		html += '</tr>';
	})

	call(html)
}

function setarEvento(chave){
	console.log(array)
	array.map((element) => {
		if(element.chave == chave){
			console.log(element)
			$('#nome').val(element.nome)
			$('#cnpj').val(element.documento)
			$('#valor').val(element.valor)
			$('#data_emissao').val(element.data_emissao)
			$('#num_prot').val(element.num_prot)
			$('#chave').val(element.chave)
		}

	})

}

function _construct(codigo, nome, codBarras, ncm, cfop, unidade, valor, quantidade, valorCompra, nNf){
	this.codigo = codigo;
	this.nome = nome;
	this.codBarras = codBarras.substring(0, 13);
	this.ncm = ncm;
	this.cfop = cfop;
	this.unidade = unidade;
	this.valor = valor;
	this.quantidade = quantidade;
	this.valorCompra = valorCompra;
	this.nNf = nNf;
}

function cadProd(codigo, nome, codBarras, ncm, cfop, unidade, valor, quantidade, valorCompra, nNf){
	_construct(codigo, nome, codBarras, ncm, cfop, unidade, valor, quantidade, valorCompra, nNf);

	$('#nome').val(nome);
	$("#nome").focus();
	getUnidadeMedida((data) => {

		let achouUnidade = false;
		data.map((v) => {
			if(v == unidade){
				achouUnidade = true;
			}
		})

		if(!achouUnidade){
			swal('', "Unidade de compra deste produto não corresponde a nenhuma pré-determinada\n"+
				"Unidade: " + unidade, 'warning')
			.then(s => {


				if(unidade == 'M3C'){
					unidade = 'M3';
					swal('', 'M3C alterado para ' + unidade, 'warning')

				}
				else if(unidade == 'M2C'){
					unidade = 'M2';
					swal('', 'M2C alterado para ' + unidade, 'warning')

				}
				else if(unidade == 'MC'){
					unidade = 'M';
					swal('', 'MC alterado para ' + unidade, 'warning')
				}
				else if(unidade == 'UN'){
					unidade = 'UNID';
					swal('', 'UN alterado para ' + unidade, 'warning')

				}else{
					unidade = 'UNID';
					swal('', 'UN alterado para ' + unidade, 'warning')

				}
			})
		}

		$('#ncm').val(ncm);
		$("#ncm").trigger("click");

		$('#cfop').val(cfop);
		console.log(unidade)

		$('#un_compra').val(unidade);
		$('#unidade_venda option[value="'+unidade+'"]').prop("selected", true);

		$('#valor').val(valor);

		$('#quantidade').val(quantidade);
		$('#conv_estoque').val('1');
		$('#valor_venda').val('0');
		$("#quantidade").trigger("click");

		$('#modal1').modal('show');
	})

}

function getUnidadeMedida(call){

	$.ajax
	({
		type: 'GET',
		url: path + 'produtos/getUnidadesMedida',
		dataType: 'json',
		success: function(e){
			console.log(e)
			call(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

$('#salvar').click(() => {
	$('#preloader').css('display', 'block');
	$("#th_"+this.codigo).removeClass("red-text");
	$("#th_"+this.codigo).html($('#nome').val());
	let valorVenda = $('#valor_venda').val();
	let valorCompra = $('#valor').val();
	let unidadeVenda = $('#unidade_venda').val();
	let conversaoEstoque =$('#conv_estoque').val();
	let categoria_id =$('#categoria_id').val();
	let cor = $('#cor').val();

	let CST_CSOSN =$('#CST_CSOSN').val();
	let CST_PIS =$('#CST_PIS').val();
	let CST_COFINS =$('#CST_COFINS').val();
	let CST_IPI =$('#CST_IPI').val();
	let cfop = $('#cfop').val();

	let prod = {
		valorVenda: valorVenda,
		valorCompra: valorCompra,
		unidadeVenda: unidadeVenda,
		conversao_unitaria: conversaoEstoque,
		categoria_id: categoria_id,
		cor: cor,
		nome: $('#nome').val(),
		ncm: this.ncm,
		cfop: cfop,
		unidadeCompra: this.unidade,
		valor: this.valor,
		quantidade: this.quantidade,
		codBarras: this.codBarras,
		numero_nfe: this.nNf,
		CST_CSOSN: CST_CSOSN,
		CST_PIS: CST_PIS,
		CST_COFINS: CST_COFINS,
		CST_IPI: CST_IPI,
		referencia: this.codigo,
		
	}
	console.log(prod.quantidade)

	console.log(prod)

	console.log(this.semRegitro)

	let token = $('#_token').val();

	$.ajax
	({
		type: 'POST',
		data: {
			produto: prod,
			_token: token
		},
		url: path + 'produtos/salvarProdutoDaNotaComEstoque',
		dataType: 'json',
		success: function(e){
			$("#th_prod_id_"+codigo).html(e.id);
			$("#th_acao1_"+codigo).css('display', 'none');
			$("#th_acao2_"+codigo).css('display', 'block');
			$("#th_estoque_"+codigo).addClass('disabled');
			
			$('#preloader').css('display', 'none');
			$('#modal1').modal('hide');
			// alert("Produto Saldo e inserido o estoque quantidade: " + prod.quantidade)
			swal("Sucesso", "Produto Saldo e inserido o estoque quantidade: " + prod.quantidade, "success")
			.then(sim => {
				location.reload();

			});

		}, error: function(e){
			console.log(e)
			$('#preloader').css('display', 'none');
		}
	});
})

function salvarEstoque(id, quantidade, valor, numero_nfe){
	swal("Alerta", "Deseja atribuir estoque a este produto?", "warning")
	.then(sim => {
		if(sim){
			let token = $('#_token').val();
			$.ajax
			({
				type: 'POST',
				data: {
					produto: id,
					quantidade: quantidade,
					valor: valor,
					numero_nfe: numero_nfe,
					_token: token
				},
				url: path + 'produtos/setEstoque',
				dataType: 'json',
				success: function(e){
					$("#th_estoque_"+id).addClass('disabled');

					swal("Sucesso", "Inserido o estoque quantidade: " + quantidade, "success")
					.then(() => {
						location.reload()
					})


				}, error: function(e){
					console.log(e)
					$('#preloader').css('display', 'none');
				}
			});
		}
	})
}
