
let adicionais = [];
var maximo = 1;
var VALOR = 0;
var VALOR_REAL = 0;
$(function () {
	VALOR = $('#valor_produto').html();
	VALOR_REAL = VALOR = parseFloat(VALOR);
	maximo = $('#maximo_adicionais_pizza').val();
})

function selet_add(adicional, nome){
	controlaMaximo(adicional.id, (cl)=> {
		if(cl == false){
			verificaAdicionado(adicional.id, (res) => {

				if(res == true){
					$('#adicional_'+adicional.id).css('background', '#fff')
					removeElemento(adicional.id)
				}else{
					$('#adicional_'+adicional.id).css('background', '#81c784')
					adicionais.push({
						'id': adicional.id,
						'nome': nome,
						'valor': adicional.valor
					})
				}

				somaTotal();
			})
		}
	})

}

function controlaMaximo(id, call){
	let ret = false;
	console.log(adicionais.length)
	if(adicionais.length >= maximo){
		ret = true
	}

	adicionais.map((rs) => {
		if(rs.id == id)
			ret = false;
	})

	if(ret == true){
		swal("Atenção!", 'Maximo de '+maximo+' adicionais!!', "warning")
	}
	
	call(ret)
}

function removeElemento(elem_id){
	let temp = [];
	adicionais.map((v) => {
		if(v.id != elem_id){
			temp.push(v)
		}
	});

	adicionais = temp;
}

function verificaAdicionado(elem_id, call){
	let b = false;
	adicionais.map((v) => {
		if(v.id == elem_id){
			b = true;
		}
	});
	call(b);
}

function somaTotal(){
	let valorProduto = $('#valor_produto').html();
	valorProduto = parseFloat(valorProduto)
	adicionais.map((v) => {
		valorProduto += parseFloat(v.valor);
	})
	VALOR = valorProduto
	$('#valor_total').html(convertMoney(valorProduto))
}

function convertMoney(v){
	return v.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}


function adicionar(){
	let tk = $('#_token').val();
	let sabores = JSON.parse($('#sabores').val());
	let quantidade = $('#quantidade').val();
	let observacao = $('#observacao').val();
	let tamanho = $('#tamanho').val();

	let js = {
		_token: tk, 
		sabores: sabores,
		tamanho: tamanho,
		adicionais: adicionais,
		quantidade: quantidade,
		observacao: observacao,
		valor: parseFloat(VALOR_REAL)
	};

	console.log(js)

	$.post(path + "pedido/addPizza", js
		)
	.done(function(data) {

		if(data){
			sucesso();
		}
	})
	.fail( function(err) {
		console.log(err)
		console.log(err.status)
		if(err.status == 401) location.href = path + 'pedido';
		if(err.status == 404) {
			swal("Atenção!", err.responseJSON, "warning")
			.then((sim) => {
				location.href = path + 'pedido';
			})
		}

	});

}

function sucesso(){
	$('#content').css('display', 'none');
	$('#anime').css('display', 'block');
	setTimeout(() => {
		location.href = path + 'pedido';
	}, 3000)
}
