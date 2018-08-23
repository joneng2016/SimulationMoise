<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class StatisticSimulationRepository
{
	public function loadToRelationGoalProbability($first,$number_goal){
		$this->first = $first;
		$this->number_goal = $number_goal;	
		$this->status = false;	
	}
	public function relationGoalProbability(){
		$this->leftJoinToStatisticNameSimulation();
		$this->analizeNameJoin();
	}
	public function getRelation(&$relation){
		$relation = $this->relation; 
		return $this->relation;
	}
	public function leftJoinToStatisticNameSimulation(){
		$this->return_db = DB::table('statistic_simulations')
            ->leftJoin('name_simulations', 'statistic_simulations.name_id', '=', 'name_simulations.id')->get();
	}
	public function analizeNameJoin(){
		foreach($this->return_db as $name_statistic){			
			if($this->avaliablePermissionQuery($name_statistic->name))
				$this->getGoalThisSimulation($name_statistic->name,$name_statistic->average);
		}
	}
	public function avaliablePermissionQuery($name_statistic){
		if(!$this->status)
			$this->status = $name_statistic == $this->first;
		return $this->status;
	}
	public function getGoalThisSimulation($name_statistic,$average_statistic){
		$goal = "goal".$this->number_goal;
		if($this->avaliableIfExistSubString($name_statistic,$goal))
			$this->ifSubStringExist($name_statistic,$average_statistic);
	}
	public function ifSubStringExist($name_statistic,$average_statistic){
		$this->getProbability($name_statistic,$probability);
		$this->relation[] = $this->mountObjct($probability,$average_statistic);
	}	
	public function mountObjct($probability,$average_statistic){
		return 
		[
			"goal_probability" => $probability,
			"activity_probability" => $average_statistic
		];
	}
	public function avaliableIfExistSubString($string,$substring){
		if(strpos($string,$substring) != false) return true;
		else return false;
	}
	public function getProbability($name_statistic,&$probability){
		$sizeofstring = strlen($name_statistic);
		if($sizeofstring == 41)
			$this->mountTo41($name_statistic,$sizeofstring,$probability);
		if($sizeofstring == 40)
			$this->mountTo40($name_statistic,$sizeofstring,$probability);
	}	
	public function mountTo41($name_statistic,$sizeofstring,&$probability){
		$third = $name_statistic[$sizeofstring-1];
		$second = $name_statistic[$sizeofstring-2];
		$first = $name_statistic[$sizeofstring-4];
		$probability = ($first.".".$second.$third)*100;		
	}
	public function mountTo40($name_statistic,$sizeofstring,&$probability){
		$second = $name_statistic[$sizeofstring-1];
		$first = $name_statistic[$sizeofstring-3];
		$probability = ($first.".".$second)*100;		
	}

}