<?php
session_start();

require('Controller/cRegisterLogin.php');
require('Controller/frontEnd.php');
require('Controller/backEnd.php');

define('MAX_LIST', 5);

//affichage des datetimes en francais
setlocale(LC_TIME, 'fr_FR');
date_default_timezone_set('UTC');

try {
    if (!isset($_GET['action'])) {
        throw new Exception('Action manquante');
    }
    $action = $_GET['action'];
    if ($action != 'register'   && $action != 'login'   && $action != 'logout' &&
        $action != 'reception'  && $action != 'list'    && $action != 'detail' &&
        $action != 'new'        && $action != 'edit'    && $action != 'delete') {
        
        throw new Exception('Action indéfinie');
    }
    
    /* BEGINNING OF TREATMENT  */

    if ($action == 'logout') {
        $_SESSION = array();//nettoie la variable
        login();
    }


    if (!isset($_SESSION['rank'])) {
        if ($action == 'register') {

            if (isset($_POST['exist'])) {
                if (isset($_POST['login']) && isset($_POST['rank']) &&
                isset($_POST['password']) && isset($_POST['passwordVerif'])) {
                    $dataPage['rank'] = $_POST['rank'];
                    $dataPage['login'] = $_POST['login'];
                    $dataPage['password'] = $_POST['password'];
                    $dataPage['passwordVerif'] = $_POST['passwordVerif'];
                }
                else throw new Exception('Données formulaire incomplètes');
            }
            register($dataPage);

        }
        else if ($action == 'login') {

            if (isset($_POST['exist'])) {
                if (isset($_POST['login']) && isset($_POST['password'])) {

                    $dataPage['login'] = $_POST['login'];
                    $dataPage['password'] = $_POST['password'];
                }
                else throw new Exception('Données formulaire incomplètes');
            }
            login($dataPage);

        }

        else login();//peut ne rien passer?
    }


    if ($_SESSION['rank'] == 'CUSTOMER') {
        switch ($action) {
            case 'reception':
                if (isset($_POST['date'])) {
                    $dataPage['date'] = $_POST['date'];
                }

                cEventsMonth($dataPage);
                break;
            
            case 'list':
                if (isset($_POST['date'])) {
                    $dataPage['date'] = $_POST['date'];
                }
                else throw new Exception('Evénements du jour : donnée absente');

                cEventsDay($dataPage);
                break;

            case 'detail';
                if (isset($_POST['idEvent'])) {
                    $dataPage['idEvent'] = $_POST['idEvent'];
                }
                else throw new Exception('Evénement : Donnée absente');

                if (isset($_POST['exist'])) {
                    if (isset($_POST['eventJoined'])) {
                        $dataPage['eventJoined'] = $_POST['eventJoined'];//true / false
                    }
                    else throw new Exception('Evénement : Donnée formulaire absente');
                }

                cEvent($dataPage);
                break;

            default:
                cEventsMonth();
                break;
        }
    }


    if ($_SESSION['rank'] == 'ORGANIZER') {
        switch ($action) {
            case 'reception':
                if (isset($_POST['date'])) {
                    $dataPage['date'] = $_POST['date'];
                }

                oEventsMonth($dataPage);
                break;
            
            case 'list':
                if (isset($_POST['date'])) {
                    $dataPage['date'] = $_POST['date'];
                }
                else throw new Exception('Evénements du jour : donnée absente');

                oEventsDay($dataPage);
                break;

            case 'detail';
                if (isset($_POST['idEvent'])) {
                    $dataPage['idEvent'] = $_POST['idEvent'];
                }
                else throw new Exception('Evénement : Donnée absente');

                if (isset($_POST['exist'])) {
                    if (isset($_POST['eventJoined'])) {
                        $dataPage['eventJoined'] = $_POST['eventJoined'];//true / false
                    }
                    else throw new Exception('Evénement : Donnée formulaire absente');
                }

                oEvent($dataPage);
                break;

            case 'new':
                if (isset($_POST['date'])) {
                    $dataPage['date'] = $_POST['date'];
                }
                else throw new Exception('Nouvel événement : Donnée absente');//peut autoriser l'absence

                if (isset($_POST['exist'])) {
                    if (isset($_POST['name']) && isset($_POST['nbPlace']) && isset($_POST['description']) &&
                    isset($_POST['startDate']) && isset($_POST['endDate'])) {
                        $dataPage['name'] = $_POST['name'];
                        $dataPage['nbPlace'] = $_POST['nbPlace'];
                        $dataPage['description'] = $_POST['description'];
                        $dataPage['startDate'] = $_POST['startDate'];
                        $dataPage['endDate'] = $_POST['endDate'];
                    }
                    else throw new Exception('Nouvel événement : Données formulaires incomplètes ou absentes');
                }

                oEventNew($dataPage);
                break;

            case 'edit':
                if (isset($_POST['id'])){
                    $dataPage['id'] = $_POST['id'];
                }
                else throw new Exception('Modifier l\'événement : Donnée absente');

                if (isset($_POST['exist'])) {
                    if (isset($_POST['nbPlaces']) && isset($_POST['description']) && isset($_POST['endDate'])) {
                        $dataPage['nbPlaces'] = $_POST['nbPlaces'];
                        $dataPage['description'] = $_POST['description'];
                        $dataPage['endDate'] = $_POST['endDate'];
                    }
                    else throw new Exception('Modifier l\'événement : Données formulaires incomplètes ou absentes');
                }

                oEventEdit($dataPage);
                break;

            case 'delete':
                if (isset($_POST['id'])){
                    $dataPage['id'] = $_POST['id'];
                }
                else throw new Exception('Supprimer l\'événement : Donnée absente');

                if (isset($_POST['exist'])) {
                    if (isset($_POST['deleteId'])) {
                        $dataPage['deleteId'] = $_POST['deleteId'];
                    }
                    else throw new Exception('Supprimer l\'événement : Donnée formulaire absente');
                }

                oEventDelete($dataPage);
                break;

            default:
                oEventsMonth();
                break;
        }
    }
}

catch(Exception $error) {//apply changes
    $errorMessage = $error->getMessage();
    $redirection['text'] = 'l\'accueil';
    $redirection['link'] = 'reception';
    if (!isset($_SESSION['rank'])) {
        $redirection['text'] = 'l\'écran de  connexion';
        $redirection['link'] = 'login';
    }
    
    require('View/vError.php');
}

//htmlspecialchars() à chaque affichage, et affichage seulement
//$formPassword = (string)filter_input(INPUT_POST, 'password');//prend le champ password du formulaire
