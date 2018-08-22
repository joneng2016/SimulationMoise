<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityRelation extends Model
{

/*	
	public function hasCondition(){
		return $this->hasMany('App\Models\Condition');
	}
*/	
	public function hasEntityFirst(){
		return $this->hasMany('App\Models\Entity','id','entity_one_id');
	}
	public function hasEntitySecond(){
		return $this->hasMany('App\Models\Entity','id','entity_two_id');
	}	
}
