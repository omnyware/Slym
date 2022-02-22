<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidoDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_deliveries', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            
            $table->integer('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('cliente_deliveries')->onDelete('cascade');
            $table->timestamp('data_registro')->useCurrent();

            $table->decimal('valor_total', 10,2);
            $table->decimal('troco_para', 10,2);

            $table->string('forma_pagamento', 20);
            $table->string('observacao', 50);

            $table->string('telefone', 15);
            
            $table->string('estado', 10);
            $table->string('motivoEstado', 50);

             // nv - novo
            // ap - aprovado
            // rp - reprovado
            // rc - recusado
            //fz - finalziado

            $table->integer('endereco_id')->nullable()->unsigned();
            $table->foreign('endereco_id')->references('id')->on('endereco_deliveries')->onDelete('cascade');

            $table->integer('cupom_id')->nullable()->unsigned();
            $table->foreign('cupom_id')->references('id')->on('codigo_descontos')->onDelete('cascade');
            $table->decimal('desconto', 10,2);

            $table->boolean('app');


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
        Schema::dropIfExists('pedido_deliveries');
    }
}
