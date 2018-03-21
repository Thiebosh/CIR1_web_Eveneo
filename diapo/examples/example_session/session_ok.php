<?php
session_start();
$nbOfTries = count($_SESSION);
$_SESSION[date('d/m/Y H:i:s')] = 'We have tried ' . $nbOfTries . 'times.';
include('./ok.inc');

