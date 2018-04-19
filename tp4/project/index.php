<?php
session_start();

require('globalFunctions.php');
require('Controller/cCommon.php');


try {
    $action = verifAction();
    
    if (!isset($_SESSION['rank'])) {
        switch ($action) {
            case 'login':    externLogin(verifScript('login'));
            break;
            case 'register': externRegister(verifScript('register'));
            break;
        }
    }
    
    switch ($action) {
        case 'month': EventsMonth(verifDateTime($_GET['date'], 'Evénements du mois'));
            break;
        case 'day': EventsDay(verifDateTime($_GET['date'], 'Evénements du jour'));
            break;
        case 'event':
            if ($_SESSION['rank'] == 'CUSTOMER') verifScript('join');
            if ($_SESSION['rank'] == 'ORGANIZER') verifScript('delete');
            EventDetail(verifID($_GET['id'], 'Evénement'));
            break;
        case 'edit':
            $received = verifScript('edit');

            $received['date'] = $received['id'] = false;
            if (isset($_GET['date'])) $received['date'] = verifDateTime($_GET['date'], 'Nouvel événement');
            if (isset($_GET['id'])) $received['id'] = verifID($_GET['id'], 'Modification d\'événement');
            if ($received['date'] && $received['id']) throw new Exception("Edition d'événement : URL sur chargée");
            if (!$received['date'] && !$received['id']) throw new Exception("Edition d'événement : URL sous chargée");

            backEventScript($received);
        break;
    }
}
catch(Exception $error) {//resume
    $errorMessage = $error->getMessage();
    $errorDetail = $error->getFile() . ', ligne ' . $error->getLine();
    $redirection['text'] = 'l\'accueil';
    $redirection['link'] = 'month';
    if (!isset($_SESSION['rank'])) {
        $redirection['text'] = 'l\'écran de  connexion';
        $redirection['link'] = 'login';
    }
    
    require('View/vError(provisoire).php');
}
