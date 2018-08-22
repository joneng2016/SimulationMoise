<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
	public function plan(){
		$goal_plans = $this->hasMany("App\Models\GoalPlan")->get();
		foreach ($goal_plans as $goalplan) 
		{
			$plan[] = 
			[
				"plan" => $goalplan->hasMany("App\Models\Plan","id","plan_id")->first(),
				"status" => $goalplan->status_goal
			];
		}
		return $plan;
	}
}
