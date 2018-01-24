<?php

function initialiseValeurs() {
	$_SESSION['dimensions'] = [50, 30];
	$_SESSION['ageMax'] = 10;
	
	$_GET["time"] = 1;
}
	
function initialiseGame() {
	initialiseValeurs();
	$_SESSION['newPartie'] = 0;
	$_SESSION['generation'] = 0;
	$_SESSION['nbCellules'] = 0;
	
	for ($x = 0; $x < $_SESSION['dimensions'][0]; $x++) {
		for ($y = 0; $y < $_SESSION['dimensions'][1]; $y++) {
			$_SESSION['plateau'][$x][$y]['cell'] = 0;
			$_SESSION['plateau'][$x][$y]['age'] = 0;
			
			
			if (rand(0,1)) {
				$_SESSION['plateau'][$x][$y]['cell'] = 1;
				$_SESSION['plateau'][$x][$y]['age'] = 1;
				$_SESSION['nbCellules']++;
			}
		}
	}
	echo 'Nouvelle population : ' . $_SESSION['nbCellules'] . ' cellules';
}


function calculVoisins($posX, $posY) {
	$nbVoisins = 0;
	
	for ($y = $posY - 1; $y <= $posY + 1; $y++) {
		if ($y == -1) $y++; // exeption sortie de tableau
		if ($y == $_SESSION['dimensions'][1]) break; //exeption
		
		for ($x = $posX - 1; $x <= $posX + 1; $x++) {
			if($x == -1) $x++; //exeption
			if ($x == $_SESSION['dimensions'][0]) break; //exeption
			
			if ($_SESSION['plateau'][$x][$y]['cell'] == 1) $nbVoisins++;
		}
	}
	
	return $nbVoisins;
}


function etatCellule($posX, $posY) {
	$nbVoisins = calculVoisins($posX, $posY);
	
	if ($_SESSION['plateau'][$posX][$posY] == 1) {
		if ($nbVoisins < 2 || $nbVoisins > 3) return 0;
		else return 1;
	}
	else {
		if ($nbVoisins != 3) return 0;
		else return 1;
	}
}


function newGeneration() {
	$newCellules = 0;
	
	for ($y = 0; $y < $_SESSION['dimensions'][1]; $y++) {
		for ($x = 0; $x < $_SESSION['dimensions'][0]; $x++) {
			$etat = etatCellule($x, $y);
			
			if ($etat == 1 && $_SESSION['plateau'][$x][$y]['age'] <= $_SESSION['ageMax']) {
				$_SESSION['newPlateau'][$x][$y]['cell'] = 1;
				$_SESSION['newPlateau'][$x][$y]['age'] = $_SESSION['plateau'][$x][$y]['age']+ 1; //génération augmente
				$newCellules++; 
			}
			else {
				$_SESSION['newPlateau'][$x][$y]['cell'] = 0;
				$_SESSION['newPlateau'][$x][$y]['age'] = 0;
			}
		}
	}
	
	$_SESSION['plateau'] = $_SESSION['newPlateau'];
	$_SESSION['nbCellules'] = $newCellules;
	$_SESSION['generation']++;
}

function déroulementJeu() {
	if (isset($_SESSION['plateau'])) {
		if ($_SESSION['nbCellules'] == 0) {
			if ($_SESSION['newPartie'] == 0) {
				echo 'Peuple exterminé';
				$_GET["time"] = 2;
				$_SESSION['newPartie'] = 1;
			}
			else {
				initialiseGame();
			}
		}
		else {
			newGeneration();
			echo 'Génération ' . $_SESSION['generation'] . '<br> Nombre de cellules vivantes : ' . $_SESSION['nbCellules'];
		}
	}

	else {
		initialiseValeurs();
		initialiseGame();
	}
}

?>
