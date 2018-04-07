<?php
require_once('Model/mCommon.php');

function cGetEventsDay($date, $limited) {
    $bdd = dbConnect();
    $query = 'SELECT id, name, startdate, nb_place
                FROM events
                WHERE DATEDIFF(:date, startdate) = 0
                ORDER BY startdate';
    if ($limited) {
        $query .= ' LIMIT 0, '.(MAX_LIST + 1);
    }
    $table = array('date' => $date);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $listEvent = $request->fetchAll();

    return $listEvent;
}


function cGetEvent($idEvent) {
    $bdd = dbConnect();

    $query = 'SELECT e.name, e.description, e.startdate, e.enddate, e.nb_place, u.login
                FROM events e INNER JOIN Users u ON e.organizer_id = u.id
                WHERE e.id = :idEvent';
    $table = array('idEvent' => $idEvent);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $dataEvent = $request->fetch();
    $request->closeCursor();

    return $dataEvent;
}

function cGetEventStatus($idEvent) {
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


function cPostStatusEvent($idEvent) {
    $bdd = dbConnect();

    $query = 'INSERT INTO user_participates_events(id_event, id_participant) 
                VALUES(:event, :user)';
    $table = array('event' => $idEvent,
                    'user' => $_SESSION['id']);

    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?


    $query = 'UPDATE events
                SET nb_place = nb_place - 1
                WHERE id = :idEvent';
    $table = array('idEvent' => $idEvent);

    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?
}


function cDeleteStatusEvent($idEvent) {
    $bdd = dbConnect();
    
    $query = 'DELETE FROM user_participates_events
                WHERE id_event = :event AND id_participant = :user';
    $table = array('event' => $idEvent, 
                    'user' => $_SESSION['id']);

    $request = $bdd->prepare($query);
    $request->execute($table);


    $query = 'UPDATE events
                SET nb_place = nb_place + 1
                WHERE id = :idEvent';
    $table = array('idEvent' => $idEvent);

    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?
}
