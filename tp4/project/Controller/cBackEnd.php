<?php
require('Model/mBackEnd.php');


function oEventsMonth($date) {
    if (!$date) $date = date('Y-m');

    $timeStamp = strtotime($date);
    $showDate = strftime('%B %Y', $timeStamp);
    $dataDate['nbDays'] = date('t', $timeStamp);

    $dateSplit = explode('-', $date);
    $dataDate['year'] = $dateSplit[0];
    $dataDate['month'] = $dateSplit[1];

    $dataMonth = oGetEventsMonth($dataDate);
    for($day = 1; $day < $dataDate['nbDays']; $day++) {
        $dataMonth[$day][0]['date'] = date('Y-m-d', gmmktime(0, 0, 0, $dataDate['month'], $day, $dataDate['year']));
    }
    
    $lastMonth = date('Y-m', gmmktime(0, 0, 0, $dataDate['month'] - 1, 1, $dataDate['year']));
    $nextMonth = date('Y-m', gmmktime(0, 0, 0, $dataDate['month'] + 1, 1, $dataDate['year']));
    
    $startMonth = date('D', gmmktime(0, 0, 0, $dataDate['month'], 1, $dataDate['year']));//pour commencer le tableau d affichage
    $endMonth = date('N', gmmktime(0, 0, 0, $dataDate['month'], $dataDate['nbDays'], $dataDate['year']));//pour finir le tableau d affichage

    $dayName = array('ang' => array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'),
                    'fr' => array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'));
    
    require('View/Common/vMonth.php');
}


function oEventsDay($date) {
    $dataDay = oGetEventsDay($date);
    $event = 0;
    foreach($dataDay as $dataEvent) {
        $dataDay[$event]['startTime'] = strftime('%hHeure %i', strtotime($dataEvent['startTime']));
        $dataDay[$event]['endTime'] = strftime('%hHeure %i', strtotime($dataEvent['endTime']));
        $event++;
    }

    $showDate = strftime('%A %e %B %Y', strtotime($date));
    $dateSplit = explode('-', $date);
    $lastDay = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dateSplit[2] - 1, $dateSplit[0]));
    $nextDay = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dateSplit[2] + 1, $dateSplit[0]));

    require('View/Common/vDay.php');
}


function oEvent($id) {
    $dataEvent = oGetEvent($id);
    if (!$dataEvent) throw new Exception("Evénement : Echec de récupération des données");
    
    if (isset($_POST['script_delete'])) {
        oDeleteEvent($id);

        header('Location: index.php?action=reception&date='.$dataEvent['startdate']);//recharge la page
        exit();
    }
    
    $startDateFr = strftime('%A %e %B %Y, %Hheures %i', strtotime($dataEvent['startdate']));
    $endDateFr = strftime('%A %e %B %Y, %Hheures %i', strtotime($dataEvent['enddate']));
    $dureeEvent = 'coder fonction';

    $action = '';

    require('View/Common/vEvent.php');
}


function oEventNew($data) {
    if (isset($_POST['script_new']) && $_POST['script_new']) {
        $id = oPostDataAndGetIdEvent($data);//throw new Exception('Création d\'événement : Echec d\'enregistrement des données');
        if (!$id) throw new Exception("Création d'événement : Echec d'enregistrement ou de redirection");
        
        header('Location: index.php?action=detail&id='.$id);//recharge la page
        exit();
    }

    $showDate = strftime('%A %e %B %Y', strtotime($data['date']));

    require('View/BackEnd/vEventNew.php');
}


function oEventEdit($data) {
    if (isset($_POST['script_edit'])) {
        oChangeEventData($data);// throw new Exception('Modification d\'événement : Echec d\'enregistrement des données');
        
        header('Location: index.php?action=detail&id='.$data['id']);//recharge la page
        exit();
    }

    require('View/BackEnd/vEventEdit.php');
}
