

function redireciona(){
	location.href= path + "cte";
}

function enviar(){
	$('#btn-enviar').addClass('spinner');
	$('#btn-enviar').addClass('disabled');
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
		url: path + 'cteSefaz/enviar',
		dataType: 'json',
		success: function(e){
			$('#btn-enviar').removeClass('spinner');
			$('#btn-enviar').removeClass('disabled');

			console.log(e)
			let recibo = e;
			let retorno = recibo.substring(0,4);
			let mensagem = recibo.substring(5,recibo.length);
			if(retorno == 'Erro'){
				let m = JSON.parse(mensagem);
				swal("Erro", "[" + m.protCTe.infProt.cStat + "] : " + m.protCTe.infProt.xMotivo, "error")
				.then(() => {
					location.reload()
				})
			}
			else if(e == 'Apro'){
				// alert("Esta CT-e já esta aprovada, não é possível enviar novamente!");
				swal("Cuidado!", "Esta CT-e já esta aprovada, não é possível enviar novamente!", "warning")

			}
			else{
				swal("Sucesso", "CT-e gerada com sucesso RECIBO: "+recibo, "success")
				.then(() => {
					window.open(path+"cteSefaz/imprimir/"+id, "_blank");
					location.href= path + "cte";
				})
				// location.href= path + "cte";
			}

		}, error: function(e){
			console.log(e)
			$('#btn-enviar').removeClass('spinner');
			$('#btn-enviar').removeClass('disabled');
			if(e.status == 401){
				swal("Erro", "teste", "error")

			}else{
				swal("Erro", "Erro verifique o console do navegador", "error")
			}
			
		}
	});
	
}

function transmitirCTe(id){
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
		url: path + 'cteSefaz/enviar',
		dataType: 'json',
		success: function(e){
			$('#btn-btn_transmitir_grid_'+id).removeClass('spinner');
			$('#btn-btn_transmitir_grid_'+id).removeClass('disabled');

			console.log(e)
			let recibo = e;
			let retorno = recibo.substring(0,4);
			let mensagem = recibo.substring(5,recibo.length);
			if(retorno == 'Erro'){
				let m = JSON.parse(mensagem);
				swal("Erro", "[" + m.protCTe.infProt.cStat + "] : " + m.protCTe.infProt.xMotivo, "error")
				.then(() => {
					location.reload()
				})
			}
			else if(e == 'Apro'){
				// alert("Esta CT-e já esta aprovada, não é possível enviar novamente!");
				swal("Cuidado!", "Esta CT-e já esta aprovada, não é possível enviar novamente!", "warning")

			}
			else{
				swal("Sucesso", "CT-e gerada com sucesso RECIBO: "+recibo, "success")
				.then(() => {
					window.open(path+"cteSefaz/imprimir/"+id, "_blank");
					location.href= path + "cte";
				})
				// location.href= path + "cte";
			}

		}, error: function(e){
			console.log(e)
			$('#btn-btn_transmitir_grid_'+id).removeClass('spinner');
			$('#btn-btn_transmitir_grid_'+id).removeClass('disabled');
			if(e.status == 401){
				swal("Erro", "teste", "error")

			}else{
				swal("Erro", "Erro verifique o console do navegador", "error")
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
		swal("Erro", "Selecione apenas um documento para impressão!", "error")

	}else{
		window.open(path+"cteSefaz/imprimir/"+id, "_blank");
	}
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
		swal("Erro", "Selecione apenas um documento para impressão!", "error")

	}else{
		window.open(path+"cteSefaz/imprimirCCe/"+id, "_blank");
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
		swal("Erro", "Selecione apenas um documento para impressão!", "error")

	}else{
		window.open(path+"cteSefaz/imprimirCancela/"+id, "_blank");
	}
}

function xmlTemp(){
	let id = 0;
	let cont = 0;
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			id = $(this).find('#id').html();
			cont++
		}
	})

	if(cont > 1){
		swal("Erro", "Selecione apenas um documento para gerar!", "error")

	}else{
		window.open(path+"cteSefaz/xmlTemp/"+id, "_blank");
	}
}

function consultar(){
	let id = 0;
	let cont = 0;
	$('#btn-consultar').addClass('spinner')
	$('#btn-consultar').addClass('disabled')
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			id = $(this).find('#id').html();
			cont++;
		}
	})

	if(cont > 1){
		swal("Erro", "Selecione apenas um documento para consultar!", "error")

	}else{
		let token = $('#_token').val();
		$.ajax
		({
			type: 'POST',
			data: {
				id: id,
				_token: token
			},
			url: path + 'cteSefaz/consultar',
			dataType: 'json',
			success: function(e){
				console.log(e)
				let js = JSON.parse(e)
				console.log(js)
				$('#btn-consultar').removeClass('spinner')
				$('#btn-consultar').removeClass('disabled')
				swal("Sucesso", "Status: " + js.xMotivo + " - chave: " + js.protCTe.infProt.chCTe + ", protocolo: " + js.protCTe.infProt.nProt, "success")

			}, error: function(e){
				console.log(e)
				swal("Erro", "Erro consulte o console", "error")
				$('#btn-consultar').removeClass('spinner')
				$('#btn-consultar').removeClass('disabled')
			}
		});
	}
}

function cancelarCTe(id, nf){
	$('#modal1_aux').modal('show')
	$('#numero_cancelamento2').html(nf)
	$('#id_cancela').val(id)
}

function corrigirCTe(id, nf){
	$('#modal4_aux').modal('show')
	$('#numero_correcao_aux').html(nf)
	$('#id_correcao').val(id)
}

function consultarCTe(id){
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
		url: path + 'cteSefaz/consultar',
		dataType: 'json',
		success: function(e){
			console.log(e)
			let js = JSON.parse(e)
			console.log(js)
			$('#btn_consulta_grid_'+id).removeClass('spinner')
			$('#btn_consulta_grid_'+id).removeClass('disabled')
			swal("Sucesso", "Status: " + js.xMotivo + " - chave: " + js.protCTe.infProt.chCTe + ", protocolo: " + js.protCTe.infProt.nProt, "success")

		}, error: function(e){
			console.log(e)
			swal("Erro", "Erro consulte o console", "error")
			$('#btn_consulta_grid_'+id).removeClass('spinner')
			$('#btn_consulta_grid_'+id).removeClass('disabled')
		}
	});

}

function setarNumero(buscarCliente = false){
	let id = 0;
	let nf = 0;
	let cont = 0;
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			nf = $(this).find('#cte_numero').html();
			id = $(this).find('#id').html();
			$('#numero_cancelamento').html(nf)
			$('#numero_email').html(nf)
			$('#numero_correcao').html(nf)
			$('#numero_nf').html(nf)
			$('#numero_cte').val(nf)

			console.log(nf)

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

function cancelar(){
	$('#btn-cancelar-2').addClass('spinner')
	$('#btn-cancelar-2').addClass('disabled')
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
			url: path + 'cteSefaz/cancelar',
			dataType: 'json',
			success: function(e){
				let js = JSON.parse(e);
				console.log(js)
				$('#btn-cancelar-2').removeClass('spinner')
				$('#btn-cancelar-2').removeClass('disabled')

				if(js.infEvento.cStat == '101' || js.infEvento.cStat == '135' || js.infEvento.cStat == '155'){
					window.open(path+"cteSefaz/imprimirCancela/"+id, "_blank");
					swal("Sucesso", js.infEvento.xMotivo, "success")
				}else{
					swal("Erro", js.infEvento.xMotivo, "error")
				}

			}, error: function(e){
				console.log(e)
				$('#btn-cancelar-2').removeClass('spinner')
				$('#btn-cancelar-2').removeClass('disabled')
				swal("Erro", "Erro veja o console do navegador", "error")
			}
		});
	}
}

function cancelar2(){
	$('#btn-cancelar-3').addClass('spinner')
	$('#btn-cancelar-3').addClass('disabled')
	let id = $('#id_cancela').val();
	let token = $('#_token').val();
	let justificativa = $('#justificativa2').val();
	$.ajax
	({
		type: 'POST',
		data: {
			id: id,
			justificativa: justificativa,
			_token: token
		},
		url: path + 'cteSefaz/cancelar',
		dataType: 'json',
		success: function(e){
			let js = JSON.parse(e);
			console.log(js)
			$('#btn-cancelar-3').removeClass('spinner')
			$('#btn-cancelar-3').removeClass('disabled')

			if(js.infEvento.cStat == '101' || js.infEvento.cStat == '135' || js.infEvento.cStat == '155'){
				swal("Sucesso", js.infEvento.xMotivo, "success")
				.then(() => {
					window.open(path+"cteSefaz/imprimirCancela/"+id, "_blank");
					location.reload()
				})
			}else{
				swal("Erro", js.infEvento.xMotivo, "error")
			}

		}, error: function(e){
			console.log(e)
			$('#btn-cancelar-3').removeClass('spinner')
			$('#btn-cancelar-3').removeClass('disabled')
			swal("Erro", "Erro veja o console do navegador", "error")
		}
	});

}

function reload(){
	location.reload();
}

function cartaCorrecao(){
	$('#btn-corrigir-2').addClass('spinner');
	$('#btn-corrigir-2').addClass('disabled');

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
		let token = $('#_token').val();
		$.ajax
		({
			type: 'POST',
			data: {
				id: id,
				correcao: $('#correcao').val(),
				grupo: $('#grupo').val(),
				campo: $('#campo').val(),
				_token: token
			},
			url: path + 'cteSefaz/cartaCorrecao',
			dataType: 'json',
			success: function(e){
				console.log(e)
				let js = JSON.parse(e);
				console.log(js)
				$('#btn-corrigir-2').removeClass('spinner');
				$('#btn-corrigir-2').removeClass('disabled');
				// alert(js.infEvento.xMotivo)
				if(js.infEvento.cStat == '135'){
					swal("Sucesso", js.infEvento.xMotivo, "success")
					.then(() => {
						window.open(path+"cteSefaz/imprimirCCe/"+id, "_blank");
						location.reload()
					})
				}else{
					swal("Erro", js.infEvento.xMotivo, "error")

				}
				
			}, error: function(e){
				console.log(e)
				swal("Erro", "Consulte o console do navegador!", "error")
				$('#btn-corrigir-2').removeClass('spinner');
				$('#btn-corrigir-2').removeClass('disabled');
			}
		});
	}
}

function cartaCorrecaoAux(){
	$('#btn-corrigir-3').addClass('spinner');
	$('#btn-corrigir-3').addClass('disabled');

	let id = $('#id_correcao').val()
	
	let token = $('#_token').val();

	let js = {
		id: id,
		correcao: $('#correcao2').val(),
		grupo: $('#grupo2').val(),
		campo: $('#campo2').val(),
		_token: token
	}
	console.log(js)
	$.ajax
	({
		type: 'POST',
		data: js,
		url: path + 'cteSefaz/cartaCorrecao',
		dataType: 'json',
		success: function(e){
			console.log(e)
			let js = JSON.parse(e);
			console.log(js)
			$('#btn-corrigir-3').removeClass('spinner');
			$('#btn-corrigir-3').removeClass('disabled');

			if(js.infEvento.cStat == '135'){
				swal("Sucesso", js.infEvento.xMotivo, "success")
				.then(() => {
					window.open(path+"cteSefaz/imprimirCCe/"+id, "_blank");
					location.reload()
				})
			}else{
				swal("Erro", js.infEvento.xMotivo, "error")

			}

		}, error: function(e){
			console.log(e)
			swal("Erro", "Consulte o console do navegador!", "error")
			$('#btn-corrigir-3').removeClass('spinner');
			$('#btn-corrigir-3').removeClass('disabled');
		}
	});
	
}

function inutilizar(){

	let justificativa = $('#justificativa-inut').val();
	let nInicio = $('#nInicio').val();
	let nFinal = $('#nFinal').val();

	console.log(nInicio)
	console.log(nFinal)
	
	$('#btn-inut-2').addClass('spinner');
	$('#btn-inut-2').addClass('disabled');


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
		url: path + 'cteSefaz/inutilizar',
		dataType: 'json',
		success: function(js){
			console.log(js)

			$('#btn-inut-2').removeClass('spinner');
			$('#btn-inut-2').removeClass('disabled');

			console.log(js.infInut.cStat)
			if(js.infInut.cStat == '102' || js.infInut.cStat == '135' || js.infInut.cStat == '155'){

				swal("Sucesso", js.infInut.xMotivo, "success")
				.then(() => {
					$('#modal3').modal('hide')
				})
				
			}else{

				swal("Erro", "[" + js.infInut.cStat + "] - " + js.infInut.xMotivo, "error")

			}

		}, error: function(e){
			console.log(e)
			swal("Erro", "Consulte o console do navegador!", "error")

			$('#btn-inut-2').removeClass('spinner');
			$('#btn-inut-2').removeClass('disabled');
		}
	});
	
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
		if(estado == 'DISPONIVEL'){
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
	$('#btn-send').addClass('spinner')
	$('#btn-send').addClass('disabled')
	let id = 0;
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked'))
			id = $(this).find('#id').html();
	})

	let email = $('#email').val();

	$.get(path+'cteSefaz/enviarXml', {id: id, email: email})
	.done(function(data){
		console.log(data)
		$('#btn-send').removeClass('spinner')
		$('#btn-send').removeClass('disabled')
		// alert('Email enviado com sucesso!');
		swal("Sucesso", "Email enviado com sucesso!", "success")
		.then(() => {
			$('#modal5').modal('hide')
		})

	})
	.fail(function(err){
		console.log(err)
		$('#btn-send').removeClass('spinner')
		$('#btn-send').removeClass('disabled')
		// alert('Erro ao enviar email!')
		swal("Erro", "Erro ao enviar email!", "error")

	})
}


