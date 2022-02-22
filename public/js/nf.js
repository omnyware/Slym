$(function () {
	let semCertificado = $('#semCertificado').val() ? $('#semCertificado').val() : false;
	if(semCertificado){
		swal("Aviso", "Os botões inferiores seram mostrados após o upload de certificado", "warning")
	}

	
})

function transmitirNFe(id){
	$('#btn_trnasmitir_grid_'+id).addClass('spinner');
	$('#btn_trnasmitir_grid_'+id).addClass('disabled');

	let token = $('#_token').val();
	$.ajax
	({
		type: 'POST',
		data: {
			vendaId: id,
			_token: token
		},
		url: path + 'nf/gerarNf',
		dataType: 'json',
		success: function(e){
			console.log(e)
			let recibo = e;
			let retorno = recibo.substring(0,4);
			let mensagem = recibo.substring(5,recibo.length);
			if(retorno == 'Erro'){
				let m = JSON.parse(mensagem);
				swal("Erro", "[" + m.protNFe.infProt.cStat + "] : " + m.protNFe.infProt.xMotivo, "error")

			}
			else if(e == 'Apro'){
				swal("Cuidado!", "Esta NF já esta aprovada, não é possível enviar novamente!", "warning")

			}
			else{

				swal("Sucesso", "NF-e gerada com sucesso RECIBO: "+recibo, "success")
				.then(() => {
					window.open(path+"nf/imprimir/"+id, "_blank");
					location.reload();
				})
			}

			// $('#preloader1').css('display', 'none');

			$('#btn_trnasmitir_grid_'+id).removeClass('spinner');
			$('#btn_trnasmitir_grid_'+id).removeClass('disabled');

		}, error: function(e){

			try{
				let js = e.responseJSON;
				console.log(js)

				if(js.message){

					swal("Erro!", js.message, "warning")

				}else if(e.status == 407){
					swal("", js, "warning")

				}else{
					let err = "";
					js.map((v) => {
						err += v + "\n";
					});

					swal("Erro!", err, "warning")

				}
			}catch{
				console.log(e)
				swal("", e, "warning")

			}

			$('#btn_trnasmitir_grid_'+id).removeClass('spinner');
			$('#btn_trnasmitir_grid_'+id).removeClass('disabled');

			// $('#preloader1').css('display', 'none');
		}
	});
}
function enviar(){
	// $('#preloader1').css('display', 'block');
	$('#btn-enviar').addClass('spinner')
	$('#btn-enviar').addClass('disabled');

	let id = 0;
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked'))
			id = $(this).find('#id').html();
	})
	console.log(id);


	let token = $('#_token').val();
	$.ajax
	({
		type: 'POST',
		data: {
			vendaId: id,
			_token: token
		},
		url: path + 'nf/gerarNf',
		dataType: 'json',
		success: function(e){
			console.log(e)
			let recibo = e;
			let retorno = recibo.substring(0,4);
			let mensagem = recibo.substring(5,recibo.length);
			if(retorno == 'Erro'){
				let m = JSON.parse(mensagem);
				swal("Erro", "[" + m.protNFe.infProt.cStat + "] : " + m.protNFe.infProt.xMotivo, "error")
			}
			else if(e == 'Apro'){
				swal("Cuidado!", "Esta NF já esta aprovada, não é possível enviar novamente!", "warning")

			}
			else{
				swal("Sucesso", "NF-e gerada com sucesso RECIBO: "+recibo, "success")
				.then(() => {
					window.open(path+"nf/imprimir/"+id, "_blank");
					location.reload();
				})
			}

			// $('#preloader1').css('display', 'none');
			$('#btn-enviar').removeClass('spinner')
			$('#btn-enviar').removeClass('disabled');

		}, error: function(e){
			try{
				let js = e.responseJSON;
				console.log(js)

				if(js.message){

					swal("Erro!", js.message, "warning")

				}else if(e.status == 407){
					swal("", js, "warning")

				}else{
					let err = "";
					js.map((v) => {
						err += v + "\n";
					});

					swal("Erro!", err, "warning")

				}
			}catch{
				console.log(e)
				swal("", e, "warning")

			}

			$('#btn-enviar').removeClass('disabled');
			$('#btn-enviar').removeClass('spinner')

			// $('#preloader1').css('display', 'none');
		}
	});
	
}

function redireciona(){
	location.reload();
}

function imprimir(){
	let id = 0;
	let cont = 0;
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			id = $(this).find('#id').html();
			cont++
		}
	})

	if(cont > 1){
		swal("Atenção", "Selecione um documento para impressão", "warning")
	}else{
		window.open(path+"nf/imprimir/"+id, "_blank");
	}
}

function consultarNFe(id){
	$('#btn_consulta_grid_'+id).addClass('spinner')
	$('#btn_consulta_grid_'+id).addClass('disabled')
	let token = $('#_token').val();
	$.ajax
	({
		type: 'POST',
		data: {
			id: id,
			_token: token
		},
		url: path + 'nf/consultar',
		dataType: 'json',
		success: function(e){
			console.log(e)
			let js = JSON.parse(e)
			if(js.cStat != '656'){
				// $('#motivo').html(js.xMotivo);
				// $('#chave').html(js.chNFe);
				// $('#protocolo').html(js.protNFe.infProt.nProt);

				swal("Sucesso", "Status: " + js.xMotivo + " - chave: " + js.chNFe + ", protocolo: " + js.protNFe.infProt.nProt, "success")

				$('#btn_consulta_grid_'+id).removeClass('spinner')
				$('#btn_consulta_grid_'+id).removeClass('disabled')
			}else{

				swal("Erro", "Consumo indevido!", "error")
			}
			$('#btn-consultar').removeClass('spinner')

		}, error: function(e){
			console.log(e)
			swal("Erro", "Erro de comunicação contate o desenvolvedor", "error")

			$('#btn_consulta_grid_'+id).removeClass('spinner')
			$('#btn_consulta_grid_'+id).removeClass('disabled')
		}
	});
}

function imprimirCCe(){
	let id = 0;
	let cont = 0;
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			id = $(this).find('#id').html();
			cont++
		}
	})

	if(cont > 1){
		swal("Atenção", "Selecione um documento para impressão", "warning")
	}else{
		window.open(path+"nf/imprimirCce/"+id, "_blank");
	}
}

function imprimirCancela(){
	let id = 0;
	let cont = 0;
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			id = $(this).find('#id').html();
			cont++
		}
	})

	if(cont > 1){

		swal("Atenção", "Selecione um documento para impressão", "warning")

	}else{
		window.open(path+"nf/imprimirCancela/"+id, "_blank");
	}
}

function consultar(){
	let id = 0;
	let cont = 0;
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			id = $(this).find('#id').html();
			cont++;
		}
	})

	if(cont > 1){

		swal("Atenção", "Selecione um documento para consultar", "warning")

	}else{
		$('#btn-consultar').addClass('spinner')
		let token = $('#_token').val();
		$.ajax
		({
			type: 'POST',
			data: {
				id: id,
				_token: token
			},
			url: path + 'nf/consultar',
			dataType: 'json',
			success: function(e){
				console.log(e)
				let js = JSON.parse(e)
				if(js.cStat != '656'){
					$('#motivo').html(js.xMotivo);
					$('#chave').html(js.chNFe);
					$('#protocolo').html(js.protNFe.infProt.nProt);
					$('#modal2').modal('show');
					$('#preloader1').css('display', 'none');
				}else{
					alert('Consumo indevido!')
				}
				$('#btn-consultar').removeClass('spinner')

			}, error: function(e){
				console.log(e)
				swal("Erro", "Erro de comunicação contate o desenvolvedor", "error")

				// $('#preloader1').css('display', 'none');
				$('#btn-consultar').removeClass('spinner')

			}
		});
	}
}

function setarNumero(buscarCliente = false){

	let id = 0;
	let nf = 0;
	let cont = 0;
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			nf = $(this).find('#numeroNf').html();
			$('#numero_cancelamento').html(nf)
			$('#numero_correcao').html(nf)
			$('#numero_nf').html(nf)

			if(buscarCliente){
				buscarDadosCliente();
			}

			cont++;
		}
	})
	
	if(cont > 1){
		swal("Atenção", "Selecione apenas um documento para continuar!", "warning")
	}
}

function buscarDadosCliente(){
	let id = 0;
	let cont = 0;

	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			id = $(this).find('#id').html();
			cont++;
		}
	})

	if(cont > 1){
		swal("Atenção", "Selecione apenas um documento para continuar!", "warning")
	}else{

		$.get(path+'nf/consultar_cliente/'+id)
		.done(function(data){
			data = JSON.parse(data)
			console.log(data.email)
			$('#email').val(data.email)
			$('#venda_id').val(id)

			if(data.email){
				$('#info-email').html('*Este é o email do cadastro');
			}else{
				$('#info-email').html('*Este cliente não possui email cadastrado');
			}
		})
		.fail(function(err){
			console.log(err)
		})
	}
}

function cancelarNFe(id, nf){
	$('#modal1_aux').modal('show')
	$('#numero_cancelamento2').html(nf)
	$('#id_cancela').val(id)
}

function cancelar2(){
	// $('#preloader5').css('display', 'block');
	$('#btn-cancelar-3').addClass('spinner')

	let id = $('#id_cancela').val();
	
	let justificativa = $('#justificativa2').val();

	
	let token = $('#_token').val();
	$.ajax
	({
		type: 'POST',
		data: {
			id: id,
			justificativa: justificativa,
			_token: token
		},
		url: path + 'nf/cancelar',
		dataType: 'json',
		success: function(e){
			console.log(e)
			let js = JSON.parse(e);
			console.log(js)
			$('#btn-cancelar-3').removeClass('spinner')
				// alert(js.retEvento.infEvento.xMotivo)
				swal("Sucesso", js.retEvento.infEvento.xMotivo, "success")
				.then(() => {
					window.open(path+"nf/imprimirCancela/"+id, "_blank");
					location.reload();
				})

				// $('#preloader5').css('display', 'none');

			}, error: function(e){
				console.log(e)
				swal("Erro", e.responseText, "error")

				$('#btn-cancelar-3').removeClass('spinner')

			}
		});
}

function cancelar(){
	// $('#preloader5').css('display', 'block');
	$('#btn-cancelar-2').addClass('spinner')

	let id = 0;
	let cont = 0;
	let justificativa = $('#justificativa').val();
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			id = $(this).find('#id').html();
			cont++;
		}
	})

	if(cont > 1){
		swal("Atenção", "Selecione apenas um documento para cancelar!", "warning")
	}else{
		let token = $('#_token').val();
		$.ajax
		({
			type: 'POST',
			data: {
				id: id,
				justificativa: justificativa,
				_token: token
			},
			url: path + 'nf/cancelar',
			dataType: 'json',
			success: function(e){
				console.log(e)
				let js = JSON.parse(e);
				console.log(js)
				$('#btn-cancelar-2').removeClass('spinner')
				// alert(js.retEvento.infEvento.xMotivo)
				swal("Sucesso", js.retEvento.infEvento.xMotivo, "success")
				.then(() => {
					window.open(path+"nf/imprimirCancela/"+id, "_blank");
					location.reload();
				})

				// $('#preloader5').css('display', 'none');

			}, error: function(e){
				console.log(e)
				swal("Erro", "Erro de comunicação contate o desenvolvedor", "error")

				// $('#preloader5').css('display', 'none');
				$('#btn-cancelar-2').removeClass('spinner')

			}
		});
	}
}

function corrigirrNFe(id, nf){
	$('#modal4_aux').modal('show')
	$('#numero_correcao_aux').html(nf)
	$('#id_correcao').val(id)
}

function cartaCorrecao(){
	// $('#preloader4').css('display', 'block');
	$('#btn-corrigir-2').addClass('spinner');
	let id = 0;
	let cont = 0;
	let correcao = $('#correcao').val();
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			id = $(this).find('#id').html();
			cont++;
		}
	})

	if(cont > 1){
		swal("Atenção", "Selecione apenas um documento para continuar!", "warning")

	}else{
		let token = $('#_token').val();
		$.ajax
		({
			type: 'POST',
			data: {
				id: id,
				correcao: correcao,
				_token: token
			},
			url: path + 'nf/cartaCorrecao',
			dataType: 'json',
			success: function(e){
				console.log(e)
				try{
					let js = JSON.parse(e);
					console.log(js)

					$('#btn-corrigir-2').removeClass('spinner');

					swal("Sucesso", js.retEvento.infEvento.xMotivo, "success")
					.then(() => {
						window.open(path+"nf/imprimirCce/"+id, "_blank");
						location.reload()
					})
				}catch{
					swal("Erro", e, "error")
					.then(() => {
						location.reload()
					})
				}
				// $('#preloader4').css('display', 'none');

			}, error: function(e){
				console.log(e)
				swal("Erro", "Erro de comunicação contate o desenvolvedor!", "error")
				$('#btn-corrigir-2').removeClass('spinner');

				// $('#preloader4').css('display', 'none');
			}
		});
	}
}

function cartaCorrecaoAux(){
	$('#btn-corrigir-2-aux').addClass('spinner')
	$('#btn-corrigir-2-aux').addClass('disabled')
	
	let token = $('#_token').val();
	let id = $('#id_correcao').val()
	let correcao = $('#correcao_aux').val()
	$.ajax
	({
		type: 'POST',
		data: {
			id: id,
			correcao: correcao,
			_token: token
		},
		url: path + 'nf/cartaCorrecao',
		dataType: 'json',
		success: function(e){
			console.log(e)
			try{
				let js = JSON.parse(e);
				console.log(js)

				$('#btn-corrigir-2-aux').removeClass('spinner')
				$('#btn-corrigir-2-aux').removeClass('disabled')

				swal("Sucesso", js.retEvento.infEvento.xMotivo, "success")
				.then(() => {
					window.open(path+"nf/imprimirCce/"+id, "_blank");
					location.reload()
				})
			}catch{
				swal("Erro", e, "error")
				.then(() => {
					location.reload()
				})
			}
				// $('#preloader4').css('display', 'none');

			}, error: function(e){
				console.log(e)
				swal("Erro", "Erro de comunicação contate o desenvolvedor!", "error")

				$('#btn-corrigir-2-aux').removeClass('spinner')
				$('#btn-corrigir-2-aux').removeClass('disabled')

				// $('#preloader4').css('display', 'none');
			}
		});

}

function inutilizar(){

	let justificativa = $('#justificativa').val();
	let nInicio = $('#nInicio').val();
	let nFinal = $('#nFinal').val();
	
	// $('#preloader3').css('display', 'block');
	$('#btn-inut-2').addClass('spinner')

	let token = $('#_token').val();
	$.ajax
	({
		type: 'POST',
		data: {
			justificativa: justificativa,
			nInicio: nInicio,
			nFinal: nFinal,
			_token: token
		},
		url: path + 'nf/inutilizar',
		dataType: 'json',
		success: function(e){
			console.log(e)
			if(e.infInut){
				// alert("cStat:" + e.infInut.cStat + "\n" + e.infInut.xMotivo);
				swal("Sucesso", e.infInut.cStat + "\n" + e.infInut.xMotivo, "success")
				.then(() => {
					location.reload()
				})
			}

			// $('#preloader3').css('display', 'none');
			$('#btn-inut-2').removeClass('spinner')

		}, error: function(e){
			console.log(e)
			swal("Erro", "Erro de comunicação contate o desenvolvedor!", "error")
			$('#preloader1').css('display', 'none');
		}
	});
	
}

$(function () {
	validaBtns();
})

$('#checkbox input').click(() => {
	validaBtns();
})

function validaBtns(){

	let cont = 0;
	let estado = "";
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			id = $(this).find('#id').html();
			estado = $(this).find('#estado_'+id).html();
			cont++;
		}
	})

	if(cont > 1 || cont == 0){
		desabilitaBotoes();
	}else{
		habilitaBotoes();
		if(estado == 'DISPONIVEL'){
			$('#btn-enviar').removeClass("disabled");
			$('#btn-imprimir').addClass("disabled");
			$('#btn-consultar').addClass("disabled");
			$('#btn-cancelar').addClass("disabled");
			$('#btn-inutilizar').removeClass("disabled");
			$('#btn-correcao').addClass("disabled");
			$('#btn-xml').addClass("disabled");

			$('#btn-danfe').removeClass("disabled");
			$('#btn-imprimir-cce').addClass("disabled");
			$('#btn-imprimir-cancelar').addClass("disabled");
			$('#btn-baixar-xml').addClass("disabled");


		} else if(estado == 'REJEITADO'){
			$('#btn-enviar').removeClass("disabled");
			$('#btn-imprimir').addClass("disabled");
			$('#btn-inutilizar').removeClass("disabled");
			$('#btn-correcao').addClass("disabled");

			$('#btn-consultar').removeClass("disabled");
			$('#btn-cancelar').addClass("disabled");
			$('#btn-xml').addClass("disabled");

			$('#btn-danfe').removeClass("disabled");
			$('#btn-imprimir-cce').addClass("disabled");
			$('#btn-imprimir-cancelar').addClass("disabled");
			$('#btn-baixar-xml').addClass("disabled");


		} else if(estado == 'CANCELADO'){
			$('#btn-enviar').addClass("disabled");
			$('#btn-inutilizar').addClass("disabled");
			$('#btn-correcao').addClass("disabled");
			$('#btn-imprimir').addClass("disabled");
			$('#btn-consultar').removeClass("disabled");
			$('#btn-cancelar').addClass("disabled");
			$('#btn-xml').addClass("disabled");

			$('#btn-danfe').removeClass("disabled");
			$('#btn-imprimir-cce').addClass("disabled");
			$('#btn-imprimir-cancelar').removeClass("disabled");
			$('#btn-baixar-xml').addClass("disabled");



		} else if(estado == 'APROVADO'){
			$('#btn-enviar').addClass("disabled");
			$('#btn-inutilizar').addClass("disabled");
			$('#btn-imprimir').removeClass("disabled");
			$('#btn-consultar').removeClass("disabled");
			$('#btn-cancelar').removeClass("disabled");
			$('#btn-correcao').removeClass("disabled");
			$('#btn-xml').removeClass("disabled");
			$('#btn-baixar-xml').removeClass("disabled");
			

			$('#btn-danfe').addClass("disabled");
			$('#btn-imprimir-cce').removeClass("disabled");
			$('#btn-imprimir-cancelar').addClass("disabled");
		}

	}
}

function desabilitaBotoes(){
	$('#btn-enviar').addClass("disabled");
	$('#btn-imprimir').addClass("disabled");
	$('#btn-consultar').addClass("disabled");
	$('#btn-cancelar').addClass("disabled");
	$('#btn-correcao').addClass("disabled");
	$('#btn-inutilizar').addClass("disabled");
	$('#btn-xml').addClass("disabled");
	$('#btn-danfe').addClass("disabled");
	$('#btn-imprimir-cce').addClass("disabled");
	$('#btn-imprimir-cancelar').addClass("disabled");

}


function habilitaBotoes(){
	$('#btn-enviar').removeClass("disabled");
	$('#btn-imprimir').removeClass("disabled");
	$('#btn-consultar').removeClass("disabled");
	$('#btn-cancelar').removeClass("disabled");
	$('#btn-correcao').removeClass("disabled");
	$('#btn-inutilizar').removeClass("disabled");
	$('#btn-xml').removeClass("disabled");

}

function enviarEmailXMl(){
	$('#btn-send').addClass('spinner');
	$('#btn-send').addClass('disabled');
	
	let id = $('#venda_id').val();
	let email = $('#email').val();

	$.get(path+'nf/enviarXml', {id: id, email: email})
	.done(function(data){
		console.log(data)
		$('#btn-send').removeClass('spinner');
		$('#btn-send').removeClass('disabled');
		swal("Sucesso", "Email enviado!!", "success")
		.then(() => {
			$('#modal5').modal('hide')
		})
	})
	.fail(function(err){
		console.log(err)
		$('#btn-send').removeClass('spinner');
		$('#btn-send').removeClass('disabled');
		swal("Erro", "Erro ao enviar email!!", "error")

	})
}

function modalWhatsApp(){
	$('#modal-whatsApp').modal('show')
}

function baixarXml(){
	let id = 0;
	let cont = 0;
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			id = $(this).find('#id').html();
			cont++
		}
	})

	if(cont > 1){
		Materialize.toast('Selecione apenas um documento para impressão!', 5000)
	}else{
		window.open(path+"vendas/baixarXml/"+id, "_blank");
	}
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

$('#btn-danfe').click(() => {
	let id = 0
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked'))
			id = $(this).find('#id').html();
	})
	window.open(path + 'vendas/rederizarDanfe/' + id);
})

