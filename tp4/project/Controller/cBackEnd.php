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
        
                header('Location: index.php?action=month&date='.$dateMonth);
                exit();
            }

            return $script;
            break;
    }
}

function backEventNew($dataPage) {
    setlocale(LC_TIME, 'fr_FR.utf8','fra');
    
    if (isset($_POST['script_new']) && $_POST['script_new']) {
        $id = backPostDataAndGetIdEvent($dataPage);
        if (!$id) throw new Exception("Création d'événement : Echec d'enregistrement ou de redirection");
        
        header('Location: index.php?action=event&id='.$id);
        exit();
    }

    $dateSplit = explode('-', $dataPage['date']);

    $page['pageName'] = 'Création';
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];
    $page['actual'] = 'new';
    $page['date'] = $dataPage['date'];
    $page['sectionTitle'] = 'Création d\'événement';

    require('View/vNew.php');
}

function backEventEdit($dataPage) {
    if (isset($_POST['script_edit']) && $_POST['script_edit']) {
        backChangeEventData($dataPage);
        
        header('Location: index.php?action=event&id='.$dataPage['id']);
        exit();
    }

    $page = backGetEventDetail($dataPage['id']);

    $page['date'] = explode(' ', $page['startdate']);
    $page['date'] = $page['date'][0];
    $dateSplit = explode('-', $page['date']);
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];

    $page['pageName'] = 'Modification';
    $page['actual'] = 'edit';
    $page['sectionTitle'] = 'Édition d\'événement';

    require('View/vEdit.php');
}
