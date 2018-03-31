<?php
require('Model/mCommon.php');

function getEventsDay($dateFull, $limited) {
    $bdd = dbConnect();

    $lim = '';//default
    if ($limited) {
        $lim = 'LIMIT 0, '.(MAX_LIST + 1);//si plus de 5, affiche le bouton //fonctionne?
    }
    $query = 'SELECT id, `name`
                FROM events e INNER JOIN Users u ON u.id = e.organizer_id
                WHERE DATEDIFF(`:date`, startdate) == 0 AND organizer_id == :orga
                ORDER BY startdate
                :lim';
    $table = array('date' => $dateFull,
                    'orga' => $_SESSION['id'],
                    'lim' => $lim);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $listEvent = $request->fetchAll();

    return $listEvent;
}


function getEvent($idEvent) {
    $bdd = dbConnect();

    $query = 'SELECT `name`, `description`, startdate, enddate, nb_place
                FROM events
                WHERE id = :id';
    $table = array('id' => $idEvent);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $dataEvent = $request->fetch();
    $request->closeCursor();

    return $dataEvent;
}


function getOtherEventDate($date, $direction) {
    $bdd = dbConnect();

    if ($direction == 'next')      $change = ['>', ''];
    else if ($direction == 'last') $change = ['<', 'DESC'];
    else throw new Exception('Requête : appel incorrect');

    $query = 'SELECT id
                FROM events
                WHERE DATEDIFF(`:dateTime`, startdate) :sign 0
                ORDER BY startdate :dir
                LIMIT 0,1';
    $table = array('dateTime' => $date, 
                    'sign' => $change[0], 
                    'dir' => $change[1]);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $dataEvent = $request->fetch();
    $request->closeCursor();

    return $idEvent;
}


function getEventDate($idEvent) {
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


function postEventData($data) {
    $bdd = dbConnect();

    $query = 'INSERT INTO events(`name`, nb_place, startdate, enddate, `description`) 
                VALUES(:title, :nbPlaces, :startDate, :endDate, :describe)';
    $table = array('title' => $data['name'],
                    'nbPlaces' => $data['nbPlaces'],
                    'startDate' => $data['startDate'],
                    'endDate' => $data['endDate'],
                    'describe' => $data['description']);

    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?
}


function changeEventData($data) {
    $bdd = dbConnect();

    $query = 'UPDATE events
                SET `description` = :describe, enddate = :endDate, nb_place = :nbPlace
                WHERE id = :idEvent';
    $table = array('describe' => $data['description'],
                    'endDate' => $data['endDate'],
                    'nbPlace' => $data['nbPlaces'],
                    'idEvent' => $data['id']);

    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?
}


function deleteEvent($idEvent) {//combinable avec un inner_join?
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