<?php
session_start();
// this is the only part I did not explained in class
if(!isset($_SESSION['csrf'], $_POST['csrf']) || $_POST['csrf'] != $_SESSION['csrf']) {
    $_SESSION['csrf'] = sha1(time());
    header('Location: ./liste_produit.php');
    exit();
}
require('csv_management.php');
$data = findData('save.csv');

if(canSell(filter_input(INPUT_POST, 'name'), $data)) {

    $data = sellProduct(filter_input(INPUT_POST, 'name'), $data);

    replaceData($data, 'save.csv');
}

header('Location: ./liste_produit.php');
exit();
