var PRODUTOS = []
$(function () {
	let p = $('#produtos').val()
	if(p){
		PRODUTOS = JSON.parse(p)
		console.log(PRODUTOS)
	}

	var w = window.innerWidth
	if(w < 900){
		$('#grade').trigger('click')
	}


})

$('#kt_select2_1').change(() => {
	let id = $('#kt_select2_1').val()
	PRODUTOS.map((p) => {
		if(id == p.id){
			$('#valor').val(p.valor_venda.replace(".", ','))
			$('#quantidade').val('1,000')
			calcSubtotal();
		}
	})
})

$('#valor').on('keyup', () => {
	calcSubtotal()
})

function maskMoney(v){
	return v.toFixed(2);
}

function calcSubtotal(){
	let quantidade = $('#quantidade').val();
	let valor = $('#valor').val();
	let subtotal = parseFloat(valor.replace(',','.'))*(quantidade.replace(',','.'));
	console.log(subtotal)
	let sub = maskMoney(subtotal)
	$('#subtotal').val(sub)
}

function getProdutos(data){
	$.ajax
	({
		type: 'GET',
		url: path + 'produtos/all',
		dataType: 'json',
		success: function(e){
			data(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

function setaEmail(){
	buscarDadosCliente();
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

function getProduto(id, data){
	console.log(id)
	$.ajax
	({
		type: 'GET',
		url: path + 'produtos/getProduto/'+id,
		dataType: 'json',
		success: function(e){
			data(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

function enviarEmail(){	

	$('#btn-send-email').addClass('spinner');
	$('#btn-send-email').addClass('disabled');

	let id = 0;
	let cont = 0;
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			id = $(this).find('#id').html();
			cont++
		}
	})

	let email = $('#email').val();
	if(id > 0){

		$.get(path+'orcamentoVenda/enviarEmail', {id: id, email: email})
		.done(function(data){
			console.log(data)
			$('#btn-send-email').removeClass('disabled');
			$('#btn-send-email').removeClass('spinner');

			swal("Sucesso", 'Email enviado com sucesso!', "success")
			.then(() => {
				location.reload()
			})

		})
		.fail(function(err){
			console.log(err)
			$('#btn-send-email').removeClass('disabled');
			$('#btn-send-email').removeClass('spinner');
			swal("Erro", 'Erro ao enviar email!', "warning")
		})
	}else{	
		$('#modal5').modal('hide')
		swal("Erro", "Escolha um orçamento na lista!!", "error")
	}
}

$('#btn-danfe').click(() => {
	let id = 0
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked'))
			id = $(this).find('#id').html();
	})

	if(id > 0){
		window.open(path + 'orcamentoVenda/rederizarDanfe/' + id);
	}else{
		swal("Erro", "Escolha um orçamento na lista!!", "error")
	}

})

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
		if(id > 0){
			window.open(path+"orcamentoVenda/imprimir/"+id, "_blank");
		}else{
			swal("Erro", "Escolha um orçamento na lista!!", "error")
		}
	}
}

function imprimirCompleto(){
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
		window.open(path+"orcamentoVenda/imprimirCompleto/"+id, "_blank");
	}
}

function modalWhatsApp(){
	$('#modal-whatsApp').modal('show')
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

function enviarEmailGrid(id){
	$('#modal5-grid').modal('show')
	$.get(path+'nf/consultar_cliente/'+id)
	.done(function(data){
		data = JSON.parse(data)
		console.log(data.email)
		$('#email-grid').val(data.email)

		if(data.email){
			$('#info-email-grid').html('*Este é o email do cadastro');
		}else{
			$('#info-email-grid').html('*Este cliente não possui email cadastrado');
		}
	})
	.fail(function(err){
		console.log(err)
	})
}

function enviarEmail2(){

	$('#btn-send-email2').addClass('disabled');
	$('#btn-send-email2').addClass('spinner');

	let id = 0;
	let cont = 0;
	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			id = $(this).find('#id').html();
			cont++
		}
	})

	let email = $('#email-grid').val();

	$.get(path+'orcamentoVenda/enviarEmail', {id: id, email: email})
	.done(function(data){
		console.log(data)
		$('#btn-send-email2').removeClass('disabled');
		$('#btn-send-email2').removeClass('spinner');
		// alert('Email enviado com sucesso!');
		swal("Sucesso", 'Email enviado com sucesso!', "success")
		.then(() => {
			location.reload()
		})

	})
	.fail(function(err){
		console.log(err)
		$('#btn-send-email2').removeClass('disabled');
		$('#btn-send-email2').removeClass('spinner');
		// alert('Erro ao enviar email!')
		swal("Erro", 'Erro ao enviar email!', "warning")

	})
}