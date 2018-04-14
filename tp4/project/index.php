<?php
session_start();

require('globalFunctions.php');
require('Controller/cCommon.php');

try {
    $action = verifAction();
    
    if (!isset($_SESSION['rank'])) {
        switch ($action) {
            case 'login':    externLogin(   verifScript('script_login'));
            break;
            case 'register': externRegister(verifScript('script_register'));
            break;
        }
    }
    
    switch ($action) {
        case 'reception': EventsMonth(verifDateTime($_GET['date'], "Evénements du mois"));
            break;
        case 'list':      EventsDay(  verifDateTime($_GET['date'], "Evénements du jour"));
            break;
        case 'detail':    EventDetail(verifID($_GET['id'], "Evénement"));
            break;
        case 'new':
            $received = verifScript('script_new');
            $received['date'] = verifDateTime($_GET['date'], "Nouvel événement");
            
            backEventNew($received);
        break;
        case 'edit':
            $received = verifScript('script_edit');
            $received['id'] = verifID($_GET['id'], "Modification d'événement");

            backEventEdit($received);
        break;
    }
}
catch(Exception $error) {//rediriger vers la page en affichant un bloc erreur
    $errorMessage = $error->getMessage();
    $errorDetail = $error->getFile() . ', ligne ' . $error->getLine();
    $redirection['text'] = 'l\'accueil';
    $redirection['link'] = 'reception';
    if (!isset($_SESSION['rank'])) {
        $redirection['text'] = 'l\'écran de  connexion';
        $redirection['link'] = 'login';
    }
    
    require('View/vError(provisoire).php');
}
