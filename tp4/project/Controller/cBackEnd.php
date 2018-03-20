<?php
require('model/mBackEnd.php');

function OrganizerReception($infoPage) {//ok
    if ($dataPage['empty']) {
        $dataPage['date'] = date('Y-m');
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
        $eventsMonth[] = getAllEvents($dataPage);//si vide, listEventsMonth[] vaudra false ->verifier requete
    }

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

function OrganizerDeleteEvent($dataForm) {

}