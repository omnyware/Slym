
let DATA_PRODUTOS = [];
let DATA_SERVICOS = [];
let totalGeral = 0;
$(function () {

	getServicos(function(data){
	    $('input.autocomplete-servico').autocomplete({
	      data: data,
	      limit: 20, 
	      onAutocomplete: function(val) {
	        var servico = $('#autocomplete-servico').val().split('-');
	        getPrecoServico(servico[0], function(p){
            $('#valor-servico').val(p);
          })
	      },
	      minLength: 1,
	    });
	});

	getProdutos(function(data){
	    $('input.autocomplete-produto').autocomplete({
	      data: data,
	      limit: 20, 
	      onAutocomplete: function(val) {
	        var produto = $('#autocomplete-produto').val().split('-');
	        console.log(produto[0]);
          getPrecoProduto(produto[0], function(p){
            $('#valor-produto').val(p);
          })
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

function getPrecoProduto(id, data){
  let token = $('#token').val();
  $.ajax
  ({
    type: 'POST',
    data: {
      id: id,
      _token: token
    },
    url: path + 'produtos/getValue',
    dataType: 'json',
      success: function(e){
        console.log(e)
        data(e)

      }, error: function(e){
        console.log(e)
      }

  });
}

function getPrecoServico(id, data){
  let token = $('#token').val();
  $.ajax
  ({
    type: 'POST',
    data: {
      id: id,
      _token: token
    },
    url: path + 'servicos/getValue',
    dataType: 'json',
      success: function(e){
        data(e)

      }, error: function(e){
        console.log(e)
      }

  });
}

$('#adicionar-produto').click(function(){
  let quantidade = $('#quantidade-produto').val();
  let valor = $('#valor-produto').val();
  let produto = $('#autocomplete-produto').val();
  produto = produto.split("-");
  let js = {
    produto_id: produto[0],
    produto_nome: produto[1],
    quantidade: quantidade,
    valor: valor
  }

  DATA_PRODUTOS.push(js);

  $('#data-produtos').val(JSON.stringify(DATA_PRODUTOS));
  montaTableProduto();
})

$('#adicionar-servico').click(function(){
  let quantidade = $('#quantidade-servico').val();
  let valor = $('#valor-servico').val();
  let servico = $('#autocomplete-servico').val();
  servico = servico.split("-");
  let js = {
    servico_id: servico[0],
    servico_nome: servico[1],
    quantidade: quantidade,
    valor: valor
  }

  DATA_SERVICOS.push(js);

  $('#data-servicos').val(JSON.stringify(DATA_SERVICOS));
  montaTableServico();
})

function montaTableProduto(){
  let html = "";
  let total = 0;
  $.each(DATA_PRODUTOS, function(index, value){
      html += "<tr>";
        html += "<td>"+value.produto_nome+"</td>";
        html += "<td>"+value.quantidade+"</td>";
        html += "<td>"+converterMoeda(value.valor, 2, ',','.')+"</td>";
        html += "<td>"+converterMoeda((value.valor * value.quantidade),
          2, ',','.')+"</td>";

      html += "</tr>";
      total += (value.valor * value.quantidade);
  });

  html += "<tr class='blue lighten-2'>";
  html += "<td class='center-align' colspan='3'>TOTAL</td>";
  html += "<td>"+converterMoeda(total, 2, ',', '.')+"</td>";
  html += "</tr>"
  console.log(html);
  

  $('#tbody-produto').html(html);

  calculaTotal();
}

function montaTableServico(){
  let html = "";
  let total = 0;
  $.each(DATA_SERVICOS, function(index, value){
      html += "<tr>";
        html += "<td>"+value.servico_nome+"</td>";
        html += "<td>"+value.quantidade+"</td>";
        html += "<td>"+converterMoeda(value.valor, 2, ',','.')+"</td>";
        html += "<td>"+converterMoeda((value.valor * value.quantidade),
          2, ',','.')+"</td>";

      html += "</tr>";
      total += (value.valor * value.quantidade);
  });

  html += "<tr class='green lighten-2'>";
  html += "<td class='center-align' colspan='3'>TOTAL</td>";
  html += "<td>"+converterMoeda(total, 2, ',', '.')+"</td>";
  html += "</tr>"
  console.log(html);
  

  $('#tbody-servico').html(html);

  calculaTotal();
}

function calculaTotal(){
  totalGeral = 0;
  $.each(DATA_SERVICOS, function(index, value){
      totalGeral += (value.valor * value.quantidade);
  });
  $.each(DATA_PRODUTOS, function(index, value){
      totalGeral += (value.valor * value.quantidade);
  });
  $('#value').val(converterMoeda(totalGeral, 2, ',', '.'));
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