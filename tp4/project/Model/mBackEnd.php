<?php
require_once('Model/mCommon.php');


function oGetEventsMonth($dataDate) {
    $bdd = dbConnect();
    
    for ($day = 1; $day <= $dataDate['nbDays']; $day++) {
        $fullDate = date('Y-m-d', gmmktime(0, 0, 0, $dataDate['month'], $day, $dataDate['year']));

        $query = 'SELECT id, name, startdate 
                FROM events
                WHERE DATEDIFF(startdate, :date) = 0 AND organizer_id = :orga
                ORDER BY startdate LIMIT 0, ' . (MAX_LIST + 1);
        $table = array('date' => $fullDate, 'orga' => $_SESSION['id']);

        $request = $bdd->prepare($query);
        $request->execute($table);
        $dataMonth[$day] = $request->fetchAll();
    }

    return $dataMonth;
}


function oGetEventsDay($day) {
    $bdd = dbConnect();

    $query = 'SELECT id, name, startdate AS startTime, enddate AS endTime, nb_place AS place
                FROM events
                WHERE DATEDIFF(:date, startdate) = 0 AND organizer_id = :orga
                ORDER BY startdate';
    $table = array('date' => $day, 'orga' => $_SESSION['id']);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $dataDay = $request->fetchAll();

    return $dataDay;
}


function oGetEvent($idEvent) {
    $bdd = dbConnect();

    $query = 'SELECT name, description, startdate, enddate, nb_place AS place
                FROM events
                WHERE id = :event';
    $table = array('event' => $idEvent);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $dataEvent = $request->fetch();
    $request->closeCursor();

    return $dataEvent;
}


function oPostDataAndGetIdEvent($data) {
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
    $request->execute($table);//retourne quelque chose?

    $query = 'SELECT id
                FROM events
                WHERE name  = :title AND startdate = :startDate AND enddate = :endDate';
    $table = array('title' => $data['name'],
                    'startDate' => $data['startDate'],
                    'endDate' => $data['endDate']);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $data = $request->fetch();
    $request->closeCursor();

    return $data['id'];
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