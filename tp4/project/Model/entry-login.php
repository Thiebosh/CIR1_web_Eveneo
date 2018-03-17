<?php

function dbConnect() {//modifier champs
    $dataBase = new PDO('mysql:host=localhost;dbname=eventCalendar;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    return $dataBase;
}

function postDataUser($infoPage) {
    $dataBase = dbConnect();

    //requete post
    $rank = $infoPage['rank'];
    $login = $infoPage['login'];
    $password = $infoPage['password'];
}

function getDataUser($login) {
    $dataBase = dbConnect();

    $request = $dataBase->prepare('SELECT id, `password`, rank FROM Users WHERE `login` = :login');
    $request->execute(array('login' => $login));

    return $request;
}