<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');

            $table->integer('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');

            $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('usuarios');

            $table->integer('natureza_id')->unsigned();
            $table->foreign('natureza_id')->references('id')->on('natureza_operacaos');

            $table->integer('frete_id')->nullable()->unsigned();
            $table->foreign('frete_id')->references('id')->on('fretes')->onDelete('cascade');

            $table->integer('transportadora_id')->nullable()->unsigned();
            $table->foreign('transportadora_id')->references('id')->on('transportadoras')
            ->onDelete('cascade');

            $table->timestamp('data_registro')->useCurrent();
            $table->decimal('valor_total', 10,2);
            $table->decimal('desconto', 10,2);

            $table->string('forma_pagamento', 20);
            $table->string('tipo_pagamento', 2);
            $table->string('observacao');
            $table->string('estado', 20);
            $table->integer('sequencia_cce');

            $table->integer('NfNumero')->default(0);
            $table->string('chave',48);
            $table->string('path_xml',51);

            $table->integer('serie')->default(0);
            $table->string('chav_ref',48);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendas');
    }
}
