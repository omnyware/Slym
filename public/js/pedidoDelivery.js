$('#btn-enviar-push').click(() => {

	let titulo = $('#titulo-push').val();
	let texto = $('#texto-push').val();
	let imagem = $('#imagem-push').val();

	let js = {
		titulo: titulo,
		texto: texto,
		imagem: imagem,
		cliente: $('#cliente').val(),
		_token: $('#token').val()
	}
	console.log(path)
	$.post(path+'pedidosDelivery/sendPush', js)
	.done((success) => {
		console.log(success)
		alert('Push Enviado')
		$('#modal-push').modal('close')

	})
	.fail((err) => {
		console.log(err)
		alert('Erro ao enviar Push')
	})
})

function setaTelefone(telefone){
	telefone = telefone.replace(" ", "").replace("-", "")
	$('#telefone-sms').val(telefone)
	$('#modal-sms').modal('show')
}

$('#btn-enviar-sms').click(() => {

	$('#btn-enviar-sms').addClass('spinner')
	let texto = $('#texto-sms').val();
	let telefone = $('#telefone-sms').val();

	let js = {
		telefone: telefone,
		texto: texto,
		cliente: $('#cliente').val(),
		_token: $('#token').val()
	}
	console.log(js)
	$.post(path+'pedidosDelivery/sendSms', js)
	.done((success) => {
		$('#btn-enviar-sms').removeClass('spinner')

		console.log(success)
		swal("Sucesso", "SMS Enviado!!", "success")
		$('#modal-sms').modal('hide')

	})
	.fail((err) => {
		$('#btn-enviar-sms').removeClass('spinner')
		console.log(err)
		swal("Erro", "Erro ao enviar SMS!!", "error")

	})
})

function consultar(codigo){
	$('#btn-pgseguro').addClass('spinner')
	console.log(codigo)
	$.get(path + "/pagseguro/consultaJS", {codigo: codigo})
	.done((success) => {
		$('#btn-pgseguro').removeClass('spinner')
		console.log(success)
		let status = success.status[0];
		let referencia = success.referencia[0];
		let total = success.total[0];
		let taxa = success.taxa[0];

		if(status == '3'){
			status = 'Aprovada';
		}else{
			status = 'Reprovada ' + status;
		}

		$('#status').html(status)
		$('#referencia').html(referencia)
		$('#total').html(total)
		$('#taxa').html(taxa)
		$('#modal-consulta').modal('show');
	})
	.fail((err) => {
		$('#btn-pgseguro').removeClass('spinner')
		console.log(err)
		alert("Ocorreu um erro ao consultar o código: " + codigo)
	})
}