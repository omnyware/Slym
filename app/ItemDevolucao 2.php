<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemDevolucao extends Model
{
    protected $fillable = [
		'cod', 'nome', 'ncm', 'cfop', 'valor_unit', 'quantidade', 'item_parcial', 'devolucao_id', 'codBarras', 'unidade_medida', 'cst_csosn', 'cst_pis', 'cst_cofins', 'cst_ipi',
		'perc_icms', 'perc_pis', 'perc_cofins', 'perc_ipi'
	];
}
