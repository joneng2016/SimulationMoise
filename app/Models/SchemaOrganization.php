<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemaOrganization extends Model
{
	public function mission(){
		return $this->hasMany("App\Models\Mission","schema_id","id");
	}
}
