<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InteractionAgent extends Controller
{
	private $agent_run;
	public function __construct(){
		$this->agent_run = new \App\Http\Controllers\Simulation\AgentsRun();
	}
	public function mainSimulation(){
		$this->agent_run->getStruct($struct);
		$this->agent_run->test($test);
	}

}
