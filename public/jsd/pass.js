function alterarSenha(id){
	swal({
		title: "Deseja alterar a senha?",
		text: "informe a nova senha:",
		icon: "warning",
		content: "input",
		buttons: ["Não", 'Alterar'],
		dangerMode: true,
	})
	.then((v) => {
		if (v) {

			$.post(path + 'info/atualizarSenha', {
				senha: v,
				id: id,
				_token: $('#token').val()
			})
			.done((data) => {
				console.log(data)
				swal("Sucesso", 'Sua senha foi alterada com sucesso', 'success');
			})
			.fail((err) => {
				console.log(err)
				swal("Erro", 'Erro ao atualizar a senha', 'warning');

			})
		} else {

		}
	});
}