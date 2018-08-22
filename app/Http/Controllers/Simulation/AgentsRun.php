<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\VocabularyQuery;

class AgentsRun
{

	public function __construct(){
		$this->vq = new VocabularyQuery;	
		$this->query = new Query;
		$this->goal_analize = new GoalAnalize;
		$this->goalload = new GoalLoad;		
		$this->vq->loadBank();
		$this->vq->relationVect($this->struct);

	}
	public function getSchema($schema){
		$this->schema = $schema;
		$this->goalload->loadGoal($this->schema,$this->struct);
		$this->goalload->getStructGoal($this->struct_goal);
	}

	public function mainRun(){
		$this->loadAgents();
		while($this->situationOfMissions())
		{
			foreach($this->agents as $this->agent)
			{
				$this->findMissionThisAgent();			
				foreach($this->missions as $this->mission)
				{
					if($this->verifySchemaThisMission())
					{
						$this->getAllGoalThisMission();
						foreach($this->goals as $this->goal){
							if((new AvaliableCondition)->condition($this->goal,$this->struct_goal))
							{		
								if(!$this->executeThisGoal())											
									return $this->whatReturn("DIE",false);
								break;
							}
							$this->cleanThisGoal();
						}
						$this->cleanThisGoals();
					}
					$this->cleanThisMission();
				}
				$this->cleanThisMissions();
				$this->cleanThisAgent();
				
			}
		}
		return $this->whatReturn("COMPLETED",true);
	}	

	public function loadAgents(){
		$this->agents[] = $this->struct_goal[0]->agent;
		$agent_now = $this->agents[0];
		foreach($this->struct_goal as $goal){
			if($goal->agent != $agent_now)
			{
				$agent_now = $goal->agent;
				$this->agents[] = $agent_now;
			}
		}
	}
	public function situationOfMissions(){
		foreach($this->struct_goal as $goal){
			if($goal->name == 'goal06' && $goal->reached)
				return false;
		}
		return true;
	}
	public function whatIdecideInRelationThis($situation_mission){

	} 
	public function findMissionThisAgent(){
		foreach($this->struct_goal as $goal){
			if($this->agent == $goal->agent)
			{	
				if(isset($this->missions))
				{	
					if(!in_array($goal->mission,$this->missions))
					{
						$this->missions[] = $goal->mission;
					}
				}
				else
					$this->missions[] = $goal->mission;
			}
		}
	}



	public function verifySchemaThisMission(){
		foreach($this->struct_goal as $goal){
			if($this->mission == $goal->mission && $this->schema == $goal->schema) return true;	
		} 
		return false;
	}
	public function getAllGoalThisMission(){
		foreach($this->struct_goal as $goal){
			if($this->mission == $goal->mission)
			{

				if(isset($this->goals))
				{	if(!in_array($goal->name, $this->goals))
						$this->goals[] = $goal->name;	
				}
				else
					$this->goals[] = $goal->name;
			}
		}
	}
	
	public function whatReturn($msg,$status){
		return (object) 
		[
			"situation" => $msg,
			"struct_goal" => $this->struct_goal,
			"goal" => $this->goal,	
			"status" => $status
		];		
	}
	public function executeThisGoal(){

		foreach($this->struct_goal as $goal)
		{
			if($goal->name == $this->goal){
				if($goal->probability == 1.0)
				{	
					$goal->reached = true;	
					return true;
				}
				else{
					if(Probability::calc((float) $goal->probability))
					{ 
						$goal->reached = true;
						return true;
					}
					else
						return false;
				}
			}
		}	
	}

	public function cleanThisGoals(){
		$this->goals= null;
	}
	public function cleanThisGoal(){
		$this->goal = null;
	}
	public function cleanThisMissions(){
		$this->missions = null;
	}
	public function cleanThisMission(){
		$this->mission = null;
	}
	public function cleanThisAgent(){
		$this->agent = null;
	}

}
