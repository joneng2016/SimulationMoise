<?php

namespace App\Repository;

class DataSimulationRepository
{
	public function __construct()
	{
		$this->name_simulation = new \App\Models\NameSimulation;
		$this->data_simulation = new \App\Models\DataSimulation;
	}
	public function getData($name_simulation){
		return $this->name_simulation->where('name',$name_simulation)->first()->dataSimulation();
	}
}
