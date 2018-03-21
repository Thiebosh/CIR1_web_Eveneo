<?php
session_start();

require('Controller/cRegisterLogin.php');
require('Controller/frontEnd.php');
require('Controller/backEnd.php');

define('MAX_LIST', 5);

//affichage des datetimes en francais
setlocale(LC_TIME, 'fr_FR');
date_default_timezone_set('UTC');
//pour chaque post, inclure un parametre caché "receptionPost", si vide passe, sinon verifie valeurs et envoie une erreur si non definie ou che pas quoi
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
            register();
        }
        else {//action = login
            if (!isset($_POST['exist'])) {
                $dataPage['empty'] = true;
            }
            else {
                $typeForm = $_POST['exist'];

                if ($typeForm == 'login') {
                    if (isset($_POST['login']) && isset($_POST['password'])) {

                        $dataPage['login'] = $_POST['login'];
                        $dataPage['password'] = $_POST['password'];
                    }
                    else {
                        throw new Exception('Données formulaire incomplètes');
                    }
                }
                else {//typeForm = register
                    if (isset($_POST['login'])  && isset($_POST['password']) &&
                        isset($_POST['rank'])   && isset($_POST['passwordVerif'])) {

                        $dataPage['rank'] = $_POST['rank'];
                        $dataPage['login'] = $_POST['login'];
                        $dataPage['password'] = $_POST['password'];
                        $dataPage['passwordVerif'] = $_POST['passwordVerif'];
                    }
                    else {
                        throw new Exception('Données formulaire incomplètes');
                    }
                }
            }
            login($dataPage);
        }
    }

    //apply changes
    if ($_SESSION['rank'] == 'CUSTOMER') {
        switch ($action) {
            case 'reception':
                if (isset($_POST['date'])){
                    $dataPage['date'] = $_POST['date'];
                }

                if (!isset($_POST['exist'])) {
                    $dataPage['empty'] = true;
                }
                else {
                    if (isset($_POST['idEvent']) && isset($_POST['eventJoined'])) {
    
                        $dataPage['idEvent'] = $_POST['idEvent'];
                        $dataPage['eventJoined'] = $_POST['eventJoined'];//true / false
                    }
                    else {
                        throw new Exception('Données formulaire incomplètes');
                    }
                }

                cEventsMonth($dataForm);
                break;
            
            case 'list':
                if (isset($_POST['date'])) {
                    $dataPage['date'] = $_POST['date'];
                }
                else {
                    throw new Exception('Données absentes');
                }

                cEventsDay($dataForm);
                break;

            case 'detail';
                if (isset($_POST['idEvent'])) {
                    $dataPage['idEvent'] = $_POST['idEvent'];
                }
                else {
                    throw new Exception('Données absentes');
                }

                cEvent($dataForm);
                break;

            default:
                cEventsMonth();
                break;
        }
    }


    if ($_SESSION['rank'] == 'ORGANIZER') {
        switch ($action) {
            case 'reception':
                if (isset($_POST['date'])){
                    $dataPage['date'] = $_POST['date'];
                }

                oEventsMonth($dataForm);
                break;

            case 'list':
                if (isset($_POST['date'])) {
                    $dataPage['date'] = $_POST['date'];
                }
                else {
                    throw new Exception('Données absentes');
                }

                if (!isset($_POST['exist'])) {
                    $dataPage['empty'] = true;
                }
                else {
                    if (isset($_POST['idEvent'])) {
                        $dataPage['idEvent'] = $_POST['idEvent'];
                    }
                    else {
                        throw new Exception('Donnée formulaire absente');
                    }
                }

                oEventsDay($dataForm);
                break;

            case 'detail';
                if (isset($_POST['idEvent'])) {
                    $dataPage['idEvent'] = $_POST['idEvent'];
                }
                else {
                    throw new Exception('Données absentes');
                }

                if (!isset($_POST['exist'])) {
                    $dataPage['empty'] = true;
                }
                else {
                    if (isset($_POST['nbPlaces']) && isset($_POST['dateend']) && isset($_POST['description'])) {
                    
                        $dataPage['dateend'] = $_POST['dateend'];
                        $dataPage['nbPlaces'] = $_POST['nbPlaces'];
                        $dataPage['description'] = $_POST['description'];
                    }
                    else {
                        throw new Exception('Donnée formulaire absente');
                    }
                }

                oEvent($dataForm);
                break;

            case 'new':
                if (isset($_POST['date'])){
                    if (isset($_POST['data'])){
                        $title = $_POST['title'];
                        $nbPlaces = $_POST['nbPlaces'];
                        $dateend = $_POST['datestart'];
                        $dateend = $_POST['dateend'];
                        $description = $_POST['description'];

                        $dataForm['dataPost'] = array('title' => $title, 'nbPlaces' => $nbPlaces,
                            'datestart' => $datestart, 'dateend' => $dateend, 'description' => $description);
                    }

                    $date = $_POST['date'];
                    $dataForm['date'] = $date;
                    $dataForm['empty'] = false;
                }

                oEventsNew($dataForm);
                break;

            case 'edit':
                if (isset($_POST['id'])){
                    $id = $_POST['id'];
                    $dataForm['id'] = $id;
                    $dataForm['empty'] = false;
                }
                else {
                    throw new Exception('Information manquante');
                }

                oEventsEdit($dataForm);
                break;

            case 'delete':
                if (isset($_POST['id'])){
                    $id = $_POST['id'];
                    $dataForm['id'] = $id;
                    $dataForm['empty'] = false;
                }
                else {
                    throw new Exception('Information manquante');
                }

                oEventsDelete($dataForm);
                break;

            default:
                oEventsMonth();
                break;
        }
    }
}

catch(Exception $error) {
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
