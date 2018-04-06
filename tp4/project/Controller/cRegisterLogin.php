<?php
require('Model/mRegisterLogin.php');

function aLogin($data) {
    if (!$data) {
        require('View/RegisterLogin/vLogin.php');
    }
    else {//active script_login
        
        $dataUser = getDataUser($data['login']);

        if (!$dataUser) throw new Exception("Connexion : Echec de récupération des données");
        else if (!password_verify($data['password'], $dataUser['password'])) {
            throw new Exception("Connexion : Identifiant ou mot de passe erronné");
        }
        
        $_SESSION['login'] = $data['login'];
        $_SESSION['rank'] = $dataUser['rank'];
        $_SESSION['id'] = $dataUser['id'];

        if ($dataUser['rank'] == 'CUSTOMER') $_SESSION['rankFR'] = 'Client';
        else                                 $_SESSION['rankFR'] = 'Organisateur';

        header('Location: index.php?action=reception');//redirige vers l'accueil
        exit();
    }
}


function aRegister($data) {
    if (!$data) {
        require('View/RegisterLogin/vRegister.php');
    }

    else {//active script_register
        if ($data['password'] != $data['passwordVerif']) {
            throw new Exception("Inscription : les mots de passe ne sont pas identiques");
        }
        $data['password'] = password_hash($data['password']);
        
        if (getLoginUser($data['login'])) throw new Exception("Inscription : Login déjà utilisé");
        
        postDataUser($data);//throw new Exception("Inscription : Echec d\'enregistrement des données');//verifier que renvoi d'un post est true ou false

        header('Location: index.php?action=login');//redirige vers la page de connexion
        exit();
    }
}