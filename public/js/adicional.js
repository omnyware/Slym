
$(function () {

  getAdicionais(function(data){
      $('input.autocomplete-adicional').autocomplete({
        data: data,
        limit: 20, 
        onAutocomplete: function(val) {
          var cliente = $('#autocomplete-adicional').val().split('|');

        },
        minLength: 1,
      });
  });


});

function getAdicionais(data){
  $.ajax
  ({
    type: 'GET',
    url: path + 'deliveryComplemento/all',
    dataType: 'json',
      success: function(e){
       // console.log(e);
        data(e)

      }, error: function(e){
        console.log(e)
      }

  });
}
