<?php
require('Model/mFrontEnd.php');


function frontEventsMonth($date) {//mettre ligne 12 a 24 en fonction et regrouper les eventsMonth
    setlocale(LC_TIME, 'fr_FR.utf8','fra');

    $dateSplit = explode('-', $date);
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];
    $page['nbDays'] = date('t', strtotime($page['dateMonth']));

    $dataMonth = frontGetEventsMonth($page);
    for($day = 1; $day < $page['nbDays']; $day++) {
        if ($dataMonth[$day]) {
            $event = 0;
            foreach($dataMonth[$day] as $dataEvent) {
                $dataMonth[$day][$event]['status'] = getEventStatus($dataEvent['id']);
                $event++;
            }
            if (count($dataMonth[$day]) > MAX_LIST) {
                $dataMonth[$day][0]['date'] = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $day, $dateSplit[0]));
            }
        }
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


function frontEventsDay($date) {//46 a 54 dans fonction
    setlocale(LC_TIME, 'fr_FR.utf8','fra');

    $dataDay = frontGetEventsDay($date);
    $event = 0;
    foreach($dataDay as $dataEvent) {
        if (getEventStatus($dataEvent['id'])) $dataDay[$event]['status'] = 'Oui';
        else $dataDay[$event]['status'] = 'Non';

        $dataDay[$event]['startTime'] = strftime('%kh %M', strtotime($dataEvent['startTime']));
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


function frontEventDetail($id) {//74, 76, 90 a 99 dans fonction
    setlocale(LC_TIME, 'fr_FR.utf8','fra');

    $dataEvent = frontGetEventDetail($id);
    if (!$dataEvent) throw new Exception("Evénement : Echec de récupération des données");
    $dataEvent['status'] = getEventStatus($id);

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
    if (isset($_POST['script_join'])) {
        if (!$dataEvent['status']) frontSetStatusON($id);
        else frontSetStatusOFF($id);

        header('Location: index.php?action=reception&date='.$page['dateMonth']);
        exit();
    }
    if (!$dataEvent['status']) $script['action'] = "Inscription";
    else $script['action'] = "Désinscription";

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
