<?php
require('Model/mRegisterLogin.php');

function register($dataPage) {
    if (!isset($_POST['exist'])) {
        //affiche formulaire
    }
    else {
        //traite les infos recues
        if ($dataPage['password'] != $dataPage['passwordVerif']) {
            //infos incorrectes
        }
        else {
            //enregistre infos
            $dataPage['password'] = password_hash($dataPage['password']);
            
            //verifier que renvoi d'un post est true ou false
            if (!postDataUser($dataPage)) throw new Exception('Echec d\'enregistrement des données');
        }
    }

    require('View/RegisterLogin/vRegister.php');
}



function login($dataPage) {
    if (!isset($_POST['exist'])) {
        //affiche formulaire
    }
    else {
        //traite les infos recues
        $dataUser = getDataUser($dataPage['login']);
        if (!$dataUser) throw new Exception('Echec de récupération des données');

        if (password_verify($dataPage['password'], $dataUser['password'])) {//compare les hash (utile de verifier retours de dataUser?)
            $_SESSION['login'] = $dataUser['login'];
            $_SESSION['rank'] = $dataUser['rank'];
            $_SESSION['id'] = $dataUser['id'];
        }
        else {
            $message = 'identifiant ou mot de passe erronné';
        }
    }

    require('View/RegisterLogin/vLogin.php');
}