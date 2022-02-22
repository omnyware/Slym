<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EscritorioContabil extends Model
{
    protected $fillable = [
        'razao_social', 'nome_fantasia', 'cnpj', 'ie', 'logradouro',
        'numero', 'bairro', 'fone', 'email', 'cep', 'empresa_id'
    ];
}
