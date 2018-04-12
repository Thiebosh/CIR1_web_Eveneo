<?php
function switchDisplayMonth($part, $dataEvent, $dataDay) {
    switch ($part) {
        case 1: ?>
            <tr><th colspan="7">
                    Sélectionnez un jour pour y créer un événement!
            </th></tr>
        <?php break;
        case 2: ?>
            <a href="index.php?action=new&amp;date=<?= htmlspecialchars($dataDay[0]['date']) ?>">
        <?php break;
        case 3:
            if (isset($dataEvent['name'])) return true;
            else return false;
        break;
        case 5: ?>
            </a>
        <?php break;
    }
}


function switchDisplayDay($part, $dataEvent, $date) {
    switch ($part) {
        case 2:?>
            Fin : <?= htmlspecialchars($dataEvent['endTime']) ?><br>
        <?php break;
        case 4:?>
            <a href="index.php?action=new&amp;date=<?= htmlspecialchars($date) ?>">
                <button>Ajouter un événement</button>
            </a>
        <?php break;
    }
}


function switchDisplayEvent($part, $data) {
    switch ($part) {
        case 2:?>
            <div>
                <form method="post" action="index.php?action=detail&amp;id=<?= htmlspecialchars($data['id']) ?>">
                    <input type="hidden" name="script_edit" value='true'>
                    <input type="submit" value="Modifier">
                </form>
                <form method="post" action="index.php?action=detail&amp;id=<?= htmlspecialchars($data['id']) ?>">
                    <input type="hidden" name="script_delete" value='true'>
                    <input type="submit" value="Supprimer">
                </form>
            </div>
            <?php break;
    }
}
