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
						/*
						foreach($this->goals as $goal){
							if($this->avaliableConditionThisGoal())
							{	
								$this->avaliableProbability();
								$this->executeThisGoal();
								$this->doYouDie();
							}
						}
						$this->doYouDie();
						*/
					}
				}
				//$this->doYouDie();
			}
			return false;
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
		$this->query->queryAllGoalOfThisMission($this->mission,$this->struct,$this->goals);
	}
	function avaliableConditionThisGoal(){}
	function avaliableProbability(){}
	function executeThisGoal(){}
	function doYouDie(){}
	
}
