<?php
session_start();
if (isset($_GET['restart'])) {
	session_destroy();
	session_start();
}

require('game.php');
$started = true;
if(!isset($_SESSION['game'])) {
	$_SESSION['generation'] = 0;
	$nbRow = isset($_GET['row']) && filter_var($_GET['row'], FILTER_SANITIZE_NUMBER_INT) ? filter_var($_GET['row'], FILTER_SANITIZE_NUMBER_INT): 25;
	$nbCol = isset($_GET['col']) && filter_var($_GET['col'], FILTER_SANITIZE_NUMBER_INT) ? filter_var($_GET['col'], FILTER_SANITIZE_NUMBER_INT): 25;
	$_SESSION['game'] = initializeGame($nbRow, $nbCol);
} else {
	$oldGame = $_SESSION['game'];
	$_SESSION['game'] = nextGeneration($_SESSION['game']);
	$started = !gameIsStill($oldGame, $_SESSION['game']);
	$_SESSION['generation']++;
}
include('template.html');
