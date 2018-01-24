<?php

session_start();
if (!isset($_SESSION['page'])) { //si n'existe pas (initialise)
	$_SESSION['page'] = 'liste'; //définit la page à afficher
}
require('gestion.php');



if (verifDonnees()) {
	//traite la requete
	//$accesImg = ;
	if (!move_uploaded_file($_POST['photo'], $accesImg)) {//vérifier l'image avant
		echo('echec d\'enregistrement de l\'image');
	}

	enregistrement();
}


$_SESSION['page'] = filter_var($_GET['page'], FILTER_SANITIZE_STRING); //supprime balises, caracteres speciaux et encodages
if ($_SESSION['page'] == 'affiche') {
	include('liste_produits.php');
}
else { //ajout
	include('liste_produits.php');
}
