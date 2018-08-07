<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status_goal',['sub','super']);
            $table->unsignedInteger('plans_id');
            $table->foreign('plans_id')->references('id')->on('plans')->onDelete('cascade');
            $table->unsignedInteger('group_sub_id');
            $table->foreign('group_sub_id')->references('id')->on('groups')->onDelete('cascade');
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
        Schema::dropIfExists('sub_groups');
    }
}
