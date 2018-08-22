<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

	public function goal(){
		$goalplans = $this->hasMany('App\Models\GoalPlan')->get();
		foreach($goalplans as $goalplan){
			$goal[] = 
			[
				"goal" => $goalplan->hasMany("App\Models\Goal","id","goal_id")->first(),
				"status" => $goalplan->status_goal
			];
		}
		return $goal;
	}
	public function goalSequence(){
		return $this->hasMany("App\Models\GoalSequence",'plan_sequence','id');
	}
}
