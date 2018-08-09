<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\VocabularyQuery;

class AgentsRun
{
	private $struct;
	private $vq;

	public function __construct(){
		$this->vq = new VocabularyQuery;	
		$this->vq->loadBank();
		$this->vq->relationVect($this->struct);
	}

	public function getStruct(&$struct){
		$struct = $this->struct;
		return $this->struct;
	}
	public function test(&$query){
		foreach($this->struct->simulation as $simulation){
			dd($simulation->entity);
		}

	}
	
}
