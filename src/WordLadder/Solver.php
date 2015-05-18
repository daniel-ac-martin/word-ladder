<?php namespace WordLadder;

/*
 * Copyright (C) 2015 Daniel A.C. Martin.
 * This file is part of word-ladder.
 * 
 * word-ladder is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * word-ladder is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with word-ladder.  If not, see <http://www.gnu.org/licenses/>.
 */

abstract class Solver
{
	protected $words;
	protected $lookups;
	protected $word_size;
	protected $orig_index;
	protected $dest_index;
	protected $steps    = null;
	
	public function __construct(&$words, &$lookups, $word_size, $orig_index, $dest_index, $steps = null)
	{
		$this->words      =& $words;
		$this->lookups    =& $lookups;
		$this->word_size   = $word_size;
		$this->orig_index  = $orig_index;
		$this->dest_index  = $dest_index;
		$this->steps       = $steps;
		$this->distance    = $this->distance($orig_index, $dest_index);
	}
	
	abstract public function solve();
	
	protected static function prevalenceScore($solution) // Weakest link
	{
		$return = PHP_INT_MAX;
		$n      = 0;
		
		foreach($solution as $e)
			if($return > $e['prevalence'])
		{
			$return = $e['prevalence'];
		}
		
		return $return;
	}

	/*
	protected static function prevalenceScore($solution) // Geometric mean
	{
		$return = 1;
		$n      = 0;
		
		foreach($solution as $e)
		{
			$return *= $e['prevalence'];
			++$n;
		}
		
		$return = pow($return, 1.0 / (double)$n);
		
		return $return;
	}
	//*/
	
	protected function distance($start, $finish)
	{
		return $this->distanceBetweenWords($this->words[$start]['value'], $this->words[$finish]['value']);
	}
	
	protected static function distanceBetweenWords($start, $finish)
	{
			$r         = false;
			$word_size = strlen($start);
			
			if(strlen($finish) === $word_size)
			{
				$r = 0;
				$n = 0;
				
				while($n < $word_size)
				{
					if($start{$n} != $finish{$n})
					{
						$r++;
					}
				
					$n++;
				}
			}
			
			return $r;
	}
}

