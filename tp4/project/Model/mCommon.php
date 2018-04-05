<?php
define('MAX_LIST', 5);

function dbConnect() {
    $errMsg = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $dbName = 'eventCalendar';
    $dbUser = 'root';
    $dbPass = 'NOPE';
    
    $dataBase = new PDO('mysql:host=localhost;dbname='.$dbName.';charset=utf8', $dbUser, $dbPass, $errMsg);
    if (!$dataBase) throw new Exception('Base De Données : Echec de connexion');

    return $dataBase;
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