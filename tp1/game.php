<?php
function initializeGame($nbOfRow, $nbOfCol) {
	$game = [];
	for($i = 0; $i < $nbOfRow; $i++) {
		$game[] = [];
		for($j = 0; $j < $nbOfCol; $j++) {
			$game[$i][$j] = (bool) random_int(0, 1);
		}
	}
	return $game;
}


function countNeightboors($game, $row, $col) {
	$neigboorsCoordinates = [[$row - 1, $col - 1], [$row - 1, $col], [$row - 1, $col + 1],
	                         [$row, $col - 1], [$row, $col + 1],
	                         [$row + 1, $col - 1], [$row + 1, $col], [$row + 1, $col + 1]];
	$neighboors = 0;
	foreach($neigboorsCoordinates as $coordinates) {
		if (isset($game[$coordinates[0]]) && isset($game[$coordinates[0]][$coordinates[1]])) {
			$neighboors += $game[$coordinates[0]][$coordinates[1]];
		}
	}
	return $neighboors;
}


function birth($array, $row, $col) {
	return (int) (countNeightboors($array, $row, $col) == 3);
}

function death($array, $row, $col) {
	return (int) !(countNeightboors($array, $row, $col) >= 4 || countNeightboors($array, $row, $col) <= 1);
}

function nextGeneration($oldGeneration) {
	$newGeneration = initializeGame(count($oldGeneration), count($oldGeneration[0]));
	foreach($oldGeneration as $rowIndex => $row) {
		foreach($row as $colIndex => $value) {
			$newGeneration[$rowIndex][$colIndex] = $value ? death($oldGeneration, $rowIndex, $colIndex) : birth($oldGeneration, $rowIndex, $colIndex);
		}
	}
	return $newGeneration;
}

function gameIsStill($old, $new) {
	foreach($old as $rowIndex => $row) {
		if (is_array($row) && !gameIsStill($row, $new[$rowIndex])) {
			return false;
		} else if (!is_array($row) && $row != $new[$rowIndex]) {
			return false;
		}
	}
	return true;
}
