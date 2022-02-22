<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemDfe extends Model
{
    protected $fillable = [
		'numero_nfe', 'produto_id', 'empresa_id'
	];
}
