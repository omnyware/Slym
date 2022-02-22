let valorIntegral = 0
$(function(){
	valorIntegral = parseFloat($("#value").val());
})

$("#discount").on('keyup', function(){
	
	let desconto = $("#discount").val();
	let temp = 0
	if(desconto.substring(0,1) == "%"){
		let perc = (desconto.length > 1 ? 
			desconto.substring(1,desconto.length).replace(',', '.') : 0);
		temp = valorIntegral - (valorIntegral * (parseFloat(perc)/100));
	}else{
		temp = valorIntegral - (desconto.length > 0 ? 
		parseFloat(desconto.substring(0,desconto.length).replace(',', '.')) : 0);
	}
	$("#value").val(converterMoeda(temp, 2, ',', '.'));
})

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