
let adicionais = [];
var TOTAL = 0;

var maximo = 1;


$(function () {
	TOTAL = $('#total_init').val()
	maximo = $('#maximo_adicionais').val();
});
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
		console.log(rs.id)
		console.log(id)
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
	let b= false;
	adicionais.map((v) => {
		if(v.id == elem_id){

			b = true;
		}
	});
	call(b);
}

function somaTotal(){
	let quantidade = $('#quantidade').val() ? $('#quantidade').val() : 1
	let valorProduto = $('#valor_produto').html();
	valorProduto = parseFloat(valorProduto)
	adicionais.map((v) => {
		valorProduto += parseFloat(v.valor);
	})
	TOTAL = valorProduto = valorProduto * quantidade;
	$('#valor_total').html(convertMoney(valorProduto))
}

function convertMoney(v){
	return v.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

$('#quantidade').keyup((value) => {
	let qtd = value.target.value
	if(!qtd || qtd == 0){
		$('#quantidade').val('1')
	}
	somaTotal();
})

$('#quantidade').click((value) => {
	let qtd = value.target.value
	if(!qtd || qtd == 0){
		$('#quantidade').val('1')
	}
	somaTotal();
})


function adicionar(){
	let tk = $('#_token').val();
	let produto_id = $('#produto_id').val();
	let quantidade = $('#quantidade').val();
	let observacao = $('#observacao').val();

	$.post(path + "carrinho/add", 
	{
		_token: tk, 
		produto_id: produto_id,
		adicionais: adicionais,
		quantidade: quantidade,
		observacao: observacao
	})
	.done(function(data) {
		if(data == '401'){
			location.href = path;
		}else if(data == 'false'){
			swal("", "Você está com um pedido pendente, aguarde o processamento", "warning")
		}else{
			sucesso();
		}
	})
	.fail( function(err) {
		console.log(err)

	});

}

function sucesso(){
	$('#content').css('display', 'none');
	$('#anime').css('display', 'block');
	setTimeout(() => {
		location.href = path + 'carrinho';
	}, 3000)
}

function pedirWhats(nome){
	let whats_delivery = $('#whats_delivery').val();
	let link = 'https://api.whatsapp.com/send?phone=55'+whats_delivery+'&text='
	let quantidade = $('#quantidade').val();
	let msg = 'Olá gostaria de \n *';
	msg += quantidade + '* UN de *' + nome + '* \n';

	if(adicionais.length > 0){
		adicionais.map((v) => {
			msg += 'Adicional: *' + v.nome + '* \n'
		});
	}

	msg += 'Total: R$ *' + TOTAL + '*';


	msg = window.encodeURIComponent(msg);
	window.open(link + msg)

	console.log(msg)
}
