<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	public function relation($type){
		return (object)
		[
			"first" => $this->hasMany('App\Models\RoleRelation','role_one_id','id')->where('type',$type)->get(),
			"second" => $this->hasMany('App\Models\RoleRelation','role_two_id','id')->where('type',$type)->get()
		];
	}
	public function linkAuthority(){
		return $this->relation('link_authority');
	}
	public function linkCommunication(){
		return $this->relation('link_communication');
	}
	public function linkAcquaintace(){
		return $this->relation('link_acquaintace');
	}
	public function heritage(){
		return $this->relation('heritage');		
	}
	public function compatibility(){
		return $this->relation('compatibility');		
	}	
	public function deonticRelation(){
		return $this->hasMany('App\Models\DeonticRelation');
	}

}
