
function atribuir(id, mesa){
	$('#pedido_id').val(id)
	$('#mesa_atribuida').val(mesa)
	Materialize.updateTextFields();
	
}

function setarMesa(id, comanda){

	$('#pedido_id_mesa').val(id)
	$('#comanda_mesa').val(comanda)
	Materialize.updateTextFields();

}