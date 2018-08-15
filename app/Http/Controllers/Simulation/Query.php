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
	public function changeGoalReached($name_of_goal,&$struct){
		foreach($struct->goal as $goal_of_struct){
			if($goal_of_struct->goal->name == $name_of_goal)
			{
				$goal_of_struct->reached = true;
				return true;
			}
			
		}
	}
	public function queryAllSubPlanOfGoal($goal,$struct){
		$vetToReturn = null;
		foreach ($struct->goal as $g)
		{	
			if($g->goal->name == $goal[0]->name)
			{
				foreach($g->plan as $plan){
					if($plan['status'] == 'super'){
						$name_of_plan = $plan['plan']->first()->name;
						$this->verifyReachedCondition($struct,$name_of_plan,$vetToReturn);
					}
				}	
			}
		}
		return $vetToReturn;
	}

	public function verifyReachedCondition($struct,$name,&$vetToReturn){
		foreach($struct->goal as $goal){
			foreach($goal->plan as $plan){
				if($name == $plan['plan']->name &&  $plan['plan']->status == 'sub'){
					$vetToReturn[] = (object) 
					[
						"goal_name" => $goal->goal->name,
						"reached" =>  $goal->reached
					];
				}
			}
		}
	}

	public function queryTypeOfThisSuperPlan($goal,$struct){	
		foreach($struct->goal as $g){
			if($goal[0]->name == $g->goal->name){
				foreach($g->plan as $plan){
					if($plan['status'] == 'super')
						return $plan['plan']->operator;
				}
			}
		}
		return null;
	}

	public function queryTypeOfThisSubPlan($goal,$struct){	
		foreach($struct->goal as $g){
			if($goal[0]->name == $g->goal->name){
				foreach($g->plan as $plan){
					if($plan['status'] == 'sub')
						return $plan['plan']->operator;
				}
			}
		}
		return null;
	}

	public function queryNameOfPlanWhenIAmSub($goal,$struct,&$name){
		foreach ($struct->goal as $g) {
			if($goal[0]->name == $g->goal->name){
				foreach($g->plan as $plan){
					if($plan['status'] == 'sub')
					{
						$name = $plan['plan']->name;
						return true;
					}
				}
			}
		}
		return false;
	}

	public function querySequenceToThisGoal($struct,$name,&$goal_sequence){						
		foreach($struct->plan as $plan){
			if($plan->plan->name == $name){
				$goal_sequence = $plan->sequence[0]->sequence_goal;
				return true;
			}
			else{
				$goal_sequence[] = "";
				return false;
			}
		}		
	}

	public function querySituationBeforeMe($struct,$index,$goal_array,&$array_situation){
		for($i = 0; $i < $index; $i++){
			$name_goal = $goal_array[$i];
			foreach ($struct->goal as $goal) {
				if($goal->goal->name == $name_goal)
					$array_situation[] = $goal->reached;
				
			}
		}
		
		return true;
	}
	public function querySubPlanOfThisGoal($goal,$struct,&$plan){
			
		foreach($struct->goal as $g){
			if($g->goal->name == $goal[0]->name)
			{
				if($g->plan[0]['status'] == 'super'){
					$plan = $g->plan[0]['plan']->name;
					return true;
				}
			}
		}
		return false;
	}
	public function querySubGoalOfThisPlan($goal,$struct,$plan,&$sub_goal){
		foreach($struct->plan as $p){
			if($p->plan->name == $plan){
				foreach($p->goal as $g_i_whant){
					$sub_goal[] = $g_i_whant['goal']->name;
				}
				return true;
			}
		}
		return false;
	}
	public function queryConditionOfThesesGoal($struct,$plan,$sub_goal,&$verification){
		foreach($sub_goal as $goal){
			foreach($struct->goal as $g){
				if($g->goal->name == $goal)
					$verification[] =(object) ["name" => $goal, "status" => $g->reached];
			}
		}
		if($verification != null)
			return true;
		else
			return false;
	}
	public function queryChangeStatusThisGoal(&$struct,$goal){
		foreach($struct->goal as $g){
			if($g->goal->name == $goal[0]->name){
				$g->reached = true;
			}
		}
	}
	public function queryToArrayAboutIfMissionComplete($struct,&$situation_mission){
		$this->getAllMission($struct,$missions);
		$this->situationOfThesesGoals($struct,$missions,$situation_mission);
	}
	public function getAllMission($struct,&$missions){
		foreach($struct->mission as $ms){
			$missions[] = (object)["mission" => $ms->mission->name, "goal" => $ms->goal];
		}
	}
	public function situationOfThesesGoals($struct,$missions){

	}

}
