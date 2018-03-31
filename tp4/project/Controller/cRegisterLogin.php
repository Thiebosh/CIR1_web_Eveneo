<?php
require('Model/mRegisterLogin.php');

function aLogin($dataPage) {
    if (empty($dataPage)) require('View/RegisterLogin/vLogin.php');

    //else : active script_login
    $dataUser = getDataUser($dataPage['login']);

    if (!$dataUser) throw new Exception('Connexion : Echec de récupération des données');
    else if (!password_verify($dataPage['password'], $dataUser['password'])) {
        throw new Exception('Connexion : Identifiant ou mot de passe erronné');
    }
    
    $_SESSION['login'] = $dataPage['login'];
    $_SESSION['rank'] = $dataUser['rank'];
    $_SESSION['id'] = $dataUser['id'];

    header('Location: index.php?action=reception');//redirige vers l'accueil
    exit();
}


function aRegister($dataPage) {
    if (empty($dataPage)) require('View/RegisterLogin/vRegister.php');

    //else : active script_register
    if ($dataPage['password'] != $dataPage['passwordVerif']) {
        throw new Exception('Inscription : les mots de passe ne sont pas identiques');
    }
    $dataPage['password'] = password_hash($dataPage['password']);
    
    if (getLoginUser($dataPage['login'])) throw new Exception('Inscription : Login déjà utilisé');
    
    postDataUser($dataPage);//throw new Exception('Inscription : Echec d\'enregistrement des données');//verifier que renvoi d'un post est true ou false

    header('Location: index.php?action=login');//redirige vers la page de connexion
    exit();
}