<?php
require_once('Model/mCommon.php');

function externGetDataUser($login) {
    $bdd = dbConnect();

    $query = 'SELECT id, password, rank 
                FROM Users 
                WHERE login = :log';
    $table = array('log' => $login);

    $request = $bdd->prepare($query);
    if (!$request->execute($table)) throw new Exception("Base De Données : Echec d'exécution");
    $dataUser = $request->fetch();
    $request->closeCursor();

    return $dataUser;
}

function externGetLoginUser($login) {
    $bdd = dbConnect();

    $query = 'SELECT login
                FROM Users 
                WHERE login = :log';
    $table = array('log' => $login);

    $request = $bdd->prepare($query);
    if (!$request->execute($table)) throw new Exception("Base De Données : Echec d'exécution");
    $result = $request->fetch();
    $request->closeCursor();

    return $result;
}

function externPostDataUser($data) {
    $bdd = dbConnect();

    $query = 'INSERT INTO Users(login, password, rank) 
                VALUES(:log, :pass, :rank)';
    $table = array('log' => $data['login'],
                    'pass' => $data['password'], 
                    'rank' => $data['rank']);

    $request = $bdd->prepare($query);
    if (!$request->execute($table)) throw new Exception("Base De Données : Echec d'exécution");
}
