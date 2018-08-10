<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\VocabularyQuery;

class Query
{
	public function logicExpresssionOne($arg_1,$arg_2,$arg_3){
		return ($arg_1 == "obligation_permission") && ($arg_2 == $arg_3);
	}
	public function queryMissions($struct,$agent,&$answer){
		foreach($agent->role as $role){
			$role_id = $role[0]->first()->id;
		}
		foreach($struct->mission as $mission)
		{
			foreach($mission->deontic_relation as $deontic_relation){
				if($this->logicExpresssionOne($deontic_relation->type,$deontic_relation->role_id,$role_id))
					$answer[] = $mission;
			}
		}
	}
	public function queryThisMissionIsInSchema($mission_analize,$schema_name,$struct,&$answer){
		$mission_name_analize = $mission_analize->mission->name;
		foreach($struct->schema as $schema){
			if($schema->schema->name == $schema_name){
				foreach($schema->mission as $mission){
					if($mission_name_analize == $mission->name);
						$answer = true;
					if($answer) break;
				}
			}
			if($answer) break;
		}
	}
	public function queryAllGoalOfThisMission($mission,&$answer){
		$answer = $mission->goal;
	}

	public function queryAboutThisGoal($goal,$struct){
		$name_of_goal = $goal->first()->name;
		foreach($struct->goal as $goal_of_struct){
			if($goal_of_struct->goal->name == $name_of_goal)
				return $goal_of_struct->reached;
			
		}
	}

}
