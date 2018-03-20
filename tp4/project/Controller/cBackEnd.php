<?php
require('model/mBackEnd.php');

function OrganizerReception($infoPage) {
    $listEvents = getAllEvents($infoPage);

    require('View/BackEnd/vReception.php');

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

    require('View/BackEnd/vAllEvents.php');

    $listEventsDay->closeCursor();//bien placé?
}

function OrganizerEvent($infoPage) {
    $dataEvent = getEvent($infoPage['idEvent']);
    
    require('View/BackEnd/vEvent.php');

    $dataEvent->closeCursor();//bien placé?
}

function OrganizerNewEvent($infoPage) {
    require('View/BackEnd/vNewEvent.php');
}

function OrganizerEditEvent($infoPage) {
    if (isset($infoPage['modify'])) {
        updateEvent($infoPage);
    }
    $dataEvent = getEvent($infoPage['idEvent']);

    require('View/BackEnd/vEditEvent.php');

    $dataEvent->closeCursor();//bien placé?
}