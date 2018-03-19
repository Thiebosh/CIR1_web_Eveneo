<?php
require('model/BackEnd.php');

function OrganizerReception($infoPage) {
    $listEvents = getAllEvents($infoPage);

    require('View/BackEnd/viewReception.php');

    $listEventsMonth->closeCursor();//bien placé?
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

    $listEventsDay->closeCursor();//bien placé?
}

function OrganizerEvent($infoPage) {
    $dataEvent = getEvent($infoPage['idEvent']);
    
    require('View/BackEnd/viewEvent.php');

    $dataEvent->closeCursor();//bien placé?
}

function OrganizerNewEvent($infoPage) {
    require('View/BackEnd/viewNewEvent.php');
}

function OrganizerModifyEvent($infoPage) {
    if (isset($infoPage['modify'])) {
        updateEvent($infoPage);
    }
    $dataEvent = getEvent($infoPage['idEvent']);

    require('View/BackEnd/viewModifyEvent.php');

    $dataEvent->closeCursor();//bien placé?
}