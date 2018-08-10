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
		return $this->query->queryAboutThisGoal($this->goal,$this->struct);
	}
	public function ifthisIsFirstGoal(){}
	public function planSubCompleted(){}
	public function analizeGoalBefore(){}
	public function analizeIfOtherGoalCompleted(){}
	public function loadSuperPlan(&$type){}
	public function verifyIfOthersPossibilityIsUp(){}
	public function iAmChoiced(){}
}
