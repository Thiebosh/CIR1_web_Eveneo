<?php
require('Model/mFrontEnd.php');

function CustomerReception($dataForm) {
    if ($dataForm['empty']) {
        $date = date();//mettre aujourd'huits
    }
    //avancée
    $dataForms['showEventFull'] = false;

    $nbDayInMonth = date('t, strtotime($dataForms[\'date\'])');//verifier
    for ($day = 1; $day <= $nbDayInMonth; $day++) {
        $listEventsMonth[] = getAllEvents($infoPage);//si vide, listEventsMonth[] vaudra false
    }
    
    require('View/FrontEnd/vReception.php');

    $listEventsMonth->closeCursor();//bien placé?
}

function CustomerAllEvents($infoPage) {
    if ($dataForm['empty']) {
        throw new Exception('Manque d\'information');
    }
    //avancée

    $infoPage['showEventFull'] = true;

    $listEventsDay = getAllEvents($infoPage);

    require('View/FrontEnd/vAllEvents.php');

    $listEventsDay->closeCursor();//bien placé?
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
