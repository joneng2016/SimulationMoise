<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataSimulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_simulations', function (Blueprint $table) {
            $table->increments('id');
			$table->string('situation');
			$table->string('goal');
			$table->string('mission');
			$table->string('agent');
			$table->unsignedInteger('name_id');
			$table->foreign('name_id')->references('id')->on('name_simulations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_simulations');
    }
}
