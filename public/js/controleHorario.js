var INICIOOK = false;
var FIMOK = false;
$('#inicio').focusout(() => {
	validaInicio()
})

$('#fim').focusout(() => {
	validaFim()
})

$('#fim').keyup(() => {
	let inicio = $('#inicio').val();
	if(inicio == null || inicio == ''){
		$('#fim').val('');
		alert("Informe o inicio primeiramente")
	}
})

function validaInicio(){
	let horario = $('#inicio').val();
	let hora = horario.split(":")[0];
	let minuto = horario.split(":")[1];

	if(hora < 0 || hora > 23){
		$('#inicio').val('');
		alert('Hora inválida')
	}else if(minuto < 0 || minuto > 59){
		$('#inicio').val('');
		alert('Hora inválida')

	}else{
		INICIOOK = true;
		habilitaBtnSalvar();
	}
}

function validaFim(){

	let inicio = $('#inicio').val();
	let horaInicio = inicio.split(":")[0];
	let minutoInicio = inicio.split(":")[1];

	let fim = $('#fim').val();
	let horaFim = fim.split(":")[0];
	let minutoFim = fim.split(":")[1];

	if(horaFim < 0 || horaFim > 23){
		$('#fim').val('');
		alert('Hora inválida')
	}else if(minutoFim < 0 || minutoFim > 59){
		$('#fim').val('');
		alert('Hora inválida')
	}else if((horaFim <= horaInicio)){
		$('#fim').val('');
		alert('Hora Fim deve ser maior que a de fim')
	}else{
		FIMOK = true;
		habilitaBtnSalvar();
	}

}

function habilitaBtnSalvar(){
	if(INICIOOK == true && FIMOK == true){
		$('#btn-salvar').removeClass('disabled');
	}else{
		$('#btn-salvar').addClass('disabled');
	}
}