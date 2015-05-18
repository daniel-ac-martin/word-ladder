<?php namespace WordLadder\Solver\Dijkstra;

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

class MinPriorityQueue extends \SEIDS\Heaps\Pairing\MinPriorityQueue
//class MinPriorityQueue extends \SplPriorityQueue
{
	public function compare($priority1, $priority2)
	{
		return $priority2 - $priority1;
	}
	
	public function update($value, $priority) // FIXME: Delete this method?
	{
		if(is_callable('parent::update'))
		{
			parent::update($value, $priority);
		}
		else
		{
			// Warning: This is slow! O(n.log(n)?
			//echo 'Warning: Re-ordering priority queue. This is a slow operation.' . n;
			
			$this->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
			
			$found = false;
			$store = array();
			
			foreach($this as $e)
			{
				if($e['data'] === $value)
				{
					$e['priority'] = $priority;
					$found         = true;
				}
				
				$store[] = $e;
			}
			
			foreach($store as $e)
			{
				$this->insert($e['data'], $e['priority']);
			}
			
			if(!$found)
			{
				$this->insert($value, $priority);
			}
			
			$this->setExtractFlags(\SplPriorityQueue::EXTR_DATA);
		}
	}
}

