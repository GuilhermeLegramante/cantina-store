<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutputProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('output_products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('output_id')->comment('FK, output.id');
            $table->integer('products_id')->comment('FK, products.id');
            $table->timestamps();

            $table->foreign('output_id')->references('id')->on('output')->onDelete('no action');
            $table->foreign('products_id')->references('id')->on('products')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('output_products');
    }
}
