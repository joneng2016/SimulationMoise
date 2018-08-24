<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NameSimulation extends Model
{
    public function insertName($name){
    	$arg = 
    	[
    		"name" => $name,
    		"created_at" => new \DateTime(),
    		"updated_at" => new \DateTime()    		
    	];
    	$this->insert($arg);
    }
    public function findId($name){
    	return $this->where('name',$name)->first()->id;
    }
    public function dataSimulation(){
    	return $this->hasMany('\App\Models\DataSimulation','name_id','id')->get();
    }
	 public function verifyIfExist($name){
		return !($this->where('name',$name)->get()->isEmpty());
	 }
}
