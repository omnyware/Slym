
$(function () {

  checkImage()

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

$('#todos').change(() => {
  let t = $('#todos').is(':checked');
  $('#autocomplete-cliente').val('')
  if(t){
    $('#cliente').css('display', 'none');
  }else{
    $('#cliente').css('display', 'block');

  }
})

$('#path_img').on('keyup', () => {
  checkImage();

})

function checkImage(){

  checkURL(path, (res) => {
    if(res){
      $('#div-img').css('display', 'block');
      $('#img-view').attr('src', path)

      if(path.length < 10)
        $('#div-img').css('display', 'none');

    }else{
      $('#div-img').css('display', 'none');
    }
  })
}

function checkURL(url, call) {
  call(url.match(/\.(jpeg|jpg|gif|png)$/) != null);
}