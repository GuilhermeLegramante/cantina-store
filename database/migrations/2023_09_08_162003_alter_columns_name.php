<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('output', function (Blueprint $table) {
            $table->renameColumn('costumer_id', 'customer_id');

            $table->dropForeign('output_costumer_id_foreign');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('no action');
        });

        Schema::table('entry', function (Blueprint $table) {
            $table->renameColumn('users_id', 'user_id');

            $table->dropForeign('entry_users_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
        });
        
        Schema::table('entry_products', function (Blueprint $table) {
            $table->renameColumn('products_id', 'product_id');

            $table->dropForeign('entry_products_products_id_foreign');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('no action');
        });
        
        Schema::table('movements', function (Blueprint $table) {
            $table->dropForeign('movements_output_products_id_foreign');
            $table->dropForeign('movements_entry_products_id_foreign');
            
            $table->renameColumn('entry_products_id', 'entry_product_id');
            $table->renameColumn('output_products_id', 'output_product_id');
            
            $table->foreign('entry_product_id')->references('id')->on('entry_products')->onDelete('no action');
            $table->foreign('output_product_id')->references('id')->on('output_products')->onDelete('no action');
        });
        
        Schema::table('output_products', function (Blueprint $table) {
            $table->renameColumn('products_id', 'product_id');

            $table->dropForeign('output_products_products_id_foreign');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('no action');
        });
        
        Schema::table('stores', function (Blueprint $table) {
            $table->renameColumn('users_id', 'user_id');

            $table->dropForeign('stores_users_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
