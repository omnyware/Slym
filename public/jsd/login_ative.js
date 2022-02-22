

let timer = 60;
let tempoInterval = 1000;
let iniciaContagem = false;
let celular = '';

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
		if(iniciaContagem){
			timer--;
			$('#timer').html(timer)
		}
	}else{
		tempoInterval = tempoInterval * tempoInterval;
		validaCodigo();
	}
}, tempoInterval)

$('#enviar-sms').click(() => {

	$('#enviar-sms').addClass('disabled')
	$.post(path+'autenticar/refreshToken',{
		_token: $('#token').val(), 
		id: $('#id').val()
	})
	.done((res) => {
		if(res){
			iniciaContagem = true;
			celular = res.celular;
			$('.sms-enviado').css('display', 'block')
			$('#cod1').focus();
		}else{
			swal("Erro", "Erro ao enviar código de autenticação!", "error")
		}
	})
	.fail((err) => {
		console.log(err)
	})
})

function validaCodigo(){
	let codToken = $('#cod1').val()+$('#cod2').val()+$('#cod3').val()+
	$('#cod4').val()+$('#cod5').val()+$('#cod6').val()
	$.post(path+'autenticar/validaToken',{
		_token: $('#token').val(), 
		celular: celular,
		codToken: codToken
	})
	.done((res) => {

		location.href=path;
	})
	.fail((err) => {
		console.log(err)
	})
}
