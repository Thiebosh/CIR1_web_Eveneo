<?php
require('Model/mCommon.php');

function getEventsDay($dateFull, $limited) {
    $bdd = dbConnect();

    $lim = '';//default
    if ($limited) {
        $lim = 'LIMIT 0, '.(MAX_LIST + 1);//si plus de 5, affiche le bouton //fonctionne?
    }
    $query = 'SELECT id, `name` 
                FROM events 
                WHERE DATEDIFF(`:date`, startdate) == 0 AND nb_place > 0
                ORDER BY startdate
                :lim';
    $table = array('date' => $dateFull, 
                    'lim' => $lim);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $listEvent = $request->fetchAll();

    return $listEvent;
}


function getEvent($idEvent) {
    $bdd = dbConnect();

    $query = 'SELECT *
                FROM events e INNER JOIN User u ON e.organizer_id = u.id
                WHERE e.id = :id';
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

function getEventStatus($idvent) {
    $bdd = dbConnect();
    
    $query = 'SELECT iduser_participates_events
                FROM user_participates_events
                WHERE id_event = :idEvent AND id_participant = :idUser';
    $table = array('idEvent' => $idEvent, 
                    'idUser' => $_SESSION['id']);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $status = $request->fetch();
    $request->closeCursor();

    return $status;
}


function postStatusEvent($idEvent) {
    $bdd = dbConnect();

    $query = 'INSERT INTO user_participates_events(id_event, id_participant) 
                VALUES(`:id`, :user)';
    $table = array('id' => $idEvent,
                    'user' => $_SESSION['id']);

    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?
}


function deleteStatusEvent($idEvent) {
    $bdd = dbConnect();
    
    $query = 'DELETE FROM user_participates_events
                WHERE id_event = :idEvent AND id_participant = :idUser';
    $table = array('idEvent' => $idEvent, 
                    'idUser' => $_SESSION['id']);

    $request = $bdd->prepare($query);
    $request->execute($table);
}
