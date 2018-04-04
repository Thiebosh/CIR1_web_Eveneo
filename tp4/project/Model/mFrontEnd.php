<?php
require_once('Model/mCommon.php');

function cGetEventsDay($dateFull, $limited) {
    $bdd = dbConnect();
    
    if (!$limited) {
        $query = 'SELECT id, name
                FROM events 
                WHERE DATEDIFF(:date, startdate) = 0 AND nb_place > 0
                ORDER BY startdate';
    }
    else {
        //$lim = 'LIMIT 0, '.(MAX_LIST + 1);//fonctionne?
        //$lim = 'LIMIT 0, 6';//si plus de 5, affiche le bouton
        $query = 'SELECT id, name
                    FROM events 
                    WHERE DATEDIFF(:date, startdate) = 0 AND nb_place > 0
                    ORDER BY startdate
                    LIMIT 0, 6';
    }
    $table = array('date' => $dateFull);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $listEvent = $request->fetchAll();

    return $listEvent;
}


function cGetEvent($idEvent) {
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

function cGetEventStatus($idvent) {
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
                VALUES(:id, :user)';
    $table = array('id' => $idEvent,
                    'user' => $_SESSION['id']);

    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?
}


function cDeleteStatusEvent($idEvent) {
    $bdd = dbConnect();
    
    $query = 'DELETE FROM user_participates_events
                WHERE id_event = :idEvent AND id_participant = :idUser';
    $table = array('idEvent' => $idEvent, 
                    'idUser' => $_SESSION['id']);

    $request = $bdd->prepare($query);
    $request->execute($table);
}
