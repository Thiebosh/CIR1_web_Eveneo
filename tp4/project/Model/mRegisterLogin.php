<?php
require_once('Model/mCommon.php');

function getDataUser($login) {
    $bdd = dbConnect();

    $query = 'SELECT id, password, rank 
                FROM Users 
                WHERE login = :log';
    $table = array('log' => $login);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $dataUser = $request->fetch();
    $request->closeCursor();

    return $dataUser;
}


function getLoginUser($login) {
    $bdd = dbConnect();

    $query = 'SELECT login
                FROM Users 
                WHERE login = :log';
    $table = array('log' => $login);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $result = $request->fetch();
    $request->closeCursor();

    return $result;
}


function postDataUser($data) {
    $bdd = dbConnect();

    $query = 'INSERT INTO Users(login, password, rank) 
                VALUES(:log, :pass, :rank)';
    $table = array('log' => $data['login'],
                    'pass' => $data['password'], 
                    'rank' => $data['rank']);

    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?
}
