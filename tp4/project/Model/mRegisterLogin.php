<?php

require('Model/mCommon.php');

function getDataUser($login) {//ok
    $bdd = dbConnect();

    $query = "SELECT id, `password`, rank FROM Users WHERE `login` = `:login`";
    $table = array('login' => $login);

    $request = $bdd->prepare($query);
    $request->execute($table);
    $dataUser = $request->fetch();
    $request->closeCursor;//verifier

    return $dataUser;
}



function postDataUser($dataBDD) {
    $bdd = dbConnect();

    $query = "INSERT INTO Users(`login`, `password`, rank) VALUES(`:login`, `:password`, :rank)";
    $table = array('login' => $dataBDD['login'], 'password' => $dataBDD['password'], 'rank' => $dataBDD['rank']);

    $request = $bdd->prepare($query);
    $request->execute($table);//retourne quelque chose?
}
