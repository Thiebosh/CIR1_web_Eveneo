<?php
require('Model/mFrontEnd.php');

function cEventsMonth($date) {
    if (!$date) $date = date('Y-m');

    $timeStamp = strtotime($date);
    $showDate = strftime('%B %Y', $timeStamp);
    $nbDayMonth = date('t', $timeStamp);

    $dateSplit = explode('-', $date);
    $lastMonth = date('Y-m', gmmktime(0, 0, 0, $dateSplit[1] - 1, 1, $dateSplit[0]));
    $nextMonth = date('Y-m', gmmktime(0, 0, 0, $dateSplit[1] + 1, 1, $dateSplit[0]));

    $dayName = array('ang' => array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'),
                    'fr' => array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'));
    $dayStartMonth = date('D', gmmktime(0, 0, 0, $dateSplit[1], 1, $dateSplit[0]));//pour commencer le tableau d affichage
    $dayEndMonth = date('N', gmmktime(0, 0, 0, $dateSplit[1], $nbDayMonth, $dateSplit[0]));//pour finir le tableau d affichage

    for ($day = 1; $day <= $nbDayMonth; $day++) {
        $fullDate = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $day, $dateSplit[0]));
        $eventsMonth[] = cGetEventsDay($fullDate, true);//si vide, listEventsMonth[] vaudra false
    }

    require('View/FrontEnd/vEventsMonth.php');
}


function cEventsDay($date) {
    $showDate = strftime('%A %e %B %Y', strtotime($date));

    $dateSplit = explode('-', $date);
    $lastDay = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dateSplit[2] - 1, $dateSplit[0]));
    $nextDay = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dateSplit[2] + 1, $dateSplit[0]));

    $eventsDay = cGetEventsDay($date, false);//si pas d'événement, n'affiche rien

    require('View/FrontEnd/vEventsDay.php');
}


function cEvent($id) {
    $status = cGetEventStatus($id);//si faux, n'est pas inscrit
    $dataEvent = cGetEvent($id);
    if (!$dataEvent) throw new Exception("Evénement : Echec de récupération des données");
    
    if (isset($_POST['script_join'])) {
        if (!$status) cPostStatusEvent($id);//throw new Exception("Echec d\'enregistrement des données');//applique cChangement d etat (INSERT INTO renvoie quelque chose pour echec?)
        else cDeleteStatusEvent($id);//throw new Exception("Echec d\'enregistrement des données');//applique cChangement d etat (DELETE FROM renvoie quelque chose pour echec?)

        header('Location: index.php?action=reception&date='.$dataEvent['startdate']);//recharge la page
        exit();
    }

    $dateStart = strftime('%A %e %B %Y, %Hheures %i', strtotime($dataEvent['startdate']));
    $dateEnd = strftime('%A %e %B %Y, %Hheures %i', strtotime($dataEvent['enddate']));
    $dureeEvent = 'coder fonction';
    
    if (!$status) $action = "Inscription";
    else $action = "Désinscription";

    require('View/FrontEnd/vEvent.php');
}
