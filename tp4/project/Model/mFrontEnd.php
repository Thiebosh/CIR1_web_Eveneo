<?php

require('Model/mCommon.php');

function getEventsDay($date, $limited) {//faire jointure et comparer nb places avec nb personnes inscrites à event
    $bdd = dbConnect();

    $query = 'SELECT id, `name` FROM events WHERE DATEDIFF(`:date`, startdate) == 0 ORDER BY startdate';
    if ($limited) {
        $query = $query . 'LIMIT 0, 6';//si plus de 5, affiche le bouton
    }
    $table = array('date' => $date);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $listEvent = $request->fetchAll();

    return $listEvent;
}

function getEvent($idEvent) {//et statut
    $bdd = dbConnect();

    $query = 'SELECT e.name nameConf, e.description describeConf, e.startdate startDate, e.enddate endDate, e.nb_place places, u.login organizer
    FROM Events e INNER JOIN User u ON u.id = e.organizer_id WHERE e.id = $idEvent';
    $table = array('login' => $login);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $dataEvent = $request->fetch();
    $request->closeCursor;//verifier

    return $dataEvent;
}

function getEventStatus($idEvent) {
    $bdd = dbConnect();
    $request = $bdd->query('SELECT id FROM User_participates_event WHERE id_participant == $_SESSION[\'id\'] AND id_event == $idEvent');
    $event = $request->fetchAll();

    return $event;
}

function changeStatusEvent($status) {
    $bdd = dbConnect();

    //requete post
}