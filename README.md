word-ladder
===========

word-ladder is a command-line program and PHP library for solving
[word ladder puzzles].

*Word ladder* is a word game invented by [Lewis Caroll]. The player is given two
words and must find a 'ladder' from one to another on which only one letter is
changed between words on adjacent rungs on the ladder.
e.g.

	Ladder from GIT to HUB:
	GIT -> GUT -> HUT -> HUB

Word ladder problems can have more than one correct answer. Because of this,
word-ladder will declare the first solution it finds, then it will analyse
all solutions (the same length as the first one) and declare the *best* one.
(Where 'best' is defined as being the solution whose least common word, is more
common than all other solutions' least common words. i.e. Ladders are judged to
only be as strong as their weakest link / rung.)

There are some variations on the word ladder game in which the problem must be
solved in a specified number of steps. In some cases it is possible to solve the
problem in fewer steps. Unlike most other solvers, word-ladder accepts an option
to attempt to solve the problem in a set number of steps. (When this option is
not provided it simply attempts to solve the problem in as few steps as
possible.)

Program - Getting started
-------------------------

Download [the Phar]. Place it wherever you want on your system. Execute it from
the command line through PHP. (Or you can execute it directly if you have a
valid, modern PHP binary at /usr/bin/php.)

Program - Usage
---------------

	Usage: word-ladder START FINISH [STEPS]

The command-line program accepts three parameters, *START*, *FINISH*, and
*STEPS*, where only the third, *STEPS* is optional.

**START**: The first word in the ladder.

**FINISH**: The last word in the ladder.

**STEPS**: The number of steps / rungs on the ladder.

Example:

	$ word-ladder git hub
	Attempting: git -> hub
	First solution set (3 steps) found after 2 lookups:
	0: git  [a person who is deemed to be despicable or contemptible; "only a ro...]
	1: gib  [a castrated tomcat]
	2: gub  []
	3: hub  [the central part of a car wheel (or fan or propeller etc) through w...]
	[Prevalence score: 112.26878713664]
	Finding and analysing all solutions... Done.
	
	10 solution(s) found.
	
	0: git  [a person who is deemed to be despicable or contemptible; "only a ro...]
	1: gut  [a strong cord made from the intestines of sheep and used in surgery]
	2: hut  [small crude shelter used as a dwelling]
	3: hub  [the central part of a car wheel (or fan or propeller etc) through w...]
	
	[Prevalence score: 16551.249116398]

Library - Getting started
-------------------------

1. Get [Composer]
2. Require word-ladder with `php composer.phar require daniel-ac-martin/word-ladder`
3. Install dependencies with `php composer.phar install`

Library - Usage
---------------

The library is invoked by including Composer's autoloader and then calling the
method, *WordLadder\WordLadder::solve*. Please see the following example.

```php
<?php

require_once 'vendor/autoload.php'; // Composer's autoloader

$start  = 'git';
$finish = 'hub';
$steps  = 4;

try
{
	$solution = WordLadder\WordLadder::solve($start, $finish, $steps);
	
	foreach($solution->solution() as $e)
	{
		echo $e->word() . ': ' . substr($e->definition(), 0, 78 - strlen($start)) . "\n";
	}
}
catch(Exception $e)
{
	die('Error: ' . $e->getMessage() . "\n");
}

?>
```

License
-------

Copyright (C) 2015 Daniel A.C. Martin

Distributed under the GNU GPL v3.

 [word ladder puzzles]: http://en.wikipedia.org/wiki/Word_ladder
 [Lewis Caroll]:        http://en.wikipedia.org/wiki/Lewis_Carroll
 [the Phar]:            https://github.com/daniel-ac-martin/word-ladder/releases/download/0.1/word-ladder.phar
 [Composer]:            http://getcomposer.org

