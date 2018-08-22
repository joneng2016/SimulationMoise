<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;

class RunSimulation
{

	public static function numberOfCaseUp($max,$name_interaction)
	{	
		\App\Http\Controllers\Simulation\GoalPrint::startPrint();
		
		for($i=1; $i<=$max;$i++)
		{
			self::interaction($i,$analizes);
			$probability_bad[] = self::analizeSituation($analizes);
		}
	   
		\App\Http\Controllers\Simulation\GoalPrint::finishSimulation();
	}
	
	public static function probabilityALotOfCase($interaction_first_level,$interaction_second_level)
	{
		\App\Http\Controllers\Simulation\GoalPrint::startPrint();
				
		for($i=0; $i < $interaction_second_level;$i++)
		{
			self::interaction($interaction_first_level,$analizes);
			$probability_bad[] = self::analizeSituation($analizes);
		}
	   
		\App\Http\Controllers\Simulation\GoalPrint::finishSimulation();		  
	}

	public static function analizeSituation($analizes)
	{
      $total = 0;
      $total_die = 0;
      $total_completed = 0;
 
		foreach($analizes as $analize){
       	if($analize->status)
        		$total_completed++;
        	else
        		$total_die++;

        	$total++;
    	}
		return 100*(($total_die)/$total);
	}

	public static function interaction($number,&$analizes){
		for($i=0;$i<$number;$i++)
      {	
         $agent_run = (new \App\Http\Controllers\Simulation\AgentsRun());
         $agent_run->getSchema("schema01");            
     		$analizes[] = $agent_run->mainRun();
    	}
	}
	public static function caseone()
	{
		(new \App\Http\Controllers\Simulation\GoalPrint())::startPrint();
		self::interaction(1000,$analizes);
		$probability_bad = self::analizeSituation($analizes);
		(new \App\Http\Controllers\Simulation\GoalPrint())::printDieProbability($probability_bad);
      	(new \App\Http\Controllers\Simulation\GoalPrint())::finishSimulation();
	}

	
}
