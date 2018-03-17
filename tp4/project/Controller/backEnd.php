<?php
require('model/BackEnd.php');

function OrganizerReception($infoPage) {
    $listEvents = getAllEvents($infoPage);

    require('View/BackEnd/viewReception.php');
}

function OrganizerAllEvents($infoPage) {
    if ($infoPage['addEvent']) {//si vrai
        postEvent($infoPage['infoEvent']);
    }
    else if ($infoPage['removeEvent']) {//si vrai
        deleteEvent($infoPage['idEvent']);
    }

    $listEvents = getAllEvents($infoPage);

    require('View/BackEnd/viewAllEvents.php');
}

function OrganizerEvent($infoPage) {
    $dataEvent = getEvent($infoPage['idEvent']);
    
    require('View/BackEnd/viewEvent.php');
}

function OrganizerNewEvent($infoPage) {
    require('View/BackEnd/viewNewEvent.php');
}