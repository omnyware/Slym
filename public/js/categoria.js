$(function () {
	let atribuir = $('#atribuir_delivery').is(':checked');
	validaExibeImagem();
})

$('#atribuir_delivery').click(() => {
	validaExibeImagem();
})

function validaExibeImagem(){
	let atribuir = $('#atribuir_delivery').is(':checked');
	
	if(atribuir == true){
		$('#imagem').css('display', 'block');
	}else{
		$('#imagem').css('display', 'none');
	}
}