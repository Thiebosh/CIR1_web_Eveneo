<?php
require('Model/mRegisterLogin.php');

function externLogin($data) {
    if ($data) {//active script_login
        $dataUser = externGetDataUser($data['login']);

        if (!$dataUser) throw new Exception("Connexion : Echec de récupération des données");
        else if (!password_verify($data['password'], $dataUser['password'])) {
            throw new Exception("Connexion : Identifiant ou mot de passe erronné");
        }
        
        $_SESSION['login'] = $data['login'];
        $_SESSION['rank'] = $dataUser['rank'];
        $_SESSION['id'] = $dataUser['id'];

        if ($dataUser['rank'] == 'CUSTOMER') $_SESSION['rankFR'] = 'Client';
        else                                 $_SESSION['rankFR'] = 'Organisateur';

        header('Location: index.php?action=reception');
        exit();
    }

    require('View/RegisterLogin/vLogin.php');
}


function externRegister($data) {
    if ($data) {//active script_register
        if ($data['password'] != $data['passwordVerif']) {
            throw new Exception("Inscription : les mots de passe ne sont pas identiques");
        }
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        if (externGetLoginUser($data['login'])) throw new Exception("Inscription : Login déjà utilisé");
        
        externPostDataUser($data);

        header('Location: index.php?action=login');
        exit();
    }

    require('View/RegisterLogin/vRegister.php');
}