
$(function () {

	getFuncionarios(function(data){
	    $('input.autocomplete-funcionario').autocomplete({
	      data: data,
	      limit: 20, 
	      onAutocomplete: function(val) {
	        var funcionario = $('#autocomplete-funcionario').val().split('|');

	      },
	      minLength: 1,
	    });
	});


});

function getFuncionarios(data){
  $.ajax
  ({
    type: 'GET',
    url: path + 'funcionarios/all',
    dataType: 'json',
      success: function(e){
       // console.log(e);
        data(e)

      }, error: function(e){
        console.log(e)
      }

  });
}
