<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_configs', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');

            $table->string('link_face');
            $table->string('link_twiteer');
            $table->string('link_google');
            $table->string('link_instagram');
            $table->string('telefone', 20);
            $table->string('endereco', 80);
            $table->string('tempo_medio_entrega', 10);
            $table->string('tempo_maximo_cancelamento', 10);
            $table->decimal('valor_entrega', 10, 2);
            $table->string('nome_exibicao_web', 30);
            $table->string('latitude', 10);
            $table->string('longitude', 10);
            $table->string('politica_privacidade', 400);
            $table->decimal('valor_km', 10, 2);
            $table->integer('entrega_gratis_ate');
            $table->integer('maximo_km_entrega');
            $table->boolean('usar_bairros');

            $table->integer('maximo_adicionais');
            $table->integer('maximo_adicionais_pizza');
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
        Schema::dropIfExists('delivery_configs');
    }
}
