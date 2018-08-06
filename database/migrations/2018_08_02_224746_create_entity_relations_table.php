<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_relations', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('entity_one_id');
			$table->foreign('entity_one_id')->references('id')->on('entities')->onDelete('cascade');
			$table->unsignedInteger('entity_two_id');
			$table->foreign('entity_two_id')->references('id')->on('entities')->onDelete('cascade');
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
        Schema::dropIfExists('entity_relations');
    }
}
