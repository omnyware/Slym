
function pagar(){
	let arr = []
	$('#body tr').each(function(){
		let checked = $(this).find('input').is(':checked');
		if(checked){
			let id = $(this).find('#id').html();
			arr.push(id)
		}
	});

	let param = { 
		arr: arr 
	};
	swal("Cuidado", "Deseja pagar esta(s) entrega(s)?", "warning")
	.then((sim) => {
		if(sim)
		location.href=path+'motoboys/pagar?arr='+arr;
		
	})

}

$(document).ready(function(){
	percorreTabela();

})

$('.check').click(() => {

	$('#btn-pagar').removeAttr('disabled');
	percorreTabela();
})

function formatReal(v){
	return v.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});;
}

function percorreTabela(){
	let temp = 0;

	$('#body tr').each(function(){
		if($(this).find('#checkbox input').is(':checked')){
			let v = $(this).find('#valor').html();
			v = v.replace(",", ".")
			temp += parseFloat(v);
		}
	});
	if(temp > 0){
		$('#btn-pagar').removeAttr('disabled');
	}else{
		$('#btn-pagar').attr('disabled', true);
	}
	$('#total-select').html(formatReal(temp))
	console.log(temp)

}
