<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Repositories\CfopRepository;

class CreateCfopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cfop', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('code')->unique();
            $table->string('description');
            $table->timestamps();
        });

        $cfop = new CfopRepository();
        $cfop->populate();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cfop');
    }
}
