<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\VocabularyQuery;

class MainRun
{
	public static function run(){
		self::withcasegoal02();
	}
	public static function withcasegoal01()
	{
		$name_of_sim = "goal_simulation_test_goal01_2308";
		$goals = ["goal01"];
		$begin_prob = 0.1;
		$end_prob = 1.0;
		$unit_prob = 0.01;
		RunSimulation::casemoungraf($name_of_sim,$goals,$begin_prob,$end_prob,$unit_prob);		
	}
	public static function withcasegoal02()
	{
		for($i = 1; $i < 6; $i++)
			RunSimulation::casemoungraf("goal_simulation_test_goal0".$i."_2308-3",["goal0".$i],0.05,1.0,0.05);		
	}
}
