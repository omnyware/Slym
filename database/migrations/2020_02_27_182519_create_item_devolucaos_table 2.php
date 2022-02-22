<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemDevolucaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_devolucaos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('cod', 10);
            $table->string('nome', 150);
            $table->string('ncm', 10);
            $table->string('cfop', 10);
            $table->string('codBarras', 13);
            $table->decimal('valor_unit', 10, 2);
            $table->decimal('quantidade', 8, 2);
            $table->boolean('item_parcial');    
            $table->string('unidade_medida', 8);   

            $table->string('cst_csosn', 3);   
            $table->string('cst_pis', 3);   
            $table->string('cst_cofins', 3);   
            $table->string('cst_ipi', 3);   
            $table->decimal('perc_icms');   
            $table->decimal('perc_pis');   
            $table->decimal('perc_cofins');   
            $table->decimal('perc_ipi');  

            $table->integer('devolucao_id')->unsigned();
            $table->foreign('devolucao_id')->references('id')->on('devolucaos')
            ->onDelete('cascade');

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
        Schema::dropIfExists('item_devolucaos');
    }
}
