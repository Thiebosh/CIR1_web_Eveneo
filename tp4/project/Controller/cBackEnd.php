<?php
require('model/mBackEnd.php');

function oEventsMonth($date) {//ok
    if (empty($date)) {
        $date = date('Y-m');
    }

    $timeStamp = strtotime($date);
    $showDate = strftime('%B %Y', $timeStamp);
    $nbDayMonth = date('t', $timeStamp);

    $dateSplit = explode('-', $date);
    $lastMonth = date('Y-m', gmmktime(0, 0, 0, $dateSplit[1] - 1, 0, $dateSplit[0]));
    $nextMonth = date('Y-m', gmmktime(0, 0, 0, $dateSplit[1] + 1, 0, $dateSplit[0]));

    $dayName['ang'] = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
    $dayName['fr'] = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    $dayStartMonth = date('D', gmmktime(0, 0, 0, $dateSplit[1], 1, $dateSplit[0]));//pour commencer le tableau d affichage
    $dayEndMonth = date('N', gmmktime(0, 0, 0, $dateSplit[1], $nbDay, $dateSplit[0]));//pour finir le tableau d affichage

    for ($day = 1; $day <= $nbDayMonth; $day++) {
        $eventsMonth[] = getEventsDay($date, true);//si vide, listEventsMonth[] vaudra false ->verifier requete
    }

    require('View/BackEnd/vReception.php');
}



function oEventsDay($date) {
    $showDate = strftime('%A %e %B %Y', strtotime($date));

    $dateSplit = explode('-', $date);
    $lastDay = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dateSplit[2] - 1, $dateSplit[0]));
    $nextDay = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dateSplit[2] + 1, $dateSplit[0]));

    $eventsDay = getEventsDay($date, false);

    require('View/BackEnd/vAllEvents.php');
}



function oEvent($idEvent) {
    $dataEvent = getEvent($idEvent);
    
    require('View/BackEnd/vEvent.php');
}

/*
requete préparée ne convertit pas bien en entier pour OFFSET ET STRING seulement
*/

function oEventNew($received) {
    if (!isset($_POST['exist'])) {
        //affiche formulaire
    }
    else {
        //traite les infos recues
        if ($received['startDate'] != $received['endDate']) {//appliquer checkdate et checktime sur les dates, etc...
            //infos incorrectes
        }
        else {
            //enregistre infos (verifier que renvoi d'un post est true ou false)
            if (!postDataEvent($received)) throw new Exception('Echec d\'enregistrement des données');
        }
    }

    //redirige vers

    require('View/BackEnd/vNewEvent.php');
}



function oEventEdit($received) {
    if (!isset($_POST['exist'])) {
        //affiche formulaire
    }
    else {
        //traite les infos recues
        if ($received['startDate'] != $received['endDate']) {//appliquer checkdate et checktime sur les dates, etc...
            //infos incorrectes
        }
        else {
            //enregistre infos (verifier que renvoi d'un post est true ou false)
            if (!updateEvent($received)) throw new Exception('Echec d\'enregistrement des données');
        }
    }

    //redirige vers

    require('View/BackEnd/vEditEvent.php');
}



function oEventDelete($idEvent) {
    //verifier le retours de deleteEvent
    if (!deleteEvent($idEvent)) throw new Exception('Echec d\'enregistrement des données');

    //redirige vers eventsDay
    header('Location: index.php?action=reception');
    exit();
}