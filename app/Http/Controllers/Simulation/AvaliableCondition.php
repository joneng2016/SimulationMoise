<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\VocabularyQuery;

class AvaliableCondition
{
	

	public function condition($goal,$struct_goal)
	{
		$this->goal = $goal;
		$this->struct_goal = $struct_goal;

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

	public function decideAboutParallel($super)
	{
		if($super)	
			return $this->ifHasSub();
		else 
			return $this->ifIHaveSuper();
	}
	
	public function decideAboutSequence($super){	
		if($super)
			return $this->ifExistSub();
		else
			return $this->analizeSituationAboutMySyper();
	}	

	


	public function isThisReached(){
		foreach($this->struct_goal as $goal){
			if($goal->name == $this->goal){
				if($goal->reached) return true;
				if(!$goal->reached) return false;
			}
		}
	}

	public function thisGoalIsFirst(){
		if($this->goal == 'goal00')
			return true;
		else
			return false;
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

	public function isSequenceOrParalell(&$type){
		if($this->ifIsSequence())
			$type = 'sequence';
		else
			$type = 'parallel';
	}
	

	public function ifHasSub()
	{
		$this->whatIsTypeOfSequenceSub($typeOf);
		if($typeOf == 'parallel')
			return $this->ifSubIsParallel();

		if($typeOf == 'sequence')
			return $this->ifSubIsSequence();
	}

	public function whatIsTypeOfSequenceSub(&$typeOf){
		foreach($this->struct_goal as $goal){
			if($goal->super == $this->goal){
				if($goal->next != 'not-exist')
				{
					$typeOf = 'sequence';
					return true;
				}
			}
		}
		$typeOf = 'parallel';
		return false;
	}	
	
	public function ifSubiSParallel()
	{
		if($this->isOneReached())
			return $this->ifIHaveSuper();
		else
			return false;		
	}

	public function isOneReached(){
		foreach($this->struct_goal as $goal){
			if($goal->super == $this->goal){
				if($goal->reached)
					return true;
			}			
		}
		return false;
	}

	public function ifIHaveSuper()
	{		

		if($this->verifyIfIHaveSuper($goal_super))
			return $this->analizeSequenceSuper($goal_super);
		else
			return true;
	}

	public function verifyIfIHaveSuper(&$goal_super){
		foreach($this->struct_goal as $goal){
			
			if($goal->name == $this->getSuper()){
				$goal_super = $goal; 
				return $goal->super != 'not-exist';
			}
		}
		return false;
	}

	public function analizeSequenceSuper($goal_super)
	{

 		$this->whatIsTypeOfSequenceSuper($typeOf,$goal_super);
				
		if($typeOf == 'sequence')
			return $this->ifSuperIsSequence($goal_super);	
		if($typeOf == 'parallel')
			return $this->ifSuperIsParalell($goal_super);		
	}
	public function whatIsTypeOfSequenceSuper(&$typeOf,$goal_super){
		if($goal_super->super == 'not-exist'){
			$typeOf = 'sequence';
			return true;
		}
		else{
			$goal_super_super = $goal_super->super;
			foreach($this->struct_goal as $goal){
				if($goal->super == $goal_super_super){
					if($goal->next != 'not-exist')
					{	
						$typeOf = 'sequence';
						return true;
					}
				}
			}
			$typeOf = 'parallel';
			return false;
		}
	}

	public function ifSuperIsSequence($goal_super)
	{
		if($this->superGoalIsFirst($goal_super))
			return $this->aboutGoalsSideMe($this->goal);
		else{
			if($this->goalBeforeSuperIsReached($goal_super))
				return $this->aboutGoalsSideMe($this->goal);
			else
				return false;
		}		
	}

	public function superGoalIsFirst($goal_super){
		foreach($this->struct_goal as $goal){
			if($goal->next == $goal_super){
				return false;
			}
		}
		return true;
	}
	public function aboutGoalsSideMe($goal)
	{
		$this->getAllGoalSideMe($goal,$goalreached);	
		
		if($this->goalReached($goalreached))
			return false;
		else
			return true;
	}
	public function getAllGoalSideMe($goal_super,&$goalreached){
		$getSuper = $this->getSuper();

		foreach($this->struct_goal as $goal){
			if($goal->name != $this->goal){
				if($goal->super == $getSuper)
					$goalreached[] = $goal;
			}
		}
	}
	public function getSuper(){
		foreach($this->struct_goal as $goal){
			if($this->goal == $goal->name)
				return $goal->super;
		}
	}
	public function goalReached(&$goalreached){
		foreach($goalreached as $goal){
			if($goal->reached){
				$goalreached = null;			
				return true;	
			}
		}
		$goalreached = null;
		return false;
	}	

	public function ifSubIsSequence()
	{

		if($this->allGoalReached())
			return $this->ifIHaveSuper();
		else 
			return false;		
	}
	public function allGoalReached(){
		$count_exist = 0;
		$count_reached = 0;		
		foreach($this->struct_goal as $goal){
			if($goal->super == $this->goal){
				$count_exist++;
				if($goal->reached) $count_reached++;
			}
		}
		if($count_reached == $count_exist) {
			return true;
		}
		else return false;
	}

	public function ifSuperIsParalell($goal_super)
	{
		if($this->someWhereIsReached($goal_super))
			return false;
		else
			return $this->aboutGoalsSideMe($goal_super);		
	}
	public function someWhereIsReached($goal_super){
		foreach($this->struct_goal as $goal){
			if($goal->name = $goal_super)
			{	
				$goal_super_super = $goal->super;
				break;
			}
		}
		foreach($this->struct_goal as $goal){
			if($goal->super == $goal_super_super && $goal->name != $this->goal){
				if($goal->reached)
					return true;
			}
		}

		return false;
	}


	public function goalBeforeSuperIsReached($goal_super){
		foreach($struct_goal as $goal){
			if($goal->next == $goal_super){
				return $goal->reached;
			}
		}
		return false;
	}


	public function ifExistSub(){
		$this->whatIsTypeOfSequenceSub($typeOf);
		if($typeOf == 'parallel')
			return $this->whatIHaveToDoIfSubParallel();
		if($typeOf == 'sequence')
			return $this->whatIHaveToDoIfSubSequence();		
	}
	public function whatIHaveToDoIfSubParallel(){
		if($this->checkIfThereIsOneReached())
			return $this->ifNextAndChecked();
		else
			return false;			
	}
	public function checkIfThereIsOneReached(){
		foreach ($this->struct_goal as $goal) {
			if($goal->super == $this->goal)
				return true;
		}
		return false;
	}
	public function whatIHaveToDoIfSubSequence(){
		if($this->checkIfAllSubReached())
			return $this->ifNextAndChecked();
		else
			return false;
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


}
