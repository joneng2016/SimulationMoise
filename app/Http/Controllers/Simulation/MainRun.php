<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\VocabularyQuery;

class MainRun
{
	public static function run(){
		(new \App\Http\Controllers\Simulation\GoalPrint())::startPrint();
        $agent_run = (new \App\Http\Controllers\Simulation\AgentsRun());
        $agent_run->getSchema("schema01");            
        $agent_run->mainRun();
        (new \App\Http\Controllers\Simulation\GoalPrint())::finishSimulation();
	}
}