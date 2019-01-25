<?php
require('Model/mBackEnd.php');


function switchEventsMonth($page, $dateSplit) {
    return backGetEventsMonth($page);
}

function switchEventsDay($date) {
    $dataDay = backGetEventsDay($date);
    $event = 0;
    foreach($dataDay as $dataEvent) {
        $dataDay[$event]['displayStartTime'] = strftime('%kh %M', strtotime($dataEvent['startTime']));
        $dataDay[$event]['displayEndTime'] = strftime('%kh %M', strtotime($dataEvent['endTime']));
        $event++;
    }

    return $dataDay;
}

function switchEventDetail($part, $id, $status, $dateMonth) {
    switch ($part) {
        case 1:
            $dataEvent = backGetEventDetail($id);
            if (!$dataEvent) throw new Exception("Evénement : Echec de récupération des données");
            $dataEvent['login'] = false;
            $dataEvent['status'] = false;

            return $dataEvent;
            break;
        case 2:
            if ($_POST['script']) {
                backDeleteEvent($id);
        
                header('Location: index.php?action=month&date='.$dateMonth);
                exit();
            }
            break;
    }
}

function backEventScript($dataPage) {
    if (isset($dataPage['echec'])) $listWarning = $dataPage['echec'];

    if ($dataPage['date']) $page['actual'] = 'new';
    else if ($dataPage['id']) {
        $page = backGetEventDetail($dataPage['id']);
        $page['actual'] = 'edit';
    }

    if ($_POST['script']) {
        if ($page['actual'] == 'new') {
            $dataPage['id'] = backPostDataAndGetIdEvent($dataPage);
            if (!$dataPage['id']) throw new Exception("Création d'événement : Echec d'enregistrement ou de redirection");
        }
        else if ($page['actual'] == 'edit') backChangeEventData($dataPage);
        
        header('Location: index.php?action=event&id='.$dataPage['id']);
        exit();
    }

    $page['pageName'] = 'Édition';

    if ($page['actual'] == 'new') {
        $page['getForm'][0] = 'date';
        $page['getForm'][1] = $dataPage['date'];
        $page['switch'] = 'création';
        $page['name'] = $page['place'] = $page['editPlace'] = $page['description'] = '';
        
        $page['startDate'] = $page['endDate'] = $dataPage['date'];
        $page['startTime'] = $page['endTime'] = date('H:i');
    }
    else if ($page['actual'] == 'edit') {
        $page['getForm'][0] = 'id';
        $page['getForm'][1] = $dataPage['id'];
        $page['switch'] = 'modification';
        $page['editPlace'] = ' restantes';

        $dateSplit = explode(' ', $page['startdate']);
        $page['startDate'] = $dateSplit[0];
        $timeSplit = explode(':', $dateSplit[1]);
        $page['startTime'] = $timeSplit[0].':'.$timeSplit[1];

        $dateSplit = explode(' ', $page['enddate']);
        $page['endDate'] = $dateSplit[0];
        $timeSplit = explode(':', $dateSplit[1]);
        $page['endTime'] = $timeSplit[0].':'.$timeSplit[1];
    }

    $dateSplit = explode('-', $page['startDate']);
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];

    require('View/vEdit.php');
}
