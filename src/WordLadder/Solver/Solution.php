<?php namespace WordLadder\Solver;

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

class Solution
{
	public $solution         = null;
	public $prevalence_score = 0;
	public $set_size         = 0;
	
	public function __construct($solution, $prevalence_score, $set_size)
	{
		$this->solution         = $solution;
		$this->prevalence_score = $prevalence_score;
		$this->set_size         = $set_size;
	}
}

