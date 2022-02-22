<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContaPagarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_pagars', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');

            $table->integer('compra_id')->nullable()->unsigned();
            $table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade');

            $table->integer('categoria_id')->unsigned();
            $table->foreign('categoria_id')->references('id')->on('categoria_contas')->onDelete('cascade');
            $table->string('referencia');
            $table->decimal('valor_integral', 10,2);
            $table->decimal('valor_pago', 10,2)->default(0);
            $table->timestamp('date_register')->useCurrent();
            $table->date('data_vencimento');
            $table->date('data_pagamento');
            $table->boolean('status')->default(false);

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
        Schema::dropIfExists('conta_pagars');
    }
}
