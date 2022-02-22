$(function () {
	let v = $('#cnpj').val();
	if(v.length == 18){
		$('#tipo-doc').html('CNPJ');
		$('#tipo').val('j').change();
	}else{
		$('#tipo-doc').html('CPF');
	}
});

$('#tipo').change(() => {
	let tipo = $('#tipo').val();
	if(tipo == 'j'){
		$('#tipo-doc').html('CNPJ');
		$('#cnpj').mask('00.000.000/0000-00', { reverse: true });
	}else{
		$('#tipo-doc').html('CPF');
		$('#cnpj').mask('000.000.000-00', { reverse: true });
	}
})