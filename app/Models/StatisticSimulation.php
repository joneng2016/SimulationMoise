<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatisticSimulation extends Model
{
	public function __construct(){
		$this->name_simulation = new \App\Models\NameSimulation;
	}
	public function insertStatistic($name_simulation,$average){
		if($this->name_simulation->verifyIfExist($name_simulation))
			$name_id = $this->name_simulation->findId($name_simulation);
		else
			$this->writeInBank($name_simulation,$name_id);

		$this->prepareArg($name_id,$average,$arg_insert);
		$this->insert($arg_insert);
		return true;
	}
	public function verifyIfExist($name_id){	
		return $this->where("name_id",$name_id)->get()->isNotEmpty();
	}
	public function prepareArg($name_id,$average,&$arg_insert){
		$arg_insert = 
		[
			"name_id" => $name_id,
			"average" => $average,
			"created_at" => new \DateTime,
			"updated_at" => new \DateTime
		];		
	}
	public function writeInBank($name_simulation,&$name_id){
		$this->name_simulation->insertName($name_simulation);
		$name_id = $this->findId($name_simulation);
	}
}
