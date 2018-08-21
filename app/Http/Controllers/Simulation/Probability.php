<?php

namespace App\Http\Controllers\Simulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\VocabularyQuery;

class Probability
{
	public static function calc($probability)
	{
		$size = 10000;
		$total_true = $probability*$size;
		$total_false = $size - $total_true;

		for($i=0;$i < $total_true; $i++)
			$array[] = true;
		
		for($i=0;$i < $total_false; $i++)
			$array[] = false;
		
		$k=0;
		while(!empty($array))
		{
			$random_key = array_rand($array);			
			$randon_array[] = $array[$random_key];
			unset($array[$random_key]);
		}
		$new_randon_key = array_rand($randon_array);	
		return $randon_array[$new_randon_key];
		
	}

	public static function validation(){
		$mais = 0;
		$menos = 0;
		echo "calc %%...\n";
		for($i=0;$i <1000; $i++)
		{
			$get =self::calc(0.35);
			echo ">>> ".$get." >".$i."\n"; 

			if($get)
				$mais++;
			else
				$menos++;

		}
		return 100*($mais)/($mais+$menos);
	}
}