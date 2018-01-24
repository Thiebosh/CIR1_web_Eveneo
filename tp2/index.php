<?php

session_start();
if (isset($_GET['restart'])) {
	session_destroy();
	session_start();
}
require('gestion.php');
$started = true;

//ancien code
if(!isset($_SESSION['game'])) {
	$_SESSION['generation'] = 0;
	$nbRow = isset($_GET['row']) && filter_var($_GET['row'], FILTER_SANITIZE_NUMBER_INT) ? filter_var($_GET['row'], FILTER_SANITIZE_NUMBER_INT): 25;
	$nbCol = isset($_GET['col']) && filter_var($_GET['col'], FILTER_SANITIZE_NUMBER_INT) ? filter_var($_GET['col'], FILTER_SANITIZE_NUMBER_INT): 25;
	$_SESSION['game'] = initializeGame($nbRow, $nbCol);
} 
if((isset($_GET['nb_generation']) && filter_var($_GET['nb_generation'], FILTER_SANITIZE_NUMBER_INT)) || $_SESSION['generation'] > 0) {
	$loops = (isset($_GET['nb_generation']) && filter_var($_GET['nb_generation'], FILTER_SANITIZE_NUMBER_INT)) ? (int)$_GET['nb_generation'] : 1;
	for($i = 0; $i < $loops; $i++) {
		$oldGame = $_SESSION['game'];
		$_SESSION['game'] = nextGeneration($_SESSION['game']);
		$started = !gameIsStill($oldGame, $_SESSION['game']);
		$_SESSION['generation']++;
	}
}

/* if (
 * 
 * 
 */
include('template.html');

?>
