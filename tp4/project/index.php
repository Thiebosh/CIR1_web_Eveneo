<?php
//affichage des datetimes en francais
setlocale(LC_TIME, "fr_FR", "French");
date_default_timezone_set('UTC');

session_start();

require('Controller/cRegisterLogin.php');
require('Controller/cFrontEnd.php');
require('Controller/cBackEnd.php');


function checktime($hour, $min) {
    if ($hour < 0 || $hour > 23 || !is_numeric($hour)) return false;
    if ($min < 0 || $min > 59 || !is_numeric($min)) return false;
    return true;
}

function verifDateTime($date, $page) {
    if (!isset($date)) throw new Exception($page." : Donnée manquante");
    
    $date = filter_var($date, FILTER_SANITIZE_STRING);
    if (!$date) throw new Exception($page." : Donnée invalide");

    $dateSplit = explode('-', $date);
    $nbPart = 0;
    foreach($dateSplit as $partDate) {
        if (!is_numeric($partDate)) throw new Exception($page." : Date invalide");
        $nbPart++;
    }
    if ($nbPart != 2 && $nbPart != 3 && $nbPart != 5) throw new Exception($page." : Date invalide");
    
    if ($nbPart < 5) $dateSplit[3] = $dateSplit[4] = 1;
    if ($nbPart < 3) $dateSplit [2] = 1;
    if (!checkdate($dateSplit[1], $dateSplit[2], $dateSplit[0]) || !checktime($dateSplit[3], $dateSplit[4])) {
        throw new Exception($page." : Date invalide");
    }

    return $date;
}

function verifID($id, $page) {
    if (!isset($id)) throw new Exception($page." : Donnée manquante");
    if (!is_numeric($id)) throw new Exception($page." : Donnée invalide");
    return $id;
}


try {
    if (!isset($_GET['action'])) {
        if (!isset($_SESSION['rank'])) $action = 'login';
        else $action = 'reception';
    }
    else $action = $_GET['action'];

    if ($action != 'login' && $action != 'logout' && $action != 'register' &&
    $action != 'reception' && $action != 'list'   && $action != 'detail' &&
    $action != 'delete'    && $action != 'new'    && $action != 'edit') {
        throw new Exception("Page indéfinie");
    }
    
    /* BEGINNING */
    if ($action == 'logout') {
        $_SESSION = array();//nettoie la variable
        header('Location: index.php?action=login');//redirige vers la page de connexion
        exit();//mets fin au script courant
    }

    if ($action == 'reception' && !isset($_GET['date'])) $_GET['date'] = date('Y-m');    

    if (!isset($_SESSION['rank'])) {
        switch ($action) {
            case 'login':
                $received = false;
                if (isset($_POST['script_login'])) {
                    if (!isset($_POST['login']) || !isset($_POST['password'])) throw new Exception("Connexion : Données formulaire incomplètes");

                    $received['login'] = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
                    $received['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

                    if (!$received['login'] || !$received['password']) throw new Exception("Connexion : Donnée(s) formulaire invalide(s)");
                }

                aLogin($received);
            break;

            case 'register':
                $received = false;
                if (isset($_POST['script_register'])) {
                    if (!isset($_POST['login']) || !isset($_POST['rank']) || !isset($_POST['password']) || !isset($_POST['passwordVerif'])) {
                        throw new Exception("Inscription : Données formulaire incomplètes");
                    }

                    $received['rank'] = filter_input(INPUT_POST, 'rank', FILTER_SANITIZE_STRING);
                    $received['login'] = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
                    $received['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                    $received['passwordVerif'] = filter_input(INPUT_POST, 'passwordVerif', FILTER_SANITIZE_STRING);

                    if (!$received['login'] || !$received['rank'] || !$received['login'] || !$received['password'] || !$received['passwordVerif']) {
                        throw new Exception("Inscription : Donnée(s) formulaire invalide(s)");
                    }
                }

                aRegister($received);
            break;
        }
    }
    else if ($_SESSION['rank'] == 'CUSTOMER') {
        switch ($action) {
            case 'reception': cEventsMonth(verifDateTime($_GET['date'], "Evénements du mois"));
                break;
            case 'list':      cEventsDay(verifDateTime($_GET['date'], "Evénements du jour"));
                break;
            case 'detail':    cEvent(verifID($_GET['id'], "Evénement"));
                break;
        }
    }
    else if ($_SESSION['rank'] == 'ORGANIZER') {
        switch ($action) {
            case 'reception': oEventsMonth(verifDateTime($_GET['date'], "Evénements du mois"));
                break;
            case 'list':      oEventsDay(verifDateTime($_GET['date'], "Evénements du jour"));
                break;
            case 'detail':    oEvent(verifID($_GET['id'], "Evénement"));
                break;
            case 'new':
                $received['date'] = verifDateTime($_GET['date'], "Nouvel événement");

                if (isset($_POST['script_new'])) {
                    if (!isset($_POST['name']) || !isset($_POST['nbPlaces']) || !isset($_POST['description']) ||
                    !isset($_POST['startDate']) || !isset($_POST['endDate'])) {
                        throw new Exception("Nouvel événement : Donnée(s) formulaire absente(s)");
                    }

                    $received['name']        = filter_input(INPUT_POST, 'name',        FILTER_SANITIZE_STRING);
                    $received['nbPlaces']    = filter_input(INPUT_POST, 'nbPlaces',    FILTER_VALIDATE_INT);
                    $received['startDate']   = filter_input(INPUT_POST, 'startDate',   FILTER_SANITIZE_STRING);
                    $received['endDate']     = filter_input(INPUT_POST, 'endDate',     FILTER_SANITIZE_STRING);
                    $received['description'] = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

                    if (!$received['name'])        $received['echec'][] = 'name';
                    if (!$received['nbPlaces'])    $received['echec'][] = 'nbPlaces';
                    if (!$received['description']) $received['echec'][] = 'description';
                    if (!$received['startDate'])   $received['echec'][] = 'startDate';
                    if (!$received['endDate'])     $received['echec'][] = 'endDate';

                    if (isset($received['echec'])) $_POST['script_new'] = false;
                }

                oEventNew($received);
            break;
            case 'edit':
                $received['id'] = verifID($_GET['id'], "Modification d'événement");

                if (isset($_POST['script_edit'])) {
                    if (!isset($_POST['nbPlaces']) || !isset($_POST['description']) || !isset($_POST['endDate'])) {
                        throw new Exception("Modification d'événement : Donnée(s) formulaire absente(s)");
                    }

                    $received['nbPlaces']    = filter_input(INPUT_POST, 'nbPlaces',    FILTER_VALIDATE_INT);
                    $received['endDate']     = filter_input(INPUT_POST, 'endDate',     FILTER_SANITIZE_STRING);
                    $received['description'] = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

                    if (!$received['nbPlaces'])    $received['echec'][] = 'nbPlaces';
                    if (!$received['endDate'])     $received['echec'][] = 'endDate';
                    if (!$received['description']) $received['echec'][] = 'description';

                    if (isset($received['echec'])) $_POST['script_edit'] = false;
                }

                oEventEdit($received);
            break;
        }
    }
    else throw new Exception("Rang : problème de définition");
}

catch(Exception $error) {//rediriger vers la page en affichant par dessus un bloc erreur, qu'on peut "fermer" en appuyant sur un bouton (a faire)
    $errorMessage = $error->getMessage();
    $errorDetail = $error->getFile() . ', ligne ' . $error->getLine();
    $redirection['text'] = 'l\'accueil';
    $redirection['link'] = 'reception';
    if (!isset($_SESSION['rank'])) {
        $redirection['text'] = 'l\'écran de  connexion';
        $redirection['link'] = 'login';
    }
    
    require('View/vError.php');
}
