<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    protected $fillable = [
		'senha', 'arquivo', 'empresa_id'
	];
}
