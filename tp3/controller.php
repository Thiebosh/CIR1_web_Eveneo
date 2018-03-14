<?php

require('model.php');
require('view_helpers.php');
$ini_array = parse_ini_file("secrets.ini", true);
$bdd = connectToDb($ini_array);
if (isset($_POST['message'], $_POST['pseudo']) && 
        filter_input(INPUT_POST, 'pseudo', FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^.{1,55}$/']])) {
    $message = filter_input(INPUT_POST, 'message');
    if (strpos($message, '/ban') === 0) {
        $exploded = explode(' ', $message);
        if (count($exploded) > 2) {
            moderatePseudo($bdd, $exploded[1], 'Message censuré par la modération parce que: ' . implode(' ', array_slice($exploded, 2)));
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
$messagesList = getPageOfMessages($bdd, $ini_array['pages']['nb_per_page'], $currentPage);
include('layout.html');
