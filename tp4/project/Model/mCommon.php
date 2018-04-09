<?php
define('MAX_LIST', 5);

function dbConnect() {
    $errMsg = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $dbName = 'eventCalendar';
    $dbUser = 'root';
    $dbPass = '1a9z9e8r';
    
    $dataBase = new PDO('mysql:host=localhost;dbname='.$dbName.';charset=utf8', $dbUser, $dbPass, $errMsg);
    if (!$dataBase) throw new Exception("Base De Données : Echec de connexion");

    return $dataBase;
}

function getEventStatus($idEvent) {//valeur ou false
    $bdd = dbConnect();

    $query = 'SELECT iduser_participates_events
            FROM user_participates_events
            WHERE id_event = :event AND id_participant = :user';
    $table = array('event' => $idEvent, 'user' => $_SESSION['id']);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $table = $request->fetch();
    $request->closeCursor();

    return $table['iduser_participates_events'];
}