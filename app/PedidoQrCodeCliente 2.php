<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoQrCodeCliente extends Model
{
    protected $fillable = [
        'pedido_id', 'hash'
    ];

}
