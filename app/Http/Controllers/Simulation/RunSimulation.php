<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Simulation\GoalPrint;
class RunSimulation
{

	public static function numberOfCaseUp($max,$name_interaction)
	{	
		GoalPrint::startPrint();
		
		for($i=1; $i<=$max;$i++)
		{
			self::interaction($i,$analizes);
			$probability_bad[] = self::analizeSituation($analizes);
		}
	   
		GoalPrint::finishSimulation();
	}
	
	public static function probabilityALotOfCase($interaction_first_level,$interaction_second_level)
	{
		GoalPrint::startPrint();
				
		for($i=0; $i < $interaction_second_level;$i++)
		{
			self::interaction($interaction_first_level,$analizes);
			$probability_bad[] = self::analizeSituation($analizes);
		}
	   
		GoalPrint::finishSimulation();		  
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
		GoalPrint::startPrint();
		self::interaction(1000,$analizes);
		$probability_bad = self::analizeSituation($analizes);
		(new \App\Http\Controllers\Simulation\GoalPrint())::printDieProbability($probability_bad);
      	GoalPrint::finishSimulation();
	}
	public static function casegenerateindb($name_simulation,$number_interaction){
		self::interaction($number_interaction,$analizes);
		return (new Statistic)->workAboutData($analizes,$name_simulation);
	}

	public static function casemoungraf($name_of_sim,$goals,$begin_prob,$end_prob,$unit_prob){
		GoalPrint::startPrint();
		$probability = $begin_prob;
		
		self::updateGoals($goals,$probability);

		while($probability < $end_prob)
			self::runProbCase($name_of_sim,$probability,$unit_prob,$goals);
		
	
		GoalPrint::finishSimulation();
	}
	public static function runProbCase(&$name_of_sim,&$probability,$unit_prob,$goals)
	{
		
		self::casegenerateindb($name_of_sim." - ".$probability,1000);
		(new Statistic)->tractDataStatisticMove($name_of_sim." - ".$probability);				
		self::updateProbInGoal($probability,$unit_prob,$goals);

		GoalPrint::runCaseGeneration();
	}

	public static function updateProbInGoal(&$probability,$unit_prob,$goals){
		$probability+=$unit_prob;
		self::updateGoals($goals,$probability);		
	}
	public static function updateGoals($goals,$probability){
		foreach ($goals as $goal) {
			(new \App\Models\Goal)->updateGoal($goal,$probability);
		}
	}
}
