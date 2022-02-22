$(function () {

	console.log('buscando')
	buscar((res) => {
		console.log(res)
		if(res != false){
			montaHtml(res)
		}
	})

	setInterval(() => {
		$('.progresso').css('display', 'block')
		buscar((res) => {
			if(res != false){
				montaHtml(res)
			}

			$('.progresso').css('display', 'none')
			
		})
	}, 5000)

})

function buscar(call){
	$.get(path+'controleCozinha/buscar')
	.done((data) => {
		call(data)
	})
	.fail((err) => {
		console.log(err)
		call(false)
	})
}

function pronto(id, ehDelivery){
	console.log(id)
	let js = {
		id: id,
		ehDelivery: ehDelivery ? 1 : 0
	}	

	$.get(path+'controleCozinha/concluido', js)
	.done((success) => {
		console.log(success)
		swal("Sucesso", "Item pronto", "success")
		.then(v => {
			location.reload()
		})
	})
	.fail((err) => {
		swal("Erro", "Algo deu errado", "warning")

		console.log(err)
	})
}

function montaHtml(obj){
	let html = '';
	contDelivery = 0;
	contComanda = 0
	obj.map((v) => {
		if(v.comanda == null){
			contDelivery++;
		}else{
			contComanda++;
		}
		let nome = v.produto.nome;
		if(!nome) nome = v.produto.produto.nome;
		criaDiv(v.comanda, nome, v.quantidade, v.data, v.id, 
			v.adicionais, v.saboresPizza, v.tamanhoPizza, v.pedido_id, v.observacao, (res) => {

				html += res;
			})
	})
	$('#contDelivery').html(contDelivery);
	$('#contComanda').html(contComanda);
	$('#itens').html(html);

	$('.progresso').css('display', 'none')
}

function criaDiv(comanda, nome, quantidade, data, item_id, adicionais, 
	saboresPizza, tamanhoPizza, pedidoId, obs, call){

	let tipo = comanda != null ? 'Comanda' : 'Item Delivery Pedido <strong class="blue-text">' + pedidoId + '</strong>';

	let html = '<div class="col-sm-6 col-lg-6 col-md-12">'+
	'<div class="card card-custom gutter-b">'+
	'<div class="card-header">'+
	'<h3 style="margin-top: 20px;">'+tipo+': <strong class="text-success">'+ (comanda != null ? comanda : '')+
	'</strong></h3></div>'+

	'<div class="card-body">'+
	'<h6>' +data+ '</h6>'+
	'<h6>Item: <strong>' + nome + '</strong>' + (tamanhoPizza != false ? ' - Tamanho: <strong class="text-danger">'+tamanhoPizza+'</strong>' : '') + '</h6>'+
	'<h6>Quantidade: <strong>' + quantidade + '</strong></h6>'+
	'<h6>Adicionais: <strong>' + adicionais + '</strong></h6>'+
	'<h6>Sabores: <strong>' + saboresPizza + '</strong></h6>'+
	'<h6>Observação: <a href="#!" onclick=\'swal("", "'+obs+'", "info")\'' + 
	' class="btn btn-light-info '+ (obs.length > 0 ? '' : 'disabled') +' ">Ver</a></h6>'+

	'</div><div class="card-footer">' + 
	'<a onclick="pronto('+item_id+', '+ (comanda == null ? true : false) +')" style="width: 100%; margin-top: 5px;" class="btn btn-success">' +
	'<i class="la la-check"></i>Pronto</a>'+

	'</div></div></div>'


	call(html);
}




