

var TAMANHOPIZZASELECIONADO = null;
var SABORESESCOLHIDOS = [];
var MAXIMOSABORES = 0;
var ADICIONAISESCOLHIDOS = [];
var TODOSSABORES = [];
var maiorValorPizza = 0;
var DIVISAO_VALOR_PIZZA = 0;
var VALOR_PIZZA= 0;

var PRODUTOS = [];
var ADICIONAIS = [];
var PRODUTO = null;
var TAMANHOSTEMP = []
var PIZZAS = [];
var TAMANHO = null;

$(function () {
  $('#sabores-pizza').css('display', 'none')
  $('#tamanhos-pizza').css('display', 'none')
  $('#btn-add-sabor').css('display', 'none')
  DIVISAO_VALOR_PIZZA = $('#DIVISAO_VALOR_PIZZA').val();


  PRODUTOS = JSON.parse($('#produtos').val())
  ADICIONAIS = JSON.parse($('#adicionais').val())
  PIZZAS = JSON.parse($('#pizzas').val())
  console.log(PIZZAS)
  verificaUnidadeCompra();

  // console.log($('#composto').val())

  verificaCategoria()

});

$('#kt_select2_1').change(() => {
  let id = $('#kt_select2_1').val()
  PRODUTOS.map((p) => {
    if(id == p.id){
      PRODUTO = p
      if(p.delivery && p.delivery.pizza.length > 0){
        setaTamanhosPizza(p.delivery)
      }else{
        $('#valor').val(p.valor_venda)
        $('#sabores-pizza').css('display', 'none')
        $('#tamanhos-pizza').css('display', 'none')
        $('#btn-add-sabor').css('display', 'none')

      }
    }
  })
})

$('#unidade_compra').change(() => {
  verificaUnidadeCompra();
})
$('#unidade_venda').change(() => {
  verificaUnidadeCompra();
})

function verificaUnidadeCompra(){
  let unidadeCompra = $('#unidade_compra').val();
  let unidadeVenda = $('#unidade_venda').val();
  if(unidadeCompra != unidadeVenda){
    $('#conversao').css('display', 'block');
  }else{
    $('#conversao').css('display', 'none');
  }
}

function alterarDestaque(id){
  $.ajax
  ({
    type: 'GET',
    url: path + 'deliveryProduto/alterarDestaque/'+id,
    dataType: 'json',
    success: function(e){
       // console.log(e);
       console.log(e)

     }, error: function(e){
      console.log(e)
    }

  });
}

function alterarStatus(id){
  $.ajax
  ({
    type: 'GET',
    url: path + 'deliveryProduto/alterarStatus/'+id,
    dataType: 'json',
    success: function(e){
       // console.log(e);
       console.log(e)

     }, error: function(e){
      console.log(e)
    }

  });
}

function verificaCategoria(){
  let cat = $('#categoria-select option:selected').html();
  if(cat && cat.includes('izza')){
    $('#produto-pizza').css('display', 'block');
    $('#produto-comum').css('display', 'none');

  }else{
    $('#produto-comum').css('display', 'block');
    $('#produto-pizza').css('display', 'none');

  }
}

$('#categoria-select').change(() => {
  verificaCategoria()
})


$('#seleciona_tamanho').change(() => {
  selecionaTamanho((op) => {
    $('#sabores').html('')

    op.map((r) => {
      $('#sabores').append("<option value="+r.value+">"+r.s+"</option>")
    })

  })
})

function selecionaTamanho(call){
  SABORESESCOLHIDOS = []
  
  let sel = $('#seleciona_tamanho').val()
  let tags = [];
  TAMANHOSTEMP.map((v) => {
    if(sel == v.id){
      PIZZAS.map((pz) => {

        pz.delivery.pizza.map((tp) => {
          TAMANHO = v.tamanho_id
          if(v.tamanho_id == tp.tamanho_id){
            MAXIMOSABORES = tp.tamanho.maximo_sabores
            montaPizzas((html) => {
              $('#sabores-html').html(html)
              $('#sabores-html').css('display', 'block')
            })
            $('#tamanho_pizza_id').val(tp.tamanho_id)
            let nome = pz.nome
            let id = pz.id
            let valor = tp.valor
            if(PRODUTO.nome != nome){
              tags.push({s: nome + ' - R$ ' + valor, value: id})
            }else{
              $('#valor').val(valor)
              maiorValorPizza = VALOR_PIZZA = valor
            }

          }
        })

      })
    }
  })
  call(tags)
}


function setaTamanhosPizza(data){
  let tags = [];

  data.pizza.map((v) => {
    TAMANHOSTEMP.push(v)
    tags.push({s: v.tamanho.nome + ' - R$ ' + v.valor, value: v.id})
  });

  $('#seleciona_tamanho').html('')
  $('#sabores').html("<option value="+0+">Selecione o tamanho</option>")
  $('#seleciona_tamanho').append("<option value="+0+">Selecione o tamanho</option>")

  tags.map((r) => {
    $('#seleciona_tamanho').append("<option value="+r.value+">"+r.s+"</option>")
  })

  $('#tamanhos-pizza').css('display', 'block');
  $('#sabores-pizza').css('display', 'block');
  $('#btn-add-sabor').css('display', 'block');


}

$('#btn-add-sabor').click(() => {
  let sabor = $('#sabores').val();
  console.log(sabor)
  console.log(VALOR_PIZZA)
  console.log(TAMANHO)
  $('#quantidade').val(1)
  validaSaborNaoAdicionado(sabor, (res) => {
    if(!res){
      SABORESESCOLHIDOS.push(sabor)

      montaPizzas((html) => {
        $('#sabores-html').html(html)
        $('#sabores-html').css('display', 'block')
      })

      somaValor();
      $('#sabores_escolhidos').val(SABORESESCOLHIDOS)
      
    }else{
      swal("Alerta", "Este sabor já esta adicionado, ou máximo de sabores escolhidos!!", "warning")
    }
  })
})

function validaSaborNaoAdicionado(sabor, call){
  let retorno = false;
  if(SABORESESCOLHIDOS.length+1 >= MAXIMOSABORES) retorno = true
    SABORESESCOLHIDOS.map((s) => {
      if(s == sabor){
        retorno = true;
      }
    })
  call(retorno)
}



function montaPizzas(call){
  let html = '';

  html = '<p class="text-danger">Adicione até '+MAXIMOSABORES+' sabores</p>'

  html += '<div class="row">'
  SABORESESCOLHIDOS.map((s) => {
    PIZZAS.map((pz) => {
      if(s == pz.id){
        html += '<div class="col-sm-4 col-lg-4 col-6">';
        html += '<div class="card card-custom bg-success">';
        html += '<div class="card-header">'
        html += '<div class="card-title">'
        html += '<h3 class="card-label">' + pz.nome + '</h3></div>'
        html += '<div class="card-toolbar">'
        html += '<a class="btn btn-sm btn-light-danger mr-1" onclick="deleteSabor('+pz.id+')">'

        html += '<i class="la la-times"></i></a>'
        html += '</div></div></div></div>';
      }
    })
  })
  html += '</div>'
  call(html)
}

function deleteSabor(id){
  percorreDelete(id, (sabores) => {
    SABORESESCOLHIDOS = sabores;
    montaPizzas((html) => {
      console.log(html)
      $('#sabores-html').html(html)
      $('#sabores-html').css('display', 'block')
    })
  })
}

function percorreDelete(id, call){
  let temp = []
  SABORESESCOLHIDOS.map((s) => {
    if(s != id){
      temp.push(s)
    }
  })
  call(temp)
}

$('#btn-add-adicional').click(() => {
  let adicional = $('#kt_select2_2').val();
  validaAdicionalNaoAdicionado(adicional, (res) => {
    if(!res){
      ADICIONAISESCOLHIDOS.push(adicional)
      $('#adicioanis_escolhidos').val(ADICIONAISESCOLHIDOS)
      montaAdicionais((html) => {

        $('#adicioanais-html').html(html)
        $('#adicioanais-html').css('display', 'block')

      })
      somaValor();
    }else{
      swal("Alerta", "Esta adicional já esta escolhido!!", "warning")
    }
  })
})

function montaAdicionais(call){
  let html = '';

  html += '<div class="row">'
  ADICIONAISESCOLHIDOS.map((s) => {
    ADICIONAIS.map((a) => {
      if(s == a.id){
        console.log(a)
        html += '<div class="col-sm-4 col-lg-4 col-6">';
        html += '<div class="card card-custom bg-info">';
        html += '<div class="card-header">'
        html += '<div class="card-title">'
        html += '<h4 class="card-label">' + a.nome + ' R$ ' + a.valor + '</h4></div>'
        html += '<div class="card-toolbar">'
        html += '<a class="btn btn-sm btn-light-danger mr-1" onclick="deleteAdicional('+a.id+')">'

        html += '<i class="la la-times"></i></a>'
        html += '</div></div></div></div>';
      }
    })
  })
  html += '</div>'
  call(html)
}

function somaValor(){

  totaliza((res) => {
    totalizaAdicional((resAd) => {
      let quantidade = $('#quantidade').val();
      console.log("setando")
      $('#valor').val(maskMoney((res + resAd) * quantidade))
    })
  })
}

function maskMoney(v){
  return v.toFixed(2);
}

$('#quantidade').keyup((v) => {
  let quantidade = v.target.value
  if(quantidade){
    somaValor();
  }
})

function formatReal(v){
  return v.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});;
}

function totaliza(call){

  if(maiorValorPizza){
    let soma = parseFloat(maiorValorPizza);
    console.log(soma)
    SABORESESCOLHIDOS.map((sb) => {
      PIZZAS.map((pz) => {
        if(sb == pz.id){

          pz.delivery.pizza.map((pt) => {
            if(pt.tamanho_id == TAMANHO){
              console.log(pt)
              if(DIVISAO_VALOR_PIZZA == 0){
                if(pt.valor > maiorValorPizza){ 
                  maiorValorPizza = pt.valor;
                }
              }else{
                soma += parseFloat(pt.valor)
              }
            }
          })
        }
      })
    })

    if(DIVISAO_VALOR_PIZZA == 1){
      console.log(soma)
      let calc = soma/(SABORESESCOLHIDOS.length + 1);
      call(calc)
    }else{
      call(maiorValorPizza)
    }

  }else{
    let valor = parseFloat($('#valor').val())
    call(valor);
  }
}

function totalizaAdicional(call){
  let soma = 0;
  ADICIONAISESCOLHIDOS.map((a) => {
    ADICIONAIS.map((ad) => {
      if(ad.id == a){
        soma += parseFloat(ad.valor)
      }
    })
  })
  call(soma)
}


function validaAdicionalNaoAdicionado(adicional, call){
  let retorno = false;

  ADICIONAISESCOLHIDOS.map((a) => {
    if(a == adicional){
      retorno = true;
    }
  })
  call(retorno)
}

function deleteAdicional(id){
  percorreDeleteAdicional(id, (adicionais) => {
    ADICIONAISESCOLHIDOS = adicionais;
    montaPizzas((html) => {
      console.log(html)
      $('#adicioanais-html').html(html)
      $('#adicioanais-html').css('display', 'block')
    })
  })
}

function percorreDeleteAdicional(id, call){
  let temp = []
  ADICIONAISESCOLHIDOS.map((s) => {
    if(s != id){
      temp.push(s)
    }
  })
  call(temp)
}

function calculaValorPizza(){

  // if(DIVISAO_VALOR_PIZZA == 0){
  //   if(v.tamanhoValor > maiorValorPizza) maiorValorPizza = v.tamanhoValor;
  //   $('#valor').val(maiorValorPizza)
  // }else{
  //   soma += parseFloat(v.tamanhoValor);
  // }
}

$('#sabores').on('chip.add', function(e, chip){

  SABORESESCOLHIDOS.push(chip.tag)
  $('#sabores_escolhidos').val(SABORESESCOLHIDOS)
  if(SABORESESCOLHIDOS.length >= MAXIMOSABORES-1){
    $('#sabores input').css('display', 'none')
  }
  let soma = 0;
  TODOSSABORES.map((v) => {
    console.log(v)
    console.log(SABORESESCOLHIDOS)
    if(SABORESESCOLHIDOS.includes(v.produto.nome)){
      if(DIVISAO_VALOR_PIZZA == 0){
        if(v.tamanhoValor > maiorValorPizza) maiorValorPizza = v.tamanhoValor;
        $('#valor').val(maiorValorPizza)
      }else{
        soma += parseFloat(v.tamanhoValor);
      }
    }
  })
  let calc = (soma + parseFloat(VALOR_PIZZA) )/(SABORESESCOLHIDOS.length + 1);
  $('#valor').val(calc.toFixed(2));


});


$('#sabores').on('chip.delete', function(e, chip){
  let temp = [];
  SABORESESCOLHIDOS.map((t) => {
    if(t != chip.tag) temp.push(t)
  })
  SABORESESCOLHIDOS = temp;
  let soma = 0;
  TODOSSABORES.map((v) => {
    console.log(v)
    console.log(SABORESESCOLHIDOS)
    if(SABORESESCOLHIDOS.includes(v.produto.nome)){
      if(DIVISAO_VALOR_PIZZA == 0){
        if(v.tamanhoValor > maiorValorPizza) maiorValorPizza = v.tamanhoValor;
        $('#valor').val(maiorValorPizza)
      }else{

        soma += parseFloat(v.tamanhoValor);
      }
    }
  })
  let calc = (soma + parseFloat(VALOR_PIZZA) )/(SABORESESCOLHIDOS.length + 1);
  $('#valor').val(calc.toFixed(2));
  
  $('#sabores_escolhidos').val(SABORESESCOLHIDOS)
  $('#sabores input').css('display', 'block')
});

$('#tamanhos').on('chip.select', function(e, chip){
  console.log(chip.item)
  maiorValorPizza = chip.item.valor;
  VALOR_PIZZA = chip.item.valor;
  $('#valor').val(maiorValorPizza)
  TAMANHOPIZZASELECIONADO = chip.item.tamanho_id;
  MAXIMOSABORES = chip.item.tamanho.maximo_sabores;
  console.log(TAMANHOPIZZASELECIONADO)
  $('#tamanho_pizza_id').val(TAMANHOPIZZASELECIONADO);
  console.log(MAXIMOSABORES)
  if(MAXIMOSABORES == 1){
    $('#sabores-pizza').css('display', 'none')
    SABORESESCOLHIDOS = [];
  }else{
    if(SABORESESCOLHIDOS.length >= MAXIMOSABORES){
      location.reload();
    }else{
      $('#sabores-pizza').css('display', 'block')
    }
  }
  getSaboresPizza();
  console.log(maiorValorPizza)
});


$('#adicionais').on('chip.add', function(e, chip){
  ADICIONAISESCOLHIDOS.push(chip.tag)
  $('#adicioanis_escolhidos').val(ADICIONAISESCOLHIDOS)
});

$('#adicionais').on('chip.delete', function(e, chip){
  let temp = [];
  ADICIONAISESCOLHIDOS.map((t) => {
    if(t != chip.tag) temp.push(t)
  })
  SABORESESCOLHIDOS = temp;
  $('#adicioanis_escolhidos').val(ADICIONAISESCOLHIDOS)
});

function sendSms(){
  $('#preloader1').css('display', 'block');
  let celular = $('#numero_sms').val()
  let msg = $('#msg_sms').val()

  let celularEnvia = '55'+celular.replace(' ', '');
  celularEnvia = celularEnvia.replace('-', '');
  let js = {
    numero: celularEnvia,
    msg: msg
  }
  console.log(js)
  $.post(path+'pedidos/sms', {data: js, _token: $('#_token').val()})
  .done(function(v){
    console.log(v)
    $('#preloader1').css('display', 'none');
    Materialize.toast('SMS enviado!', 4000);
    $('#modal1').modal('close');

  })
  .fail(function(err){
    console.log(err)
    Materialize.toast('Erro ao enviar SMS!', 4000);
    $('#preloader1').css('display', 'none');

  })
}

function enviarWhatsApp(){
  let celular = $('#numero_whats').val();
  let texto = $('#msg_whats').val();

  let mensagem = texto.split(" ").join("%20");

  let celularEnvia = '55'+celular.replace(' ', '');
  celularEnvia = celularEnvia.replace('-', '');
  let api = 'https://api.whatsapp.com/send?phone='+celularEnvia
  +'&text='+mensagem;
  window.open(api)
}



$('#bairro').change(() => {
  let bairro = $('#bairro').val();
  if(bairro != '0'){
    let js = {
      bairro_id: bairro,
      pedido_id: $('#pedido_id').val()
    }
    console.log(js)
    $.get(path + '/pedidos/setarBairro', js)
    .done((success) => {
      console.log(success)
      location.reload()
    })
    .fail((err) => {
      console.log(err)
    })
  }
})


function imprimirItens(){
  let ids = "";
  $('#body tr').each(function(){
    if($(this).find('#checkbox input').is(':checked')){
      id = $(this).find('#item_id').html();
      ids += id + ",";
    }
  })

  window.open(path + 'pedidos/imprimirItens?ids='+ids);
  location.href = window.location.href;



  // $.get(path + 'pedidos/imprimirItens', {ids: ids})
  // .done((res) => {
  //   console.log(res)
  // })
  // .fail((err) => {
  //   console.log(err)
  // })

}








