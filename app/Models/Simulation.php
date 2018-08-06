<?php

namespace App\Models\;

use Illuminate\Database\Eloquent\Model;

class Simulation extends Model
{
    public function hasEntity(){
    	return $this->hasMany('App\Models\Entity');
    }
    public function hasOrganization(){
		return $this->hasMany('App\Models\Organization');
    }
}
