<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSimulation extends Model
{
	public function __construct(){
		$this->name_service = new NameSimulation;
	}
	public function insertData($situation,$goal,$mission,$agent,$name){
		if($this->name_service->verifyIfExist($name))
			$name_id = $this->name_service->findId($name);
		else
			$this->soIWriteInBank($name,$name_id);

		$this->argToInsert($situation,$goal,$mission,$agent,$name_id,$arg_to_insert);
		$this->insert($arg_to_insert);
	}
	public function soIWriteInBank($name,&$name_id){
		$this->name_service->insertName($name);
		$name_id = $this->name_service->findId($name);
	}
	public function argToInsert($situation,$goal,$mission,$agent,$name_id,&$arg){
		$arg = 
		[
			"situation" => $situation,
			"goal" => $goal,
			"mission" => $mission,
			"agent" => $agent,
			"name_id" => $name_id,
			"created_at" => new \DateTime,
			"updated_at" => new \DateTime
		];
	}
}

