<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeonticRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deontic_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',['obligation_permission','permission']);
            $table->unsignedInteger('mission_id');
            $table->foreign('mission_id')->references('id')->on('missions');
            $table->unsignedInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');            
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
        Schema::dropIfExists('deontic_relations');
    }
}
