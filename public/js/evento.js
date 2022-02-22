var CATEGORIAS = [];
var SERVICOS = [];
var CATEGORIASELECIONADA = 0;

$(function () {
	CATEGORIAS = JSON.parse($('#categorias').val());
	SERVICOS = JSON.parse($('#servicos').val());
	if(CATEGORIAS[0])
		filtraServicos(CATEGORIAS[0].id)

	console.log(SERVICOS)
});

function filtraServicos(categoria_id){
	$('#cat_'+CATEGORIASELECIONADA).removeClass('btn-info')
	$('#cat_'+CATEGORIASELECIONADA).addClass('btn-light')
	CATEGORIASELECIONADA = categoria_id;
	let x = SERVICOS.filter((s) => {
		return s.categoria_id == categoria_id;
	})

	$('#cat_'+categoria_id).removeClass('btn-light')
	$('#cat_'+categoria_id).addClass('btn-info')

	// console.log(x)
	let html = '';
	x.map((rs) => {
		let cor = rs.selecionado ? 'success' : 'light'
		html += '<a class="btn btn-'+cor+' servico" onclick="selectServico('+rs.id+')">';
		html += rs.nome
		html += '</a>'
	})
	$('.servicos').html(html)
}

function filtraServicos(categoria_id){
	$('#cat_'+CATEGORIASELECIONADA).removeClass('btn-info')
	$('#cat_'+CATEGORIASELECIONADA).addClass('btn-light')
	CATEGORIASELECIONADA = categoria_id;
	let x = SERVICOS.filter((s) => {
		return s.categoria_id == categoria_id;
	})

	$('#cat_'+categoria_id).removeClass('btn-light')
	$('#cat_'+categoria_id).addClass('btn-info')

	// console.log(x)
	let html = '';
	x.map((rs) => {
		let cor = rs.selecionado ? 'success' : 'light'
		html += '<a class="btn btn-'+cor+' servico" onclick="selectServico('+rs.id+')">';
		html += rs.nome
		html += '</a>'
	})
	$('.servicos').html(html)
}

function selectServico(id){
	for(let i = 0; i < SERVICOS.length; i++){
		if(SERVICOS[i].id == id){
			SERVICOS[i].selecionado = !SERVICOS[i].selecionado;
		}
	}
	setTimeout(() => {
		filtraServicos(CATEGORIASELECIONADA);
		calculaTempo()
	}, 300)
}

function converterData(data){
	let temp = data.split('/')
	return temp[2] + '-' + temp[1] + '-' + temp[0]
}

function consertoData(inicio){
	alert(inicio)
	let temp = inicio.split(':')
	return (temp[0] < 10 ? '0'+temp[0] : temp[0])  + ':' + temp[1] + ':' + temp[2]
}

function calculaTempo(){
	SOMAVALOR = 0;
	SOMATEMPO = 0;
	let inicio = $('#inicio').val();

	now = new Date
	let mes = parseInt(now.getMonth())+1;

	let data = now = now.getFullYear() + '-' + (mes < 10 ? ('0' + mes) : mes) +
	'-' + now.getDate()
	if(inicio && data){

		for(let i = 0; i < SERVICOS.length; i++){
			if(SERVICOS[i].selecionado){
				SOMATEMPO += parseInt(SERVICOS[i].tempo_servico);
				SOMAVALOR += parseFloat(SERVICOS[i].valor);
			}
		}

		// inicio = consertoData(inicio)
		let time = new Date(data+'T'+inicio)

		var outraData = new Date();
		time.setMinutes(time.getMinutes() + SOMATEMPO);
		console.log(data+'T'+inicio)
		console.log(time)
		console.log(time.getHours())

		let temp = time.getHours() + ":" + time.getMinutes();
		console.log(temp)
		$('.ipt').val(temp)

		setTimeout(() => {
			$('#somaValor').html(SOMAVALOR.toFixed(2))
			$('#total').val(SOMAVALOR.toFixed(2))
			$('#fim').val(temp)
			setaServicos()
		}, 300)
	}else{
		swal("Cuidado", "Primeiro selecione data e horário de inicio", "warning")
	}
}

function setaServicos(){
	let temp = [];
	for(let i = 0; i < SERVICOS.length; i++){
		if(SERVICOS[i].selecionado){
			console.log(SERVICOS[i])
			temp.push(SERVICOS[i].id)
		}
	}
	
	setTimeout(() => {
		$('#servicos_selecionados').val(temp)
	}, 300)
}