
var MUNIPIOSCARREGAMENTO = [];
var PERCURSO = [];
var CIOT = [];
var VALEPEDAGIO = [];
var contVale = 0;
var contInfo = 0;

var VEICULOTRACAO = null;
var VEICULOREBOQUE = null;

var INFODESCARGA = [];
var LACRESTRANSP = [];
var LACRESUNIDCARGA = [];
var MDFEID = 0;

$(function () {

	// se editar
	if($('#mdfe_id').val()) MDFEID = $('#mdfe_id').val()
		if(MDFEID > 0){

			let mdfe = JSON.parse($('#mdfe_c').val())
			if(mdfe){
				$('#condutor_nome').val(mdfe.condutor_nome)
				$('#condutor_cpf').val(mdfe.condutor_cpf)
			}
			mostraVeiculoTracao();
			mostraVeiculoReboque();
			let municipios = $('#municipios_hidden').val()
			MUNIPIOSCARREGAMENTO = JSON.parse(municipios);
			montaTabelaMunicipioCarregamento();


			let percurso = $('#percurso_hidden').val()
			PERCURSO = JSON.parse(percurso);
			montaTabelaPercuso();

			let ciots = $('#ciots_hidden').val()
			CIOT = JSON.parse(ciots);
			montaTabelaCiot();

			let vales = $('#vales_pedagio_hidden').val()
			VALEPEDAGIO = JSON.parse(vales);
			montaTabelaValePedagio();

			let infos = $('#info_descarga_hidden').val()
			INFODESCARGA = JSON.parse(infos);
			montaTabelaInfosDescargaEdit();

			habilitaBtnSalvar();
		}

	});

function getCidades(data){
	$.ajax
	({
		type: 'GET',
		url: path + 'cidades/all',
		dataType: 'json',
		success: function(e){
			data(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

$('#veiculo_tracao').change(() => {
	mostraVeiculoTracao();
})

function mostraVeiculoTracao(){
	let veiculo = $('#veiculo_tracao').val();
	if(veiculo != 'null'){

		veiculo = JSON.parse(veiculo);
		VEICULOTRACAO = veiculo;
		$('#tracao_marca').html(veiculo.marca);
		$('#tracao_modelo').html(veiculo.modelo);
		$('#tracao_placa').html(veiculo.placa);
		$('#tracao_proprietario_nome').html(veiculo.proprietario_nome);
		$('#tracao_proprietario_documento').html(veiculo.proprietario_documento);
		$('#display-tracao').css('display', 'block');
		habilitaBtnSalvar()
	}
}

$('#veiculo_reboque').change(() => {
	mostraVeiculoReboque();
})

function mostraVeiculoReboque(){
	let veiculo = $('#veiculo_reboque').val();

	if(veiculo != 'null'){
		veiculo = JSON.parse(veiculo);
		VEICULOREBOQUE = veiculo;

		$('#reboque_marca').html(veiculo.marca);
		$('#reboque_modelo').html(veiculo.modelo);
		$('#reboque_placa').html(veiculo.placa);
		$('#reboque_proprietario_nome').html(veiculo.proprietario_nome);
		$('#reboque_proprietario_documento').html(veiculo.proprietario_documento);
		$('#display-reboque').css('display', 'block');
		habilitaBtnSalvar()
	}
}


//** INICIO FUNCOES DE MUNICIPIO
$('#btn-add-municipio-carregamento').click(() => {
	let cidade = JSON.parse($('#kt_select2_4').val());
	console.log(cidade)
	if(cidade != 'null'){
		
		validaMunipioNaoInserido(cidade.id, (res) => {
			if(!res){
				MUNIPIOSCARREGAMENTO.push({id: cidade.id, nome: cidade.nome});
				montaTabelaMunicipioCarregamento();
			}else{
				swal("Erro", "Este municipio já esta incluido", "error")

			}
			console.log(MUNIPIOSCARREGAMENTO)
		})

		habilitaBtnSalvar()

	}else{
		alert("Escolha uma cidade")
	}
})

function montaTabelaMunicipioCarregamento(){
	let html = "";
	MUNIPIOSCARREGAMENTO.map((v) => {

		html += '<tr class="datatable-row">'
		html += '<td class="datatable-cell"><span class="codigo" style="width: 60px;" id="id">'
		html += v.id
		html += '</span></td>'

		html += '<td class="datatable-cell"><span class="codigo" style="width: 200px;" id="id">'
		html += v.nome
		html += '</span></td>'


		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += '<a onclick="deleteMunicipioCarregamento('+v.id+')" class="btn btn-sm btn-danger"><i class="la la-trash"></i></a>'
		html += '</span></td>'

		html += "</tr>";
	})	

	$('#tbody-municipio-carregamento').html(html);
}

function deleteMunicipioCarregamento(cId){
	let temp = [];
	MUNIPIOSCARREGAMENTO.map((m) => {
		if(m.id != cId) temp.push(m);
	})
	MUNIPIOSCARREGAMENTO = temp;
	montaTabelaMunicipioCarregamento()
}

function validaMunipioNaoInserido(cId, call){
	let retorno = false;
	MUNIPIOSCARREGAMENTO.map((m) => {
		if(m.id == cId) retorno = true;
	})
	call(retorno)
}

//***** FIM FUNCOES DE MUNICIPIO



//** INICIO FUNCOES DE PERCURSO
$('#btn-add-percurso').click(() => {
	let uf = $('#percurso').val();
	console.log(uf)

	if(uf.length > 1){

		validaUfNaoInserida(uf, (res) => {
			if(!res){
				PERCURSO.push(uf);
				montaTabelaPercuso();
			}else{
				alert("Esta UF já esta incluido")
			}
			console.log(PERCURSO)
		})
		habilitaBtnSalvar()
		
	}else{
		alert("Escolha uma UF")
	}
})

function montaTabelaPercuso(){
	let html = "";
	PERCURSO.map((v) => {

		html += '<tr class="datatable-row">'
		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += v
		html += '</span></td>'



		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += '<a onclick="deleteUfPercurso(\''+v+ '\')" class="btn btn-sm btn-danger"><i class="la la-trash"></i></a>'
		html += '</span></td>'

		html += "</tr>";

		
	})	

	$('#tbody-percurso').html(html);
}

function deleteUfPercurso(uf){

	let temp = [];
	PERCURSO.map((m) => {

		if(m != uf) temp.push(m);
	})
	PERCURSO = temp;
	montaTabelaPercuso()
}

function validaUfNaoInserida(uf, call){
	let retorno = false;
	PERCURSO.map((m) => {
		if(m == uf) retorno = true;
	})
	call(retorno)
}

//***** FIM FUNCOES DE PERCURSO

//** INICIO FUNCOES DE PERCURSO
$('#btn-add-ciot').click(() => {
	let codigo = $('#ciot_codigo').val();
	let doc = $('#ciot_cpf_cnpj').val();

	if(codigo.length > 1 && doc.length > 10){

		CIOT.push({codigo: codigo, documento: doc});
		montaTabelaCiot();

		habilitaBtnSalvar()

	}else{
		alert("Digite os dados válidos")
	}
})

function montaTabelaCiot(){
	let html = "";
	CIOT.map((v) => {

		html += '<tr class="datatable-row">'
		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += v.codigo
		html += '</span></td>'

		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += v.documento
		html += '</span></td>'

		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += '<a onclick="deleteCiot(\''+v.codigo+ '\')" class="btn btn-sm btn-danger"><i class="la la-trash"></i></a>'
		html += '</span></td>'
		html += '</tr>'

	})	

	$('#tbody-ciot').html(html);
}

function deleteCiot(codigo){

	let temp = [];
	CIOT.map((m) => {

		if(m.codigo != codigo) temp.push(m);
	})
	CIOT = temp;
	montaTabelaCiot()
}


//***** FIM FUNCOES DE PERCURSO

//** INICIO FUNCOES DE PERCURSO
$('#btn-add-vale').click(() => {
	let cnpj_fornecedor = $('#vale_cnpj_fornecedor').val();
	let doc_pagador = $('#vale_cpf_cnpj_pagador').val();
	let numero_compra = $('#vale_numero_compra').val();
	let valor = $('#vale_valor').val();

	if(cnpj_fornecedor.length > 10 && doc_pagador.length > 10 && numero_compra.length > 0 && valor.length > 1){


		VALEPEDAGIO.push(
		{
			id: contVale+1,
			cnpj_fornecedor: cnpj_fornecedor, 
			doc_pagador: doc_pagador,
			numero_compra: numero_compra,
			valor: valor
		}
		);
		montaTabelaValePedagio();
		habilitaBtnSalvar()

		contVale++;
	}else{
		swal("Erro", "Digite todos os valores para adicionar", "error")
	}
})

function montaTabelaValePedagio(){
	let html = "";
	VALEPEDAGIO.map((v) => {

		html += '<tr class="datatable-row">'
		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += v.cnpj_fornecedor
		html += '</span></td>'

		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += v.doc_pagador
		html += '</span></td>'

		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += v.numero_compra
		html += '</span></td>'

		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += v.valor
		html += '</span></td>'

		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += '<a onclick="deleteValePedagio(\''+v.id+ '\')" class="btn btn-sm btn-danger"><i class="la la-trash"></i></a>'
		html += '</span></td>'
		html += '</tr>'


	})	
	$('#tbody-vale-pegadio').html(html);
}

function deleteValePedagio(id){

	let temp = [];
	VALEPEDAGIO.map((m) => {

		if(m.id != id) temp.push(m);
	})
	VALEPEDAGIO = temp;
	montaTabelaValePedagio()
}


//***** FIM FUNCOES DE PERCURSO


//** INICIO FUNCOES DE LACRE TRANSP
$('#btn-add-lacre-transp').click(() => {
	let lacre = $('#lacre_transp').val();

	if(lacre.length > 1){
		
		validaLacreTranspNaoInseido(lacre, (res) => {
			if(!res){
				LACRESTRANSP.push(lacre);
				montaTabelaLacreTransp();
			}else{
				alert("Este Lacre já esta incluido")
			}
			console.log(LACRESTRANSP)
		})
		habilitaBtnSalvar()

	}else{
		alert("Informe um valor para o lacre")
	}
})

function montaTabelaLacreTransp(){
	let html = "";
	LACRESTRANSP.map((v) => {

		html += '<tr class="datatable-row">'
		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += v
		html += '</span></td>'

		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += '<a onclick="deleteLacreTransp(\''+v+ '\')" class="btn btn-sm btn-danger"><i class="la la-trash"></i></a>'
		html += '</span></td>'
		html += '</tr>'

		
	})	

	$('#tbody-lacre-transp').html(html);
}

function deleteLacreTransp(l){
	let temp = [];
	LACRESTRANSP.map((m) => {
		if(m != l) temp.push(m);
	})
	LACRESTRANSP = temp;
	montaTabelaLacreTransp()
}

function validaLacreTranspNaoInseido(l, call){
	let retorno = false;
	LACRESTRANSP.map((m) => {
		if(m == l) retorno = true;
	})
	call(retorno)
}

//***** FIM FUNCOES DE LACRE TRANSP

//** INICIO FUNCOES DE LACRE UNID
$('#btn-add-larcre-unidade').click(() => {
	let lacre = $('#lacre_unidade').val();

	if(lacre.length > 1){
		
		validaLacreUnidNaoInseido(lacre, (res) => {
			if(!res){
				LACRESUNIDCARGA.push(lacre);
				montaTabelaLacreUnidCarga();
			}else{
				alert("Este Lacre já esta incluido")
			}
			console.log(LACRESUNIDCARGA)

		})

	}else{
		alert("Informe um valor para o lacre")
	}
})

function montaTabelaLacreUnidCarga(){
	let html = "";
	LACRESUNIDCARGA.map((v) => {

		html += '<tr class="datatable-row">'
		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += v
		html += '</span></td>'

		html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
		html += '<a onclick="deleteLacreUnidCarga(\''+v+ '\')" class="btn btn-sm btn-danger"><i class="la la-trash"></i></a>'
		html += '</span></td>'
		html += '</tr>'

	})	

	$('#tbody-lacre-unid').html(html);
}

function deleteLacreUnidCarga(l){
	let temp = [];
	LACRESUNIDCARGA.map((m) => {
		if(m != l) temp.push(m);
	})
	LACRESUNIDCARGA = temp;
	montaTabelaLacreUnidCarga()
}

function validaLacreUnidNaoInseido(l, call){
	let retorno = false;
	LACRESUNIDCARGA.map((m) => {
		if(m == l) retorno = true;
	})
	call(retorno)
}

//***** FIM FUNCOES DE MUNICIPIO


//** INICIO FUNCOES add info desc

$('#btn-add-info-desc').click(() => {

	let tpTransp = $('#tp_unid_transp').val();
	let idUnidTransp = $('#id_unid_transp').val();
	let qtdRateioTransp = $('#qtd_rateio_transp').val();
	let idUnidCarga = $('#id_unid_carga').val();
	let qtdRateioUnidCarga = $('#qtd_rateio_unid_carga').val();

	let chaveNFe = $('#chave_nfe').val();
	let segCodNFe = $('#seg_cod_nfe').val();

	let chaveCTe = $('#chave_cte').val();
	let segCodCTe = $('#seg_cod_cte').val();


	validaInsertInfo((msg) => {

		if(msg == ""){
			let js = { 
				id: contInfo+1,
				tpTransp: tpTransp,
				idUnidTransp: idUnidTransp,
				qtdRateioTransp: qtdRateioTransp,
				idUnidCarga: idUnidCarga,
				qtdRateioUnidCarga: qtdRateioUnidCarga,
				chaveNFe: chaveNFe,
				segCodNFe: segCodNFe,
				chaveCTe: chaveCTe,
				segCodCTe: segCodCTe,
				lacresUnidTransp: LACRESTRANSP,
				lacresUnidCarga: LACRESUNIDCARGA,
				municipio: $('#kt_select2_5').val()
			}
			contInfo++;

			INFODESCARGA.push(js);
			montaTabelaInfosDescarga();
			habilitaBtnSalvar();
			limparInfo();
		}else{
			alert(msg)
		}
	})

})

function limparInfo(){
	LACRESTRANSP = [];
	LACRESUNIDCARGA = [];
	$('#tbody-lacre-unid').html("<tr><td>-</td><td>-</td><td>-</td></tr>");
	$('#tbody-lacre-transp').html("<tr><td>-</td><td>-</td><td>-</td></tr>");
	$('#tp_unid_transp').val("");
	$('#id_unid_transp').val("");
	$('#qtd_rateio_transp').val("");
	$('#id_unid_carga').val("");
	$('#qtd_rateio_unid_carga').val("");
	$('#lacre_unidade').val("");
	$('#lacre_transp').val("");

	$('#chave_nfe').val("");
	$('#chave_nfe').attr('disabled', false)
	$('#seg_cod_nfe').val("");
	$('#seg_cod_nfe').attr('disabled', false)


	$('#chave_cte').val("");
	$('#chave_cte').attr('disabled', false)

	$('#seg_cod_cte').val("");
	$('#seg_cod_cte').attr('disabled', false)
	

}

function validaInsertInfo(call){
	let msg = "";
	console.log($('#id_unid_transp').val())
	if($('#chave_nfe').val().length > 0 && $('#seg_cod_nfe').val().length > 0){
		msg += "Informe somente o campo Chave NF-e ou Chave NF-e contigencia\n";
	}
	if($('#chave_cte').val().length > 0 && $('#seg_cod_cte').val().length > 0){
		msg += "Informe somente o campo Chave CT-e ou Chave CT-e contigencia\n";
	}
	if($('#id_unid_transp').val().length == 0){
		msg += "Informe o ID unidade de transporte\n";
	}
	if($('#qtd_rateio_transp').val().length == 0){
		msg += "Informe a quantidade de rateio de transporte\n";
	}
	if($('#qtd_rateio_unid_carga').val().length == 0){
		msg += "Informe a quantidade de rateio da unidade da carga\n";
	}
	if($('#kt_select2_5').val() == 'null'){
		msg += "Informe o municipio de decarregamento\n";
	}
	call(msg);
}

function habilitarInputsdocumentos(){
	$('#chave_nfe').attr('disabled', false)
	$('#chave_cte').attr('disabled', false)
	$('#seg_cod_nfe').attr('disabled', false)
	$('#seg_cod_cte').attr('disabled', false)

	$('#chave_nfe').val("")
	$('#seg_cod_nfe').val("")
	$('#chave_cte').val("")
	$('#seg_cod_cte').val("")
}

function montaTabelaInfosDescarga(){
	let html = "";
	montaLacres(LACRESTRANSP, (lacresTranp) => {
		montaLacres(LACRESUNIDCARGA, (lacresUnid) => {
			INFODESCARGA.map((v) => {
				console.log(v)

				html += '<tr class="datatable-row">'
				html += '<td class="datatable-cell"><span class="codigo" style="width: 120px;" id="id">'
				html += v.tpTransp
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 120px;" id="id">'
				html += v.idUnidTransp
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 120px;" id="id">'
				html += v.qtdRateioUnidCarga
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 150px;" id="id">'
				html += (v.chaveNFe.length > 0 ? v.chaveNFe : v.segCodNFe)
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 150px;" id="id">'
				html += (v.chaveCTe.length > 0 ? v.chaveCTe : v.segCodCTe)
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 150px;" id="id">'
				html += v.municipio
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 150px;" id="id">'
				html += lacresTranp
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 150px;" id="id">'
				html += lacresUnid
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
				html += '<a onclick="deleteInfoDescarga(\''+v.id+ '\')" class="btn btn-sm btn-danger"><i class="la la-trash"></i></a>'
				html += '</span></td>'
				html += '</tr>'

				// html += "<tr>";
				// html += "<td>"+v.tpTransp+"</td>";
				// html += "<td>"+v.idUnidTransp+"</td>";
				// html += "<td>"+v.qtdRateioUnidCarga+"</td>";
				// html += "<td>"+ (v.chaveNFe.length > 0 ? v.chaveNFe : v.segCodNFe) +"</td>";
				// html += "<td>"+ (v.chaveCTe.length > 0 ? v.chaveCTe : v.segCodCTe) +"</td>";
				// html += "<td>"+ v.municipio +"</td>";
				// html += "<td>[" + 
				// lacresTranp
				// +"]</td>";
				// html += "<td>[" + 
				// lacresUnid
				// +"]</td>";
				// html += "<td><a href='#!' onclick='deleteInfoDescarga("+v.id+")'>"+
				// "<i class='material-icons red-text'>delete</i></a></td>";
				// html += "</tr>";
			})	
		})
	})

	$('#tbody-info-descarga').html(html);
}

function montaTabelaInfosDescargaEdit(){
	let html = "";
	
	INFODESCARGA.map((v) => {
		montaLacres(v.lacresUnidTransp, (lacresTranp) => {
			montaLacres(v.lacresUnidCarga, (lacresUnid) => {
				console.log(v)
				// html += "<tr>";
				// html += "<td>"+v.tpTransp+"</td>";
				// html += "<td>"+v.idUnidTransp+"</td>";
				// html += "<td>"+v.qtdRateioUnidCarga+"</td>";
				// html += "<td>"+ (v.chaveNFe.length > 0 ? v.chaveNFe : v.segCodNFe) +"</td>";
				// html += "<td>"+ (v.chaveCTe.length > 0 ? v.chaveCTe : v.segCodCTe) +"</td>";
				// html += "<td>"+ v.municipio +"</td>";
				// html += "<td>[" + 
				// lacresTranp
				// +"]</td>";
				// html += "<td>[" + 
				// lacresUnid
				// +"]</td>";
				// html += "<td><a href='#!' onclick='deleteInfoDescarga("+v.id+")'>"+
				// "<i class='material-icons red-text'>delete</i></a></td>";
				// html += "</tr>";


				html += '<tr class="datatable-row">'
				html += '<td class="datatable-cell"><span class="codigo" style="width: 120px;" id="id">'
				html += v.tpTransp
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 120px;" id="id">'
				html += v.idUnidTransp
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 120px;" id="id">'
				html += v.qtdRateioUnidCarga
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 150px;" id="id">'
				html += (v.chaveNFe.length > 0 ? v.chaveNFe : v.segCodNFe)
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 150px;" id="id">'
				html += (v.chaveCTe.length > 0 ? v.chaveCTe : v.segCodCTe)
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 150px;" id="id">'
				html += v.municipio
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 150px;" id="id">'
				html += lacresTranp
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 150px;" id="id">'
				html += lacresUnid
				html += '</span></td>'

				html += '<td class="datatable-cell"><span class="codigo" style="width: 100px;" id="id">'
				html += '<a onclick="deleteInfoDescarga(\''+v.id+ '\')" class="btn btn-sm btn-danger"><i class="la la-trash"></i></a>'
				html += '</span></td>'
				html += '</tr>'
			})	
		})
	})

	$('#tbody-info-descarga').html(html);
}

function montaLacres(array, call){
	let cont = 0;
	let lacres = "";
	array.map((v) => {
		cont++;
		lacres +=  v + (cont < array.length ? ", " : "")
	})
	call(lacres)
}

function deleteInfoDescarga(l){
	let temp = [];
	INFODESCARGA.map((m) => {

		if(m.id != l) temp.push(m);
	})
	INFODESCARGA = temp;
	montaTabelaInfosDescarga()
}

//***** FIM FUNCOES DE MUNICIPIO


$('#chave_nfe').on('keyup', () => { 
	if($('#chave_nfe').val().length > 0){
		$('#seg_cod_nfe').val('');
	}
})
$('#seg_cod_nfe').on('keyup', () => { 
	if($('#seg_cod_nfe').val().length > 0){
		$('#chave_nfe').val('');
	}
})
$('#chave_cte').on('keyup', () => { 
	if($('#chave_cte').val().length > 0){
		$('#seg_cod_cte').val('');
	}
})
$('#seg_cod_cte').on('keyup', () => { 
	if($('#seg_cod_cte').val().length > 0){
		$('#chave_cte').val('');
	}
})

$('#condutor_nome').on('keyup', () => { 
	habilitaBtnSalvar()
})

$('#condutor_cpf').on('keyup', () => { 
	habilitaBtnSalvar()
})


function habilitaBtnSalvar(){
	let camposValidos = true;

	if($('#condutor_nome').val().length < 2){
		camposValidos = false;
	}
	if($('#condutor_cpf').val().length < 11){
		camposValidos = false;
	}

	if(MUNIPIOSCARREGAMENTO.length > 0 && INFODESCARGA.length > 0 && $('#cnpj_contratante').val().length > 10
		&& VEICULOREBOQUE != null && VEICULOTRACAO != null && camposValidos){
		$('#finalizar').removeClass('disabled')
}else{
	$('#finalizar').addClass('disabled')
}
}

function salvarMDFe(){
	console.log('salvando');
	validaMDFe((msgErro) => {

		if(msgErro == ""){
			let js = {
				id: MDFEID,
				infoDescarga: INFODESCARGA,
				municipios_carregamento: MUNIPIOSCARREGAMENTO,
				ciot: CIOT,
				vale_pedagio: VALEPEDAGIO,
				percurso: PERCURSO,
				veiculo_tracao: VEICULOTRACAO.id,
				veiculo_reboque: VEICULOREBOQUE.id,
				uf_inicio: $('#uf_inicio').val(),
				uf_fim: $('#uf_fim').val(),
				data_inicio_viagem: $('#kt_datepicker_3').val(),
				carga_posteior: $('#carga_posteior').is(':checked') ? 1 : 0,
				cnpj_contratante: $('#cnpj_contratante').val(),
				seguradora_nome: $('#seguradora_nome').val(),
				seguradora_numero_apolice: $('#seguradora_numero_apolice').val(),
				seguradora_numero_averbacao: $('#seguradora_numero_averbacao').val(),
				seguradora_cnpj: $('#seguradora_cnpj').val(),
				valor_carga: $('#valor_carga').val(),
				qtd_carga: $('#quantidade_carga').val(),
				info_complementar: $('#info_complementar').val(),
				info_fisco: $('#info_fisco').val(),
				condutor_nome: $('#condutor_nome').val(),
				condutor_cpf: $('#condutor_cpf').val(),
				tp_emit: $('#tpEmit').val(),
				tp_transp: $('#tpTransp').val(),
				lacre_rodo: $('#lacre_rodo').val(),
				produto_pred_nome: $('#produto_pred_nome').val(),
				produto_pred_ncm: $('#produto_pred_ncm').val(),
				produto_pred_cod_barras: $('#produto_pred_cod_barras').val(),
				cep_carrega: $('#cep_carrega').val(),
				cep_descarrega: $('#cep_descarrega').val(),
				tp_carga: $('#tp_carga').val()
			}

			console.log(js)

			let url = 'mdfe/salvar';
			
			if(MDFEID > 0){
				url = 'mdfe/update'
			}
			$.post(path + url, {_token: $('#_token').val(), data: js})
			.done((res) => {
				console.log(res)
				sucesso();

			})
			.fail((err) => {
				console.log(err)
			})
		}else{
			alert(msgErro)
		}
	})
}

function sucesso(){
	$('#content').css('display', 'none');
	$('#anime').css('display', 'block');
	setTimeout(() => {
		location.href = path+'mdfe';
	}, 4500)
}

function validaMDFe(call){
	let msgErro = "";


	call(msgErro);
}


//habilita e desabilita campos de ref nfe e cte

$('#chave_nfe').on('keyup', () => {
	if($('#chave_nfe').val().length > 0){
		$('#chave_cte').attr('disabled', true)
		$('#seg_cod_cte').attr('disabled', true)

		$('#chave_cte').val("")
		$('#seg_cod_cte').val("")
	}else{
		$('#chave_cte').attr('disabled', false)
		$('#seg_cod_cte').attr('disabled', false)
	}

})

$('#chave_cte').on('keyup', () => {
	if($('#chave_cte').val().length > 0){
		$('#chave_nfe').attr('disabled', true)
		$('#seg_cod_nfe').attr('disabled', true)

		$('#chave_nfe').val("")
		$('#seg_cod_nfe').val("")
	}else{
		$('#chave_nfe').attr('disabled', false)
		$('#seg_cod_nfe').attr('disabled', false)
	}
})



