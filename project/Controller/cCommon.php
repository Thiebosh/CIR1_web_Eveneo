<?php
if (!isset($_SESSION['rank']))             require('Controller/cExtern.php');
else if ($_SESSION['rank'] == 'CUSTOMER')  require('Controller/cFrontEnd.php');
else if ($_SESSION['rank'] == 'ORGANIZER') require('Controller/cBackEnd.php');
else throw new Exception("Rang : inconnu");


function EventsMonth($date) {
    setlocale(LC_TIME, 'fr_FR.utf8','fra');

    $dateSplit = explode('-', $date);
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];
    $page['nbDays'] = date('t', strtotime($page['dateMonth']));

    $dataMonth = switchEventsMonth($page, $dateSplit);

    $page['pageName'] = 'Mois';
    $page['actual'] = 'month';
    $page['lastPage'] = date('Y-m', gmmktime(0, 0, 0, $dateSplit[1] - 1, 1, $dateSplit[0]));
    $page['nextPage'] = date('Y-m', gmmktime(0, 0, 0, $dateSplit[1] + 1, 1, $dateSplit[0]));
    $page['mainGridTitle'] = strftime('%B %Y', strtotime($page['dateMonth']));
    
    $page['dayName'] = array('ang' => array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'),
                              'fr' => array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'));
    $page['startDate'] = $page['dateMonth'].'-0';
    $page['startMonth'] = date('D', gmmktime(0, 0, 0, $dateSplit[1], 1, $dateSplit[0]));//to start the matrix
    $page['endMonth'] = date('N', gmmktime(0, 0, 0, $dateSplit[1], $page['nbDays'], $dateSplit[0]));//to finish the matrix
    
    require('View/vMonth.php');
}

function EventsDay($date) {
    setlocale(LC_TIME, 'fr_FR.utf8','fra');

    $dataDay = switchEventsDay($date);

    $page['pageName'] = 'Jour';
    $page['actual'] = 'day';
    $page['startDate'] = $date;
    $dateSplit = explode('-', $date);
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];
    $page['lastPage'] = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dateSplit[2] - 1, $dateSplit[0]));
    $page['nextPage'] = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dateSplit[2] + 1, $dateSplit[0]));
    $page['mainGridTitle'] = strftime('%A %e %B %Y', strtotime($date));
    
    require('View/vDay.php');
}

function EventDetail($id) {
    setlocale(LC_TIME, 'fr_FR.utf8','fra');

    $dataEvent = switchEventDetail(1, $id, false, false);
    
    $page['startDate'] = explode(' ', $dataEvent['startdate']);
    $page['startTime'] = $page['startDate'][1];
    $page['startDate'] = $page['startDate'][0];
    $splitEndDate = explode(' ', $dataEvent['enddate']);
    $splitStartDate = explode('-', $page['startDate']);
    $page['dateMonth'] = $splitStartDate[0].'-'.$splitStartDate[1];
    
    if (isPreviousDate(date('Y-m-d H-i'), $dataEvent['startdate'])) {
        $script = switchEventDetail(2, $id, $dataEvent['status'], $page['dateMonth']);
        $script['id'] = $id;
    }

    $page['pageName'] = 'Détails';
    $page['actual'] = 'event';
    $page['displayStartDate']  = strftime('%A %e %B %Y', strtotime($page['startDate']));
    $page['displayStartTime']  = strftime('%kh %M',      strtotime($page['startTime']));
    $page['displayEndDate']    = strftime('%A %e %B %Y', strtotime($splitEndDate[0]));
    $page['displayEndTime']    = strftime('%kh %M',      strtotime($splitEndDate[1]));


    $totalPart = $nbPart = $filledPart = 0;
    $page['duration'][$filledPart] = '';
    $interval = date_diff(date_create($dataEvent['startdate']), date_create($dataEvent['enddate']));
    $splitDuration = explode('-', $interval->format('%y-%m-%d-%h-%i'));
    foreach($splitDuration as $part) if ($part != 0) $totalPart++;
    for ($part = 0; $part < 5; $part++) {
        if ($splitDuration[$part]) {
            $page['duration'][$filledPart] .= $splitDuration[$part];
            switch ($part) {
                case 0:
                    if ($splitDuration[$part] == 1) $page['duration'][$filledPart] .= ' an';
                    else $page['duration'][$filledPart] .= ' ans';
                    break;
                case 1: $page['duration'][$filledPart] .= ' mois';
                    break;
                case 2:
                    if ($splitDuration[$part] == 1) $page['duration'][$filledPart] .= ' jour';
                    else $page['duration'][$filledPart] .= ' jours';
                    break;
                case 3:
                    if ($splitDuration[$part] == 1) $page['duration'][$filledPart] .= ' heure';
                    else $page['duration'][$filledPart] .= ' heures';
                    break;
                case 4:
                    if ($splitDuration[$part] == 1) $page['duration'][$filledPart] .= ' minute';
                    else $page['duration'][$filledPart] .= ' minutes';
                    break;
            }

            $nbPart++;
            if ($nbPart < $totalPart - 1) $page['duration'][$filledPart] .= ', ';
            else if ($nbPart > 0 && $nbPart != $totalPart) $page['duration'][$filledPart] .= ' et ';
            if ($nbPart == $totalPart) break;
            if (($nbPart == 2 && $totalPart == 4) || ($nbPart == 3 && $totalPart == 5)) {
                $filledPart++;
                $page['duration'][$filledPart] = '';
            }
        }
    }

    require('View/vEvent.php');
}
