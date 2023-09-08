<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100)->comment('Descricao do tipo'); // Relação dos tipos de saída. Ex: Venda, Transferência, Baixa, ...
            $table->boolean('locked')->default(false)->comment('Registro bloqueado para edicao');
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
        Schema::dropIfExists('types');
    }
}
