<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	public function role(){
		return $this->hasMany("App\Models\Role");
	}

}
