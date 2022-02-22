
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
    url: path + 'clientes/all',
    dataType: 'json',
      success: function(e){
       // console.log(e);
        data(e)

      }, error: function(e){
        console.log(e)
      }

  });
}
