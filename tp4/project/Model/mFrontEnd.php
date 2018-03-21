<?php

function dbConnect() {//modifier champs
    $dataBase = new PDO('mysql:host=localhost;dbname=eventCalendar;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    return $dataBase;
}

function getEventsDay($infoPage, $limited) {//faire jointure et comparer nb places avec nb personnes inscrites à event
    $dataBase = dbConnect();

    if ($limited) {
        $request = $dataBase->query('SELECT id, `name` FROM Events WHERE DATEDIFF($infoPage[\'`date`\'] - startdate) == 0 ORDER BY startdate LIMIT 0, 6');//si plus de 5, affiche le bouton
    }
    else {
        $request = $dataBase->query('SELECT id, `name` FROM Events WHERE DATEDIFF($infoPage[\'`date`\'] - startdate) == 0 ORDER BY startdate');
    }
    $listEvent = $request->fetchAll();

    return $listEvent;
}

function getEvent($idEvent) {
    $dataBase = dbConnect();

    $request = $dataBase->query('SELECT e.name nameConf, e.description describeConf, e.startdate startDate, e.enddate endDate, e.nb_place places, u.login organizer
        FROM Events e INNER JOIN User u ON u.id = e.organizer_id WHERE e.id = $idEvent');
    $event = $request->fetchAll();

    return $event;
}

function getEventStatus($idEvent) {
    $dataBase = dbConnect();
    $request = $dataBase->query('SELECT id FROM User_participates_event WHERE id_participant == $_SESSION[\'id\'] AND id_event == $idEvent');
    $event = $request->fetchAll();

    return $event;
}

function changeEvent($status) {
    $dataBase = dbConnect();

    //requete post
}