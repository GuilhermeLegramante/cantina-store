<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('entry_products_id')->comment('FK, entry_products.id');               // Relação da entrada do produto (Sempre relacionar)
            $table->integer('output_products_id')->nullable()->comment('FK, output_products.id'); // Relação com a saída de produtos (Exceto na entrada)
            $table->enum('operation', ['E', 'S', 'EE', 'ES'])->comment('Entrada, Saída, Estorno entrada, Estorno saida');
            $table->decimal('amout', 15, 2)->comment('Quantidade do produto movimentada');
            $table->decimal('value', 15, 2)->comment('Valor unitário do produto movimentado');
            $table->timestamps();

            $table->foreign('entry_products_id')->references('id')->on('entry_products')->onDelete('no action');
            $table->foreign('output_products_id')->references('id')->on('output_products')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movements');
    }
}
