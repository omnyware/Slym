<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TokenWeb extends Model
{
     protected $fillable = [
		'token', 'cliente_id'
	];
}
