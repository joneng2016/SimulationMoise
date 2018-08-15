<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\VocabularyQuery;

class AgentsRun
{
	private $struct;
	private $vq;

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
	}
	public function mainRun(){
		$this->loadAgents();
		$this->goalload->loadGoal($this->schema,$this->struct);
/*
		while($this->situationOfMissions($i))
		{
			foreach($this->agents as $this->agent)
			{
				$this->findMissionThisAgent();			
				foreach($this->missions as $this->mission){			
					$this->verifySchemaThisMission();
					if($this->avaliableIfThisMissionOkToThisSchema)
					{
						$this->getAllGoalThisMission();
						foreach($this->goals as $this->goal){
							if($this->avaliableConditionThisGoal())
							{		
								$this->executeThisGoal();
									
								$this->avaliableProbability();
								$this->doYouDie();
								
							}
							$this->cleanThisGoal();
						}
						$this->cleanThisGoals();
						$this->doYouDie();
					}
					$this->cleanThisMission();
				}
				$this->cleanThisMissions();
				$this->doYouDie();
				$this->cleanThisAgent();

			}

		}
*/
	}	

	public function loadAgents(){
		foreach($this->struct->entity as $entity){
			if($entity->entity->type == 'agent')
				$this->agents[] = $entity;
		}
	}
	public function situationOfMissions($i){
		/*
		$this->query->queryToArrayAboutIfMissionComplete($this->struct,$situation_mission);
		return $this->whatIdecideInRelationThis($situation_mission);
		*/
	
		return true;
	}
	public function whatIdecideInRelationThis($situation_mission){

	} 
	public function findMissionThisAgent(){
		$this->query->queryMissions($this->struct,$this->agent,$this->missions);
	}

	public function verifySchemaThisMission(){
		$this->query->queryThisMissionIsInSchema($this->mission,$this->schema,$this->struct,$this->avaliableIfThisMissionOkToThisSchema);
	}
	public function getAllGoalThisMission(){
		$this->query->queryAllGoalOfThisMission($this->mission,$this->goals);
	}
	public function avaliableConditionThisGoal(){
		$this->goal_analize->set($this->goal,$this->struct);

		if($this->goal_analize->ifthisIsFirstGoal($this->struct)) return false;
		if($this->goal_analize->verifyIfThisGoalIsCompleted()) return false;
		if($this->goal_analize->planSubCompleted()) return false;
		$this->goal_analize->loadSuperPlan($type);

		switch ($type) {
			case "sequence":
				return $this->goal_analize->analizeGoalBefore();
			break;

			case "parallel":
				return true;
			break;				
/*
			case "choice":
				if($this->goal_analize->verifyIfOthersPossibilityIsUp()) return $this->goal_analize->iAmChoiced())
				else return false;
			break;		
*/
		}
		
		
	}
	public function avaliableProbability(){}
	public function executeThisGoal(){
		$this->query->queryChangeStatusThisGoal($this->struct,$this->goal);
		$this->printSituation();
	}
	public function doYouDie(){}

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
	public function printSituation(){
		echo "%%%%%%%%%%%%% INTERACTION";
		foreach($this->struct->goal as $goal)
		{
			echo
			"*************************************************************** <br>".
			"GOAL: ".$goal->goal->name."<br>".
			"REACHED: <strong>".$goal->reached." </strong> <br>".
			"STATUS: ".$goal->plan[0]['status']."<br>".
			"AGENT: ".$this->agent->entity->name."<br>".
			"*************************************************************** <br>";
		}
		echo "%%%%%%%%%%%%% INTERACTION";
	}


}
