<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('output', function (Blueprint $table) {
            $table->integer('id', true);                                                   // Relação das saídas dos produtos, seja por venda, devolução, baixa, ajuste, etc.
            $table->integer('store_id')->comment('FK, stores.id');                         // Loja responsável (Proprietária) pelo produto
            $table->integer('costumer_id')->comment('FK, customers.id');                   // Cliente que realizou a compra ou loja destino do produto
            $table->integer('type_id')->comment('FK, types.id');                           // Tipo do movimento de saída
            $table->string('nfe_id', 47)->nullable()->comment('Id da Nfe para consulta');  // Dados da NF-e para caso de venda ou transporte
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores')->onDelete('no action');
            $table->foreign('costumer_id')->references('id')->on('costumers')->onDelete('no action');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('output');
    }
}
