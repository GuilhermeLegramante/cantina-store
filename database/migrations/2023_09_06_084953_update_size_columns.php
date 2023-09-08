<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSizeColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cest_ncm', function (Blueprint $table) {
            $table->string('cest', 7)->change();
            $table->string('ncm', 10)->change();
            $table->string('description', 1000)->change();
        });

        Schema::table('cfop', function (Blueprint $table) {
            $table->string('code', 5)->change();
            $table->string('description', 1000)->change();
        });

        Schema::table('csosn', function (Blueprint $table) {
            $table->string('code', 3)->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->decimal('weight', 15, 2)->comment('Peso bruto em gramas')->change();
            $table->decimal('cost_price', 15, 2)->comment('Preco de custo')->change();
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
