<?php
require('Model/FrontEnd.php');

function CustomerReception($infoPage) {
    $listEvents = getAllEvents($infoPage);

    require('View/FrontEnd/viewReception.php');
}

function CustomerAllEvents($infoPage) {
    $listEvents = getAllEvents($infoPage);

    require('View/FrontEnd/viewAllEvents.php');
}

function CustomerEvent($infoPage) {
    if ($infoPage['changeStatus']) {
        //modifier pour que current indique la relation actuelle (vrai = inscrit ou faux = non inscrit)
        $current = getEvent($infoPage['idEvent']);
        if (current) {
            changeEvent(false);
        }
        else {
            changeEvent(true);
        }
    }
    
    $dataEvent = getEvent($infoPage['idEvent']);
    
    require('View/FrontEnd/viewEvent.php');
}