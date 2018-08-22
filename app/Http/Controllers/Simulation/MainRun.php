<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\VocabularyQuery;

class MainRun
{
	public static function run(){
		RunSimulation::casegenerateindb('testeagosto22155839',2000);
	}
}
