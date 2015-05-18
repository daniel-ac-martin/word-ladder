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

class Word
{
	protected $word;
	protected $definition;
	
	public function __construct($word, $definition)
	{
		$this->word       = $word;
		$this->definition = $definition;
	}
	
	public function word()
	{
		return $this->word;
	}
	
	public function definition()
	{
		return $this->definition;
	}
}

