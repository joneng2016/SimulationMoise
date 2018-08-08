<?php

namespace App\Test;

use App\Repository\VocabularyQuery;

class Test
{
	public function run(){
		$vc = new VocabularyQuery;
		$vc->constructArray();
		return $vc->relationSimulation();
	}
}
