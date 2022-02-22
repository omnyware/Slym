$(function(){
	let doc = $('#proprietario_documento').val()
	if(doc.length > 14){
		$('#tipo-prop').val('j').change()
	}else{
		$('#tipo-prop').val('f').change()
	}
	setTimeout(() => {
		__set()
	}, 300);
});

$('#tipo-prop').change(() => {
	__set();
})

function __set(){
	if($('#tipo-prop').val() == 'f'){
		$('.tipo-doc').html('CPF Proprietário')
		$('.tipo-ie').html('RG Proprietário')
		$('#proprietario_documento').mask('000.000.000-00', { reverse: true });
	}else{
		$('.tipo-doc').html('CNPJ Proprietário')
		$('.tipo-ie').html('IE Proprietário')
		$('#proprietario_documento').mask('00.000.000/0000-00', { reverse: true });
	}
}