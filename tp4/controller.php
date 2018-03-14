<?php
session_start();

if (!isset($_SESSION['logged'])) {
    require('view/viewLogin.php');
    require('data/dataLogin.php');
}
else {
    if ($_SESSION['rank'] == "CUSTOMER") {
        require('view/viewCustomer.php');
        require('data/dataProcessing.php');
    }
    else {
        require('view/viewOrganizer.php');
        require('data/dataProcessing.php');
    }
}

if (isset($_POST["logged"]) && $_POST["logged"] == false) {//si user se deconnecte
    session_desroy();
}
