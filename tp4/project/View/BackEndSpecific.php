<?php 
function displayMonth($weekDay, $dataDay) {
    ?><a href="index.php?action=new&amp;date=<?= htmlspecialchars($date) ?>">
        <table>
            <tr>
                <td class="date">
                    <?= htmlspecialchars($weekDay) ?>
                </td>
                <td>
                    <?php if ($dataDay) {
                        $nbEvent = 0;
                        foreach($dataDay as $dataEvent) {
                            if ($dataEvent['place'] > 0 || $dataEvent['status']) {?>
                                <div <?php if ($dataEvent['status']) echo 'class="follow"' ?>>
                                    <a href="index.php?action=detail&amp;id=<?= htmlspecialchars($dataEvent['id']) ?>">
                                        <?= htmlspecialchars($dataEvent['name']) ?>
                                    </a>
                                </div>
                                <?php
                                $nbEvent++;
                            }
                            if ($nbEvent == MAX_LIST) break;
                        }
                        
                        if (count($dataDay) > MAX_LIST) {//au moins 6 : ajoute bouton au template ?>
                            <br>
                            <a href="index.php?action=list&amp;date=<?= htmlspecialchars($dataDay[0]['startdate']) ?>">
                                <button>Voir plus</button>
                            </a>
                        <?php }
                    } ?>
                </td>
            </tr>
        </table>
    </a><?php
}


function displayDay($dataDay) {
    foreach($eventsDay as $event) {
        $startDate = strftime('%hHeure %i', strtotime($event['startdate']));
        ?>
        <hr>
        <div class="event">
            <h3>
                <?= htmlspecialchars($event['name']) ?>
            </h3>
            Début : <?= htmlspecialchars($startDate) ?><br>
            Places restantes : <?= htmlspecialchars($event['nb_place']) ?><br>
            <br>
            <a href="index.php?action=detail&amp;id=<?= htmlspecialchars($event['id']) ?>"><button>Plus d'infos</button></a>
        </div>
        <hr>
    <?php } ?>
    <a href="index.php?action=new&amp;date=<?= htmlspecialchars($date) ?>">
        <button>Ajouter un événement</button>
    </a><?php
}


function displayEvent($id, $action) {
    ?><form method="post" action="index.php?action=detail&amp;id=<?= htmlspecialchars($id) ?>">
        <input type="hidden" name="script_delete" value='true'>
        <input type="submit" value=<?= $action ?>>
    </form><?php
}