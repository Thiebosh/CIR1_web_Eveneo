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



function oEvent($received) {
    if (isset($_POST['script_delete'])) {
        //traite les infos recues
        $dateRedirection = getDateEvent($received);

        //verifier que renvoi d'un delete est true ou false
        if (!deleteEvent($received['deleteId'])) throw new Exception('Echec de suppression des données');//applique suppression

        header('Location: index.php?action=reception&date='.'$dateRedirection');//recharge la page
        exit();
    }

    $dataEvent = getEvent($infoPage['idEvent']);
    
    //$lastEvent = ;
    //$nextEvent = ;
    $dateStart = strftime('%A %e %B %Y, %Hheures %i', strtotime($dataEvent['datestart']));
    $dateEnd = strftime('%A %e %B %Y, %Hheures %i', strtotime($dataEvent['dateend']));
    
    require('View/BackEnd/vEvent.php');
}



function oEventEdit($received) {
    if (isset($_POST['script_edit'])) {
        if (!modifyDataEvent($received)) throw new Exception('Modification d\'événement : Echec d\'enregistrement des données');
        
        header('Location: index.php?action=detail&id='.'$received[\'idEvent\']');//recharge la page
        exit();
    }

    $dateSplit = explode('-', $received['endDate']);

    require('View/BackEnd/vEditEvent.php');
}

/*
requete préparée ne convertit pas bien en entier pour OFFSET ET STRING seulement
*/

function oEventNew($received) {
    if (isset($_POST['script_new'])) {
        if (!postDataEvent($received)) throw new Exception('Création d\'événement : Echec d\'enregistrement des données');
        $idEvent = getDataEvent($received);//checker retours de requete

        header('Location: index.php?action=detail&id='.'$idEvent');//recharge la page
        exit();
    }

    $dateSplit = explode('-', $received['date']);

    require('View/BackEnd/vNewEvent.php');
}



function oEventDelete($idEvent) {
    $date = getDataEvent($idEvent);
    if (!deleteDataEvent($idEvent)) throw new Exception('Création d\'événement : Echec d\'enregistrement des données');
    
    header('Location: index.php?action=reception&date='.'$date');//recharge la page
    exit();
}