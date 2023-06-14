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
            $table->integer('manufacturer_id');
            $table->integer('category_id');
            $table->string('description')->unique();
            $table->string('code')->unique()->nullable();
            $table->string('barcode')->unique()->nullable();
            $table->double('weight')->nullable();
            $table->integer('measurement_unit_id')->nullable();
            $table->integer('cest_ncm_id')->nullable();
            $table->integer('cfop_id')->nullable();
            $table->integer('csosn_id')->nullable();
            $table->double('cost_price')->nullable();
            $table->integer('user_id');
            $table->timestamps();
            $table->foreign('manufacturer_id')
                ->references('id')
                ->on('manufacturers')
                ->onDelete('cascade');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
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
                ->on('cfop')
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
