<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Repositories\CestncmRepository;

class CreateCestNcmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cest_ncm', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('cest');
            $table->string('ncm');
            $table->string('description');
            $table->timestamps();
        });

        $cest = new CestncmRepository();
        $cest->populate();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cest_ncm');
    }
}
