<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
	protected $fillable = ['probability'];
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
	public function updateGoal($name,$probability){
		$this->prepareArg($probability,$return);
		$this->where('name',$name)->first()->update($return);
	}
	public function prepareArg($probability,&$toreturn){
		$toreturn = 
		[
			"probability" => $probability,
			"updated_at" => new \DateTime
		];
	}
}
