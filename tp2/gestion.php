<?php

function verifDonnees() {
    if (isset($_POST['nom'], $_POST['prix'], $_POST['stock'], $_POST['photo'])) { //test de toutes les variables
        if (ctype_alpha($_POST['nom']) && is_numeric($_POST['prix']) && is_numeric($_POST['stock'])) { //verifie qu elles soient correct
            //verif prix et stocks positifs
            
            return TRUE;
        }
    }
    return FALSE;
}

function enregistrement() {
	//verifier les retours des 3 prochaines lignes
    $fichier = fopen('mesproduits.csv', 'a+');
    fputcsv($fichier, array($_post['nom'], $_POST['prix'], $_POST['stock'], $accesImg), ';', '\n'); //ecriture en fichier
    fclose($fichier);
}

function referencement() {
    //$listeProduits[$nom]
    //$listeProduits[$img]
    //$listeProduits[$prix]
    //$listeProduits[$nbArticle]

    //return $listeProduits; //pointeur sur tableau
}