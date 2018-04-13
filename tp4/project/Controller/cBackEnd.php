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


function backEventNew($data) {
    setlocale(LC_TIME, 'fr_FR.utf8','fra');
    
    if (isset($_POST['script_new']) && $_POST['script_new']) {
        $id = backPostDataAndGetIdEvent($data);
        if (!$id) throw new Exception("Création d'événement : Echec d'enregistrement ou de redirection");
        
        header('Location: index.php?action=detail&id='.$id);
        exit();
    }
    
    $page['date'] = $data['date'];
    $dateSplit = explode('-', $page['date']);
    $page['dateMonth'] = $dateSplit[0].'-'.$dateSplit[1];
    $template['title'] = strftime('%A %e %B %Y', strtotime($data['date']));

    require('View/Common/vNew.php');
}

//A REPRENDRE (dans le fichier de fonction)
function backEventEdit($data) {
    if (isset($_POST['script_edit'])) {
        backChangeEventData($data);
        
        header('Location: index.php?action=detail&id='.$data['id']);
        exit();
    }

    require('View/BackEnd/vEventEdit.php');
}
