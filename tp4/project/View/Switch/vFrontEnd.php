<?php
function switchMonth($part, $dataEvent, $dateFull) {
    switch ($part) {
        case 4:
            if ($dataEvent['place'] > 0 || $dataEvent['status']) return true;
            else return false;
            break;
        case 5: if ($dataEvent['status']) echo 'class="follow"';
            break;
    }
}

function switchDay($part, $dataEvent, $date) {
    switch ($part) {
        case 2:
            if ($dataEvent['place'] > 0 || $dataEvent['status'] == 'Oui') return true;
            else return false;
            break;
        case 3: if ($dataEvent['status'] == 'Oui') echo 'class="follow"';
            break;
        case 5: ?>
            <br>Organisateur : <?= htmlspecialchars($dataEvent['organizer']) ?><br>
            <br>
            Inscrit : <?= htmlspecialchars($dataEvent['status']) ?><?php 
            break;
    }
}

function switchEvent($part, $data) {
    switch ($part) {
        case 1: ?>
            <form method="post" action="index.php?action=event&amp;id=<?= htmlspecialchars($data['id']) ?>">
                <input type="hidden" name="script_join" value='true'>
                <input type="submit" value=<?= htmlspecialchars($data['action']) ?>>
            </form><?php 
            break;
        case 2: ?>
            <span>Organisateur : </span><?= htmlspecialchars($data) ?><br><?php
            break;
    }
}
