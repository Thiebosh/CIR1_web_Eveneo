<?php
require('Model/mRegisterLogin.php');

function Register($dataForm) {
    if (!$dataForm['empty']) {
        $dataUser = postDataUser($dataForm);
    }
    //avancée

    require('View/RegisterLogin/vRegister.php');
}

function Login($dataForm) {
    if (!$dataForm['empty']) {
        $dataUser = getDataUser($dataForm['login']);

        if ($dataUser && password_verify($dataForm['password'], $dataUser['password'])) {//compare les hash (utile de verifier retours de dataUser?)
            $_SESSION['login'] = $dataForm['login'];
            $_SESSION['rank'] = $dataUser['rank'];
            $_SESSION['id'] = $dataUser['id'];
        }
    }
    //avancée

    require('View/RegisterLogin/vLogin.php');
}