
$(function () {
	getServicos(function(data){
	    $('input.autocomplete-servico').autocomplete({
	      data: data,
	      limit: 20, 
	      onAutocomplete: function(val) {
	        var cliente = $('#autocomplete-servico').val().split('|');

	      },
	      minLength: 1,
	    });
	});


});

function getServicos(data){
  $.ajax
  ({
    type: 'GET',
    url: path + 'servicos/all',
    dataType: 'json',
      success: function(e){
       // console.log(e);
        data(e)

      }, error: function(e){
        console.log(e)
      }

  });
}
