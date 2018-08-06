<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityRelation extends Model
{
	public function hasCondition(){
		return $this->hasMany('App\Models\Condition');
	}
	public function hasEntity(){
		return $this->hasMany('App\Models\Entity');
	}
}
