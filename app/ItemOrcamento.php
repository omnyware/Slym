<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemOrcamento extends Model
{
    protected $fillable = [
		'produto_id', 'orcamento_id', 'quantidade', 'valor'
	];

	public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }

    public function orcamento(){
        return $this->belongsTo(Orcamento::class, 'orcamento_id');
    }


}
