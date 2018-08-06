<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goal_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status_goal',['super','sub']);
            $table->unsignedInteger('goal_id');
            $table->foreign('goal_id')->references('id')->on('goals')->onDelete('cascade');
            $table->unsignedInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');            
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
        Schema::dropIfExists('goal_plans');
    }
}
