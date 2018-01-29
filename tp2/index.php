<?php

if (!isset($page)) { //si n existe pas (initialise)
	$page = 'affiche'; //definit la page a afficher
}
require('gestion.php');



if (verifDonnees()) {//si recoit un produit, traite
	//traite la requete
	$accesImg = './images/';//range dans le fichier images
	if (!move_uploaded_file($_POST['photo'], $accesImg)) {//verifie l image avant	//move_uploaded_file($_FILES['photo']['tmp_name'], $accesImg . $_FILES['photo']['tmp_name']));
		echo('echec d\'enregistrement de l\'image');
	}

	enregistrement();
}

$listeProduits = referencement(); //liste tous les produits et informations relatives

if (isset($_GET['page'])) {
	$page = filter_var($_GET['page'], FILTER_SANITIZE_STRING); //supprime balises, caracteres speciaux et encodages
}

if ($page == 'affiche') {
	include('liste_produits.php');
}
else if ($page == 'ajout') {
	include('ajout_produits.php');
}
else {
	echo 'ERROR 404';
}