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

		$this->vq->loadBank();
		$this->vq->relationVect($this->struct);

	}
	public function getSchema($schema){
		$this->schema = $schema;
	}
	public function mainRun(){
		$this->loadAgents();
		while($this->situationOfMissions()){
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
							/*	
								$this->avaliableProbability();
								$this->executeThisGoal();
								$this->doYouDie();
							*/
							}
						}
						$this->doYouDie();
					}
				}
				$this->doYouDie();
			}
			return 'finito';
		}
	}	

	function loadAgents(){
		foreach($this->struct->entity as $entity){
			if($entity->entity->type == 'agent')
				$this->agents[] = $entity;
		}
	}
	function situationOfMissions(){
		return true;
	}

	function findMissionThisAgent(){
		$this->query->queryMissions($this->struct,$this->agent,$this->missions);
	}

	function verifySchemaThisMission(){
		$this->query->queryThisMissionIsInSchema($this->mission,$this->schema,$this->struct,$this->avaliableIfThisMissionOkToThisSchema);
	}
	function getAllGoalThisMission(){
		$this->query->queryAllGoalOfThisMission($this->mission,$this->goals);
	}
	function avaliableConditionThisGoal(){

		$this->goal_analize->set($this->goal,$this->struct);

		if($this->goal_analize->ifthisIsFirstGoal($this->struct)) return false;
		if($this->goal_analize->verifyIfThisGoalIsCompleted()) return false;
		if($this->goal_analize->planSubCompleted()) return false;


		$this->goal_analize->loadSuperPlan($type);
		
		switch ($type) {
			case "sequence":
				return $this->goal_analize->analizeGoalBefore();
			break;
/*
			case "parallel":
				return $this->goal_analize->analizeIfOtherGoalCompleted();
			break;				

			case "choice":
				if($this->goal_analize->verifyIfOthersPossibilityIsUp()) return $this->goal_analize->iAmChoiced())
				else return false;
			break;		
*/
		}
		
		
	}
	function avaliableProbability(){}
	function executeThisGoal(){}
	function doYouDie(){}
	
}
