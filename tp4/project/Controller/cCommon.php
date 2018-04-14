<?php
if (!isset($_SESSION['rank']))             require('Controller/cExtern.php');
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
    $template['title'] = ucfirst(strftime('%B %Y', strtotime($page['dateMonth'])));
    $template['lastPage'] = "reception&amp;date=".$lastMonth;
    $template['nextPage'] = "reception&amp;date=".$nextMonth;

    require('View/vMonth.php');
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
    $template['title'] = ucfirst(strftime('%A %e %B %Y', strtotime($date)));

    require('View/vDay.php');
}


function EventDetail($id) {
    setlocale(LC_TIME, 'fr_FR.utf8','fra');

    $dataEvent = switchEventDetail(1, $id, false, false, false);

    $interval = date_diff(date_create($dataEvent['startdate']), date_create($dataEvent['enddate']));
    $splitDuration = explode('-', $interval->format('%y-%m-%d-%h-%i'));

    $page['date'] = explode(' ', $dataEvent['startdate']);
    $page['time'] = $page['date'][1];
    $page['date'] = $page['date'][0];
    $splitEndDate = explode(' ', $dataEvent['enddate']);

    $dateSplit = explode('-', $page['date']);
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];
    
    if (isPreviousDate(date('Y-m-d H-i'), $dataEvent['startdate'])) {
        $script = switchEventDetail(2, $id, $dataEvent['status'], $page['dateMonth']);
    }

    $template['title'] = '';

    $display['title']     = $dataEvent['name'];
    $display['startDate'] = strftime('%A %e %B %Y', strtotime($page['date']));
    $display['startTime'] = strftime('%kh %M',      strtotime($page['time']));
    $display['endDate']   = strftime('%A %e %B %Y', strtotime($splitEndDate[0]));
    $display['endTime']   = strftime('%kh %M',      strtotime($splitEndDate[1]));

    $totalPart = $nbPart = 0;
    foreach($splitDuration as $part) if ($part != 0) $totalPart++;
    $DisplayPart = 0;
    $display['duration'][$DisplayPart] = '';
    for ($part = 0; $part < 5; $part++) {
        if ($splitDuration[$part]) {
            $display['duration'][$DisplayPart] .= $splitDuration[$part];
            switch ($part) {
                case 0:
                    if ($splitDuration[$part] == 1) $display['duration'][$DisplayPart] .= ' an';
                    else $display['duration'][$DisplayPart] .= ' ans';
                    break;
                case 1: $display['duration'][$DisplayPart] .= ' mois';
                    break;
                case 2:
                    if ($splitDuration[$part] == 1) $display['duration'][$DisplayPart] .= ' jour';
                    else $display['duration'][$DisplayPart] .= ' jours';
                    break;
                case 3:
                    if ($splitDuration[$part] == 1) $display['duration'][$DisplayPart] .= ' heure';
                    else $display['duration'][$DisplayPart] .= ' heures';
                    break;
                case 4:
                    if ($splitDuration[$part] == 1) $display['duration'][$DisplayPart] .= ' minute';
                    else $display['duration'][$DisplayPart] .= ' minutes';
                    break;
            }

            $nbPart++;
            if ($nbPart < $totalPart - 1) $display['duration'][$DisplayPart] .= ', ';
            else if ($nbPart > 0 && $nbPart != $totalPart) $display['duration'][$DisplayPart] .= ' et ';
            if ($nbPart == $totalPart) break;
            if (($nbPart == 2 && $totalPart == 4) || ($nbPart == 3 && $totalPart == 5)) {
                $DisplayPart++;
                $display['duration'][$DisplayPart] = '';
            }
        }
    }

    require('View/vEvent.php');
}