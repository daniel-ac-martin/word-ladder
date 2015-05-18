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

class Solution
{
	protected $graph_size       = 0;
	protected $lookups          = 0;
	protected $solution         = null;
	protected $prevalence_score = 0;
	protected $set_size         = 0;
	
	public function __construct($graph_size, $lookups, $solver_solution)
	{
		$this->graph_size       = $graph_size;
		$this->lookups          = $lookups;
		$this->solution         = $this->objectify($solver_solution->solution);
		$this->prevalence_score = $solver_solution->prevalence_score;
		$this->set_size         = $solver_solution->set_size;
	}
	
	public function graphSize()
	{
		return $this->graph_size;
	}
	
	public function lookups()
	{
		return $this->lookups;
	}
	
	public function solution()
	{
		return $this->solution;
	}
	
	public function prevalenceScore()
	{
		return $this->prevalence_score;
	}
	
	public function setSize()
	{
		return $this->set_size;
	}
	
	protected static function objectify($solution)
	{
		$return = array();
		
		if(!is_array($solution))
		{
			throw Exception('\$solution is not an array');
		}
		else
			foreach($solution as $e)
		{
			$return[] = new Word($e['value'], $e['glossary']);
		}
		
		return $return;
	}
}

