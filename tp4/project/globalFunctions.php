<?php
function checktime($hour, $min) {
    if ($hour < 0 || $hour > 23 || !is_numeric($hour)) return false;
    if ($min < 0 || $min > 59 || !is_numeric($min)) return false;
    return true;
}

function verifDateTime($date, $page) {
    if (!isset($date)) throw new Exception($page." : Donnée manquante");
    $timeSplit = explode(' ', filter_var($date, FILTER_SANITIZE_STRING));

    $nbDate = 0;
    if (isset($timeSplit[0])) {
        $dateSplit = explode('-', $timeSplit[0]);
        foreach($dateSplit as $partDate) {
            if (!is_numeric($partDate)) throw new Exception($page." : Date invalide");
            $nbDate++;
        }
    }
    if ($nbDate != 2 && $nbDate != 3) throw new Exception($page." : Date invalide");
    if ($nbDate == 3 && $dateSplit[2] < 10) $dateSplit[2] = '0'.(int)$dateSplit[2];
    if ($nbDate == 2) $dateSplit[2] = '01';

    $nbTime = 0;
    if (isset($timeSplit[1])) {
        $timeSplit = explode(':', $timeSplit[1]);
        foreach($timeSplit as $partTime) {
            if (!is_numeric($partDate)) throw new Exception($page." : Heure invalide");
            $nbTime++;
        }
    }
    if ($nbTime != 0 && $nbTime != 2) throw new Exception($page." : Heure invalide");
    if ($nbTime == 0) $timeSplit[0] = $timeSplit[1] = '01';

    if (!checkdate($dateSplit[1], $dateSplit[2], $dateSplit[0]) || !checktime($timeSplit[0], $timeSplit[1])) {
        throw new Exception($page." : Date invalide");
    }

    return $dateSplit[0].'-'.$dateSplit[1].'-'.$dateSplit[2].' '.$timeSplit[0].':'.$timeSplit[1];;
}

function verifID($id, $page) {
    if (!isset($id)) throw new Exception($page." : Donnée manquante");
    if (!is_numeric($id)) throw new Exception($page." : Donnée invalide");
    return $id;
}

function verifAction() {
    if (!isset($_GET['action'])) {
        if (!isset($_SESSION['rank'])) $action = 'login';
        else $action = 'month';
    }
    else {
        $action = $_GET['action'];

        if ($action != 'login' && $action != 'logout' && $action != 'register' &&
        $action != 'month' && $action != 'day' && $action != 'event' && $action != 'edit') {
            throw new Exception("Page indéfinie");
        }
        if ($action == 'edit' && $_SESSION['rank'] == 'CUSTOMER') throw new Exception("Redirection : page invalide");
    }

    if ($action == 'logout') {
        $_SESSION = array();//cleans the variable
        header('Location: index.php?action=login');//redirects to login page
        exit();
    }

    if ($action == 'month' && !isset($_GET['date'])) $_GET['date'] = date('Y-m');
    switch ($action) {
        case 'month': if (count(explode('-', $_GET['date'])) != 2) throw new Exception("Evénements du mois : date invalide");
            break;
        case 'day': if (count(explode('-', $_GET['date'])) != 3) throw new Exception("Evénements du jour : date invalide");
            break;
    }

    return $action;
}

function isPreviousDate($reference, $compared) {//strictly superior
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

function verifScript($scriptWanted) {
    if (!isset($_POST['script']) || $_POST['script'] != $scriptWanted) {//return $_POST['script'] = false; ->tester
        $_POST['script'] = false;
        return false;
    }

    switch ($scriptWanted) {
        case 'login':
            if (!isset($_POST['login']) || !isset($_POST['password'])) throw new Exception("Connexion : Données formulaire incomplètes");

            $received['login']    = filter_input(INPUT_POST, 'login',    FILTER_SANITIZE_STRING);
            $received['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            if (!$received['login'])    $received['echec'][] = 'login';
            if (!$received['password']) $received['echec'][] = 'password';
            
            break;
        case 'register':
            if (!isset($_POST['login']) || !isset($_POST['rank']) || !isset($_POST['password']) || !isset($_POST['passwordVerif'])) {
                throw new Exception("Inscription : Données formulaire incomplètes");
            }

            $received['rank']          = filter_input(INPUT_POST, 'rank',          FILTER_SANITIZE_STRING);
            $received['login']         = filter_input(INPUT_POST, 'login',         FILTER_SANITIZE_STRING);
            $received['password']      = filter_input(INPUT_POST, 'password',      FILTER_SANITIZE_STRING);
            $received['passwordVerif'] = filter_input(INPUT_POST, 'passwordVerif', FILTER_SANITIZE_STRING);

            if (!$received['login'])         $received['echec'][] = 'login';
            if (!$received['password'])      $received['echec'][] = 'password';
            if (!$received['passwordVerif']) $received['echec'][] = 'passwordVerif';

            break;
        //case 'join': validate $_POST['script'] only
        case 'edit':
            if (!isset($_POST['name']) || !isset($_POST['nbPlaces']) || !isset($_POST['description']) || 
            !isset($_POST['startDate']) || !isset($_POST['startTime']) || !isset($_POST['endDate']) || !isset($_POST['endTime'])) {
                throw new Exception("Edition d'événement : Donnée(s) formulaire absente(s)");
            }

            $received['name']        = filter_input(INPUT_POST, 'name',        FILTER_SANITIZE_STRING);
            $received['nbPlaces']    = filter_input(INPUT_POST, 'nbPlaces',    FILTER_VALIDATE_INT);
            $received['description'] = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $received['startDate']   = filter_input(INPUT_POST, 'startDate',   FILTER_SANITIZE_STRING);
            $received['startTime']   = filter_input(INPUT_POST, 'startTime',   FILTER_SANITIZE_STRING);
            $received['endDate']     = filter_input(INPUT_POST, 'endDate',     FILTER_SANITIZE_STRING);
            $received['endTime']     = filter_input(INPUT_POST, 'endTime',     FILTER_SANITIZE_STRING);

            if (!$received['name'])        $received['echec'][] = 'nom';
            if ($received['nbPlaces'] === false ||
            $received['nbPlaces'] < 0)     $received['echec'][] = 'nombre de places';
            if (!$received['description']) $received['echec'][] = 'description';
            if (!$received['startDate'])   $received['echec'][] = 'date de début';
            if (!$received['startTime'])   $received['echec'][] = 'heure de début';
            if (!$received['endDate'])     $received['echec'][] = 'date de fin';
            if (!$received['endTime'])     $received['echec'][] = 'heure de fin';

            $received['startDate'] .= ' '.$received['startTime'];
            $received['endDate'] .= ' '.$received['endTime'];

            if (!isPreviousDate($received['startDate'], $received['endDate'])) {
                $received['echec'][] = 'durée nulle ou négative';
            }
            if (!isPreviousDate(date('Y-m-d H-i'), $received['startDate'])) {
                $received['echec'][] = 'date de début passée';
            }
            break;
        //case 'delete': validate $_POST['script'] only
    }

    if (isset($received['echec'])) $_POST['script'] = false;//invalidate the script
    else $_POST['script'] = true;

    return $received;
}
