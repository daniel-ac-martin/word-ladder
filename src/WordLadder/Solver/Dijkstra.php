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

class Dijkstra extends \WordLadder\Solver
{
	// Overload this method to manufacture an A* algorthm.
	// Note: Don't modify $node.
	public function heuristic($node)
	{
		return 0;
	}
	
	public function solve($first = false)
	{
		$return          = false;
		$solutions       = 0;
		$PQ              = new Dijkstra\MinPriorityQueue;
		$closed          = array();
		$dist            = array($this->orig_index => 0);
		$prev            = array();
		$done            = false;
		$max_steps       = $this->steps;
	
		$PQ->insert($this->orig_index, 0);
	
		while(count($PQ))
		{
			$index = $PQ->extract();
			
			if(!isset($closed[$index]))
			{
				foreach($this->words[$index]['paths'] as $e1)
					foreach($e1 as $neighbour_index)
				{
					$g_score = $dist[$index] + 1;
					$f_score = $g_score + $this->heuristic($neighbour_index);
				
					if
					(
						   (null === $max_steps)
						|| ($f_score <= $max_steps)
					)
					{
						$no_dist = !isset($dist[$neighbour_index]);
					
						if
						(
							   $no_dist
							|| ($g_score < $dist[$neighbour_index])
						)
						{
							$dist[$neighbour_index]           = $g_score;
							$prev[$neighbour_index][$g_score] = array($index);
						
							//$PQ->insert($neighbour_index, $f_score); // Perhaps we should just insert (as it is quicker) and tolerate duplicates in the priority queue?
							$no_dist ? $PQ->insert($neighbour_index, $f_score)
									 : $PQ->update($neighbour_index, $f_score); // I believe this (update) only happens with A*. And perhaps when distances between nodes are not all equal.
						}
						else
						{
							$prev[$neighbour_index][$g_score][] = $index;
						}
				
						if
						(
							   !$done
							&& ($neighbour_index == $this->dest_index)
						)
						{
							if(null === $max_steps)
							{
								$max_steps = $dist[$this->dest_index];
							}
					
							$solution = $this->prev2solution($prev, $solutions, $this->dest_index, $max_steps);
					
							if(null !== $solution)
							{
								$done = true;
								
								if($first)
								{
									// We only want the first solution we find, so short-circuit here
									return new Solution($solution, $this->prevalenceScore($solution), null);
								}
							}
						}
					}
				}
				
				$closed[$index] = true;
				++$this->lookups;
			}
		}
	
		if($done)
		{
			$solutions = 0;
			$solution  = $this->prev2solution($prev, $solutions, $this->dest_index, $max_steps);
			$return    = new Solution($solution, $this->prevalenceScore($solution), $solutions);
		}
	
		return $return;
	}
	
	public function prev2solution(&$prev, &$solutions, $index, $steps)
	{
		if(null !== $return = $this->prev2solutionSub($prev, $solutions, $index, $steps))
		{
			$return = array_reverse($return);
		}
		return $return;
	}

	public function prev2solutionSub(&$prev, &$solutions, $index, $steps, &$memo = array())
	{
		$return   = null;
		$set_size = 0;
	
		if(isset($memo[$steps][$index]))
		{
			$return    = $memo[$steps][$index]['return'];
			$set_size += $memo[$steps][$index]['set_size'];
		}
		else
		{
			if($index === $this->orig_index)
			{
				if($steps === 0)
				{
					$return = array();
				}
			}
			else
			{
				$best_score = 0;
				$n          = 0;
			
				while($n++ < $steps)
				{
					if(isset($prev[$index][$n]))
						foreach($prev[$index][$n] as $e)
							if(null !== $candidate = $this->prev2solutionSub($prev, $set_size, $e, $steps - 1, $memo))
					{
						$score = $this->prevalenceScore($candidate);
					
						if($score > $best_score)
						{
							$best_score = $score;
							$return     = $candidate;
						}
					
						++$set_size;
					}
				}
			}
		
			if(null !== $return)
			{
				array_unshift($return, $this->words[$index]);
			}
		
			$memo[$steps][$index]['return']   = $return;
			$memo[$steps][$index]['set_size'] = $set_size;
		}
	
		$solutions += $set_size;
	
		return $return;
	}
}

