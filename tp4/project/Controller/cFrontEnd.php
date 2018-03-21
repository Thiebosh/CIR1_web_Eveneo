<?php
require('Model/mFrontEnd.php');

function CustomerReception($dataPage) {//ok (customerEventMonth?)
    if ($dataPage['empty']) {
        $dataPage['date'] = date('Y-m');
    }
    if ($dataPage['data']) {
        changeStatusEvent($dataPage['data']);
    }

    $timeStamp = strtotime($dataPage['date']);
    $showDate = strftime('%B %Y', $timeStamp);
    $nbDayMonth = date('t', $timeStamp);

    $split = explode('-', $dataPage['date']);
    $lastMonth = date('Y-m', gmmktime(0, 0, 0, $split[1] - 1, 0, $split[0]));
    $nextMonth = date('Y-m', gmmktime(0, 0, 0, $split[1] + 1, 0, $split[0]));

    $dayName['ang'] = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
    $dayName['fr'] = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    $dayStartMonth = date('D', gmmktime(0, 0, 0, $split[1], 1, $split[0]));//pour commencer le tableau d affichage
    $dayEndMonth = date('N', gmmktime(0, 0, 0, $split[1], $nbDay, $split[0]));//pour finir le tableau d affichage

    for ($day = 1; $day <= $nbDayMonth; $day++) {
        $eventsMonth[] = getEventsDay($dataPage, true);//si vide, listEventsMonth[] vaudra false ->verifier requete
    }

    require('View/FrontEnd/vReception.php');
    $eventsMonth->closeCursor();//bien placé?
}

function CustomerAllEvents($infoPage) {//customerEventsDay
    $showDate = strftime('%A %e %B %Y', strtotime($dataPage['date']));

    $split = explode('-', $dataPage['date']);
    $lastDay = date('Y-m-d', gmmktime(0, 0, 0, $split[1], $split[2] - 1, $split[0]));
    $nextDay = date('Y-m-d', gmmktime(0, 0, 0, $split[1], $split[2] + 1, $split[0]));

    $eventsDay = getEventsDay($dataPage, false);

    require('View/FrontEnd/vAllEvents.php');
    $eventsDay->closeCursor();//bien placé?
}

function CustomerEvent($infoPage) {
    if ($dataForm['empty']) {
        throw new Exception('Manque d\'information');
    }
    //avancée

    if ($infoPage['changeStatus']) {
        //current indique la relation actuelle (vrai = inscrit ou faux = non inscrit)
        $current = getEventStatus($infoPage['idEvent']);
        if (!current) {
            changeEvent(true);
        }
        else {
            changeEvent(false);
        }
    }
    
    $dataEvent = getEvent($infoPage['idEvent']);
    
    require('View/FrontEnd/vEvent.php');

    $dataEvent->closeCursor();//bien placé?
}
