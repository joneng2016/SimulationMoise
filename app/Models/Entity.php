<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Entity extends Model
{
	public function role(){
		$agent_role =  $this->hasMany('App\Models\AgentRole')->get();
		if($agent_role->isNotEmpty())
		{
			foreach($agent_role as $a_r){
				$role[] = 
				[
					$a_r->hasMany('App\Models\Role','id','role_id')->get()
				];
			}	
			return $role;
		}
		return "There Is Not Role";
	}
	public function entityRelation(){
		return (object)
		[
			"first" => $this->hasMany('App\Models\EntityRelation','entity_one_id','id')->get(),
			"second" => $this->hasMany('App\Models\EntityRelation','entity_two_id','id')->get()
		];
	}
	
}
