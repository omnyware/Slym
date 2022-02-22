
$(function () {
	$('#cod1').focus();
})

let timer = 60;
let tempoInterval = 1000;


$('#cod1').on('keyup', () => {
	if($('#cod1').val().length > 0)
		$('#cod2').focus();
})
$('#cod2').on('keyup', () => {
	if($('#cod2').val().length > 0)
		$('#cod3').focus();
})
$('#cod3').on('keyup', () => {
	if($('#cod3').val().length > 0)
		$('#cod4').focus();
})
$('#cod4').on('keyup', () => {
	if($('#cod4').val().length > 0)
		$('#cod5').focus();
})
$('#cod5').on('keyup', () => {
	if($('#cod5').val().length > 0)
		$('#cod6').focus();
})
$('#cod6').on('keyup', () => {
	timer = 0;
	validaCodigo();
	tempoInterval = tempoInterval * tempoInterval;
})

setInterval(() => {
	if(timer > 0){
		timer--;
		$('#timer').html(timer)
	}else{
		tempoInterval = tempoInterval * tempoInterval;
		validaCodigo();
	}
}, tempoInterval)

function validaCodigo(){
	let codToken = $('#cod1').val()+$('#cod2').val()+$('#cod3').val()+
	$('#cod4').val()+$('#cod5').val()+$('#cod6').val()

	$.post(path+'delivery/validaToken',{
		_token: $('#token').val(), 
		celular: $('#celular').val(),
		codToken: codToken
	})
	.done((res) => {
		location.href = path + 'delivery';
	})
	.fail((err) => {
		location.href = path + 'delivery';
	})
}
