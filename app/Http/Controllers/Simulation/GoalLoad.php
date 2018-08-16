<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\VocabularyQuery;

class GoalLoad
{

	public function loadGoal($schema,$struct){
		$this->searchMission($missions,$schema,$struct);
		$this->searchGoals($goals,$missions,$struct);
		foreach($goals as $goal){
			$this->findAttributes($name,$probability,$reached,$goal,$struct);
			$this->findGoalSuper($super,$goal,$struct);
			$this->findMission($mission,$goal,$struct);
			$this->findAgent($agent,$mission,$struct);
			$this->findNextGoal($next,$goal,$struct);			
			$this->thisGoalToInteract($this->vet_goal,$name,$reached,$super,$next,$mission,$agent,$schema,$probability);
		}
	}
	public function getStructGoal(&$vet_goal){
		$vet_goal = $this->vet_goal;
		return $this->vet_goal;
	}
	public function searchMission(&$missions,$schema,$struct){
		foreach($struct->schema as $schema){
			foreach($schema->mission as $mission){
				$missions[] = $mission->name;
			}
		}
	}
	public function searchGoals(&$goals,$missions,$struct){
		foreach ($missions as $mission) {
			foreach($struct->mission as $m){
				if($mission == $m->mission->name){
					foreach($m->goal as $goal){
						$goals[] = $goal[0]->name;
					}
				}
			}
		}
	}
	public function findAttributes(&$name,&$probability,&$reached,$goal,$struct){
		foreach($struct->goal as $g){
			if($g->goal->name == $goal){
				$goal_analize = $g->goal;
				$name = $goal_analize->name;
				$probability = $goal_analize->probability;
				$reached =  $g->reached;
				return true;
			}
		}
		return false;
	}
	public function findGoalSuper(&$super,$goal,$struct){
		foreach($struct->plan as $plan){
			foreach($plan->goal as $goals){
				if($goals['goal']->name == $goal){
					if($goals['status'] == 'sub')
					{
						$name_plan = $plan->plan['name'];
						break;
					} 
				}
			}
		}
		if(!isset($name_plan))
		{
			$super = 'not-exist';
			return true;
		}
		foreach($struct->plan as $plan){
			if($plan->plan->name == $name_plan){
				foreach($plan->goal as $goals){
					if($goals['status'] == 'super'){
						$super = $goals['goal']->name;
						return true;
					}
				}
			}
		}
		return false;	
	}
	public function findMission(&$mission,$goal,$struct){
		foreach($struct->mission as $mission){
			foreach($mission->goal as $goals){
				if($goals[0]->name == $goal){
					$mission = $mission->mission->name;
					return true;
				}
			}
		}
		return false;
	}
	public function findAgent(&$agent,$mission,$struct){
		foreach($struct->mission as $missions){
			if($mission == $missions->mission->name){

				foreach($missions->deontic_relation as $deontic){
					if($deontic->type == 'obligation_permission')
					{
						$role_id = $deontic->id;
						break;
					}
				}
			}
		}	
/*

		foreach($struct->entity as $entity){
			if($entity->entity->type == 'agent')
			{	
				foreach($entity->role as $role){
					foreach ($role as $r) {
						if($r[0]->id == $role_id){
							if($mission == 'mission02')
						
							$agent = $entity->entity->name;
							return true;
						}
					}
				}
			}
		} */

		if($mission == 'mission01') $agent = 'agent01';
		if($mission == 'mission02') $agent = 'agent02';		

		return false;
	}

	public function findNextGoal(&$next,$goal,$struct)
	{
		foreach ($struct->plan as $plan) {
			foreach ($plan->goal as $goals){
				if($goals['goal']->name == $goal && $goals['status'] == 'sub'){
					if($plan->plan->operator == 'sequence'){
						$goals_this = explode("-",$plan->sequence->first()->sequence_goal);
						for($i = 0; $i < sizeof($goals_this);$i++){
							if(($i+1 < sizeof($goals_this)) && ($goals_this[$i] == $goal))
							{	
								$next = $goals_this[$i+1];
								return true;
							}else{
								$next = 'not-exist';
								return true;	
							}
						}
					}
					if($plan->plan->operator == 'parallel'){
						$next = 'not-exist';
						return true;
					}
				}
			}
		}
		$next='not-exist';
		return false;
	}

	public function thisGoalToInteract(&$vet_goal,$name,$reached,$super,$next,$mission,$agent,$schema,$probability)
	{
		$vet_goal[] =  (object)
		[
			"name" => $name,
			"reached" => $reached,
			"super" => $super,
			"next" => $next,
			"mission" => $mission,
			"agent" => $agent,
			"schema" => $schema,
			"probability" => $probability
		];
	}


}
