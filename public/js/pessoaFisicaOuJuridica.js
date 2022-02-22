
$(function () {
	if ($('#pessoaFisica').is(':checked')) {
		$('#cpf_cnpj').mask('000.000.000-00', { reverse: true });
		$('#lbl_cpf_cnpj').html('CPF');
		$('#lbl_ie_rg').html('RG');

		$('#btn-consulta-cadastro').css('display', 'none')
	} else {
		$('#cpf_cnpj').mask('00.000.000/0000-00', { reverse: true });
		$('#lbl_cpf_cnpj').html('CNPJ');
		$('#lbl_ie_rg').html('IE');
		$('#btn-consulta-cadastro').css('display', 'block');

	}

});

$('#pessoaFisica').click(function () {
	$('#lbl_cpf_cnpj').html('CPF');
	// $('#lbl_ie_rg').html('RG');
	$('#cpf_cnpj').mask('000.000.000-00', { reverse: true });
	$('#btn-consulta-cadastro').css('display', 'none')

})

$('#pessoaJuridica').click(function () {
	$('#lbl_cpf_cnpj').html('CNPJ');
	// $('#lbl_ie_rg').html('IE');
	$('#cpf_cnpj').mask('00.000.000/0000-00', { reverse: true });
	$('#btn-consulta-cadastro').css('display', 'block');
});

function consultaCadastro() {
	let cnpj = $('#cpf_cnpj').val();
	let uf = $('#sigla_uf').val();
	cnpj = cnpj.replace('.', '');
	cnpj = cnpj.replace('.', '');
	cnpj = cnpj.replace('-', '');
	cnpj = cnpj.replace('/', '');

	if (cnpj.length == 14 && uf.length != '--') {
		$('#btn-consulta-cadastro').addClass('spinner')

		$.ajax
		({
			type: 'GET',
			data: {
				cnpj: cnpj,
				uf: uf
			},
			url: path + 'nf/consultaCadastro',

			dataType: 'json',

			success: function (e) {
				$('#btn-consulta-cadastro').removeClass('spinner')

				console.log(e)
				if (e.infCons.infCad) {
					let info = e.infCons.infCad;
					console.log(info)

					$('#ie_rg').val(info.IE)
					$('#razao_social').val(info.xNome)
					$('#nome_fantasia').val(info.xFant ? info.xFant : info.xNome)

					$('#rua').val(info.ender.xLgr)
					$('#numero').val(info.ender.nro)
					$('#bairro').val(info.ender.xBairro)
					let cep = info.ender.CEP;
					$('#cep').val(cep.substring(0, 5) + '-' + cep.substring(5, 9))

					findNomeCidade(info.ender.xMun, (res) => {
						let jsCidade = JSON.parse(res);
						console.log(jsCidade)
						if (jsCidade) {
							console.log(jsCidade.id + " - " + jsCidade.nome)
							$('#kt_select2_1').val(jsCidade.id).change();

						}
					})

				} else {
					//swal("Erro", e.infCons.xMotivo, "error")

					consultaAlternativa(cnpj, (data) => {
						console.log(data)
						if(data == false){
							swal("Alerta", "Nenhum retorno encontrado para este CNPJ, informe manualmente por gentileza", "warning")
						}else{
							$('#razao_social').val(data.nome)
							$('#nome_fantasia').val(data.nome)

							$('#rua').val(data.logradouro)
							$('#numero').val(data.numero)
							$('#bairro').val(data.bairro)
							let cep = data.cep;
							$('#cep').val(cep.replace(".", "").replace("-", ""))

							findNomeCidade(data.municipio, (res) => {
								let jsCidade = JSON.parse(res);
								console.log(jsCidade)
								if (jsCidade) {
									console.log(jsCidade.id + " - " + jsCidade.nome)
									$('#kt_select2_1').val(jsCidade.id).change();

								}
							})
						}
					})

					$('#btn-consulta-cadastro').removeClass('spinner')

				}
			}, error: function (e) {
				// console.log(e)
				// if(e.status == 403){
				// 	swal("Erro", e.responseJSON, "error")
				// }else if(e.status == 401){
				// 	swal("Erro", e.responseJSON, "error")
				// }else{
				// 	try{
				// 		swal("Erro", e.responseText, "error")
				// 	}catch{
				// 		swal("Erro", "Verifique o console", "error")
				// 	}
				// }
				consultaAlternativa(cnpj, (data) => {
					console.log(data)
					if(data == false){
						swal("Alerta", "Nenhum retorno encontrado para este CNPJ, informe manualmente por gentileza", "warning")
					}else{
						$('#razao_social').val(data.nome)
						$('#nome_fantasia').val(data.nome)

						$('#rua').val(data.logradouro)
						$('#numero').val(data.numero)
						$('#bairro').val(data.bairro)
						let cep = data.cep;
						$('#cep').val(cep.replace(".", "").replace("-", ""))

						findNomeCidade(data.municipio, (res) => {
							let jsCidade = JSON.parse(res);
							console.log(jsCidade)
							if (jsCidade) {
								console.log(jsCidade.id + " - " + jsCidade.nome)
								$('#kt_select2_1').val(jsCidade.id).change();

							}
						})
					}
				})

				$('#btn-consulta-cadastro').removeClass('spinner')


			}

		});
	}
}

function consultaAlternativa(cnpj, call){
	cnpj = cnpj.replace('.', '');
	cnpj = cnpj.replace('.', '');
	cnpj = cnpj.replace('-', '');
	cnpj = cnpj.replace('/', '');
	let res = null;
	$.ajax({

		url: 'https://www.receitaws.com.br/v1/cnpj/'+cnpj, 
		type: 'GET', 
		crossDomain: true, 
		dataType: 'jsonp', 
		success: function(data) 
		{ 
			$('#consulta').removeClass('spinner');
			console.log(data);
			if(data.status == "ERROR"){
				swal(data.message, "", "error")
				call(false)
			}else{
				call(data)
			}

		}, 
		error: function(e) { 
			$('#consulta').removeClass('spinner');
			console.log(e)

			call(false)

		},
	});
}

function findNomeCidade(nomeCidade, call) {
	$.get(path + '/cidades/findNome/' + nomeCidade)
	.done((success) => {
		call(success)
	})
	.fail((err) => {
		call(err)
	})
}