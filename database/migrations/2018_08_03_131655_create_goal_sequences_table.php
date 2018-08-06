<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalSequencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goal_sequences', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('plan_sequence');
            $table->foreign('plan_sequence')->references('id')->on('plans')->onDelete('cascade');
            $table->string('sequence_goal');            
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
        Schema::dropIfExists('goal_sequences');
    }
}
