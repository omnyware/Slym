
function enviar(id){

	swal("Atenção", "Deseja gerar entrada fiscal desta Compra?", "warning")
	.then((v) => {
		$('#btn-enviar-nfe').addClass('spinner')
		

		let token = $('#_token').val();
		let js = {
			compra_id: id,
			natureza: $('#natureza').val(),
			tipo_pagamento: $('#tipo_pagamento').val(),
			_token: token
		}
		console.log(js)
		$.ajax
		({
			type: 'POST',
			data: js,
			url: path + 'compras/gerarEntrada',
			dataType: 'json',
			success: function(e){
				$('#btn-enviar-nfe').removeClass('spinner')

				console.log(e)

				swal("Sucesso", "NF-e de Entrada emitida com sucesso RECIBO: "+e, "success")
				.then(() => {
					window.open(path+"compras/imprimir/"+id, "_blank");
					location.reload()
				})

			}, error: function(e){
				console.log(e)
				$('#btn-enviar-nfe').removeClass('spinner')

				let js = e.responseJSON;

				try{
					let mensagem = js.substring(5,js.length);
					js = JSON.parse(mensagem)
					console.log(js)

					swal("Erro", "[" + js.protNFe.infProt.cStat + "] : " + js.protNFe.infProt.xMotivo, "warning")
				}catch{
					swal("Erro", e.responseJSON.message, "error")
				}
			}
		});
	})

}

function redireciona(){
	location.reload();
}

function cancelar(){
	$('#preloader5').css('display', 'block')
	let token = $('#_token').val();

	let js = {
		justificativa: $('#justificativa').val(),
		compra_id: $('#compra_id').val(),
		_token: token
	}
	console.log(js)

	$('#btn-cancelar').addClass('spinner')
	$.ajax
	({
		type: 'POST',
		data: js,
		url: path + 'compras/cancelarEntrada',
		dataType: 'json',
		success: function(e){
			$('#btn-cancelar').removeClass('spinner')

			console.log(e)
			let js = JSON.parse(e);
			console.log(js)

			swal("Sucesso", js.retEvento.infEvento.xMotivo, "success")
			.then(() => {

				location.reload();
			})
		}, error: function(e){
			console.log(e)
			$('#btn-cancelar').removeClass('spinner')
			swal("Erro", "Algo deu errado", "warning")

			// Materialize.toast('Erro de comunicação contate o desenvolvedor', 5000)

		}
	});
}