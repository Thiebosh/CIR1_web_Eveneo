<?php
require('Model/mRegisterLogin.php');

function login($received) {
    if (isset($received)) {//fonctionne? gère script_login
        //traite les infos recues
        $dataUser = getDataUser($received['login']);
        if (!$dataUser) throw new Exception('Connexion : Echec de récupération des données');

        else if (!password_verify($received['password'], $dataUser['password'])) {//compare les hash (utile de verifier retours de dataUser?)
            throw new Exception('Connexion : Identifiant ou mot de passe erronné');
        }

        else {
            $_SESSION['login'] = $dataUser['login'];
            $_SESSION['rank'] = $dataUser['rank'];
            $_SESSION['id'] = $dataUser['id'];
            header('Location: index.php?action=reception');//redirige vers l'accueil
        }
    }

    //finir de préparer variables

    require('View/RegisterLogin/vLogin.php');
}



function register($received) {
    if (isset($received)) {//fonctionne? gère script_register
        //traite les infos recues
        if ($received['password'] != $received['passwordVerif']) {
            throw new Exception('Inscription : les mots de passe ne sont pas identiques');
        }

        $received['password'] = password_hash($received['password']);
        if (!postDataUser($received)) throw new Exception('Inscription : Echec d\'enregistrement des données');//verifier que renvoi d'un post est true ou false

        header('Location: index.php?action=login');//redirige vers la page de connexion
    }

    //finir de préparer variables

    require('View/RegisterLogin/vRegister.php');
}