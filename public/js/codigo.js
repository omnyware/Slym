
$(function () {

	getClientes(function(data){
	    $('input.autocomplete-cliente').autocomplete({
	      data: data,
	      limit: 20, 
	      onAutocomplete: function(val) {
	        var cliente = $('#autocomplete-cliente').val().split('|');

	      },
	      minLength: 1,
	    });
	});


});

function getClientes(data){
  $.ajax
  ({
    type: 'GET',

    url: path + 'clienteDelivery/all',
    dataType: 'json',
      success: function(e){
       // console.log(e);
        data(e)

      }, error: function(e){
        console.log(e)
      }

  });
}

$('#gerar-codigo').click(() => {

  let v = (Math.floor(Math.random() * 888888)+111111 )
  $('#codigoPromocional').val(v)
  Materialize.updateTextFields();
})