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
        throw new Exception('Pas d\'action définie');
    }
    $action = $_GET['action'];
    $dataForm['empty'] = true;

    if ($_GET['action'] != 'register' && $_GET['action'] != 'login' && $_GET['action'] != 'logout' &&
        $_GET['action'] != 'reception' && $_GET['action'] != 'list' && $_GET['action'] != 'detail' &&
        $_GET['action'] != 'new' && $_GET['action'] != 'edit' && $_GET['action'] != 'delete') {
        throw new Exception('Action indéfinie');
    }

    if (!isset($_SESSION['rank'])) {
        if ($action == 'register') {
            if (isset($_POST['data'])) {
                //verifier valeurs de post
                $rank = $_POST['data']['rank'];
                $login = $_POST['data']['login'];
                $password = $_POST['data']['password'];
                $passwordVerif = $_POST['data']['passwordVerif'];

                $dataForm = array('login' => $login, 'rank' => $rank,
                    'password' => $password, 'passwordVerif' => $passwordVerif);
                
                $dataForm['empty'] = false;
            }

            Register($dataForm);
        }
        
        else {
            if (isset($_POST['data'])) {
                $login = $_POST['data']['login'];
                $password = $_POST['data']['password'];

                $dataForm = array('login' => $login, 'password' => $password);
                
                $dataForm['empty'] = false;
            }

            Login($dataForm);
        }
    }
    

    if ($action == 'logout') {
        $_SESSION = array();//nettoie la variable
    }

    
    if ($_SESSION['rank'] == 'CUSTOMER') {
        switch ($action) {
            case 'reception':
                if (isset($_POST['date'])){
                    $date = $_POST['date'];
                    $dataForm['date'] = $date;
                    $dataForm['empty'] = false;
                }
                if (isset($_POST['data'])) {
                    $id = $_POST['data']['id'];
                    $status = $_POST['data']['status'];//follow / unfollow
                    $dataForm['data'] = array('id' => $id, 'status' => $status);
                }

                CustomerReception($dataForm);
                break;
            
            case 'list':
                if (isset($_POST['date'])){
                    if (isset($_POST['time'])){
                        $time = $_POST['time'];
                        $dataForm['time'] = $time;
                    }

                    $date = $_POST['date'];
                    $dataForm['date'] = $date;
                }
                else {
                    throw new Exception('Information manquante');
                }

                CustomerAllEvents($dataForm);
                break;

            case 'detail';
                if (isset($_POST['id'])){
                    if (isset($_POST['data'])){
                        $duree = $_POST['data']['duree'];
                        $dateend = $_POST['data']['dateend'];
                        $nbPlaces = $_POST['data']['nbPlaces'];
                        $description = $_POST['data']['description'];

                        $dataForm = array('duree' => $duree, 'dateend' => $dateend,
                            'nbPlaces' => $nbPlaces, 'description' => $description);
                    }

                    $id = $_POST['id'];
                    $dataForm['id'] = $id;
                    $dataForm['empty'] = false;
                }
                else {
                    throw new Exception('Information manquante');
                }

                CustomerEvent($dataForm);
                break;

            default:
                CustomerReception($dataForm);
                break;
        }
    }


    if ($_SESSION['rank'] == 'ORGANIZER') {
        switch ($action) {
            case 'reception':
                if (isset($_POST['date'])){
                    $date = $_POST['date'];
                    $dataForm['date'] = $date;//Y-m
                    $dataForm['empty'] = false;
                }

                OrganizerReception($dataForm);
                break;

            case 'list':
                if (isset($_POST['date'])){
                    if (isset($_POST['time'])){
                        $time = $_POST['time'];
                        $dataForm['time'] = $time;
                    }

                    $date = $_POST['date'];
                    $dataForm['date'] = $date;
                    $dataForm['empty'] = false;
                }
                else {
                    throw new Exception('Information manquante');
                }

                OrganizerAllEvents($dataForm);
                break;

            case 'detail';
                if (isset($_POST['id'])){
                    if (isset($_POST['data'])){
                        $duree = $_POST['data']['duree'];
                        $dateend = $_POST['data']['dateend'];
                        $nbPlaces = $_POST['data']['nbPlaces'];
                        $description = $_POST['data']['description'];

                        $dataForm = array('duree' => $duree, 'dateend' => $dateend,
                            'nbPlaces' => $nbPlaces, 'description' => $description);
                    }

                    $id = $_POST['id'];
                    $dataForm['id'] = $id;
                    $dataForm['empty'] = false;
                }
                else {
                    throw new Exception('Information manquante');
                }

                OrganizerEvent($dataForm);
                break;

            case 'new':
                if (isset($_POST['date'])){
                    if (isset($_POST['data'])){
                        $title = $_POST['data']['title'];
                        $nbPlaces = $_POST['data']['nbPlaces'];
                        $dateend = $_POST['data']['datestart'];
                        $dateend = $_POST['data']['dateend'];
                        $duree = $_POST['data']['duree'];
                        $description = $_POST['data']['description'];

                        $dataForm = array('title' => $title, 'nbPlaces' => $nbPlaces, 'duree' => $duree,
                            'datestart' => $datestart, 'dateend' => $dateend, 'description' => $description);
                    }

                    $date = $_POST['date'];
                    $dataForm['date'] = $date;
                    $dataForm['empty'] = false;
                }

                OrganizerNewEvent($dataForm);
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

                OrganizerEditEvent($dataForm);
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

                OrganizerDeleteEvent($dataForm);
                break;

            default:
                OrganizerReception($dataForm);
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
