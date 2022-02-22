

function select_pizza(produto, galeria, sabor){

	$('#pizza_id').val(produto.id)
	$('#ingredientes').html(produto.ingredientes)
	$('#descricao').html(produto.descricao)
	$('#sabor').html(sabor.nome)
	if(galeria.length > 0){
		$("#img").attr('src', '/imagens_produtos/'+galeria[0].path)
	}else{
		$("#img").attr('src', '/imgs/no_image.png')
	}
	verificaAdicionado(produto.id, (res) => {

		if(res == 'true'){
			location.href='#!';
			alert('Este sabor ja esta adicionado!')
		}
	})

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

function verificaAdicionado(pizza_id, call){
	$.get(path+'pizza/verificaPizzaAdicionada', {pizza_id: pizza_id})
	.done((v) => {
		call(v)
	})
	.fail((e) => {
		call(e)
	})
}

function somaTotal(){
	let valorProduto = $('#valor_produto').html();
	valorProduto = parseFloat(valorProduto)
	adicionais.map((v) => {

		valorProduto += parseFloat(v.valor);
	})
	alert(valorProduto)
	$('#valor_total').html(convertMoney(valorProduto))
}

function convertMoney(v){
	return v.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}


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

		if(data == 'false'){
			alert("Você está com um pedido pendente, aguarde o processamento");
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
