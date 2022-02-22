<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComponenteCte extends Model
{
    protected $fillable = [
		'nome', 'valor', 'cte_id'
	];
}
