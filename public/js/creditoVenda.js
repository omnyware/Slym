
function receber(){
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
	location.href=path+'vendasEmCredito/receber?arr='+arr;

}

$('.check').click(() => {
	$('#btn-receber').removeClass('disabled');
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
	$('#total-select').html(formatReal(temp))
	console.log(temp)

}
