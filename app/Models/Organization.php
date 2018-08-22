<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	public function group(){
		return $this->hasMany("App\Models\Group");
	}
	public function schemaOrganization(){
		return $this->hasMany("App\Models\SchemaOrganization");
	}
}
