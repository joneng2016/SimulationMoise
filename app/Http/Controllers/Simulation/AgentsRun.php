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
		$i = 0;
		while($this->situationOfMissions($i))
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
							if($this->avaliableConditionThisGoal())
							{		

								$this->executeThisGoal();
							/*									
								$this->avaliableProbability();
								$this->doYouDie();
							*/	
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
			$i++;
		}
		dd($this->struct_goal);

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
	public function situationOfMissions($i){
		if($i < 10) return true;
		else return false;
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
	public function avaliableConditionThisGoal(){
		if($this->isThisReached()) return false;
		if($this->thisGoalIsFirst()) return true;

		$this->verifyIfThereIsSuper($super);
		$this->isSequenceOrParalell($type);
		switch($type) {
			case 'parallel':
				return $this->decideAboutParallel($super);
				break;			
			case 'sequence':
				return $this->decideAboutSequence($super);
				break;			

		}

	}

	/*************************************************/
	/*
	public function decideAboutParallel($super)
	{
		if($this->goalHasSub())	
			return $this->ifHasSub();
		else
			return $this->ifIHaveSuper();
	}
	public function ifHasSub()
	{
		$this->whatIsTypeOfSequenceSub($typeOf);
		if($typeOf == 'parallel')
			return $this->ifSubIsParallel();

		if($typeOf == 'sequence'){
			return $this->ifSubIsSequence();
		}
	}
	public function ifSubiSParallel()
	{
		if($this->isOneReached())
			return $this->ifIHaveSuper();
		else
			return false;		
	}
	public function ifSubIsSequence()
	{
		if($this->allGoalReached())
			return $this->ifIHaveSuper();
		else 
			return false;		
	}
	public function ifIHaveSuper()
	{
		if($this->verifyIfIHaveSuper())
			return $this->analizeSequenceSuper();
		else
			return true;
	}
	public function analizeSequenceSuper()
	{
		$this->whatIsTypeOfSequenceSuper($typeOf);
		if($typeOf == 'sequence')
			return $this->ifSuperIsSequence();	
		if($typeOf == 'parallel')
			return $this->ifSuperIsParalell();		
	}
	public function ifSuperIsSequence()
	{
		if($this->superGoalIsFirst())
			return $this->aboutGoalsSideMe();
		else{
			if($this->goalBeforeSuperIsReached())
				return $this->aboutGoalsSideMe();
			else
				return false;
		}		
	}
	public function ifSuperIsParalell()
	{
		if($this->someWhereIsReached())
			return false;
		else
			return $this->aboutGoalsSideMe();		
	}
	public function aboutGoalsSideMe()
	{
		$this->getAllGoalSideMe();
		if($this->goalReached())
			return false;
		else
			return true;
	}



	public function goalHasSub(){}
	public function whatIsTypeOfSequenceSub($typeOf){}
	public function isOneReached(){}
	public function allGoalReached(){}
	public function verifyIfIHaveSuper(){}
	public function whatIsTypeOfSequenceSuper(){}
	public function superGoalIsFirst(){}
	public function goalBeforeSuperIsReached(){}
	public function goalReached(){}
	*/
	/*************************************************/
	public function isThisReached(){
		foreach($this->struct_goal as $goal){
			if($goal->name == $this->goal){
				if($goal->reached) return true;
				if(!$goal->reached) return false;
			}
		}
	}
	public function decideAboutSequence($super){
		if($super)
		{	
			if($this->checkIfAllSubReached())
				return $this->ifNextAndChecked();
			else
				return false;
		}
		else
			return $this->analizeSituationAboutMySyper();
	}
	public function analizeSituationAboutMySyper(){
		$this->whoIsMySuper($goal_super);
		if($this->amINextWhoSomeOne($goal_super,$about_goal)){
			if($this->ifNextAndChecked($about_goal))
				return $this->ifNextAndChecked();
			return false;
		}
		else
			return $this->ifNextAndChecked();
	}
	public function amINextWhoSomeOne($goal_super,&$about_goal){
		foreach($this->struct_goal as $goal){
			if($goal->next == $goal_super)
			{
				$about_goal = $goal;
				return true;
			}
		}
		return false;
	}

	public function whoIsMySuper(&$goal_super){
		foreach($this->struct_goal as $goal)
		{
			if($goal->name == $this->goal){
				$goal_super = $goal->super;
				break;
			}
		}
	}
	public function ifNextAndChecked(){
		if($this->ifIamNextToOtherGoal($about_goal))	
				return $this->verifyIfThisIsChecked($about_goal);
		else
			return true;		
	}

	public function verifyIfThisIsChecked($about_goal){
		return $about_goal->reached;
	}
	public function ifIamNextToOtherGoal(&$about_goal){
		foreach($this->struct_goal as $goal){
			if($goal->next == $this->goal)
			{
				$about_goal = $goal;
				return true;
			}
		}
		return false;
	}
	public function checkIfAllSubReached(){
		$count_super = 0;
		$count_reached = 0;
		foreach($this->struct_goal as $goal){
			if($goal->super == $this->goal) 
			{	
				$count_super++;
				if($goal->reached) $count_reached++;
			}
		}
		if($count_super == $count_reached) return true;
		else return false;

	}
	public function verifyIfThereIsSuper(&$super){
		foreach ($this->struct_goal as $goal) {
			if($goal->super == $this->goal)
			{
				$super = true;
				return true;
			}
		}
		$super = false;
		return false;
	}

	public function thisGoalIsFirst(){
		if($this->goal == 'goal00')
			return true;
		else
			return false;
	}

	public function isSequenceOrParalell(&$type){
		if($this->ifIsSequence())
			$type = 'sequence';
		else
			$type = 'parallel';
	}
	public function ifIsSequence()
	{
		foreach($this->struct_goal as $goal){
			if($goal->name == $this->goal){
				if($goal->next != 'not-exist')
					return true;
			}
		}
		foreach($this->struct_goal as $goal){
			if($goal->next == $this->goal)
				return true;
		}
		return false;
	}

	public function executeThisGoal(){
		foreach($this->struct_goal as $goal)
		{
			if($goal->name == $this->goal){
				$goal->reached = true;
			}
		}	
	}
	public function avaliableProbability(){}

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
