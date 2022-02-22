

let enderecoSelecionado = null;
var TOTAL = 0;
var VALORENTREGA = 0;
var ENTREGA = false;
var DESCONTO = 0;
var DESCONTOAPLICADO = false;
var latPadrao = 0;
var lngPadrao = 0;
var BANDEIRA = "";
var INSTALLMENTS = [];
var USARBAIRROS = 0;

var ENTREGADISTANTE = false;

let LAT = latPadrao;
let LNG = lngPadrao;

var HASHCLIENTE = '';
var TOKENCARTAO = '';

$(function () {


	getCarrinho();

	MAXIMOPARCELAMENTO = $('#maximo_parcelamento').val();

	LAT = latPadrao = $('#lat_padrao').val()
	LNG = lngPadrao = $('#lng_padrao').val()

	USARBAIRROS = $('#usar_bairros').val();


	if(LAT){
		TOTAL = $('#total-init').val();
		TOTAL = parseFloat(TOTAL);
		$('#total').html("R$ "+TOTAL.toFixed(2));

		getDadosCalculoEntrega((res) => {
			console.log(res)
			DADOSCALCULOENTREGA = res;

			getCurrentLocation((crd) => {

				if(crd){
					initMap(crd.latitude, crd.longitude);

				}else{
					swal("Atenção!",'Não foi possivel recuperar sua localização, ative e recarregue a pagina!', "warning")

					initMap(latPadrao, lngPadrao);
				}
			});
		})
		

		$.get(path + 'pagseguro/getSessao')
		.done((success) => {
			let token = success.id

			let res = PagSeguroDirectPayment.setSessionId(token);

		})
		.fail((err) => {
			console.log(err)

		})
	}
})


function upProd(id, unidade){

	$('#loader_'+id).css('display', 'inline-block');
	let qtd = $('#input_prod_'+id).val();
	let token = $('#token').val();

	if(unidade == 'UNID'){
		qtd = parseInt(qtd);
		qtd = qtd+1;
	}else{
		qtd = parseFloat(qtd);

		qtd += 0.1;
	}

	let clienteLogado = $('#cliente_logado').val();

	if(clienteLogado == 0){
		location.href = path + 'deliveryProduto/novo_cliente';
	}else{

		let js = {
			id: id,
			qtd: qtd,
			_token: token
		}	

		$.post(path + 'deliveryProduto/addProduto', js)
		.done((success) => {
			$('#loader_'+id).css('display', 'none');
			montaCarrinho(success, (html) => {
				$('#carrinho_html').html(html)
				totalizaCarrino(success);
			})

			success.itens.map((item) => {
				if(item.produto_id == id){
					if(unidade == 'UNID'){
						$('#input_prod_'+id).val(qtd);
						$('#input_html_'+id).html((item.quantidade * item.produto.valor).toFixed(2));
					}else{
						$('#input_prod_'+id).val(qtd.toFixed(3));
						$('#input_html_'+id).html((item.quantidade * item.produto.valor).toFixed(2));

					}
				}
			})

		})
		.fail((err) => {

			$('#loader_'+id).css('display', 'none');
			location.href = path + 'delivery/pedidoPendente'
		})
	}
}

function downProd(id, unidade){
	$('#loader_'+id).css('display', 'inline-block');
	
	let qtd = $('#input_prod_'+id).val();
	let token = $('#token').val();


	if(unidade == 'UNID'){
		qtd = parseInt(qtd);
		qtd = qtd-1;
	}else{
		qtd = parseFloat(qtd);

		qtd -= 0.1;
	}

	if(qtd >= 0){
		


		let clienteLogado = $('#cliente_logado').val();
		if(clienteLogado == 0){
			location.href = path + 'deliveryProduto/novo_cliente';
		}

		let js = {
			id: id,
			qtd: qtd,
			_token: token
		}

		$.post(path + 'deliveryProduto/downProduto', js)
		.done((success) => {
			$('#loader_'+id).css('display', 'none');
			montaCarrinho(success, (html) => {

				$('#carrinho_html').html(html)
				totalizaCarrino(success);
			})

			// if(unidade == 'UNID'){
			// 	$('#input_prod_'+id).val(qtd);
			// 	$('#input_html_'+id).html(qtd);
			// }else{
			// 	$('#input_prod_'+id).val(qtd.toFixed(3));
			// 	$('#input_html_'+id).html(qtd.toFixed(3));
			// }

			if(qtd == 0){
				$('#div_' + id).css('display', 'none')
			}

			success.itens.map((item) => {

				if(item.produto_id == id){
					if(unidade == 'UNID'){
						$('#input_prod_'+id).val(qtd);
						$('#input_html_'+id).html((item.quantidade * item.produto.valor).toFixed(2));
					}else{
						$('#input_prod_'+id).val(qtd.toFixed(3));
						$('#input_html_'+id).html((item.quantidade * item.produto.valor).toFixed(2));

					}

				}
			})
		})
		.fail((err) => {
			$('#loader_'+id).css('display', 'none');	
		})
	}else{
		$('#loader_'+id).css('display', 'none');	
		$('#input_prod_'+id).val('0');

		swal("Atenção!", "Número negativo!", "warning")

	}
}

function montaCarrinho(pedido, call){

	let itens = pedido.itens;

	let html = "";
	itens.map(v => {

		html += '<div class="cart-inline-item">';
		html += '<div class="unit align-items-center">';
		html += '<div class="unit-left">';
		html += '<a class="cart-inline-figure" href="#">';
		html += '<img src="'+v.imagem+'" class="img-carrinho" alt="" />';
		html += '</a></div>';
		html += '<div class="unit-body">';
		html += '<h6 class="cart-inline-name"><a href="#">' + v.produto.produto.nome + '</a></h6>';
		html += '<div><div class="group-xs group-inline-middle">';
		html += '<div class="table-cart-stepper">';
		html += '<input class="form-input" type="text" disabled data-zeros="true" value="'+v.quantidade+'" min="1" max="1000">';
		html += ' </div><h6 class="cart-inline-title">' + v.produto.valor + ' ' + v.produto.produto.unidade_venda+'</h6>';
		html += '</div></div></div></div></div>';
	})


	call(html);
}

function getDadosCalculoEntrega(call){
	$.get(path+'carrinho/getDadosCalculoEntrega')
	.done(function(data){
		call(data)
	})
	.fail(function(err){
		console.log(err)
		call(err)
	})
}

function getCarrinho(){
	$.get(path + 'deliveryProduto/carrinho')
	.done((success) => {
		montaCarrinho(success, (html) => {
			$('#carrinho_html').html(html)
			totalizaCarrino(success);

		})
	})
	.fail((err) => {
		console.log(err)
	})
}

function totalizaCarrino(pedido){

	let itens = pedido.itens;
	$('#qtd_carrinho').html(itens.length)
	$('#qtd_carrinho_2').html(' ' +itens.length)
	$('#qtd-itens').html('x' +itens.length)
	$('#total_carrinho').html('R$ ' + pedido.soma.toFixed(2))
	$('#soma').html('R$ ' + pedido.soma.toFixed(2))
}

function upCart(id){
	let qtd = $('#input_cart_'+id).val();
	if(qtd > 20 || qtd < 1){
		$('#input_cart_'+id).val(1);
	}
}


function alterCart(id, unidade){

	$('#loader_'+id).css('display', 'inline-block')
	let qtd = $('#input_cart_'+id).val();
	let valorUnit = $('#valor_unit_'+id).val();
	$('#valor_'+id).html((valorUnit * qtd).toFixed(2))

	let pedido_id = $('#pedido_id').val();
	let token = $('#token').val();

	let js = {
		item_id: id,
		pedido_id: pedido_id,
		qtd: qtd,
		_token: token
	}

	$.post(path + 'deliveryProduto/alterCart', js)
	.done((success) => {
		$('#loader_'+id).css('display', 'none')

		$('#soma').html('R$ ' + success.soma.toFixed(2))
	})
	.fail((err) => {
		console.log(err)	
		$('#loader_'+id).css('display', 'none')
		if(err.status == 401){

			swal("Atenção!", "Algo esta errado no seu pedido!", "warning")

		}
	})

}


function set_endereco(id){
	TOTAL -= parseFloat(VALORENTREGA)
	$('#endereco_select_'+enderecoSelecionado).css('background', '#fff')

	$('#entrega-distante').css('display', 'none')
	$('#frete-gratuito').css('display', 'none')
	if(id == 'balcao'){
		$('#endereco_select_balcao').css('background', '#81c784')
		$('#acrescimo-entrega').css('display', 'none')
		if(ENTREGA == true){
			VALORENTREGA = 0;
			$('#total').html("R$ "+parseFloat(TOTAL).toFixed(2))
		}
		ENTREGA = false;

	}else{

		getValorEntrega((d) => {
			let j = JSON.parse(d)

			getEndereco(id, (enderecoData) => {

				if(USARBAIRROS == 1){

					getValorBairro(id, (valor) => {

						if(valor == false){
							VALORENTREGA = j.valor_entrega;
						}else{

							VALORENTREGA = parseFloat(valor)
						}

						TOTAL += parseFloat(VALORENTREGA)

						$('#acrescimo-entrega').css('display', 'block')


						if(VALORENTREGA > 0){ 
							$('#valor-entrega').html(parseFloat(VALORENTREGA).toFixed(2))
						}
						else{ 
							$('#valor-entrega').html('0.00') 
						}

						$('#total').html("R$ "+parseFloat(TOTAL).toFixed(2))
					})
				}else if(DADOSCALCULOENTREGA.valor_km > 0){

					getDistancia(enderecoData.latitude, enderecoData.longitude, (distacia) => {

						if(distacia == 0 || enderecoData == false || DADOSCALCULOENTREGA.valor_km == 0){
							VALORENTREGA = j.valor_entrega;
						}else{

							if(DADOSCALCULOENTREGA.maximo_km_entrega > 0 && distacia > DADOSCALCULOENTREGA.maximo_km_entrega){
								ENTREGADISTANTE = true;

								$('#entrega-distante').css('display', 'block')
								$('#frete-gratuito').css('display', 'none')
								$('#acrescimo-entrega').css('display', 'none')


							}else{
								ENTREGADISTANTE = false;
								distacia = parseInt(distacia);
								if(distacia >= DADOSCALCULOENTREGA.entrega_gratis_ate){
									VALORENTREGA = DADOSCALCULOENTREGA.valor_km * distacia;
									$('#frete-gratuito').css('display', 'none')

								}else{
									VALORENTREGA = 0;
									$('#frete-gratuito').css('display', 'block')


								}
							}
						}

						TOTAL += parseFloat(VALORENTREGA)
						if(ENTREGADISTANTE == false){
							$('#acrescimo-entrega').css('display', 'block')
						}

						if(VALORENTREGA > 0){ 
							$('#valor-entrega').html(parseFloat(VALORENTREGA).toFixed(2))
						}
						else{ 
							$('#valor-entrega').html('0.00') 
						}
						$('#total').html("R$ "+parseFloat(TOTAL).toFixed(2))

					})
				}else{
					//valor padrao

					VALORENTREGA = j.valor_entrega;
					TOTAL += parseFloat(VALORENTREGA)
					$('#total').html("R$ "+parseFloat(TOTAL).toFixed(2))
					$('#valor-entrega').html(parseFloat(VALORENTREGA).toFixed(2))
					$('#acrescimo-entrega').css('display', 'block')

				}
			})

			ENTREGA = true;
		})
		// getValorEntrega((d) => {
		// 	let j = JSON.parse(d)
		// 	if(ENTREGA == false){
		// 		VALORENTREGA = j.valor_entrega;
		// 		TOTAL += parseFloat(VALORENTREGA)
		// 		$('#acrescimo-entrega').css('display', 'block')
		// 		$('#valor-entrega').html(VALORENTREGA)
		// 		$('#total').html("R$ "+parseFloat(TOTAL).toFixed(2))
		// 	}
		// 	ENTREGA = true;
		// })
		$('#endereco_select_balcao').css('background', '#fff')

		$('#endereco_select_'+id).css('background', '#81c784')
		
	}
	enderecoSelecionado = id;
	verificaBotaoFinalizarSemCartao();
}

function getCurrentLocation(call){
	var options = {
		enableHighAccuracy: true,
		timeout: 5000,
		maximumAge: 0
	};

	function success(pos) {
		var crd = pos.coords;
		call(crd);
	};

	function error(err) {

		call(false)
	};

	navigator.geolocation.getCurrentPosition(success, error, options);
}


function initMap(lat, lng){
	LAT = lat;
	LNG = lng;
	const position = new google.maps.LatLng(lat, lng);

	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 16,
		center: position,
		disableDefaultUI: false
	});	

	const marker = new google.maps.Marker({
		position: position,
		map: map,
		animation: google.maps.Animation.BOUNCE,
		draggable: true
	})

	getEnderecoByCoords(lat, lng, (res) => {

		if(res == false){

		}else{
			$('#rua').val(res.rua)
			$('#numero').val(res.numero)
			validaCamposNovoEndereco();
		}
	})

	google.maps.event.addListener(marker, 'dragend', (event) => {
		var myLatLng = event.latLng;
		var latAux = myLatLng.lat();
		var lngAux = myLatLng.lng();


		LAT = latAux;
		LNG = lngAux;

		getEnderecoByCoords(latAux, lngAux, (res) => {
			if(res == false){

			}else{

				$('#rua').val(res.rua)
				$('#numero').val(res.numero)
				validaCamposNovoEndereco();
			}
		})
	})

}

$('#telefone').keyup(() => {
	verificaBotaoFinalizarSemCartao();
})

function verificaBotaoFinalizarSemCartao(){
	let telefone = $('#telefone').val();
	if(telefone.length > 12 && $('#pagseguro').is(':checked') == false && enderecoSelecionado != null && ENTREGADISTANTE == false){
		$('#finalizar-venda').removeClass('disabled')
	}else{
		$('#finalizar-venda').addClass('disabled')
	}
}

function getEnderecoByCoords(lat, lng, call){
	geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(lat, lng);
	geocoder.geocode({
		'latLng': latlng
	}, function (results, status) {
		if (status === google.maps.GeocoderStatus.OK) {
			if (results[1]) {
				let res = results[1].address_components;
				let numero = res[0].long_name;
				let rua = res[1].long_name;

				let js = {
					numero: res[0].long_name,
					rua: res[1].long_name
				};

				call(js);
				
			} else {

				call(false);
			}
		} else {
			console.log('Geocoder failed due to: ' + status);
			call(false);
		}
	});
}

function validaCamposNovoEndereco(){

	let rua = $('#rua').val();
	let numero = $('#numero').val();
	let bairro = $('#bairro').val();
	let referencia = $('#referencia').val();

	if(rua.length > 0 && numero.length > 0 && bairro.length > 0 && referencia.length){
		$('#salvar_endereco').removeClass('disabled')
	}else{
		$('#salvar_endereco').addClass('disabled')
	}
}

$('#btn-end-map').click(() => {
	$('#info-mapa').css('display', 'none');
	$('#form-endereco').css('display', 'block');

})

$('#novo-endereco').click(() => {
	$('#info-mapa').css('display', 'block');
	$('#form-endereco').css('display', 'none');
})

$('.fr').keyup(() => {
	validaCamposNovoEndereco()
})

function validaCamposNovoEndereco(){
	let rua = $('#rua').val();
	let numero = $('#numero').val();
	let bairro = $('#bairro').val();
	let referencia = $('#referencia').val();

	if(rua.length > 0 && numero.length > 0 && bairro.length > 0 && referencia.length){
		$('#salvar_endereco').removeClass('disabled')
	}else{
		$('#salvar_endereco').addClass('disabled')
	}
}

$('#salvar_endereco').click(() => {
	let rua = $('#rua').val()
	let numero = $('#numero').val()
	let bairro = $('#bairro').val()
	let referencia = $('#referencia').val()
	let cliente_id = $('#cliente_id').val()
	let tk = $('#_token').val()

	let js = {
		rua: rua,
		numero: numero,
		bairro: bairro,
		referencia: referencia,
		cliente_id: cliente_id,
		latitude: LAT,
		longitude: LNG
	}

	$.post(path+'enderecoDelivery/save', {_token : tk, data: js})
	.done(function(data){
		data = JSON.parse(data)
		let ht = '<div class="col-lg-4 col-md-6" onclick="set_endereco('+data.id+')">'+
		'<div id="endereco_select_'+data.id+'" class="card border-0 med-blog">'+

		'<div class="card-body border border-top-0">'+
		'<h5 class="blog-title card-title m-0">'+
		rua + ', ' + numero+
		'</h5>'+
		// '<h5>'+bairro+'</h5>'+
		'<p>Referencia: '+ referencia +'</p>'+
		'</div>'+
		'</div>'+
		'</div>';

		$( ".ends" ).append( ht );
		$('#modal-mapa').modal('hide')

	})
	.fail( function(err) {
		console.log(err)

	});

})

$('#voltar').click(() => {
	$('#nome').val("")
	$('#cpf').val("")
	$('#number').val("")
	$('#cvc').val("")
	$('#validade').val("")
	$('#fator').html('');
	$('#div-cartao-antigo').css('display', 'block');
	$('#div-pagar').css('display', 'none');

})

$("input[name=escolha-cartao]").change(() => {
	$('#div-cartao-antigo').css('display', 'none');
	$('#div-pagar').css('display', 'block');

	let escolha = JSON.parse($("input[name=escolha-cartao]:checked").val())
	if(escolha != null){
		$('#nome').val(escolha.nome_impresso)
		$('#cpf').val(escolha.cpf)
		$('#number').val(escolha.numero_cartao)

		var keyupEvent= new Event('keyup');
		document.getElementById('number').dispatchEvent(keyupEvent);
		document.getElementById('nome').dispatchEvent(keyupEvent);
		// $('#number').focus().blur();
		$('#cpf').focus().blur();
		// $('#number').focus()
		
		let numero = escolha.numero_cartao;
		if(numero.length > 5){
			getBrand(numero)
			getParcelas();
		}else{
		}
	}else{
		$('#nome').val('')
		$('#cpf').val('')
		$('#number').val('')


	}

})

$('#maquineta').click(() => {
	verificaBotaoFinalizarSemCartao();
	$('#div_do_troco').css('display', 'none');
})
$('#pagseguro').click(() => {
	verificaBotaoFinalizarSemCartao();

	let formaPagamento = $('#maquineta').is(':checked') ? 'maquineta' :  
	$('#dinheiro').is(':checked') ? 'dinheiro' : $('#pagseguro').is(':checked') ?
	'pagseguro' : '';

	let troco = $('#troco_para').val();
	let telefone = $('#telefone').val();
	let cupom = $('#cupom').val();

	if(telefone.length > 12 && enderecoSelecionado != null){
		$('#div_do_troco').css('display', 'none');
		$('#total-cartao').html("R$ "+parseFloat(TOTAL).toFixed(2))
		// $('#nome').val($('#nome-cliente').val())

		$('#modal-pagseguro').modal('show')

		HASHCLIENTE = PagSeguroDirectPayment.getSenderHash();

	}else{
		
		if(!enderecoSelecionado){
			swal("Atenção!", "Por favor selecione a forma de entrega", "warning")

		}
		else if(telefone.length < 12){
			swal("Atenção!", "Por favor informe um telefone de contato (11) 99999-9999", "warning")

		}
	}
});

$('#dinheiro').click(() => {
	verificaBotaoFinalizarSemCartao();
	$('#div_do_troco').css('display', 'block');
})

$('#abrir-mapa').click(() => {
	$('#info-mapa').css('display', 'block');
	$('#form-endereco').css('display', 'none');
})

function getValorEntrega(call){
	$.get(path+'carrinho/configDelivery')
	.done(function(data){

		call(data)
	})
	.fail(function(err){
		console.log(err)
		call(err)
	})
}

$("#cpf").focus(function(){ 

	HASHCLIENTE = PagSeguroDirectPayment.getSenderHash();

});

$("#cvc").keyup(function(){ 

	if($("#cvc").val().length > 2){
		let numCartao = $("#number").val().replace(" ", "").replace(" ", "").replace(" ", "");
		let cvvCartao = $("#cvc").val();
		let validade = $("#validade").val().split('/');
		expiracaoMes = validade[0].replace(" ", "");
		expiracaoAno = validade[1].replace(" ", "");

		PagSeguroDirectPayment.createCardToken({
			cardNumber: numCartao,
			cvv: cvvCartao,
			expirationMonth: expiracaoMes,
			expirationYear: expiracaoAno,

			success: function(response){ 
				TOKENCARTAO = response['card']['token'];

			},
			error: function(response){ 
				console.log(response); 
				// alert("Data de validade incorreta")
			}
		});
	}

});

function getTokenCartao(){
	if($("#cvc").val().length > 2){
		let numCartao = $("#number").val().replace(" ", "").replace(" ", "").replace(" ", "");
		let cvvCartao = $("#cvc").val();
		let validade = $("#validade").val().split('/');
		expiracaoMes = validade[0].replace(" ", "");
		expiracaoAno = validade[1].replace(" ", "");

		PagSeguroDirectPayment.createCardToken({
			cardNumber: numCartao,
			cvv: cvvCartao,
			expirationMonth: expiracaoMes,
			expirationYear: expiracaoAno,

			success: function(response){ 
				TOKENCARTAO = response['card']['token'];

			},
			error: function(response){ 
				console.log(response); 
				// alert("Data de validade incorreta")
			}
		});
	}
}
function getParcelas(){

	PagSeguroDirectPayment.getInstallments({
		amount: TOTAL,
		brand: BANDEIRA,
		maxInstallmentNoInterest: 1,
		success: function(response) {
			installments = response.installments

			INSTALLMENTS = installments[BANDEIRA];
			$('#fator').html('');
			INSTALLMENTS.map((v) => {

				$('#fator').append('<option value="'+v.quantity+'">'+v.quantity+'x R$ ' + 
					parseFloat(v.installmentAmount).toFixed(2) + '</option>'); 
			})
		},
		error: function(response) {
			console.log(response);
		}
	})
}

$('#number').keyup(() => {
	let numero = $('#number').val().replace(" ", "").replace(" ", "").replace(" ", "");
	if(numero.length > 5){
		getBrand(numero)
	}else{
	}
})

function getBrand(numero){

	PagSeguroDirectPayment.getBrand( {
		cardBin: numero,
		success: function(response) {
			BANDEIRA = response['brand']['name'];
			getParcelas(BANDEIRA)
			
		},
		error: function(response) {
			console.log(response)
		}
	});
}

$('#cupom').on('keyup', () => {
	let cupom = $('#cupom').val();
	if(cupom.length == 6){
		calculaCupom(cupom);

	}else{
		DESCONTOAPLICADO = false;
		TOTAL += DESCONTO;
		DESCONTO = 0;
		if(cupom.length > 3){
			$('#total').html("R$ "+parseFloat(TOTAL).toFixed(2))
			$('#cupom-invalido').css('display', 'block');
			$('#desconto').css('display', 'none');
		}else{
			$('#cupom-invalido').css('display', 'none');
		}
	}

})

function calculaCupom(cupom){

	getCupom(cupom, (res) => {
		let js = JSON.parse(res)

		if(js){
			$('#cupom-invalido').css('display', 'none');
			$('#desconto').css('display', 'block');
			$('#valor-cupom').html((js.tipo == 'valor' ? 'R$': '') + parseFloat(js.valor).toFixed(2) 
				+ (js.tipo == 'percentual' ? '%': ''))
			if(js.tipo == 'valor'){
				DESCONTO = parseFloat(js.valor);
				if(!DESCONTOAPLICADO) TOTAL = TOTAL - DESCONTO;
				DESCONTOAPLICADO = true;
			}else{
				let v = parseFloat(js.valor);
				DESCONTO = ((TOTAL*v)/100);
				if(!DESCONTOAPLICADO) TOTAL = TOTAL - DESCONTO;
				DESCONTOAPLICADO = true;
			}

			$('#total').html("R$ "+parseFloat(TOTAL).toFixed(2))
		}
	})
}

$('#finalizar-venda').click(() => {

	let formaPagamento = $('#maquineta').is(':checked') ? 'maquineta' :  
	$('#dinheiro').is(':checked') ? 'dinheiro' : $('#pagseguro').is(':checked') ?
	'pagseguro' : '';

	let troco = $('#troco_para').val();
	let telefone = $('#telefone').val();
	let cupom = $('#cupom').val();
	let js = {
		forma_pagamento: formaPagamento,
		troco: troco.replace(",", "."),
		observacao: $('#observacao').val(),
		endereco_id: enderecoSelecionado,
		pedido_id: $('#pedido_id').val(),
		telefone: telefone,
		desconto: DESCONTO,
		valor_entrega: VALORENTREGA,
		cupom: DESCONTO > 0 ? cupom : ''
	}

	if(!formaPagamento){

		swal("Atenção!", "Por favor selecione a forma de pagamento", "warning")
	}
	else if(!enderecoSelecionado){
		swal("Atenção!", "Por favor selecione a forma de entrega", "warning")

	}
	else if(telefone.length <= 12){
		swal("Atenção!", "Por favor informe um telefone de contato (11) 99999-9999", "warning")
	}
	else if(ENTREGADISTANTE == true){
		swal("Atenção!", "Por favor selecione outro endereço", "warning")
	}

	else if(formaPagamento == 'dinheiro' && troco.length == 0 || parseFloat(troco.replace(",", ".")) == 0){
		swal("Atenção!", "Por favor insira o valor de troco para", "warning")
	}

	else if(formaPagamento == 'dinheiro' && parseFloat(troco.replace(",", ".")) < TOTAL){
		swal("Atenção!", "Valor do troco deve ser maior que o valor total do pedido", "warning")


		if(ENTREGA){
			swal("Atenção!", 'Total com entrega: R$' + TOTAL.toFixed(2), "warning")

		} 
		else{ 

			swal("Atenção!", 'Total: R$' + TOTAL.toFixed(2), "warning")

		}
	}

	else{

		let tk = $('#_token').val()

		$.post(path+'delivery/finalizarPedido', {_token : tk, data: js})
		.done(function(data){

			sucesso(data.id)

		})
		.fail( function(err) {
			console.log(err)

		});

	}
})

function sucesso(id){
	$('#content').css('display', 'none');
	$('#anime').css('display', 'block');
	setTimeout(() => {
		location.href = path + 'delivery/finalizado/'+id;
	}, 4000)
}

function getInstallment(call){
	let fator = $('#fator').val();
	INSTALLMENTS.map((v) => {
		if(v.quantity == fator){

			call(v)
		}
	})
}

$('#finalizar-venda-cartao').click(() => {
	getTokenCartao();
	$('#loader').css('display', 'inline-block')

	let formaPagamento = $('#maquineta').is(':checked') ? 'maquineta' :  
	$('#dinheiro').is(':checked') ? 'dinheiro' : $('#pagseguro').is(':checked') ?
	'pagseguro' : '';

	let troco = $('#troco_para').val();
	let telefone = $('#telefone').val();
	let cupom = $('#cupom').val();
	let cpf = $('#cpf').val().replace("-", "").replace(".", "").replace(".", "");
	let nome_cartao = $('#nome').val();
	let email = $('#email-cliente').val();
	let numCartao = $("#number").val().replace(" ", "").replace(" ", "").replace(" ", "");

	getInstallment((installment) => {
		let js = {
			forma_pagamento: formaPagamento,
			troco: troco.replace(",", "."),
			observacao: $('#observacao').val(),
			endereco_id: enderecoSelecionado,
			pedido_id: $('#pedido_id').val(),
			telefone: telefone,
			desconto: DESCONTO,
			total: parseFloat(installment.totalAmount).toFixed(2),
			cupom: DESCONTO > 0 ? cupom : '',

			produto_nome: "Refeicao",
			valor: parseFloat(installment.installmentAmount).toFixed(2),
			telefone: telefone.replace(" ", "").replace("-", ""),
			cpf: cpf,
			email: email,
			valor_entrega: VALORENTREGA,
			hashCliente: HASHCLIENTE,
			creditCardToken: TOKENCARTAO,
			nome_cartao: nome_cartao,
			parcelas: installment.quantity,
			numero_cartao: numCartao,
			bandeira: BANDEIRA
		}


		let tk = $('#_token').val()
		$.post(path+'pagseguro/efetuaPagamento', {_token : tk, data: js})
		.done(function(data){

			$('#loader').css('display', 'none')
			if(data.consulta.original.status == "3"){

				swal("Sucesso!", "Pagamento Aprovado!", "success")


				location.href = path + 'delivery/finalizado/'+data.pedido_id;
			}

		})
		.fail(function(err){
			$('#loader').css('display', 'none')
			if(err.status == 403){
				json = err.responseJSON;

				swal("Atenção!", "403: Erro de pagamento!", "warning")


			}else if(err.status == 404){
				json = err.responseJSON;
				console.log(json)
				swal("Atenção!", "404: Pagamento não autorizado!", "warning")

			}
			else if(err.status == 402){
				json = err.responseJSON;
				console.log(json)
				swal("Atenção!", "402: Pagamento ainda não aprovado pelo getway!", "warning")

			}
			console.log(err)
		});

	});



})


function getDistancia(latitude, longitude, call){
	var myLatLng = {lat: latitude, lng: longitude};
	var cliLatLng = {lat: DADOSCALCULOENTREGA.latitude_local, lng: DADOSCALCULOENTREGA.longitude_local};

	var directionsService = new google.maps.DirectionsService();
	var directionsRequest = {
		origin: new google.maps.LatLng(myLatLng.lat, myLatLng.lng),
		destination: new google.maps.LatLng(cliLatLng.lat, cliLatLng.lng),

		travelMode: google.maps.DirectionsTravelMode.DRIVING,
		unitSystem: google.maps.UnitSystem.METRIC
	};

	directionsService.route(
		directionsRequest,
		function(response, status)
		{	
			if (status == google.maps.DirectionsStatus.OK) {
				let route = response.routes[0].legs[0];
				let distancia = route.distance.value;
				let duracao = route.duration.text;
				DISTANCIA = distancia/1000; 
				call(DISTANCIA)
			}else{
				call(false);
			}
		});

}

function getValorBairro(endereco_id, call){
	$.get(path + 'enderecoDelivery/getValorBairro', {endereco_id: endereco_id})
	.done((res) => {
		call(res)
	})
	.fail((err) => {
		console.log(err)
		call(false)
	})
}

function getEndereco(endereco_id, call){
	$.get(path + 'enderecoDelivery', {endereco_id: endereco_id})
	.done((res) => {
		call(res)
	})
	.fail((err) => {
		call(false)
	})
}



