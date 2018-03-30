<?php
require('Model/mFrontEnd.php');

function cEventsMonth($date) {
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

    require('View/FrontEnd/vReception.php');
}



function cEventsDay($date) {
    $showDate = strftime('%A %e %B %Y', strtotime($date));

    $dateSplit = explode('-', $date);
    $lastDay = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dateSplit[2] - 1, $dateSplit[0]));
    $nextDay = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dateSplit[2] + 1, $dateSplit[0]));

    $eventsDay = getEventsDay($date, false);
    
    require('View/FrontEnd/vAllEvents.php');
}



function cEvent($received) {
    if (isset($_POST['script_joined'])) {
        $received['eventJoined'] = !$received['eventJoined'];//change l etat de eventJoined
        
        changeStatusEvent($received);//throw new Exception('Echec d\'enregistrement des données');//applique changement d etat (UPDATE renvoie quelque chose pour echec?)

        header('Location: index.php?action=detail&id='.'$event[\'id\']');//recharge la page
        exit();
    }

    $dataEvent = getEvent($infoPage['idEvent']);
    if (!$dataEvent) throw new Exception('Evénement : Echec de récupération des données');
    
    //$lastEvent = ;
    //$nextEvent = ;
    $dateStart = strftime('%A %e %B %Y, %Hheures %i', strtotime($dataEvent['datestart']));
    $dateEnd = strftime('%A %e %B %Y, %Hheures %i', strtotime($dataEvent['dateend']));
    
    require('View/FrontEnd/vEvent.php');
}
