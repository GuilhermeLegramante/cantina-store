<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Repositories\CsosnRepository;

class CreateCsosnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csosn', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('code')->unique();
            $table->string('description');
            $table->timestamps();
        });

        $cson = new CsosnRepository();
        $cson->populate();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('csosn');
    }
}
