<?php
require_once('Model/mCommon.php');

function backGetEventsMonth($dataDate) {
    $bdd = dbConnect();
    
    for ($day = 1; $day <= $dataDate['nbDays']; $day++) {
        $dateSplit = explode('-', $dataDate['dateMonth']);
        $fullDate = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $day, $dateSplit[0]));

        $query = 'SELECT id, name, startdate 
                FROM events
                WHERE DATEDIFF(startdate, :date) = 0 AND organizer_id = :orga
                ORDER BY startdate LIMIT 0, ' . (MAX_LIST + 1);
        $table = array('date' => $fullDate, 'orga' => $_SESSION['id']);

        $request = $bdd->prepare($query);
        if (!$request->execute($table)) throw new Exception("Base De Données : Echec d'exécution");
        $dataMonth[$day] = $request->fetchAll();
    }

    return $dataMonth;
}

function backGetEventsDay($day) {
    $bdd = dbConnect();

    $query = 'SELECT id, name, startdate AS startTime, enddate AS endTime, nb_place AS place
                FROM events
                WHERE DATEDIFF(:date, startdate) = 0 AND organizer_id = :orga
                ORDER BY startdate';
    $table = array('date' => $day, 'orga' => $_SESSION['id']);

    $request = $bdd->prepare($query);
    if (!$request->execute($table)) throw new Exception("Base De Données : Echec d'exécution");
    $dataDay = $request->fetchAll();

    return $dataDay;
}

function backGetEventDetail($idEvent) {
    $bdd = dbConnect();

    $query = 'SELECT id, name, description, startdate, enddate, nb_place AS place
                FROM events
                WHERE id = :event';
    $table = array('event' => $idEvent);

    $request = $bdd->prepare($query);
    if (!$request->execute($table)) throw new Exception("Base De Données : Echec d'exécution");
    $dataEvent = $request->fetch();
    $request->closeCursor();

    return $dataEvent;
}

function backPostDataAndGetIdEvent($data) {
    $bdd = dbConnect();

    $query = 'INSERT INTO events(name, organizer_id, nb_place, startdate, enddate, description) 
                VALUES(:title, :orga, :nbPlaces, :startDate, :endDate, :describe)';
    $table = array('title' => $data['name'] ,
                    'orga' => $_SESSION['id'],
                    'nbPlaces' => $data['nbPlaces'],
                    'startDate' => $data['startDate'],
                    'endDate' => $data['endDate'],
                    'describe' => $data['description']);

    $request = $bdd->prepare($query);
    if (!$request->execute($table)) throw new Exception("Base De Données : Echec d'exécution");

    
    $query = 'SELECT id
                FROM events
                WHERE name  = :title AND startdate = :startDate AND enddate = :endDate';
    $table = array('title' => $data['name'],
                    'startDate' => $data['startDate'],
                    'endDate' => $data['endDate']);

    $request = $bdd->prepare($query);
    if (!$request->execute($table)) throw new Exception("Base De Données : Echec d'exécution");
    $data = $request->fetch();
    $request->closeCursor();

    return $data['id'];
}

function backChangeEventData($data) {
    $bdd = dbConnect();

    $query = 'UPDATE events
                SET name = :title, description  = :describe, enddate = :endDate, nb_place = :nbPlace
                WHERE id = :idEvent';
    $table = array('title' => $data['name'],
                    'describe' => $data['description'],
                    'endDate' => $data['endDate'],
                    'nbPlace' => $data['nbPlaces'],
                    'idEvent' => $data['id']);

    $request = $bdd->prepare($query);
    if (!$request->execute($table)) throw new Exception("Base De Données : Echec d'exécution");
}

function backDeleteEvent($idEvent) {
    $bdd = dbConnect();
    
    $table = array('idEvent' => $idEvent);

    $query = 'DELETE FROM user_participates_events
                WHERE id_event = :idEvent';
    $request = $bdd->prepare($query);
    if (!$request->execute($table)) throw new Exception("Base De Données : Echec d'exécution");

    $query = 'DELETE FROM events
                WHERE id = :idEvent';
    $request = $bdd->prepare($query);
    if (!$request->execute($table)) throw new Exception("Base De Données : Echec d'exécution");
}
