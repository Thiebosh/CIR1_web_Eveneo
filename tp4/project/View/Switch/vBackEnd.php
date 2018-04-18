<?php
function switchMonth($part, $dataEvent, $startDate) {
    switch ($part) {
        case 1:
            ?><tr><td colspan="7">
                Sélectionnez un jour pour y créer un événement!
            </td></tr><?php 
            break;
        case 2: ?><a href="index.php?action=edit&amp;date=<?= htmlspecialchars($startDate) ?>"><?php 
            break;
        case 3: ?></a><?php 
            break;
        case 4: return true;
            break;
    }
}

function switchDay($part, $dataEvent, $startDate) {
    switch ($part) {
        case 1: ?>
            <a href="index.php?action=edit&amp;date=<?= htmlspecialchars($startDate) ?>">
                <button>Ajouter un événement</button>
            </a><?php 
            break;
        case 2: return true;
            break;
        case 4: ?>Fin : <?= htmlspecialchars($dataEvent['displayEndTime']) ?><br><?php 
            break;
    }
}

function switchEvent($part, $data) {
    switch ($part) {
        case 1: ?>
            <div>
                <form method="post" action="index.php?action=edit&amp;id=<?= htmlspecialchars($data['id']) ?>">
                    <input type="submit" value="Modifier">
                </form>
                <form method="post" action="index.php?action=event&amp;id=<?= htmlspecialchars($data['id']) ?>">
                    <input type="hidden" name="script" value="delete">
                    <input type="submit" value="Supprimer">
                </form>
            </div><?php 
            break;
        case 2: ?>
            <div><span>Nombre d'inscrits : </span>à coder</div><?php
            break;
    }
}
