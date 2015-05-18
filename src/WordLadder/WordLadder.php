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

define('DATAFILE_PREFIX',    __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR);
define('DATAFILE_POSTFIX',   '-letters');
define('DATAFILE_EXTENSION', '.json');

class WordLadder
{
	public static function solve($start, $finish, $steps = null, $first = false)
	{
		$return         = false;
		$word_size      = strlen($start);
		$proc_PREFIX    = DATAFILE_PREFIX . $word_size . DATAFILE_POSTFIX;
		$words_dir_proc = $proc_PREFIX . DATAFILE_EXTENSION;
	
		if(!file_exists($words_dir_proc))
		{
			throw new Exception('Cannot find relevant data file.');
		}
		else
		{
			$words_dir = json_decode(file_get_contents($words_dir_proc), true);
	
			if(!isset($words_dir[$start]))
			{
				throw new Exception('Could not find ' . $start . ' in dictionary.');
			}
			else if(!isset($words_dir[$finish]))
			{
				throw new Exception('Could not find ' . $finish . ' in dictionary.');
			}
			else
			{
				$start_data =& $words_dir[$start];
		
				$group = $start_data['group'];
				$start_index = $start_data['index'];
				$finish_index = $words_dir[$finish]['index'];
		
				if($group !== $words_dir[$finish]['group'])
				{
					throw new Exception('Unsolvable; ' . $start . ' and ' . $finish . ' are not connected.');
				}
				else
				{
					$words_proc = $proc_PREFIX . DIRECTORY_SEPARATOR . $group . DATAFILE_EXTENSION;
				
					if(!file_exists($words_proc))
					{
						throw new Exception('Cannot find relevant data file.');
					}
					else
					{
						$words = json_decode(file_get_contents($words_proc), true);
					
						$lookups = 0;
						$solver = new Solver\AStar($words, $lookups, $word_size, $start_index, $finish_index, $steps);
						$solution = $solver->solve($first);
	
						if($solution === false)
						{
							throw new Exception('FAIL.'); // This should never happen
						}
						else
						{
							$return = new Solution(count($words), $lookups, $solution);
						}
					}
				}
			}
		}
		
		return $return;
	}
}

