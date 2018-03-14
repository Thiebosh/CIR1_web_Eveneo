<?php
session_start();

if (!isset($_SESSION['logged'])) {
    require('view/viewLogin.php');
    require('data/dataLogin.php');
}
else {
    require('view/viewCalendar.php');
    require('data/dataProcessing.php');
}

if (isset($_POST["logged"]) && $_POST["logged"] == false) {//si user se deconnecte
    session_desroy();
}
