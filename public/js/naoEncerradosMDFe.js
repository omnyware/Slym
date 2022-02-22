$(function () {

})


function encerrar(){
	
	let docs = []
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			chave = $(this).find('#chave').html();
			protocolo = $(this).find('#protocolo').html();
			docs.push({
				chave: chave,
				protocolo: protocolo
			})
			
		}
	})

	if(docs.length > 0){
		$('#btn-encerrar').addClass('spinner');
		$('#btn-encerrar').addClass('disabled');
		console.log(docs)
		$.post(path + 'mdfeSefaz/encerrar', {data: docs, _token: $('#token').val()})
		.done((success) => {
			console.log(success)
			$('#btn-encerrar').removeClass('spinner');
			$('#btn-encerrar').removeClass('disabled');
			swal("Sucesso", "Documento(s) encerrados!", "success")
			.then(() => {
				location.href = path + "mdfe"
			})

		})
		.fail((err) => {
			console.log(err)
			swal("Erro", "Verifique o console do navegador!", "error")
			$('#btn-encerrar').removeClass('spinner');
			$('#btn-encerrar').removeClass('disabled');
		})
	}
}