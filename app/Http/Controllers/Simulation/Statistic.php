<?php

namespace App\Http\Controllers\Simulation;

class Statistic
{
	public function workAboutData($analizes){
		foreach($analizes as $analize){
			foreach($analize->struct_goal as $struct){
				if($struct->name == $analize->goal){
					$agent = $struct->agent;
					$mission = $struct->mission;
					$probability = $struct->probability;
				}
			}
			$this->data_analize[] = (object)
			[
				"situation" => $analize->situation,
				"goal" => $analize->goal,
				"agent" => $agent,
				"mission" => $mission,	
				"probability" => $probability
			];
		}
		return $this->data_analize;
	}

}
