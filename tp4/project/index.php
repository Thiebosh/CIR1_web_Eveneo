<?php
session_start();

require('Controller/cRegisterLogin.php');
require('Controller/frontEnd.php');
require('Controller/backEnd.php');

define('MAX_LIST', 5);

try {
    if (!isset($_GET['action'])) {
        throw new Exception('Pas d\'action définie');
    }
    $action = $_GET['action'];
    $dataForm['empty'] = true;


    if (!isset($_SESSION['rank'])) {
        if ($action == 'register') {
            if (isset($_POST['data'])) {
                //verifier valeurs de post
                $login = $_POST['data']['login'];
                $rank = $_POST['data']['rank'];
                $password = $_POST['data']['password'];
                $passwordVerif = $_POST['data']['passwordVerif'];

                $dataForm = array('login' => $login, 'rank' => $rank,
                    'password' => $password, 'passwordVerif' => $passwordVerif);
                
                $dataForm['empty'] = false;
            }

            Register($dataForm);
        }
        
        
        //else
        if (isset($_POST['data'])) {
            $login = $_POST['data']['login'];
            $password = $_POST['data']['password'];

            $dataForm = array('login' => $login, 'password' => $password);
            
            $dataForm['empty'] = false;
        }

        Login($dataForm);
    }
    

    if ($action == 'logout') {
        $_SESSION = array();//nettoie la variable
    }

    
    if ($_SESSION['rank'] == 'CUSTOMER') {
        switch ($action) {
            case 'reception':
                if (isset($_POST['date'])){
                    $date = $_POST['date'];

                    $dataForm = array('date' => $date);

                    $dataForm['empty'] = false;
                }

                CustomerReception($dataForm);
                break;
            case 'list':
                if (isset($_POST['date'])){
                    $date = $_POST['date'];
                    $dataForm = array('date' => $date);

                    if (isset($_POST['time'])){
                        $time = $_POST['time'];
                        $dataForm = array('time' => $time);
                    }

                    $dataForm['empty'] = false;
                }

                CustomerAllEvents($dataForm);
                break;
            case 'detail';
                if (isset($_POST['id'])){
                    $id = $_POST['id'];
                    $dataForm = array('id' => $id);

                    if (isset($_POST['data'])){
                        $duree = $_POST['duree'];
                        $dateend = $_POST['dateend'];
                        $nbPlaces = $_POST['nbPlaces'];
                        $description = $_POST['description'];
                        $dataForm = array('duree' => $duree, 'dateend' => $dateend,
                            'nbPlaces' => $nbPlaces, 'description' => $description);
                    }

                    $dataForm['empty'] = false;
                }

                CustomerEvent($dataForm);
                break;
            default:
                throw new Exception('Action indéfinie');
                break;
        }
    }


    if ($_SESSION['rank'] == 'ORGANIZER') {
        switch ($action) {
            case 'reception':
                if (isset($_POST['date'])){
                    $date = $_POST['date'];

                    $dataForm = array('date' => $date);

                    $dataForm['empty'] = false;
                }

                OrganizerReception($dataForm);
                break;
            case 'list':
                if (isset($_POST['date'])){
                    $date = $_POST['date'];
                    $dataForm = array('date' => $date);

                    if (isset($_POST['time'])){
                        $time = $_POST['time'];
                        $dataForm = array('time' => $time);
                    }

                    $dataForm['empty'] = false;
                }

                OrganizerAllEvents($dataForm);
                break;
            case 'detail';
                if (isset($_POST['id'])){
                    $id = $_POST['id'];
                    $dataForm = array('id' => $id);

                    if (isset($_POST['data'])){
                        $duree = $_POST['duree'];
                        $dateend = $_POST['dateend'];
                        $nbPlaces = $_POST['nbPlaces'];
                        $description = $_POST['description'];
                        $dataForm = array('duree' => $duree, 'dateend' => $dateend,
                            'nbPlaces' => $nbPlaces, 'description' => $description);
                    }

                    $dataForm['empty'] = false;
                }

                OrganizerEvent($dataForm);
                break;
            case 'new':
                if (isset($_POST['date'])){
                    $date = $_POST['date'];
                    $dataForm = array('date' => $date);

                    if (isset($_POST['data'])){
                        $title = $_POST['title'];
                        $nbPlaces = $_POST['nbPlaces'];
                        $dateend = $_POST['datestart'];
                        $duree = $_POST['duree'];
                        $dateend = $_POST['dateend'];
                        $description = $_POST['description'];
                        $dataForm = array('title' => $title, 'nbPlaces' => $nbPlaces, 'duree' => $duree,
                            'datestart' => $datestart, 'dateend' => $dateend, 'description' => $description);
                    }

                    $dataForm['empty'] = false;
                }

                OrganizerNewEvent($dataForm);
                break;
            case 'edit':
                if (isset($_POST['id'])){
                    $id = $_POST['id'];

                    $dataForm = array('id' => $id);

                    $dataForm['empty'] = false;
                }

                OrganizerEditEvent($dataForm);
                break;
            default:
                throw new Exception('Action indéfinie');
                break;
        }
    }
}
catch(Exception $error) { // S'il y a eu une erreur, alors...
    $errorMessage = $error->getMessage();
    require('View/vError.php');
}




/*preparer nouvelles dates dans controleur et inclure dans le post de view
lastMonth
nextMonth

lastDay
nextDay

lastEvent
nextEvent


//htmlspecialchars() à chaque affichage, et affichage seulement
//$formPassword = (string)filter_input(INPUT_POST, 'password');//prend le champ password du formulaire
