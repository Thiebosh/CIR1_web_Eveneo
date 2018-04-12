<?php
//require('controllerFonctions.php');
if (!isset($_SESSION['rank']))             require('Controller/cRegisterLogin.php');
else if ($_SESSION['rank'] == 'CUSTOMER')  require('Controller/cFrontEnd.php');
else if ($_SESSION['rank'] == 'ORGANIZER') require('Controller/cBackEnd.php');
else throw new Exception("Rang : problème de définition");

function EventsMonth($date) {
    setlocale(LC_TIME, 'fr_FR.utf8','fra');

    $dateSplit = explode('-', $date);
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];
    $page['nbDays'] = date('t', strtotime($page['dateMonth']));

    $dataMonth = switchEventsMonth($page, $dateSplit);

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


function EventsDay($date) {
    setlocale(LC_TIME, 'fr_FR.utf8','fra');

    $dataDay = switchEventsDay($date);

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


function EventDetail($id) {
    setlocale(LC_TIME, 'fr_FR.utf8','fra');

    $dataEvent = switchEventDetail(1, $id, false, false);

    $interval = date_diff(date_create($dataEvent['startdate']), date_create($dataEvent['enddate']));
    $splitDuration = explode('-', $interval->format('%y-%m-%d-%h-%i'));
    if ($splitDuration[0] || $splitDuration[1] || $splitDuration[2]) $return = true;
    else $return = false;

    $page['date'] = explode(' ', $dataEvent['startdate']);
    $page['time'] = $page['date'][1];
    $page['date'] = $page['date'][0];
    $splitEndDate = explode(' ', $dataEvent['enddate']);

    $dateSplit = explode('-', $page['date']);
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];
    
    $script = switchEventDetail(2, $id, $dataEvent['status'], $page['dateMonth']);

    $template['title'] = '';

    $display['title']     = $dataEvent['name'];
    $display['startDate'] = strftime('%A %e %B %Y', strtotime($page['date']));
    $display['startTime'] = strftime('%kh %M',      strtotime($page['time']));
    $display['endDate']   = strftime('%A %e %B %Y', strtotime($splitEndDate[0]));
    $display['endTime']   = strftime('%kh %M',      strtotime($splitEndDate[1]));
    $display['duration']  = '<span>Durée : </span>';
    if ($return) $display['duration'] .= '<br>';
    if ($splitDuration[0]) $display['duration'] .= $splitDuration[0].' an, ';
    if ($splitDuration[1]) $display['duration'] .= $splitDuration[1].' mois, ';
    if ($splitDuration[2]) $display['duration'] .= $splitDuration[2].' jour, ';
    if ($return) $display['duration'] .= '<br>';
    if ($splitDuration[3]) $display['duration'] .= $splitDuration[3].' heure';
    if ($return || $splitDuration[3]) $display['duration'] .= ' et ';
    $display['duration'] .= $splitDuration[4].' minutes ';

    require('View/Common/vEvent.php');
}
