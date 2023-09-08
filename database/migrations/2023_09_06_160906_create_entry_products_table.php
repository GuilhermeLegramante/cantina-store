<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntryProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('entry_id')->comment('FK, entry.id');
            $table->integer('products_id')->comment('FK, products.id');
            $table->date('expiration_date')->nullable()->comment('Data de validade');
            $table->timestamps();

            $table->foreign('entry_id')->references('id')->on('entry')->onDelete('cascade');
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
        Schema::dropIfExists('entry_products');
    }
}
