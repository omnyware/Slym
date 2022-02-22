$('#testar').click(() => {

	$('#testar').addClass('spinner')

	$.ajax
	({
		type: 'GET',
		url: path + 'configNF/teste',
		dataType: 'json',
		success: function(e){
			if(e.status == 200){
				// alert('Ambiente ok')
				swal("Sucesso", 'Ambiente ok', "success")
				$('#testar').removeClass('spinner')

			}
		}, error: function(e){
			if(e.status == 200){
				$('#testar').removeClass('spinner')

				// alert('Ambiente ok')
				swal("Sucesso", 'Ambiente ok', "success")
				.then((v) => {

					alert(e.responseText)
				})

			}else{
				$('#testar').removeClass('spinner')

				// alert('Algo esta errado, verifique o console do navegador!')
				swal("Erro", 'Algo esta errado, verifique o console do navegador!', "warning")

				console.log(e)
			}

		}
	});
})

$('#testarEmail').click(() => {

	$('#preloaderEmail').css('display', 'block')

	$.get(path + 'configNF/testeEmail')
	.done((success) => {
		$('#preloaderEmail').css('display', 'none')
		swal("Sucesso", 'Config de email OK', "success")
	}).fail((e) => {
		let err = e.responseJSON
		$('#preloaderEmail').css('display', 'none')
		console.log(err)

		swal("Erro", err, "error")
	})

})