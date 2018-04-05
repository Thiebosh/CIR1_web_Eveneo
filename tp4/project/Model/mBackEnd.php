<?php
require_once('Model/mCommon.php');

function oGetEventsDay($dateFull, $limited) {
    $bdd = dbConnect();
    $query = 'SELECT u.id, e.name  
                FROM events e INNER JOIN Users u ON u.id = e.organizer_id
                WHERE DATEDIFF(:date, startdate) = 0 AND e.organizer_id = :orga
                ORDER BY startdate';
    if ($limited) {
        
        $query .= "\nLIMIT 0, 6";
    }
    $table = array('date' => $dateFull,
                    'orga' => $_SESSION['id']);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $listEvent = $request->fetchAll();

    return $listEvent;
}


function oGetEvent($idEvent) {
    $bdd = dbConnect();

    $query = 'SELECT name, description, startdate, enddate, nb_place
                FROM events
                WHERE id = :id';
    $table = array('id' => $idEvent);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $dataEvent = $request->fetch();
    $request->closeCursor();

    return $dataEvent;
}

function oGetEventDate($idEvent) {
    $bdd = dbConnect();

    $query = 'SELECT startdate
                FROM events
                WHERE id = :id';
    $table = array('id' => $idEvent);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $dataEvent = $request->fetch();
    $request->closeCursor();

    return $dataEvent;
}


function oGetEventId($data) {
    $bdd = dbConnect();

    $query = 'SELECT id
                FROM events
                WHERE name  = :title AND startdate = :startDate AND enddate = :endDate';
    $table = array('title' => $data['name'],
                    'startDate' => $data['startDate'],
                    'endDate' => $data['endDate']);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $id = $request->fetch();
    $request->closeCursor();

    return $id;
}


function oPostEventData($data) {
    $bdd = dbConnect();

    $query = 'INSERT INTO events(name, nb_place, startdate, enddate, description) 
                VALUES(:title, :nbPlaces, :startDate, :endDate, :describe)';
    $table = array('title' => $data['name'] ,
                    'nbPlaces' => $data['nbPlaces'],
                    'startDate' => $data['startDate'],
                    'endDate' => $data['endDate'],
                    'describe' => $data['description']);

    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?

    
}


function oChangeEventData($data) {
    $bdd = dbConnect();

    $query = 'UPDATE events
                SET description  = :describe, enddate = :endDate, nb_place = :nbPlace
                WHERE id = :idEvent';
    $table = array('describe' => $data['description'],
                    'endDate' => $data['endDate'],
                    'nbPlace' => $data['nbPlaces'],
                    'idEvent' => $data['id']);

    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?
}


function oDeleteEvent($idEvent) {//combinable avec un inner_join?
    $bdd = dbConnect();
    
    $table = array('idEvent' => $idEvent);

    $query = 'DELETE FROM user_participates_events
                WHERE id_event = :idEvent';
    $request = $bdd->prepare($query);
    $request->execute($table);

    $query = 'DELETE FROM events
                WHERE id = :idEvent';
    $request = $bdd->prepare($query);
    $request->execute($table);
}