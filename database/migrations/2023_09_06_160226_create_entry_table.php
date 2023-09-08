<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('users_id')->comment('FK, users.id');
            $table->integer('store_id')->comment('FK, stores.id'); // Loja que detém a "propriedade" do produto
            $table->string('nfe_id', 47)->nullable()->comment('Id da Nfe para consulta');
            $table->string('nfe_code', 15)->nullable()->unique('idx_cost_control_code')->comment('Codigo da Nfe');
            $table->date('date')->comment('Data da entrada da nota');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('no action');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entry');
    }
}
