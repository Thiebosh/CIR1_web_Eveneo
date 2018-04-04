<?php
session_start();
include('csv_management.php');
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = sha1(time());
}
$csrf = $_SESSION['csrf'];
$products = findData('save.csv');
include('liste_produit.html');
