<?php
require('Model/mFrontEnd.php');


function cEventsMonth($date) {
    $timeStamp = strtotime($date);
    $dataDate['nbDays'] = date('t', $timeStamp);
    $dateSplit = explode('-', $date);
    $dataDate['year'] = $dateSplit[0];
    $dataDate['month'] = $dateSplit[1];

    $dataMonth = cGetEventsMonth($dataDate);
    for($day = 1; $day < $dataDate['nbDays']; $day++) {
        if ($dataMonth[$day]) {
            $event = 0;
            foreach($dataMonth[$day] as $dataEvent) {
                $dataMonth[$day][$event]['status'] = getEventStatus($dataEvent['id']);
                $event++;
            }
            if (count($dataMonth[$day]) > MAX_LIST) {
                $dataMonth[$day][0]['date'] = date('Y-m-d', gmmktime(0, 0, 0, $dataDate['month'], $day, $dataDate['year']));
            }
        }
    }

    $startMonth = date('D', gmmktime(0, 0, 0, $dataDate['month'], 1, $dataDate['year']));//pour commencer le tableau d affichage
    $endMonth = date('N', gmmktime(0, 0, 0, $dataDate['month'], $dataDate['nbDays'], $dataDate['year']));//pour finir le tableau d affichage
    $lastMonth = date('Y-m', gmmktime(0, 0, 0, $dataDate['month'] - 1, 1, $dataDate['year']));
    $nextMonth = date('Y-m', gmmktime(0, 0, 0, $dataDate['month'] + 1, 1, $dataDate['year']));
    
    $dayName = array('ang' => array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'),
                    'fr' => array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'));

    $display = strftime('%B %Y', $timeStamp);
    $date = $dateSplit[0].'-'.$dateSplit[1];
    $lastPage = "reception&amp;date=".$lastMonth;
    $nextPage = "reception&amp;date=".$nextMonth;
    $switchName = 'Mois';

    require('View/Common/vMonth.php');
}


function cEventsDay($date) {
    $dataDay = cGetEventsDay($date);
    $event = 0;
    foreach($dataDay as $dataEvent) {
        if (getEventStatus($dataEvent['id'])) $dataDay[$event]['status'] = 'Oui';
        else $dataDay[$event]['status'] = 'Non';

        $dataDay[$event]['startTime'] = strftime('%hHeure %i', strtotime($dataEvent['startTime']));
        $event++;
    }

    $dateSplit = explode('-', $date);
    $lastDay = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dateSplit[2] - 1, $dateSplit[0]));
    $nextDay = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dateSplit[2] + 1, $dateSplit[0]));
    
    $display = strftime('%A %e %B %Y', strtotime($date));
    $dateMonth = $dateSplit[0].'-'.$dateSplit[1];
    $lastPage = "list&amp;date=".$lastDay;
    $nextPage = "list&amp;date=".$nextDay;
    $switchName = 'Jour';

    require('View/Common/vDay.php');
}


function cEvent($id) {
    $dataEvent = cGetEventDetail($id);
    if (!$dataEvent) throw new Exception("Evénement : Echec de récupération des données");
    $dateSplit = explode(' ', $dataEvent['startdate']);
    
    $dataEvent['status'] = getEventStatus($id);
    
    if (isset($_POST['script_join'])) {
        if (!$dataEvent['status']) cSetStatusON($id);
        else cSetStatusOFF($id);

        header('Location: index.php?action=reception&date='.$dateSplit[0]);
        exit();
    }

    $startDateFr = strftime('%A %e %B %Y, %Hheures %i', strtotime($dataEvent['startdate']));
    $endDateFr = strftime('%A %e %B %Y, %Hheures %i', strtotime($dataEvent['enddate']));
    $dureeEvent = 'coder fonction';
    if (!$dataEvent['status']) $action = "Inscription";
    else $action = "Désinscription";
    
    $dateSplit = explode(' ', $dataEvent['startdate']);
    $date = $dateSplit[0];
    $dateSplit = explode('-', $date);
    $dateMonth = $dateSplit[0].'-'.$dateSplit[1];
    $display = $dataEvent['name'];

    require('View/Common/vEvent.php');
}
