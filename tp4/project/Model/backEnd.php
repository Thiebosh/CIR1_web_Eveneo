<?php

function dbConnect() {//modifier champs
    $dataBase = new PDO('mysql:host=localhost;dbname=eventCalendar;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    return $dataBase;
}

function getAllEvents($infoPage) {
    $dataBase = dbConnect();

    //modifier requete
    $nbEvent = $infoPage['nbEvent'];
    $month = $infoPage['month'];
    $request = $dataBase->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT 0, 5');

    return $request;
}

function getEvent($idEvent) {
    $dataBase = dbConnect();
    //modifier champs
    $request = $dataBase->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT 0, 5');

    return $request;
}

function postEvent($infoEvent) {
    $dataBase = dbConnect();

    //requete post
    $nameEvent = infoEvent['name'];
    $startDateEvent = infoEvent['start'];
    $endDateEvent = infoEvent['end'];
    $nbPlaces = infoEvent['nbPlace'];
    $description = infoEvent['description'];
}