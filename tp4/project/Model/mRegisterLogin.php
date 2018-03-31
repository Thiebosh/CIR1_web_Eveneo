<?php
require('Model/mCommon.php');

function getDataUser($login) {
    $bdd = dbConnect();

    $query = 'SELECT id, `password`, rank 
                FROM Users 
                WHERE `login` = `:login`';
    $table = array('login' => $login);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $dataUser = $request->fetch();
    $request->closeCursor();

    return $dataUser;
}


function getLoginUser($login) {
    $bdd = dbConnect();

    $query = 'SELECT `login`
                FROM Users 
                WHERE `login` = `:login`';
    $table = array('login' => $login);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $result = $request->fetch();
    $request->closeCursor();

    return $result;
}


function postDataUser($data) {
    $bdd = dbConnect();

    $query = 'INSERT INTO Users(`login`, `password`, rank) 
                VALUES(`:login`, `:password`, :rank)';
    $table = array('login' => $data['login'],
                    'password' => $data['password'], 
                    'rank' => $data['rank']);

    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?
}
