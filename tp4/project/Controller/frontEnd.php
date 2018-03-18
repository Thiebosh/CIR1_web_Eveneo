<?php
require('Model/FrontEnd.php');

function CustomerReception($infoPage) {
    $infoPage['showEventFull'] = false;

    $nbDayInMonth = date('t, strtotime($infoPage[\'date\'])');//verifier
    for ($day = 1; $day <= $nbDayInMonth; $day++) {
        $listEventsMonth[] = getAllEvents($infoPage);//si vide, listEventsMonth[] vaudra false
    }
    
    require('View/FrontEnd/viewReception.php');

    $listEventsMonth->closeCursor();//bien placé?
}

function CustomerAllEvents($infoPage) {
    $infoPage['showEventFull'] = true;

    $listEventsDay = getAllEvents($infoPage);

    require('View/FrontEnd/viewAllEvents.php');

    $listEventsDay->closeCursor();//bien placé?
}

function CustomerEvent($infoPage) {
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
    
    require('View/FrontEnd/viewEvent.php');

    $dataEvent->closeCursor();//bien placé?
}
