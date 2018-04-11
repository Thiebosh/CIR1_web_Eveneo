<?php
function displayMonth($part, $dataEvent, $dataDay) {
    switch ($part) {
        case 3:
            if ($dataEvent['place'] > 0 || $dataEvent['status']) return true;
            else return false;
        break;
        case 4:
            if ($dataEvent['status']) echo 'class="follow"';
        break;
    }
}

function displayDay($part, $dataEvent, $date) {
    switch ($part) {
        case 1:
            if ($dataEvent['status'] == 'Oui') echo 'class="follow"';
        break;
        case 3:?>
            <br>Organisateur : <?= htmlspecialchars($dataEvent['organizer']) ?><br>
            <br>
            Inscrit : <?= htmlspecialchars($dataEvent['status']) ?>
        <?php break;
    }
}


function displayEvent($data) {
    ?><form method="post" action="index.php?action=detail&amp;id=<?= htmlspecialchars($data['id']) ?>">
        <input type="hidden" name="script_join" value='true'>
        <input type="submit" value=<?= htmlspecialchars($data['action']) ?>>
    </form><?php
}
