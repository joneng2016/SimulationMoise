<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEntityRelation01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {			
        Schema::table('entity_relations',function(Blueprint $table){
            $table->enum('type_relation',['agent_get_tool','tool_on_object','agent_drop_tool','remove_tool_on_object'])->after('id');
            $table->enum('status',['created','destroyed'])->after('entity_two_id');
            $table->unsignedInteger('condition_id')->after('entity_two_id');
            $table->foreign('condition_id')->references('id')->on('conditions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
