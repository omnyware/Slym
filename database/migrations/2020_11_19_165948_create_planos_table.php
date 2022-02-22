<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 40);
            $table->decimal('valor', 6,2);
            $table->integer('maximo_clientes');
            $table->integer('maximo_produtos');
            $table->integer('maximo_fornecedores');
            $table->integer('maximo_nfes');
            $table->integer('maximo_nfces');
            $table->integer('maximo_cte');
            $table->integer('maximo_mdfe');
            $table->integer('maximo_evento');
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
        Schema::dropIfExists('planos');
    }
}
