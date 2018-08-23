<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\VocabularyQuery;

class GoalPrint
{
	static $goal;
	static $name;
	static $agent;
	static $count = 1;
	public static function loadGoal($goal,$name,$agent){
		self::$goal = $goal;
		self::$name = $name;
		self::$agent = $agent;
	}
	public static function startPrint(){
		echo "¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨\n";
		echo "START SIMULATION *****************************\n";		
		echo "***********************************************\n";
	}
	public static function printGoal(){
		foreach(self::$goal as $goal){
			if($goal->name == self::$name)
			{
				if($goal->reached)
					$status = 'Completed';
				else
					$status = 'Not-Completed';


				echo "COUNT > ".self::$count." | GOAL > ".$goal->name." | MISSION > ".$goal->mission." ::: Status > ".$status." ::: Agent >".self::$agent." <br>";
				self::$count++;
			}
		}
	}
	public static function finishSimulation(){
		echo "¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨\n";
		echo "FINISH  ***************************************\n";		
		echo "***********************************************\n";		
	}
	public static function printDieProbability($probability){
		echo "Probability - of Die > ".$probability."\n";
	}
	public static function runCaseGeneration(){
		echo "finish one case\n";
	}
	public static function finishStatisticTract(){
		echo "Finish Statistic Tract\n";
	}
}
