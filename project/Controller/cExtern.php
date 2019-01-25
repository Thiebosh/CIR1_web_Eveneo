<?php
require('Model/mExtern.php');


function externLogin($dataPage) {
    if ($_POST['script']) {
        $dataUser = externGetDataUser($dataPage['login']);
        if (!$dataUser) throw new Exception("Connexion : Echec de récupération des données");
        else if (!password_verify($dataPage['password'], $dataUser['password'])) {
            throw new Exception("Connexion : Identifiant ou mot de passe erronné");
        }
        
        $_SESSION['login'] = $dataPage['login'];
        $_SESSION['rank'] = $dataUser['rank'];
        $_SESSION['id'] = $dataUser['id'];

        if ($dataUser['rank'] == 'CUSTOMER') $_SESSION['rankFR'] = 'Client';
        else                                 $_SESSION['rankFR'] = 'Organisateur';

        header('Location: index.php?action=month');
        exit();
    }
    else if (isset($dataPage['echec'])) $listError = $dataPage['echec'];

    $page['pageName'] = 'Connexion';
    $page['actual'] = 'login';

    require('View/vExtern.php');
}


function externRegister($dataPage) {
    if ($_POST['script']) {
        if (externGetLoginUser($dataPage['login'])) throw new Exception("Inscription : Nom de compte déjà utilisé");
        if ($dataPage['password'] != $dataPage['passwordVerif']) throw new Exception("Inscription : les mots de passe ne sont pas identiques");
        $dataPage['password'] = password_hash($dataPage['password'], PASSWORD_DEFAULT);
        
        externPostDataUser($dataPage);

        header('Location: index.php?action=login');
        exit();
    }
    else if (isset($dataPage['echec'])) $listError = $dataPage['echec'];

    $page['pageName'] = 'Inscription';
    $page['actual'] = 'register';

    require('View/vExtern.php');
}