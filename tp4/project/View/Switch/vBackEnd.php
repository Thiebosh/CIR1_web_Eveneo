<?php
function switchMonth($part, $dataEvent, $dateFull) {
    switch ($part) {
        case 1:
            ?><tr><td colspan="7">
                Sélectionnez un jour pour y créer un événement!
            </td></tr><?php 
            break;
        case 2: ?><a href="index.php?action=new&amp;date=<?= htmlspecialchars($dateFull) ?>"><?php 
            break;
        case 3: ?></a><?php 
            break;
        case 4: return true;
            break;
    }
}

function switchDay($part, $dataEvent, $date) {
    switch ($part) {
        case 1: ?>
            <a href="index.php?action=new&amp;date=<?= htmlspecialchars($date) ?>">
                <button>Ajouter un événement</button>
            </a><?php 
            break;
        case 2: return true;
            break;
        case 4: ?>Fin : <?= htmlspecialchars($dataEvent['endTime']) ?><br><?php 
            break;
    }
}

function switchEvent($part, $data) {
    if ($part == 1) { ?>
        <div>
            <form method="post" action="index.php?action=edit&amp;id=<?= htmlspecialchars($data['id']) ?>">
                <input type="submit" value="Modifier">
            </form>
            <form method="post" action="index.php?action=event&amp;id=<?= htmlspecialchars($data['id']) ?>">
                <input type="hidden" name="script_delete" value='true'>
                <input type="submit" value="Supprimer">
            </form>
        </div>
    <?php }
}
