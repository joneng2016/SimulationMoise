<?php

namespace App\Test;

use App\Repository\VocabularyQuery;

class Test
{
	public function run(){
		$vq = new VocabularyQuery;
		
		$vq->loadBank();
		$vq->relationVect($vet);
		return $vet;
	}
}
