<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\VocabularyQuery;

class GoalAnalize
{
	public function __construct(){
		$this->query = new Query;
	}

	public function set($goal,$struct){
		$this->goal = $goal;
		$this->struct = $struct;
	}
	public function verifyIfThisGoalIsCompleted(){
		$goalname = $this->query->queryAboutThisGoal($this->goal,$this->struct);
		if($this->goal == $goalname)
			return true;
		else
			return false;
	}
	public function ifthisIsFirstGoal(&$struct){
		$goal_struct = $this->query->queryAboutThisGoal($this->goal,$this->struct);
		if(!$goal_struct && $this->goal[0]->name == 'goal00'){
			$this->query->changeGoalReached('goal00',$this->struct);
			$struct = $this->struct;
			return true;
		}
		$struct = $this->struct;
		return false;
	}

	public function planSubCompleted(){
		$sub_plan = $this->query->queryAllSubPlanOfGoal($this->goal,$this->struct);
		if($sub_plan == null)
			return false;

		foreach ($sub_plan as $sub) {
			if(!$sub->reached)
				return false;
		}
		return true;
	}
	public function loadSuperPlan(&$type){
		$type = $this->query->queryTypeOfThisSubPlan($this->goal,$this->struct);
	}	
	public function analizeGoalBefore(){
		$this->query->queryNameOfPlanWhenIAmSub($this->goal,$this->struct,$name);
		if(!$this->query->querySequenceToThisGoal($this->struct,$name,$goal_sequence)) 
			return false;
		$this->breakSequenceInArray($goal_sequence,$goal_array);
		$this->verifyMyPosition($goal_array,$index,$definition);
		$this->query->querySituationBeforeMe($this->struct,$index,$goal_array,$array_situation);
		
		return 
			$this->iDecideThatThisSequenceIs($definition,$array_situation,$index);
	}	
	public function analizeIfOtherGoalCompleted(){
		if(!$this->query->querySubPlanOfThisGoal($this->goal,$this->struct,$plan))
			return false;

		if(!$this->query->querySubGoalOfThisPlan($this->goal,$this->struct,$plan,$sub_goal))
			return false;

		if(!$this->query->queryConditionOfThesesGoal($this->struct,$plan,$sub_goal,$verification))
			return false;

		return $this->whatIDecide($verification);		
	}
	public function verifyIfOthersPossibilityIsUp(){}
	public function iAmChoiced(){}


	public function breakSequenceInArray($goal_sequence,&$goal_array){
		$goal_array = explode("-",$goal_sequence);
	}
	public function verifyMyPosition($goal_array,&$index,&$definition){
		$definition = false;
		foreach($goal_array as $goal){
			if($goal == $this->goal[0]->name)
			{
				$index = array_keys($goal_array,$goal)[0];
				return true;
			}
		}
		$definition = true;

	}
	public function iDecideThatThisSequenceIs($definition,&$array_situation,$index){

		if(!$definition)
		{
			foreach($array_situation as $array){
				if(!$array)
				{
					$array_situation = null;
					return false;
				}
			}
			{
				$array_situation = null;				
				return true;
			}
		}
		else
		{	
			$array_situation = null;
			return false;
		}
	}
	public function verifyIfOthersGoalsCompleted(){

	}
	public function whatIDecide($verification){
		foreach($verification as $verify){
			if($verify->status)
				return true;
		}
		return false;
	}
}
