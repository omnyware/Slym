var CATEGORIAS = [];
var SERVICOS = [];
var CATEGORIASELECIONADA = 0;
var SOMATEMPO = 0;
var SOMAVALOR = 0;
function preparaServicos(){
	for(let i = 0; i < SERVICOS.length; i++){
		SERVICOS[i].selecionado = false;
	}
	console.log(SERVICOS)
}

function getAgendamentos(eventos){
	$.get(path+'agendamentos/all')
	.done((success) => {
		console.log(success)

		eventos(success)
	})
	.fail((err) => {
		console.log(err)
		eventos(-1)
	})
}
$(function () {
	CATEGORIAS = JSON.parse($('#categorias').val());
	SERVICOS = JSON.parse($('#servicos').val());
	if(CATEGORIAS[0])
	filtraServicos(CATEGORIAS[0].id)
	getAgendamentos((agendamentos) => {
		console.log(agendamentos)

		if(agendamentos == -1){
			swal("Erro", "Erro ao buscar agendamentos", "error")
		}
		var calendarEl = document.getElementById('calendar');
		var calendar = new FullCalendar.Calendar(calendarEl, {
			initialView: 'dayGridMonth',
			locale: 'pt-br',
			headerToolbar: {
				left: 'prev,next today',
				center: 'title',
				right: 'dayGridMonth,timeGridWeek,timeGridDay'
			},
			events: agendamentos
		});
		calendar.render();
		preparaServicos();
	})


})

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

function calculaTempo(){
	SOMAVALOR = 0;
	SOMATEMPO = 0;
	let inicio = $('#kt_timepicker_2').val();
	let data = $('.data_inicio_servico').val()
	if(inicio && data){
		for(let i = 0; i < SERVICOS.length; i++){
			if(SERVICOS[i].selecionado){
				SOMATEMPO += parseInt(SERVICOS[i].tempo_servico);
				SOMAVALOR += parseFloat(SERVICOS[i].valor);
			}
		}
		data = converterData(data)
		inicio = consertoData(inicio)

		let time = new Date(data+'T'+inicio)

		var outraData = new Date();
		time.setMinutes(time.getMinutes() + SOMATEMPO);
		console.log(data+'T'+inicio)
		console.log(time)
		console.log(time.getHours())

		let temp = time.getHours() + ":" + time.getMinutes() + ":00";
		console.log(temp)
		$('.ipt').val(temp)
		$('.bootstrap-timepicker-hour').val(time.getHours())
		$('.bootstrap-timepicker-minute').val(time.getMinutes())

		setTimeout(() => {
			$('#somaValor').html(SOMAVALOR.toFixed(2))
			$('#tempoServico').html(SOMATEMPO)
		}, 300)
	}else{
		swal("Cuidado", "Primeiro selecione data e horário de inicio", "warning")
	}
}

function converterData(data){
	let temp = data.split('/')
	return temp[2] + '-' + temp[1] + '-' + temp[0]
}

function consertoData(inicio){
	let temp = inicio.split(':')
	return (temp[0] < 10 ? '0'+temp[0] : temp[0])  + ':' + temp[1] + ':' + temp[2]
}

$('#btn-send-cliente').click(() => {
	let nome = $('#nome').val();
	let telefone = $('#telefone').val();

	let js = {
		nome: nome,
		telefone: telefone
	};

	console.log(js)

	$.post(path+'agendamentos/saveCliente', {cliente: js, _token: $('#_token').val()})
	.done((res) => {
		console.log(res)
		swal("Sucesso", "Cliente salvo", "success")
		.then(() => {
			location.reload();
		})

	})
	.fail((err) => {
		console.log(err)
		swal("Erro", "Erro ao salvar", "error");
	})
})

$('#kt_timepicker_2').click(() => {
	$('.ki-arrow-down').addClass('las la-angle-double-down')
	$('.la-angle-double-down').removeClass('ki ki-arrow-down')
	$('.ki-arrow-up').addClass('las la-angle-double-up')
	$('.la-angle-double-up').removeClass('ki ki-arrow-up')
})

$('.ipt').click(() => {
	$('.ki-arrow-down').addClass('las la-angle-double-down')
	$('.la-angle-double-down').removeClass('ki ki-arrow-down')
	$('.ki-arrow-up').addClass('las la-angle-double-up')
	$('.la-angle-double-up').removeClass('ki ki-arrow-up')
})

$('#btn-send').click(() => {
	let cliente_id = $('#kt_select2_3').val()	
	let funcionario_id = $('#kt_select2_4').val()
	let data = $('.data_inicio_servico').val()
	let inicio = $('#kt_timepicker_2').val()
	let termino = $('.ipt').val()

	let msg = "";
	getServicosParaSalvar((itens) => {
		if(itens.length == 0){
			msg += "Informe ao menos um serviço"
		}
		if(cliente_id == 'null'){
			msg += "\nSelecione o cliente"
		}
		if(funcionario_id == 'null'){
			msg += "\nSelecione o atendente"
		}
		if(data == ''){
			msg += "\nInforme a data"
		}
		if(inicio == ''){
			msg += "\nInforme o horário de início"
		}
		if(termino == ''){
			msg += "\nInforme o horário de término"
		}

		setTimeout(() => {
			if(msg == ""){

				let js = {
					itens: itens,
					cliente_id: cliente_id,
					funcionario_id: funcionario_id,
					data: data,
					inicio: inicio,
					termino: termino,
					observacao: $('#obs').val() ? $('#obs').val() : "",
					desconto: $('#desconto').val() ? $('#desconto').val() : 0,
					acrescimo: $('#acrescimo').val() ? $('#acrescimo').val() : 0,
					total: SOMAVALOR
				}

				console.log(js)
				$.post(path+'agendamentos/save', {agendamento: js, _token: $('#_token').val()})
				.done((success) => {
					console.log(success)
					swal("Sucesso", "Agendamento salvo!!", "success")
					.then(() => {
						location.href = path + 'agendamentos';
					})

				})
				.fail((err) => {
					console.log(err)
					swal("Erro", "Erro ao salvar agendamento", "error")

				})

			}else{
				swal("Erro", msg, "warning")
			}
		}, 300)
	})
})

function getServicosParaSalvar(call){
	let temp = [];
	SERVICOS.map((s) => {
		console.log(s)
		if(s.selecionado) temp.push(s)
	})
	call(temp)
}

$('#filtrar').click(() => {
	$('#filtrar').addClass('spinner');
	let js = {
		data_inicial: $('.data_inicial').val(),
		data_final: $('.data_final').val(),
		cliente: $('#kt_select2_7').val(),
		funcionario: $('#kt_select2_1').val(),
		status: $('#status').val()
	}
	console.log(js)
	$.get(path+'agendamentos/filtro', js)
	.done((success) => {
		$('#filtrar').removeClass('spinner');
		console.log(success)
		montaAgendamentos(success)
	})
	.fail((err) => {
		$('#filtrar').removeClass('spinner');
		console.log(err)
	})
})

function montaAgendamentos(agendamentos){
	var calendarEl = document.getElementById('calendar');
	var calendar = new FullCalendar.Calendar(calendarEl, {
		initialView: 'dayGridMonth',
		locale: 'pt-br',
		headerToolbar: {
			left: 'prev,next today',
			center: 'title',
			right: 'dayGridMonth,timeGridWeek,timeGridDay'
		},
		events: agendamentos
	});
	calendar.render();
	preparaServicos();
}

