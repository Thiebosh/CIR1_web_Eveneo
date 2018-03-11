<?php

require('model.php');
require('view_helpers.php');
$ini_array = parse_ini_file("secrets.ini", true);
$bdd = connectToDb($ini_array);
if (isset($_POST['message'], $_POST['pseudo']) && 
        filter_input(INPUT_POST, 'pseudo', FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/[\w ]{0, 55}']])) {
    $message = filter_input(INPUT_POST, 'message');
    if (strpos('/moderate') === 0) {
        $exploded = explode(' ', $message);
        if (count($exploded) == 2) {
            moderatePseudo($bdd, $exploded[1]);
        }
    } else {
        insertMessage($bdd, filter_input(INPUT_POST, 'pseudo'), $message);
    }
}
$currentPage = isset($_GET['page']) ? int($_GET['page']) : 1;
if ($currentPage <= 0) {
    $currentPage = 1;
}
$nbPages = getNbPages($bdd, $ini_array['pages']['nb_per_page']);
$message = getPageOfMessages($bdd, $ini_array['pages']['nb_per_page'], $currentPage);
include('layoyt.html');
