FORNECEDORES = [];
html = ''
$('#add').click(() => {
	var forn = $('#kt_select2_1').val().split('-');
	let fornecedorAtual = $('#fornecedor-atual').val();

	getFornecedor(forn[0], (d) => {

		console.log(fornecedorAtual)
		if(d.id != fornecedorAtual){
			validaDuplicidade(forn[0], (duplicidade) => {

				console.log(duplicidade)
				if(!duplicidade){
					FORNECEDORES.push(d.id);
					html += '<div class="col-4"><div class="card card-custom gutter-b bg-info"><div class="card-body"><label>'+
					'<i class="la la-check"></i>'+
					d.razao_social+
					'</label></div></div></div>';

					$('#fornecedores').html(html);

					console.log(FORNECEDORES)
					$('#btn-clonar').removeAttr('disabled');

				}else{
					swal("Erro", "Fornecedor ja adicionado!!", "error")

				}
			})
		}else{
			swal("Erro", "Esta cotação já pertence a este fornecedor!", "error")

		}

	})

})



function validaDuplicidade(id, call){
	let t = false;
	FORNECEDORES.map((v) => {
		if(v == id){
			t = true;
		}
	})
	call(t)
}


$('#btn-clonar').click(() => {
	console.log(FORNECEDORES)
	let js = {
		fornecedores: FORNECEDORES,
		cotacao: $('#cotacao').val()
	}

	console.log(js)
	let token = $('#_token').val();
	$.ajax
	({
		type: 'POST',
		data: {
			data: js,
			_token: token
		},
		url: path + 'cotacao/clonarSave',
		dataType: 'json',
		success: function(e){
			console.log(e)
			sucessoClone();
			// sucesso(e)

		}, error: function(e){
			console.log(e)
		}
	});
})

function sucessoClone(){
	$('#content').css('display', 'none');
	$('#anime').css('display', 'block');
	setTimeout(() => {
		location.href = path+'cotacao';
	}, 4000)
}