<?php

namespace App\Http\Controllers\Simulation;

class Statistic
{
	public function __construct()
	{
		$this->name_simulation = new \App\Models\NameSimulation;
		$this->data_simulation = new \App\Models\DataSimulation;
		$this->data_repository = new \App\Repository\DataSimulationRepository;
		$this->statistic_simulation = new \App\Models\StatisticSimulation; 
	}	

	public function workAboutData($analizes,$name_simulation){
		if($this->name_simulation->verifyIfExist($name_simulation))
			$name_id = $this->name_simulation->findId($name_simulation);
		else
			$this->soIWriteInBank($name_simulation,$name_id);

		foreach($analizes as $analize){
			foreach($analize->struct_goal as $struct){
				if($struct->name == $analize->goal){
					$agent = $struct->agent;
					$mission = $struct->mission;
				}
			}
			$this->data_analize[] = 
			[
				"situation" => $analize->situation,
				"goal" => $analize->goal,
				"agent" => $agent,
				"mission" => $mission,
				"name_id" => $name_id,	
				"created_at" => new \DateTime,
				"updated_at" => new \DateTime
			];
		}
		$this->data_simulation->insert($this->data_analize);
		return $this->data_analize;
	}
	public function soIWriteInBank($name,&$name_id){
		$this->name_simulation->insertName($name);
		$name_id = $this->name_simulation->findId($name);
	}
	public function tractDataStatisticMove($name_simulation){
		$solutions = $this->data_repository->getData($name_simulation);
		$total_die = 0;
		$total = sizeof($solutions);
		foreach($solutions as $solution){
			if($solution->situation == 'DIE')
				$total_die++;
		}
		$percent = 100*($total_die/$total);
		$this->statistic_simulation->insertStatistic($name_simulation,$percent);
		return $percent;
	}

}
