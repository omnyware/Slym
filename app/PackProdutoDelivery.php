<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackProdutoDelivery extends Model
{
    protected $fillable = ['nome', 'descricao', 'valor'];
}
