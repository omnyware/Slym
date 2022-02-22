
$(function () {

	getModelos(function(data){
	    $('input.autocomplete-modelo').autocomplete({
	      data: data,
	      limit: 20, 
	      onAutocomplete: function(val) {
          if($('#autocomplete-produto').val().length > 1)
	        setDescricao();
	      },
	      minLength: 1,
	    });
	});

	getProdutos(function(data){
	    $('input.autocomplete-produto').autocomplete({
	      data: data,
	      limit: 20, 
	      onAutocomplete: function(val) {
          if($('#autocomplete-modelo').val().length > 1)
	        setDescricao();
	      },
	      minLength: 1,
	    });
	});


});

function setDescricao(){
  let servico = $('#autocomplete-produto').val().split('-');
  let modelo = $('#autocomplete-modelo').val().split('-');
          
  let description = servico[1] + ", Modelo: " + modelo[1];
  $('#description').val(description);
  alert("Setando uma sugestao de descrição de serviço!");
}

function getModelos(data){
  $.ajax
  ({
    type: 'GET',
    url: path + 'modelos/all',
    dataType: 'json',
      success: function(e){
       // console.log(e);
        data(e)

      }, error: function(e){
        console.log(e)
      }

  });
}

function getProdutos(data){
  $.ajax
  ({
    type: 'GET',
    url: path + 'produtos/all',
    dataType: 'json',
      success: function(e){
       // console.log(e);
        data(e)

      }, error: function(e){
        console.log(e)
      }

  });
}

$('#autocomplete-produto').on('key')