
$(function () {
	getFornecedores(function(data){
	    $('input.autocomplete-fornecedor').autocomplete({
	      data: data,
	      limit: 20, 
	      onAutocomplete: function(val) {
	        var funcionario = $('#autocomplete-fornecedor').val().split('|');

	      },
	      minLength: 1,
	    });
	});


});

function getFornecedores(data){
  $.ajax
  ({
    type: 'GET',
    url: path + 'fornecedores/all',
    dataType: 'json',
      success: function(e){
       // console.log(e);
        data(e)

      }, error: function(e){
        console.log(e)
      }

  });
}
