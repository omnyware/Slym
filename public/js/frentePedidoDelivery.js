$(function () {

	getClientes(function(data){
		$('input.autocomplete-cliente').autocomplete({
			data: data,
			limit: 20, 
			onAutocomplete: function(val) {
				var cliente = $('#autocomplete-cliente').val().split(' - ');
				console.log(cliente[0])
				abrirPedido(parseInt(cliente[0]));
			},
			minLength: 1,
		});
	});


});

$('#kt_select2_3').change(() => {
	let id = $('#kt_select2_3').val()
	abrirPedido(parseInt(id));
})

function getClientes(data){
	$.ajax
	({
		type: 'GET',
		url: path + 'pedidosDelivery/clientes',
		dataType: 'json',
		success: function(e){
			console.log(e);
			data(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

function abrirPedido(cliente){
	
	$.post(path + 'pedidosDelivery/abrirPedidoCaixa', {cliente: cliente ,_token: $('#token').val()})
	.done((success) => {
		console.log(success)
		location.href = path + 'pedidosDelivery/frenteComPedido/'+success.id
	})
	.fail((err) => {
		console.log(err)
	})
}

$('#endereco').change(() => {
	let endereco = $('#endereco').val();
	let pedido_id = $('#pedido_id').val();

	$.post(path + 'pedidosDelivery/setEnderecoCaixa', 
	{
		endereco: endereco, 
		pedido_id: pedido_id, 
		_token: $('#token').val()
	})
	.done((success) => {
		console.log(success)
		location.href = path + 'pedidosDelivery/frenteComPedido/'+success.id
	})
	.fail((err) => {
		console.log(err)
	})
})
