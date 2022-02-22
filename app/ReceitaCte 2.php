<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceitaCte extends Model
{	
	protected $fillable = [
		'descricao', 'cte_id', 'valor', 'data_registro'
	];

	public function cte(){
        return $this->hasOne('App\Cte', 'id', 'cte_id');
    }
}
