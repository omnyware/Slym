<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');

            $table->string('chave_nfe', 450);
            $table->integer('remetente_id')->unsigned();
            $table->foreign('remetente_id')->references('id')
            ->on('clientes');
            $table->integer('destinatario_id')->unsigned();
            $table->foreign('destinatario_id')->references('id')
            ->on('clientes');

            $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('usuarios');

            $table->integer('natureza_id')->unsigned();
            $table->foreign('natureza_id')->references('id')->on('natureza_operacaos');

            $table->integer('tomador');
            // Indica o "papel" do tomador: 0-Remetente; 1-Expedidor; 2-Recebedor; 3-Destinatário

            $table->integer('municipio_envio')->unsigned();
            $table->foreign('municipio_envio')->references('id')
            ->on('cidades');

            $table->integer('municipio_inicio')->unsigned();
            $table->foreign('municipio_inicio')->references('id')
            ->on('cidades');

            $table->integer('municipio_fim')->unsigned();
            $table->foreign('municipio_fim')->references('id')
            ->on('cidades');

            $table->string('logradouro_tomador', 80)->nullable();
            $table->string('numero_tomador', 20)->nullable();
            $table->string('bairro_tomador', 40)->nullable();
            $table->string('cep_tomador', 10)->nullable();

            $table->integer('municipio_tomador')->nullable()->unsigned();
            $table->foreign('municipio_tomador')->references('id')
            ->on('cidades');

            $table->decimal('valor_transporte', 10, 2);
            $table->decimal('valor_receber', 10, 2);
            $table->decimal('valor_carga', 10, 2);
            
            $table->string('produto_predominante', 30);
            $table->date('data_previsata_entrega');

            $table->string('observacao');
            $table->integer('sequencia_cce');
            $table->integer('cte_numero')->default(0);
            $table->string('chave', 48);
            $table->string('path_xml', 51);
            $table->string('estado', 20);
            $table->timestamp('data_registro')->useCurrent();

            $table->boolean('retira');
            $table->string('detalhes_retira', 100);
            $table->string('modal', 2);

            $table->integer('veiculo_id')->unsigned();
            $table->foreign('veiculo_id')->references('id')
            ->on('veiculos');

            $table->string('tpDoc', 2);
            $table->string('descOutros', 100);
            $table->integer('nDoc');
            $table->decimal('vDocFisc', 10, 2);
            $table->integer('globalizado');
            
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
        Schema::dropIfExists('ctes');
    }
}
