<?php

function dbConnect() {//modifier champs
    $errMsg = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $dbName = 'eventCalendar';
    $dbPass = 'root';
    
    $dataBase = new PDO('mysql:host=localhost;dbname=$dbName;charset=utf8', $dbPass, '', $errMsg);
    if (!$dataBase) throw new Exception('Base De Données : Echec de connexion');

    return $dataBase;
}
