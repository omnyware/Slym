<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPackProdutoDelivery extends Model
{
    protected $fillable = ['produto_delivery_id', 'pack_id', 'quantidade'];
    
}
