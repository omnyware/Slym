

function redireciona(){
	location.href= path + "mdfe";
}


function enviar(){
	$('#btn-enviar').addClass('spinner')
	$('#btn-enviar').addClass('disabled')
	let id = 0
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
			id: id,
			_token: token
		},
		url: path + 'mdfeSefaz/enviar',
		dataType: 'json',
		success: function(e){
			$('#btn-enviar').removeClass('spinner')
			$('#btn-enviar').removeClass('disabled')

			console.log(e)

			swal("Sucesso", "MDF-e gerada com sucesso Protocolo: " + e.protocolo, "success")
			.then(() => {
				window.open(path+"mdfeSefaz/imprimir/"+id, "_blank");
				location.href = path + 'mdfe'
			})

			

		}, error: function(e){
			// Materialize.toast('Erro de comunicação contate o desenvolvedor', 5000)
			$('#btn-enviar').removeClass('spinner')
			$('#btn-enviar').removeClass('disabled')

			console.log(e)
			if(e.status == '403'){
				let js = e.responseJSON;
				console.log(js)

				swal("Erro", '[' + js.cStat + ']: ' + js.message, "error")
			}
			else if(e.status == '401'){
				let js = e.responseJSON;
				console.log(js)

				swal("Erro", 'Esta ao transmitir, verifique o console do navegador!', "error")

			}
			else if(e.status == '404'){
				let js = e.responseJSON;
				console.log(js)

				swal("Erro", js[0], "error")

			}
			else if(e.status == 407){
				swal("Erro", e.responseJSON, "warning")

			}

			if(e.status == '500'){
				let js = e.responseJSON;
				console.log(js)

				swal("Erro", 'Erro no XML, verifique o console do navegador!', "error")

			}
		}
	});
	
}

$('#btn-xml-temp').click(() => {
	let id = 0
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked'))
			id = $(this).find('#id').html();
	})
	console.log(id);

	window.open(path+'mdfeSefaz/xmlTemp/'+id)
})

function transmitirMDFe(id){
	$('#btn_transmitir_grid_'+id).addClass('spinner')
	$('#btn_transmitir_grid_'+id).addClass('disabled')

	let token = $('#_token').val();
	$.ajax
	({
		type: 'POST',
		data: {
			id: id,
			_token: token
		},
		url: path + 'mdfeSefaz/enviar',
		dataType: 'json',
		success: function(e){
			$('#btn_transmitir_grid_'+id).removeClass('spinner')
			$('#btn_transmitir_grid_'+id).removeClass('disabled')

			console.log(e)

			swal("Sucesso", "MDF-e gerada com sucesso Protocolo: " + e.protocolo, "success")
			.then(() => {
				window.open(path+"mdfeSefaz/imprimir/"+id, "_blank");
				location.href = path + 'mdfe'
			})

			

		}, error: function(e){
			// Materialize.toast('Erro de comunicação contate o desenvolvedor', 5000)
			$('#btn_transmitir_grid_'+id).removeClass('spinner')
			$('#btn_transmitir_grid_'+id).removeClass('disabled')

			console.log(e)
			if(e.status == '403'){
				let js = e.responseJSON;
				console.log(js)

				swal("Erro", '[' + js.cStat + ']: ' + js.message, "error")
			}
			else if(e.status == '401'){
				let js = e.responseJSON;
				console.log(js)

				swal("Erro", 'Esta ao transmitir, verifique o console do navegador!', "error")

			}
			else if(e.status == '404'){
				let js = e.responseJSON;
				console.log(js)

				swal("Erro", js[0], "error")

			}

			if(e.status == '500'){
				let js = e.responseJSON;
				console.log(js)

				swal("Erro", 'Erro no XML, verifique o console do navegador!', "error")

			}
		}
	});
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
		Materialize.toast('Selecione apenas um documento para impressão!', 5000)
	}else{
		window.open(path+"mdfeSefaz/imprimir/"+id, "_blank");
	}
}

function consultarMDFe(id){
	$('#btn_consulta_grid_'+id).addClass('spinner');
	$('#btn_consulta_grid_'+id).addClass('disabled');
	
	let token = $('#_token').val();
	$.ajax
	({
		type: 'POST',
		data: {
			id: id,
			_token: token
		},
		url: path + 'mdfeSefaz/consultar',
		dataType: 'json',
		success: function(js){
			$('#btn_consulta_grid_'+id).removeClass('spinner');
			$('#btn_consulta_grid_'+id).removeClass('disabled');
			console.log(js)
			console.log(js.xMotivo)

			swal("Sucesso", "Status: " + js.xMotivo + " - chave: " + js.protMDFe.infProt.chMDFe + ", protocolo: " + js.protMDFe.infProt.nProt, "success")

		}, error: function(e){
			console.log(e)
			swal("Erro", "Veja o console do navegador!", "error")
			$('#btn_consulta_grid_'+id).removeClass('spinner');
			$('#btn_consulta_grid_'+id).removeClass('disabled');
		}
	});
	
}

function consultar(){
	$('#btn-consultar').addClass('spinner');
	$('#btn-consultar').addClass('disabled');
	let id = 0;
	let cont = 0;
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			id = $(this).find('#id').html();
			cont++;
		}
	})

	if(cont > 1){
		Materialize.toast('Selecione apenas um documento para consultar!', 5000)
	}else{
		let token = $('#_token').val();
		$.ajax
		({
			type: 'POST',
			data: {
				id: id,
				_token: token
			},
			url: path + 'mdfeSefaz/consultar',
			dataType: 'json',
			success: function(js){
				$('#btn-consultar').removeClass('spinner');
				$('#btn-consultar').removeClass('disabled');
				console.log(js)
				console.log(js.xMotivo)
				
				swal("Sucesso", "Status: " + js.xMotivo + " - chave: " + js.protMDFe.infProt.chMDFe + ", protocolo: " + js.protMDFe.infProt.nProt, "success")

			}, error: function(e){
				console.log(e)
				swal("Erro", "Veja o console do navegador!", "error")
				$('#btn-consultar').removeClass('spinner');
				$('#btn-consultar').removeClass('disabled');
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
			nf = $(this).find('#numero').html();
			$('#numero_cancelamento').html(nf)
			$('#numero_correcao').html(nf)
			$('#numero_nf').html(nf)
			$('#numero_cte').val(nf)


			cont++;
		}
	})
	
	if(cont > 1){
		Materialize.toast('Selecione apenas um documento para continuar!', 5000)
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
		Materialize.toast('Selecione apenas um documento para continuar!', 5000)
	}else{

		$.get(path+'cteSefaz/consultar_cliente/'+id)
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

function cancelarMDFe(id, numero){
	$('#modal1_aux').modal('show')
	$('#numero_cancelamento2').html(numero)
	$('#id_cancela').val(id)
}

function cancelar2(){
	$('#btn-cancelar-3').addClass('spinner')
	$('#btn-cancelar-3').addClass('disabled')
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
		url: path + 'mdfeSefaz/cancelar',
		dataType: 'json',
		success: function(js){
			console.log(js)
			$('#btn-cancelar-3').removeClass('spinner');
			$('#btn-cancelar-3').removeClass('disabled');


			swal("Sucesso", js.infEvento.xMotivo, "success")
			.then(() => {
				location.reload()
			})

		}, error: function(e){
			$('#btn-cancelar-3').removeClass('spinner');
			$('#btn-cancelar-3').removeClass('disabled');
			let js = e.responseJSON;
			console.log(js)

			swal("Erro", js.infEvento.xMotivo, "error")

		}
	});
}

function cancelar(){
	$('#btn-cancelar-2').addClass('spinner');
	$('#btn-cancelar-2').addClass('disabled');
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
		Materialize.toast('Selecione apenas um documento para cancelar!', 5000)
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
			url: path + 'mdfeSefaz/cancelar',
			dataType: 'json',
			success: function(js){
				console.log(js)
				$('#btn-cancelar-2').removeClass('spinner');
				$('#btn-cancelar-2').removeClass('disabled');


				swal("Sucesso", js.infEvento.xMotivo, "success")
				.then(() => {
					location.reload()
				})

			}, error: function(e){
				$('#btn-cancelar-2').removeClass('spinner');
				$('#btn-cancelar-2').removeClass('disabled');
				let js = e.responseJSON;
				console.log(js)

				swal("Erro", js.infEvento.xMotivo, "error")

			}
		});
	}
}

function reload(){
	location.reload();
}

$(function () {
	validaBtns();
	var w = window.innerWidth
	if(w < 900){
		$('#grade').trigger('click')
	}
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
		desabilitaBotoes(cont);
	}else{
		habilitaBotoes();
		if(estado == 'NOVO'){
			$('#btn-enviar').removeClass("disabled");
			$('#btn-imprimir').addClass("disabled");
			$('#btn-consultar').addClass("disabled");
			$('#btn-cancelar').addClass("disabled");
			$('#btn-inutilizar').removeClass("disabled");
			$('#btn-correcao').addClass("disabled");
			$('#btn-xml').addClass("disabled");


		} else if(estado == 'REJEITADO'){
			$('#btn-enviar').removeClass("disabled");
			$('#btn-imprimir').addClass("disabled");
			$('#btn-inutilizar').removeClass("disabled");
			$('#btn-correcao').addClass("disabled");

			$('#btn-consultar').removeClass("disabled");
			$('#btn-cancelar').addClass("disabled");
			$('#btn-xml').addClass("disabled");


		} else if(estado == 'CANCELADO'){
			$('#btn-enviar').addClass("disabled");
			$('#btn-inutilizar').addClass("disabled");
			$('#btn-correcao').addClass("disabled");
			$('#btn-imprimir').addClass("disabled");
			$('#btn-consultar').removeClass("disabled");
			$('#btn-cancelar').addClass("disabled");
			$('#btn-xml').addClass("disabled");


		} else if(estado == 'APROVADO'){
			$('#btn-enviar').addClass("disabled");
			$('#btn-inutilizar').addClass("disabled");
			$('#btn-imprimir').removeClass("disabled");
			$('#btn-consultar').removeClass("disabled");
			$('#btn-cancelar').removeClass("disabled");
			$('#btn-correcao').removeClass("disabled");
			$('#btn-xml').removeClass("disabled");
		}

	}
}

function desabilitaBotoes(cont){
	$('#btn-enviar').addClass("disabled");
	$('#btn-imprimir').addClass("disabled");
	$('#btn-consultar').addClass("disabled");
	$('#btn-cancelar').addClass("disabled");
	$('#btn-correcao').addClass("disabled");
	$('#btn-inutilizar').addClass("disabled");
	$('#btn-xml').addClass("disabled");

	if(cont == 0) $('#btn-inutilizar').removeClass("disabled");

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
	let id = 0
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked'))
			id = $(this).find('#id').html();
	})
	console.log(id);
	
	
	let email = $('#email').val();

	$.get(path+'mdfeSefaz/enviarXml', {id: id, email: email})
	.done(function(data){
		console.log(data)
		$('#btn-send').removeClass('spinner');
		$('#btn-send').removeClass('disabled');

		swal("Sucesso", "Email enviado com sucesso!", "success")
		.then(() => {
			$('#modal5').modal('hide')
		})
	})
	.fail(function(err){
		console.log(err)
		$('#btn-send').removeClass('spinner');
		$('#btn-send').removeClass('disabled');
		swal("Erro", "ao enviar email!", "error")
		
	})
}


