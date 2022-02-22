

function printOs(id){

  getOsItems(id, function(data){
    console.log(data)
    let order = JSON.parse(data);
    constroiComprovante(order, function(value){

      var html = $('html').find('head').remove();
      $.print(value,{
        addGlobalStyles : true,
        stylesheet : 'http://localhost:8000/css/print.css'
      });
      $('html').append(html);
    })
  })
}

function getOsItems(id, retorno){
  $.post(path+'ordemServico/find', 
  {
    id: id,
    _token: $("#_token").val()
  })
  .done((s) => {
    console.log(s)
  })
  .fail((e) => {
    console.log(e)
  })
}

function constroiComprovante(order, retorno){
  var html = '<table border="0">';
  html += '<tr><td><table border="0" width="100%">';
  html += '<tr><td align="center"><h1>Cupom Não Fiscal</h1></td></tr>';
  html += '<tr><td align="center"><h1>Slym Tech</h1></td></tr>';

  html += '</table>';

  html += '<table align="left" border="0" width="100%">';
  html += '<tr><td align="left">Qtd x Item x Preço x Subtotal</td></tr>';

  $.each(order.products, function(index, value){
    html += '<tr><td>' + value.quantity + ' x ' + value.name + ' x ' +
    converterMoeda(value.value, 2, ',', '.') + ' x ' + 
    converterMoeda((value.value * value.quantity), 2, ',', '.') + '</td></tr>';
  });

  html += '<tr><td align="left"><nobr>Cliente: '+ order.client
  +'</nobr></td></tr>';

  html += '<tr><td align="left"><nobr>Forma de pagamento: '+
  order.payment_form+'</nobr></td></tr>';

  html += '<tr><td align="left"><nobr>Informação do pedido:</td></tr>';

  html += '<tr><td align="left">'+
  order.note +'</td></tr>';

  var data = new Date();
  var montaData = (data.getDate() <= 9 ? ('0' + data.getDate()) : data.getDate()) +
  '/' + (data.getMonth() <= 9 ? ('0' + data.getMonth()) : data.getMonth()) + '/' + 
  data.getFullYear() +
  ' ' + (data.getHours() <= 9 ? ('0' + data.getHours()) : data.getHours()) + ':' + 
  (data.getMinutes() <= 9 ? ('0' + data.getMinutes()) : data.getMinutes());
  html += '<tr> <td align="left">Data: '+
  montaData+'</td></tr>';

  html += '<tr><td>_</td></tr>';
  html += '</table></td></tr></table>';
  retorno(html);
}

function converterMoeda(valor, casas, separdor_decimal, separador_milhar){

  var valor_total = parseInt(valor * (Math.pow(10,casas)));
  var inteiros =  parseInt(parseInt(valor * (Math.pow(10,casas))) / parseFloat(Math.pow(10,casas)));
  var centavos = parseInt(parseInt(valor * (Math.pow(10,casas))) % parseFloat(Math.pow(10,casas)));

  if(centavos%10 == 0 && centavos+"".length<2 ){
    centavos = centavos+"0";
  }else if(centavos<10){
    centavos = "0"+centavos;
  }

  var milhares = parseInt(inteiros/1000);
  inteiros = inteiros % 1000;

  var retorno = "";

  if(milhares>0){
    retorno = milhares+""+separador_milhar+""+retorno
    if(inteiros == 0){
      inteiros = "000";
    } else if(inteiros < 10){
      inteiros = "00"+inteiros;
    } else if(inteiros < 100){
      inteiros = "0"+inteiros;
    }
  }
  retorno += inteiros+""+separdor_decimal+""+centavos;
  return retorno;

}