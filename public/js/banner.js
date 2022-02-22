$(function () {

	getProdutos(function(data){

		$('input.autocomplete-produto').autocomplete({
			data: data,
			limit: 20, 
			onAutocomplete: function(val) {
				let v = val.split('-')
				getProduto(v[0], (data) => {

					console.log(data)
					if(data.pizza.length > 0){
						setaTamanhosPizza(data)
					}else{
						$('#valor').val(data.valor)
					}

					Materialize.updateTextFields();

				})
			},
			minLength: 1,
		});
	});
})

function getProdutos(data){
	$.ajax
	({
		type: 'GET',
		url: path + 'pedidosDelivery/produtos',
		dataType: 'json',
		success: function(e){

			data(e)

		}, error: function(e){
			console.log(e)
		}

	});
}