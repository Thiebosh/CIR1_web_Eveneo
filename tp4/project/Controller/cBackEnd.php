<?php
require('Model/mBackEnd.php');


function backEventsMonth($date) {//mettre ligne 12 a 15 en fonction et regrouper les eventsMonth
    setlocale(LC_TIME, 'fr_FR.utf8','fra');

    $dateSplit = explode('-', $date);
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];
    $page['nbDays'] = date('t', strtotime($page['dateMonth']));

    $dataMonth = backGetEventsMonth($page);
    for($day = 1; $day < $page['nbDays']; $day++) {
        $dataMonth[$day][0]['date'] = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $day, $dateSplit[0]));
    }

    $lastMonth = date('Y-m', gmmktime(0, 0, 0, $dateSplit[1] - 1, 1, $dateSplit[0]));
    $nextMonth = date('Y-m', gmmktime(0, 0, 0, $dateSplit[1] + 1, 1, $dateSplit[0]));
    
    $page['startMonth'] = date('D', gmmktime(0, 0, 0, $dateSplit[1], 1, $dateSplit[0]));//pour commencer le tableau d affichage
    $page['endMonth'] = date('N', gmmktime(0, 0, 0, $dateSplit[1], $page['nbDays'], $dateSplit[0]));//pour finir le tableau d affichage
    $page['dayName'] = array('ang' => array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'),
                    'fr' => array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'));
    
    $template['switchName'] = 'Mois';
    $template['title'] = strftime('%B %Y', strtotime($page['dateMonth']));
    $template['lastPage'] = "reception&amp;date=".$lastMonth;
    $template['nextPage'] = "reception&amp;date=".$nextMonth;
    
    require('View/Common/vMonth.php');
}


function backEventsDay($date) {//37 a 43 dans fonction
    setlocale(LC_TIME, 'fr_FR.utf8','fra');
    
    $dataDay = backGetEventsDay($date);
    $event = 0;
    foreach($dataDay as $dataEvent) {
        $dataDay[$event]['startTime'] = strftime('%kh %M', strtotime($dataEvent['startTime']));
        $dataDay[$event]['endTime'] = strftime('%kh %M', strtotime($dataEvent['endTime']));
        $event++;
    }

    $dateSplit = explode('-', $date);
    $lastDay = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dateSplit[2] - 1, $dateSplit[0]));
    $nextDay = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dateSplit[2] + 1, $dateSplit[0]));
    
    $page['date'] = $date;
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];
    $template['switchName'] = 'Jour';
    $template['lastPage'] = "list&amp;date=".$lastDay;
    $template['nextPage'] = "list&amp;date=".$nextDay;
    $template['title'] = strftime('%A %e %B %Y', strtotime($date));

    require('View/Common/vDay.php');
}


function backEventDetail($id) {//63, 79 a 84 dans fonction
    setlocale(LC_TIME, 'fr_FR.utf8','fra');
    
    $dataEvent = backGetEventDetail($id);
    if (!$dataEvent) throw new Exception("Evénement : Echec de récupération des données");
    
    $interval = date_diff(date_create($dataEvent['startdate']), date_create($dataEvent['enddate']));
    $splitDuration = explode('-', $interval->format('%y-%m-%d-%h-%i'));
    if ($splitDuration[0] || $splitDuration[1] || $splitDuration[2]) $br = true;

    $page['date'] = explode(' ', $dataEvent['startdate']);
    $page['time'] = $page['date'][1];
    $page['date'] = $page['date'][0];
    $splitEndDate = explode(' ', $dataEvent['enddate']);

    $dateSplit = explode('-', $page['date']);
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];

    $script['id'] = $id;
    if (isset($_POST['script_delete'])) {
        backDeleteEvent($id);

        header('Location: index.php?action=reception&date='.$dateSplit[0]);
        exit();
    }

    $template['title'] = $dataEvent['name'];

    $display['startDate'] = strftime('%A %e %B %Y', strtotime($page['date']));
    $display['startTime'] = strftime('%kh %M',      strtotime($page['time']));
    $display['endDate']   = strftime('%A %e %B %Y', strtotime($splitEndDate[0]));
    $display['endTime']   = strftime('%kh %M',      strtotime($splitEndDate[1]));
    $display['duration']  = '<span>Durée : </span>';
    if (isset($br)) $display['duration'] .= '<br>';
    if ($splitDuration[0]) $display['duration'] .= $splitDuration[0].' an, ';
    if ($splitDuration[1]) $display['duration'] .= $splitDuration[1].' mois, ';
    if ($splitDuration[2]) $display['duration'] .= $splitDuration[2].' jour, ';
    if (isset($br)) $display['duration'] .= '<br>';
    if ($splitDuration[3]) $display['duration'] .= $splitDuration[3].' heure, ';
    $display['duration'] .= $splitDuration[4].' minutes ';

    require('View/Common/vEvent.php');
}

//A REPRENDRE
function backEventNew($data) {
    setlocale(LC_TIME, 'fr_FR.utf8','fra');
    
    if (isset($_POST['script_new']) && $_POST['script_new']) {
        $id = backPostDataAndGetIdEvent($data);
        if (!$id) throw new Exception("Création d'événement : Echec d'enregistrement ou de redirection");
        
        header('Location: index.php?action=detail&id='.$id);
        exit();
    }

    $displayDate = strftime('%A %e %B %Y', strtotime($data['date']));

    require('View/BackEnd/vEventNew.php');
}

//A REPRENDRE
function backEventEdit($data) {
    if (isset($_POST['script_edit'])) {
        backChangeEventData($data);
        
        header('Location: index.php?action=detail&id='.$data['id']);
        exit();
    }

    require('View/BackEnd/vEventEdit.php');
}
