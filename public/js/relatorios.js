$(function () {

	getClientes(function(data){
		$('input.autocomplete-cliente').autocomplete({
			data: data,
			limit: 20, 
			onAutocomplete: function(val) {
				
			},
			minLength: 1,
		});
	});


	getProdutos(function(data){
		$('input.autocomplete-produto').autocomplete({
			data: data,
			limit: 20, 
			onAutocomplete: function(val) {
				
			},
			minLength: 1,
		});
	});

});

$('#tipo_lucro').change(() => {
	let tipo = $('#tipo_lucro').val()
	if(tipo == 'detalhado'){
		$('.dt').html('Data')
		$('#lucro_col').css('display', 'none')
	}else{
		$('.dt').html('Data inicial')
		$('#lucro_col').css('display', 'block')

	}
})

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

function getClientes(data){
	$.ajax
	({
		type: 'GET',
		url: path + 'clientes/all',
		dataType: 'json',
		success: function(e){
			data(e)
		}, error: function(e){
			console.log(e)
		}

	});
}

