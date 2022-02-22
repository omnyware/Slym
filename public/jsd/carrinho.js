
function removeItem(id){
	$.get(path+'carrinho/removeItem/'+id, 
		function(data) {
			location.reload();
		})
}

function refresh(id){
	let qtd = $('#qtd_item_'+id).val()

	$.get(path+'carrinho/refreshItem/'+id+'/'+qtd, 
		function(data) {
				//console.log(data)
				location.reload();
			})
}