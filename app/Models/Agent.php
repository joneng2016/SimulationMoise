<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Entity
{
    protected $table = 'entities';

    public function hasRole(){
    	return $this->haMany('App\Models\Role');
    }
}
