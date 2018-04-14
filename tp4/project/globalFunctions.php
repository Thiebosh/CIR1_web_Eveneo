<?php
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

function verifAction() {
    if (!isset($_GET['action'])) {
        if (!isset($_SESSION['rank'])) $action = 'login';
        else $action = 'reception';
    }
    else {
        $action = $_GET['action'];

        if ($action != 'login' && $action != 'logout' && $action != 'register' &&
        $action != 'reception' && $action != 'list'   && $action != 'detail' &&
        $action != 'delete'    && $action != 'new'    && $action != 'edit') {
            throw new Exception("Page indéfinie");
        }
        if (($action == 'new' || $action == 'edit') && $_SESSION['rank'] == 'CUSTOMER') {
            throw new Exception("Redirection : page invalide");
        }
    }

    if ($action == 'logout') {
        $_SESSION = array();//nettoie la variable
        header('Location: index.php?action=login');//redirige vers la page de connexion
        exit();//mets fin au script courant
    }

    if ($action == 'reception' && !isset($_GET['date'])) $_GET['date'] = date('Y-m');
    
    switch ($action) {
        case 'reception': if (count(explode('-', $_GET['date'])) != 2) throw new Exception("Evénements du mois : date invalide");
            break;
        case 'list': if (count(explode('-', $_GET['date'])) != 3) throw new Exception("Evénements du jour : date invalide");
            break;
        case 'new': if (count(explode('-', $_GET['date'])) != 3) throw new Exception("Evénement : date invalide");
            break;
    }

    return $action;
}

function isPreviousDate($reference, $compared) {//strictement superieur
    $splitReference = explode(' ', $reference);
    $dateReference = explode('-', $splitReference[0]);//Y-m-d
    if (isset($splitReference[1])) $timeReference = explode('-', $splitReference[1]);//h-m

    $splitCompared = explode(' ', $compared);
    $dateCompared = explode('-', $splitCompared[0]);//Y-m-d
    if (isset($splitCompared[1])) $timeCompared = explode('-', $splitCompared[1]);//h-m

    if ($dateReference[0] < $dateCompared[0]) return true;
    else if ($dateReference[0] == $dateCompared[0]) {

        if ($dateReference[1] < $dateCompared[1]) return true;
        else if ($dateReference[1] == $dateCompared[1]) {

            if ($dateReference[2] < $dateCompared[2]) return true;
            else if ($dateReference[2] == $dateCompared[2]) {

                if (isset($timeReference[0]) && isset($timeCompared[0])) {
                    if ($timeReference[0] < $timeCompared[0]) return true;
                    else if ($timeReference[0] == $timeCompared[0]) {
                    
                        if (isset($timeReference[1]) && isset($timeCompared[1])) {
                            if ($timeReference[1] < $timeCompared[1]) return true;
                            else return false;
                        }

                    }
                    else return false;
                }

            }
            else return false;

        }
        else return false;

    }
    else return false;
}

function verifScript($script) {
    if (!isset($_POST[$script])) return false;

    switch ($script) {
        case 'script_login':
            if (!isset($_POST['login']) || !isset($_POST['password'])) {
                throw new Exception("Connexion : Données formulaire incomplètes");
            }

            $received['login'] = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
            $received['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            if (!$received['login'] || !$received['password']) {
                throw new Exception("Connexion : Donnée(s) formulaire invalide(s)");
            }
            
            break;
        case 'script_register':
            if (!isset($_POST['login']) || !isset($_POST['rank']) || !isset($_POST['password']) || !isset($_POST['passwordVerif'])) {
                throw new Exception("Inscription : Données formulaire incomplètes");
            }

            $received['rank']          = filter_input(INPUT_POST, 'rank',          FILTER_SANITIZE_STRING);
            $received['login']         = filter_input(INPUT_POST, 'login',         FILTER_SANITIZE_STRING);
            $received['password']      = filter_input(INPUT_POST, 'password',      FILTER_SANITIZE_STRING);
            $received['passwordVerif'] = filter_input(INPUT_POST, 'passwordVerif', FILTER_SANITIZE_STRING);

            if (!$received['login'] || !$received['rank'] || !$received['login'] || !$received['password'] || !$received['passwordVerif']) {
                throw new Exception("Inscription : Donnée(s) formulaire invalide(s)");
            }
            break;
        case 'script_new':
            if (!isset($_POST['name']) || !isset($_POST['nbPlaces']) || !isset($_POST['description']) || !isset($_POST['startDate']) || !isset($_POST['endDate'])) {
                throw new Exception("Nouvel événement : Donnée(s) formulaire absente(s)");
            }

            $received['name']        = filter_input(INPUT_POST, 'name',        FILTER_SANITIZE_STRING);
            $received['nbPlaces']    = filter_input(INPUT_POST, 'nbPlaces',    FILTER_VALIDATE_INT);
            $received['startDate']   = filter_input(INPUT_POST, 'startDate',   FILTER_SANITIZE_STRING);
            $received['endDate']     = filter_input(INPUT_POST, 'endDate',     FILTER_SANITIZE_STRING);
            $received['description'] = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

            if (!$received['name'])              $received['echec'][] = 'nom';
            if ($received['nbPlaces'] === false) $received['echec'][] = 'nombre de places';
            if (!$received['description'])       $received['echec'][] = 'description';
            if (!$received['startDate'])         $received['echec'][] = 'date de début';
            if (!$received['endDate'])           $received['echec'][] = 'date de fin';
            if (!isPreviousDate($received['startDate'], $received['endDate'])) {
                $received['echec'][] = 'durée nulle ou négative';
            }
            if (!isPreviousDate(date('Y-m-d H-i'), $received['startDate'])) {
                $received['echec'][] = 'date de début passée';
            }
            break;
        case 'script_edit':
            if (!isset($_POST['name']) || !isset($_POST['nbPlaces']) || !isset($_POST['description']) || !isset($_POST['startDate']) || !isset($_POST['endDate'])) {
                throw new Exception("Modification d'événement : Donnée(s) formulaire absente(s)");
            }

            $received['name']        = filter_input(INPUT_POST, 'name',        FILTER_SANITIZE_STRING);
            $received['nbPlaces']    = filter_input(INPUT_POST, 'nbPlaces',    FILTER_VALIDATE_INT);
            $hidden['startDate']     = filter_input(INPUT_POST, 'startDate',   FILTER_SANITIZE_STRING);
            $received['endDate']     = filter_input(INPUT_POST, 'endDate',     FILTER_SANITIZE_STRING);
            $received['description'] = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

            if (!$received['name'])               $received['echec'][] = 'nom';
            if ($received['nbPlaces'] === false) $received['echec'][] = 'nombre de places';
            if (!$received['description'])       $received['echec'][] = 'description';
            if (!$received['endDate'])           $received['echec'][] = 'date de fin';
            if (!isPreviousDate($received['startDate'], $received['endDate'])) {
                $received['echec'][] = 'durée nulle ou négative';
            }
            break;
    }

    if (isset($received['echec'])) $_POST[$script] = false;

    return $received;
}
