<?php

require('Model/mCommon.php');

function getAllEvents($infoPage) {//faire jointure pour ne prendre que les conf de organizer
    $dataBase = dbConnect();

    if ($infoPage['showEventFull']) {
        $request = $dataBase->query('SELECT id, `name` FROM Events WHERE DATEDIFF($infoPage[\'`date`\'] - startdate) == 0 ORDER BY startdate');
    }
    else {
        $request = $dataBase->query('SELECT id, `name` FROM Events WHERE DATEDIFF($infoPage[\'`date`\'] - startdate) == 0 ORDER BY startdate LIMIT 0, 6');//si plus de 5, affiche le bouton
    }
    $listEvent = $request->fetchAll();

    return $listEvent;
}

function getEvent($idEvent) {//verifier champs
    $dataBase = dbConnect();
    
    $request = $dataBase->query('SELECT e.name nameConf, e.description describeConf, e.startdate startDate, e.enddate endDate, e.nb_place places
        FROM Events e INNER JOIN User u ON u.id = e.organizer_id WHERE e.id = $idEvent');
    $event = $request->fetchAll();

    return $event;
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

function updateEvent($infoEvent) {
    $dataBase = dbConnect();

    //requete update
}