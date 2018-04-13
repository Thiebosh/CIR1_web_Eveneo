<?php
require('Model/mBackEnd.php');


function switchEventsMonth($page, $dateSplit) {
    return backGetEventsMonth($page);
}


function switchEventsDay($date) {
    $dataDay = backGetEventsDay($date);
    $event = 0;
    foreach($dataDay as $dataEvent) {
        $dataDay[$event]['startTime'] = strftime('%kh %M', strtotime($dataEvent['startTime']));
        $dataDay[$event]['endTime'] = strftime('%kh %M', strtotime($dataEvent['endTime']));
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
            $script['id'] = $id;
            if (isset($_POST['script_delete'])) {
                backDeleteEvent($id);
        
                header('Location: index.php?action=reception&date='.$dateMonth);
                exit();
            }

            return $script;
            break;
    }
}


function backEventNew($reception) {
    setlocale(LC_TIME, 'fr_FR.utf8','fra');
    
    if (isset($_POST['script_new']) && $_POST['script_new']) {
        $id = backPostDataAndGetIdEvent($reception);
        if (!$id) throw new Exception("Création d'événement : Echec d'enregistrement ou de redirection");
        
        header('Location: index.php?action=detail&id='.$id);
        exit();
    }
    
    $dateSplit = explode('-', $reception['date']);
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];
    $page['date'] = $reception['date'];
    $template['title'] = strftime('%A %e %B %Y', strtotime($reception['date']));

    require('View/Common/vNew.php');
}


function backEventEdit($reception) {
    if (isset($_POST['script_edit']) && $_POST['script_edit']) {
        backChangeEventData($reception);
        
        header('Location: index.php?action=detail&id='.$reception['id']);
        exit();
    }

    $page = backGetEventDetail($reception['id']);
    $page['date'] = explode(' ', $page['startdate']);
    $page['date'] = $page['date'][0];
    $dateSplit = explode('-', $page['date']);
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];

    $template['title'] = '';

    require('View/Common/vEdit.php');
}
