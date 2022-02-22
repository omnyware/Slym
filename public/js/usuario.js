var menu = [];
$(function () {
	menu = JSON.parse($('#menus').val())
	validaCategoriaCompleta()
});
function marcarTudo(titulo){
	let marked = $('#todos_'+titulo).is(':checked')
	if(!marked){
		acaoCheck(false, titulo)
	}else{
		acaoCheck(true, titulo)
	}
}

function acaoCheck(acao, titulo){
	menu.map((m) => {
		if(titulo == m.titulo){
			m.subs.map((sub) => {
				let rt = sub.rota.replaceAll("/", "")
				console.log(rt)
				if(acao){
					$('#sub_'+rt).attr('checked', true);
				}else{
					$('#sub_'+rt).removeAttr('checked');
				}
			})
		}
	})
}

function validaCategoriaCompleta(){
	let temp = true;
	menu.map((m) => {
		temp = true;
		m.subs.map((sub) => {
			let rt = sub.rota.replaceAll("/", "")
			let marked = $('#sub_'+rt).is(':checked')
			if(!marked) temp = false;

		})

		if(temp){

			$('#todos_'+m.titulo).attr('checked', true);
		}else{
			$('#todos_'+m.titulo).removeAttr('checked');
		}
	});
}

$('#adm').click(() =>{

	if($('#adm').is(':checked')){
		console.log("sim")
		marcarTodos(true);
	}else{
		desmarcarTodos();
	}
})

function marcarTodos(){
	menu.map((m) => {
		temp = true;
		m.subs.map((sub) => {
			let rt = sub.rota.replaceAll("/", "")
			$('#sub_'+rt).attr('checked', true);
		});
	});
	setTimeout(() => {
		validaCategoriaCompleta()
	}, 200)
}

function desmarcarTodos(){
	menu.map((m) => {
		temp = true;
		m.subs.map((sub) => {
			let rt = sub.rota.replaceAll("/", "")
			$('#sub_'+rt).removeAttr('checked');
		});
	});
	setTimeout(() => {
		validaCategoriaCompleta()
	}, 200)
}

$('.check-sub').click(() => {
	validaCategoriaCompleta()
})


