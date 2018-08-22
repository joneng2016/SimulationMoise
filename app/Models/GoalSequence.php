<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalSequence extends Model
{
	public function plan(){
		return $this->hasMany("App\Models\GoalSequence");
	}
}
