<?php
require('fonction.php');

$bdd = initial();

if(isset($_POST['username'])) { //si recoit un message
    insertion($bdd);
}

include('template.php');