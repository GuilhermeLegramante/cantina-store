<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('description')->unique();
            $table->string('code')->unique();
            $table->string('barcode')->unique();
            $table->integer('measurement_unit_id');
            $table->integer('cest_ncm_id');
            $table->integer('cfop_id');
            $table->integer('csosn_id');
            $table->integer('user_id');
            $table->timestamps();
            $table->foreign('measurement_unit_id')
                ->references('id')
                ->on('measurement_units')
                ->onDelete('cascade');
            $table->foreign('cest_ncm_id')
                ->references('id')
                ->on('cest_ncm')
                ->onDelete('cascade');
            $table->foreign('cfop_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('csosn_id')
                ->references('id')
                ->on('csosn')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
