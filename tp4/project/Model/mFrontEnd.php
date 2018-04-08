<?php
require_once('Model/mCommon.php');


function cGetEventsMonth($dataDate) {
    $bdd = dbConnect();
    
    for ($day = 1; $day <= $dataDate['nbDays']; $day++) {
        $fullDate = date('Y-m-d', gmmktime(0, 0, 0, $dataDate['month'], $day, $dataDate['year']));

        $query = 'SELECT id, name, nb_place AS place, startdate 
                FROM events
                WHERE DATEDIFF(startdate, :date) = 0
                ORDER BY startdate LIMIT 0, ' . (MAX_LIST + 1);
        $table = array('date' => $fullDate);

        $request = $bdd->prepare($query);
        $request->execute($table);
        $dataMonth[$day] = $request->fetchAll();
    }

    return $dataMonth;
}


function cGetEventsDay($day) {
    $bdd = dbConnect();

    $query = 'SELECT e.id, e.name, e.startdate AS startTime, e.nb_place AS place, u.login AS organizer
            FROM events e INNER JOIN Users u ON e.organizer_id = u.id
            WHERE DATEDIFF(e.startdate, :date) = 0
            ORDER BY e.startdate';
    $table = array('date' => $day);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $dataDay = $request->fetchAll();

    return $dataDay;
}


function cGetEventDetail($idEvent) {
    $bdd = dbConnect();

    $query = 'SELECT e.name, e.description, e.startdate, e.enddate, e.nb_place AS place, u.login
            FROM events e INNER JOIN Users u ON e.organizer_id = u.id
            WHERE e.id = :event';
    $table = array('event' => $idEvent);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $dataEvent = $request->fetch();
    $request->closeCursor();

    return $dataEvent;
}


function cSetStatusON($idEvent) {
    $bdd = dbConnect();

    $query = 'INSERT INTO user_participates_events(id_event, id_participant) 
            VALUES(:event, :user)';
    $table = array('event' => $idEvent, 'user' => $_SESSION['id']);
    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?

    $query = 'UPDATE events
            SET nb_place = nb_place - 1
            WHERE id = :idEvent';
    $table = array('idEvent' => $idEvent);
    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?
}


function cSetStatusOFF($idEvent) {
    $bdd = dbConnect();
    
    $query = 'DELETE FROM user_participates_events
            WHERE id_event = :event AND id_participant = :user';
    $table = array('event' => $idEvent, 'user' => $_SESSION['id']);
    $request = $bdd->prepare($query);
    $request->execute($table);

    $query = 'UPDATE events
            SET nb_place = nb_place + 1
            WHERE id = :idEvent';
    $table = array('idEvent' => $idEvent);
    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?
}
