
let TOTAL = 0;


$(function () {
	$('#value').val('');
	$('#payment_form').val('');
	$('#responsible').val('');
});

$('.value').keyup(function(){
	var total = 0;
	$('#cotacao tbody tr.itens').each(function(item, value){
		var value = $(this).find('#value').val();
		value = value.replace(",", ".");
		var quantity = $(this).find('#quantity').html();
		console.log(value)
		if(!value){
			$(this).find('#total').html(formatReal(0));
		}else{
			if(value){
				TOTAL = total += (parseFloat(value) * parseFloat(quantity));
				$(this).find('#total').html(formatReal((parseFloat(value) * parseFloat(quantity))));
			}
		}

	});

	$("#totalMax").html(formatReal(total));
})

function formatReal(v)
{
	return v.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});;
}

$("#salvar").click(function(){
	verificaCampos(function(next){
		if(next){
			montarJs(function(js){
				console.log(js)
				$.ajax
				({
					type: 'POST',
					data: {
						js: js,
						_token: $("#_token").val()
					},
					url: path + 'responseSave',
					dataType: 'json',
					success: function(data){
						console.log(data)
						if(data){
							sucesso();
						}else{
							M.toast({html: 'ERRO AO ENVIAR COTAÇÃO'})
						}

					}, error: function(e){
						console.log(e)
					}
				})
			})
			
		}
	})

})

function sucesso(){
	$('#content').css('display', 'none');
	$('#anime').css('display', 'block');
	setTimeout(() => {
		// location.href = 'http://google.com.br';
	}, 4000)
}

function verificaCampos(callback){
	var _return = true;
	$('#cotacao tbody tr.itens').each(function(item, value){

		var value = $(this).find('#value').val();

		if(value.length == 0){
			if(_return)
				M.toast({html: 'INFORME O VALOR PARA LINHA ' + (item+1) + ' DA TABELA'})
			_return = false;
		}
	});

	if(_return){
		if($("#responsible").val().length <= 0){
			M.toast({html: 'INFORME O RESPONSAVEL'})
			_return = false;
		}
	}

	callback(_return);
}

function montarJs(callback){
	itens = [];
	$('#cotacao tbody tr.itens').each(function(item, value){

		var id = $(this).find('#id_prod').html();
		var valor = $(this).find('#value').val();
		var obs = $(this).find('#note').val();

		var temp = {
			id: id,
			valor: valor,
			obs: obs
		};

		itens.push(temp);
		
		
	});

	var priceId = $("#priceId").val();
	var paymentForm = $("#payment_form").val();
	var responsible = $("#responsible").val();
	

	let js = { 
		itens: itens,
		total: TOTAL, 
		cotacao_id: priceId, 
		forma_pagamento: paymentForm,
		resposavel: responsible
	};

	callback(js);
}