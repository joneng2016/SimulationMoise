<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goal_missions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('goal_id');
            $table->foreign('goal_id')->references('id')->on('goals')->onDelete('cascade');
            $table->unsignedInteger('mission_id');
            $table->foreign('mission_id')->references('id')->on('missions')->onDelete('cascade');
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
        Schema::dropIfExists('goal_missions');
    }
}
