<?php
// start session
session_start();
// declare variables
$PLAYERS = ['X', 'O'];
// run functions
init();

function init()
{
	// start the game
	if (isset($_POST['start']))
	{
		game_start();
	}
	game_turn();
}



function game_start()
{
	global $PLAYERS;
	$_SESSION['status'] = 'start';
	$_SESSION['game']   =
	[
		1 => null,
		2 => null,
		3 => null,
		4 => null,
		5 => null,
		6 => null,
		7 => null,
		8 => null,
		9 => null,
	];

	if(isset($_SESSION['lastWinner']))
	{
		$_SESSION['current'] = $_SESSION['lastWinner'];
	}
	else
	{
		$_SESSION['current'] = $PLAYERS[rand(0,1)];
	}
}


function game_create()
{
	$element = null;
	foreach ($_SESSION['game'] as $cell => $value)
	{
		$className = null;
		if($value)
		{
			$className = 'c'.$value;
		}
		$element .= "    <input type='submit' class='cell $className' value='$value' name='cell$cell'";
		if($value)
		{
			$element .= " disabled";
		}
		elseif($_SESSION['status'] == 'winner' || $_SESSION['status'] == 'draw')
		{
			$element .= " disabled";
		}
		$element .=  ">\n";
	}
	return $element;
}


function game_turn()
{
	if($_SESSION['status'] == 'winner' || $_SESSION['status'] == 'draw')
	{
		return null;
	}

	foreach ($_SESSION['game'] as $cell => $value)
	{
		if (isset($_POST['cell'.$cell]))
		{
			$_SESSION['status']      = 'inprogress';
			$_SESSION['game'][$cell] = $_SESSION['current'];
			if($_SESSION['current'] === 'X')
			{
				$_SESSION['current'] = 'O';
			}
			else
			{
				$_SESSION['current'] = 'X';
			}
		}
	}
}

function game_checkWinner()
{
	$g      = $_SESSION['game'];
	$winner = false;
	if(
			($g[1] && $g[1] == $g[2] && $g[2] == $g[3]) //row 1
		|| 	($g[4] && $g[4] == $g[5] && $g[5] == $g[6]) //row 2
		|| 	($g[7] && $g[7] == $g[8] && $g[8] == $g[9]) //row 3

		|| 	($g[1] && $g[1] == $g[4] && $g[4] == $g[7]) //col 1
		|| 	($g[2] && $g[2] == $g[5] && $g[5] == $g[8]) //col 2
		|| 	($g[3] && $g[3] == $g[6] && $g[6] == $g[9]) //col 3

		|| 	($g[1] && $g[1] == $g[5] && $g[5] == $g[9]) // \
		|| 	($g[3] && $g[3] == $g[5] && $g[5] == $g[7]) // /

		)
	{
		if ($_SESSION['current'] == 'X')
		{
			$winner = 'O';
		}
		else
		{
			$winner = 'X';
		}
	}
	return $winner;
}

function game_winner()
{
	if($_SESSION['status'] === 'start')
	{
		return null;
	}

	$game_result = game_checkWinner();
	$result      = null;
	if($game_result)
	{
		// has one winner
		$_SESSION['lastWinner'] = $game_result;
		$_SESSION['status'] = 'winner';
		$result = "<div id='result'>$game_result win!</div>";
	}
	elseif(!in_array(null, $_SESSION['game']))
	{
		// draw
		$_SESSION['status'] = 'draw';
		$_SESSION['lastWinner'] = null;
		$result = "<div id='result'>Draw</div>";
	}
	else
	{
		$_SESSION['status'] = 'inprogress';
	}
	return $result;
}

function game_resetBtn()
{
	$result     = null;
	$resetValue = 'Start';
	if($_SESSION['status'] == 'inprogress')
	{
		$resetValue = 'Resign';
	}
	elseif($_SESSION['status'] == 'winner' || $_SESSION['status'] == 'draw')
	{
		$resetValue = 'Play Again!';
	}

	if($_SESSION['status'] !== 'start')
	{
		$result = "<input type='submit' name='start' value='$resetValue' id='resetBtn'>";
	}


	return $result;
}


?>