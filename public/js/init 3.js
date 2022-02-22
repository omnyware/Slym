$(document).ready(function(){
	$('select').material_select();
	
	$(".button-collapse").sideNav();
	$(".dropdown-button").dropdown({
		inDuration: 700,
		outDuration: 700,
		constrainWidth: false, 
		hover: false, 
		gutter: 55, 
		belowOrigin: false, 
		alignment: 'left', 
		stopPropagation: false 
	});
	$('.tooltipped').tooltip({delay: 50});
	$('.modal').modal();
	$('.collapsible').collapsible();

	$('.datepicker').pickadate({
		monthsFull: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
		weekdaysFull: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabádo'],
		weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
		today: 'Hoje',
		clear: 'Limpar',
		close: 'Pronto',
		labelMonthNext: 'Próximo mês',
		labelMonthPrev: 'Mês anterior',
		labelMonthSelect: 'Selecione um mês',
		labelYearSelect: 'Selecione um ano',
		selectMonths: true, 
		selectYears: 15,
		format: 'dd/mm/yyyy'
	});

	$('.timepicker').pickatime({
	    default: 'now', // Set default time: 'now', '1:30AM', '16:30'
	    fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
	    twelvehour: false, // Use AM/PM or 24-hour format
	    donetext: 'OK', // text for done-button
	    cleartext: 'Clear', // text for clear-button
	    canceltext: 'Cancel', // Text for cancel-button,
	    container: undefined, // ex. 'body' will append picker to body
	    autoclose: false, // automatic close timepicker
	    ampmclickable: true, // make AM PM clickable
	    aftershow: function(){} //Function for after opening timepicker
	});

	
	$('ul.tabs').tabs();
	$('ul.tabs').tabs('select_tab', 'tab_id');
	$('.chips').material_chip();

});