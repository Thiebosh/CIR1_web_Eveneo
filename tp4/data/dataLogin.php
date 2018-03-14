<?php 
//connexion a la BDD
try {
	$bdd = new PDO('mysql:host=localhost;dbname=eventCalendar;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $error) {
        die('Erreur : '.$error->getMessage());
}

if (isset($_POST['login']) AND isset($_POST['password'])) {//si a bien recu les donnees
    //  Récupération de l'utilisateur et de son pass hashé
    $request = $bdd->prepare('SELECT id, `password`, rank FROM Users WHERE `login` = :login');
    $request->execute(array('login' => $_POST['login']));
    $identifiers = $request->fetch();

    // Comparaison des infos envoyées via le formulaire avec celles de la BDD
    $formPassword = (string)filter_input(INPUT_POST, 'password');//prend le champ password du formulaire
    if (!identifiers || !password_verify($formPassword, $identifiers['password'])) {//faux ou vide
        echo 'Mauvais identifiant ou mot de passe !';
    }
    else if (identifiers && password_verify($formPassword, $identifiers['password'])) {
        session_start();
        $_SESSION['id'] = $identifiers['id'];
        $_SESSION['rank'] = $identifiers['rank'];
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['logged'] = true;
        echo 'Vous êtes connecté !';
    }

    $request->closeCursor();
}