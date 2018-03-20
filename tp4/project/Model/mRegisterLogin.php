<?php

function dbConnect() {//modifier champs
    $dataBase = new PDO('mysql:host=localhost;dbname=eventCalendar;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    return $dataBase;
}

function postDataUser($infoPage) {
    $dataBase = dbConnect();

    //avancée
    //requete post
    $rank = $infoPage['rank'];
    $login = $infoPage['login'];
    $password = $infoPage['password'];
}

function getDataUser($login) {//ok
    $dataBase = dbConnect();

    $request = $dataBase->prepare('SELECT id, `password`, rank FROM Users WHERE `login` = :login');
    $request->execute(array('login' => $login));
    $dataUser = $request->fetch();

    return $dataUser;
}