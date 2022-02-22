<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_deliveries', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nome', 30);
            $table->string('sobre_nome', 30);

            $table->string('senha', 80);
            $table->string('celular', 15);
            $table->string('email', 50);
            $table->integer('token');
            $table->timestamp('data_token')->useCurrent();
            $table->boolean('ativo');
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
        Schema::dropIfExists('cliente_deliveries');
    }
}
