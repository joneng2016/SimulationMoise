<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',['link_authority','link_communication','link_acquaintace','heritage','compatibility']);
            $table->unsignedInteger('role_one_id');
            $table->foreign('role_one_id')->references('id')->on('roles')->onDelete('cascade');
            $table->unsignedInteger('role_two_id');
            $table->foreign('role_two_id')->references('id')->on('roles')->onDelete('cascade');
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
        Schema::dropIfExists('role_relations');
    }
}
