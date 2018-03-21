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
        throw new Exception('Pas d\'action définie');
    }
    $action = $_GET['action'];
    $dataForm['empty'] = true;

    if ($_GET['action'] != 'register' && $_GET['action'] != 'login' && $_GET['action'] != 'logout' &&
        $_GET['action'] != 'reception' && $_GET['action'] != 'list' && $_GET['action'] != 'detail' &&
        $_GET['action'] != 'new' && $_GET['action'] != 'edit' && $_GET['action'] != 'delete')
    {
        throw new Exception('Action indéfinie');
    }

    if (!isset($_SESSION['rank'])) {
        if ($action == 'register') {
            if (isset($_POST['rank']) && isset($_POST['login']) &&
                isset($_POST['password']) && isset($_POST['passwordVerif'])) {
                //verifier existence de chaque post et leur type
                $rank = $_POST['rank'];
                $login = $_POST['login'];
                $password = $_POST['password'];
                $passwordVerif = $_POST['passwordVerif'];

                $dataForm['dataPost'] = array('login' => $login, 'rank' => $rank,
                    'password' => $password, 'passwordVerif' => $passwordVerif);
                
                $dataForm['empty'] = false;
            }
            else {
                throw new Exception('Information manquante');
            }

            Register($dataForm);
        }
        
        else {
            if (isset($_POST['login']) && isset($_POST['password'])) {
                $login = $_POST['login'];
                $password = $_POST['password'];

                $dataForm['dataPost'] = array('login' => $login, 'password' => $password);
                
                $dataForm['empty'] = false;
            }
            else {
                throw new Exception('Information manquante');
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
                if (isset($_POST['id']) && isset($_POST['status'])) {
                    $id = $_POST['id'];
                    $status = $_POST['status'];//follow / unfollow
                    $dataForm['dataPost'] = array('id' => $id, 'status' => $status);
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
                    if (isset($_POST['duree']) && isset($_POST['dateend']) &&
                        isset($_POST['nbPlaces']) && isset($_POST['description'])){
                        $duree = $_POST['duree'];
                        $dateend = $_POST['dateend'];
                        $nbPlaces = $_POST['nbPlaces'];
                        $description = $_POST['description'];

                        $dataForm['dataPost'] = array('duree' => $duree, 'dateend' => $dateend,
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
                        $duree = $_POST['duree'];
                        $dateend = $_POST['dateend'];
                        $nbPlaces = $_POST['nbPlaces'];
                        $description = $_POST['description'];

                        $dataForm['dataPost'] = array('duree' => $duree, 'dateend' => $dateend,
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
                        $title = $_POST['title'];
                        $nbPlaces = $_POST['nbPlaces'];
                        $dateend = $_POST['datestart'];
                        $dateend = $_POST['dateend'];
                        $duree = $_POST['duree'];
                        $description = $_POST['description'];

                        $dataForm['dataPost'] = array('title' => $title, 'nbPlaces' => $nbPlaces, 'duree' => $duree,
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
