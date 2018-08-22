<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
	public function goal(){
		$goalmissions =  $this->hasMany("App\Models\GoalMission")->get();
		foreach($goalmissions as $goalmission){
			$goal[] = $goalmission->hasMany('App\Models\Goal','id','goal_id')->get();
		}
		return $goal;	
	}
	public function deonticRelation(){
		return $this->hasMany('App\Models\DeonticRelation');
	}
}
