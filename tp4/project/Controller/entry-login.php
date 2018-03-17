<?php
require('Model/entry-login.php');

function Entry($infoPage) {
    if (isset($infoPage['login'])) {
        $dataUser = postDataUser($infoPage);
    }

    require('View/Entry-Login/viewEntry.php');
}

function Login($infoPage) {
    if (isset($infoPage['login'])) {
        $dataUser = getDataUser($infoPage['login']);
        $dataUser = $request->fetch();//utile?

        if (dataUser && password_verify($infoPage['password'], $dataUser['password'])) {//compare les hash (utile de verifier retours de dataUser?)
            session_start();//utile?
            $_SESSION['login'] = $infoPage['login'];
            $_SESSION['rank'] = $dataUser['rank'];
            $_SESSION['id'] = $dataUser['id'];
            $_SESSION['logged'] = true;
        }
    }

    require('View/Entry-Login/viewLogin.php');
}