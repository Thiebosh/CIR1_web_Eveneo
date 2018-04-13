<?php
require('Model/mFrontEnd.php');


function switchEventsMonth($page, $dateSplit) {
    $dataMonth = frontGetEventsMonth($page);
    for($day = 1; $day <= $page['nbDays']; $day++) {
        if ($dataMonth[$day]) {
            $event = 0;
            foreach($dataMonth[$day] as $dataEvent) {
                $dataMonth[$day][$event]['status'] = getEventStatus($dataEvent['id']);
                $event++;
            }
        }
    }

    return $dataMonth;
}


function switchEventsDay($date) {
    $dataDay = frontGetEventsDay($date);
    $event = 0;
    foreach($dataDay as $dataEvent) {
        if (getEventStatus($dataEvent['id'])) $dataDay[$event]['status'] = 'Oui';
        else $dataDay[$event]['status'] = 'Non';

        $dataDay[$event]['startTime'] = strftime('%kh %M', strtotime($dataEvent['startTime']));
        $event++;
    }

    return $dataDay;
}


function switchEventDetail($part, $id, $status, $dateMonth) {
    switch ($part) {
        case 1:
            $dataEvent = frontGetEventDetail($id);
            if (!$dataEvent) throw new Exception("Evénement : Echec de récupération des données");
            $dataEvent['status'] = getEventStatus($id);

            return $dataEvent;
            break;
        case 2: 
            $script['id'] = $id;
            if (isset($_POST['script_join'])) {
                if (!$status) frontSetStatusON($id);
                else frontSetStatusOFF($id);
        
                header('Location: index.php?action=reception&date='.$dateMonth);
                exit();
            }
            if (!$status) $script['action'] = "Inscription";
            else $script['action'] = "Désinscription";

            return $script;
            break;
    }
}
