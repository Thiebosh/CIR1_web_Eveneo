<?php
if ($_SESSION['rank'] == 'CUSTOMER') require('View/Switch/vFrontEnd.php');
else require('View/Switch/vBackEnd.php');


function selectClass($dateFull, $monthDay) {
    if ($dateFull == date('Y-m-d')) echo 'class="today" ';
    if (($monthDay + 1) % 7 == 0) echo 'class="saturday" ';
    else if ($monthDay % 7 == 0) echo 'class="sunday" ';
}

ob_start();
    for ($weekDay = 0; $weekDay < 7; $weekDay++) { ?>
        <th>
            <h4><?= htmlspecialchars($page['dayName']['fr'][$weekDay]) ?></h4>
        </th>
    <?php }
$page['headBand'] = ob_get_clean();

ob_start(); ?>
    <table id="month">
        <thead>
            <tr><?= $page['headBand'] ?></tr>
            <?php switchMonth(1, false, false) ?>
        </thead>
        <tfoot><tr><?= $page['headBand'] ?></tr></tfoot>
        <tbody>
            <tr>
                <?php
                $monthDay = $weekDay = 0;
                while ($page['dayName']['ang'][$monthDay] != $page['startMonth']) {//ne commence pas par lundi ?>
                    <td class="otherMonth">
                        <a href="index.php?action=month&amp;date=<?= htmlspecialchars($page['lastPage']) ?>">
                            <aside>
                                <div class="date"></div>
                                <div class="vLine"></div>
                                <div class="allEvents"></div>
                            </aside>
                        </a>
                    </td>
                    <?php
                    $monthDay++;
                }

                foreach($dataMonth as $dataDay) {
                    $weekDay++;
                    $monthDay++;
                    ?>
                    <td <?php selectClass($page['dateMonth'].'-'.$weekDay, $monthDay) ?>>
                        <aside>
                            <div class="date">
                                <?php switchMonth(2, false, $page['dateMonth'].'-'.$weekDay) ?>
                                    <?= htmlspecialchars($weekDay) ?>
                                <?php switchMonth(3, false, false) ?>
                            </div>
                            <div class="vLine"></div>
                            <div class="allEvents">
                                <?php if ($dataDay) {
                                    $nbEvent = 0;
                                    foreach($dataDay as $dataEvent) {
                                        if (switchMonth(4, $dataEvent, false)) {?>
                                            <a href="index.php?action=event&amp;id=<?= htmlspecialchars($dataEvent['id']) ?>" <?php switchMonth(5, $dataEvent, false) ?>>
                                                <?= /*preg_replace ("\\", "", */preg_quote($dataEvent['name'], "'")/*)*/ ?><!--explode aux espaces et afficher tout au foreach?-->
                                            </a>
                                            <?php
                                            $nbEvent++;
                                        }
                                        if ($nbEvent == MAX_LIST) break;
                                    }
                                    
                                    if (count($dataDay) > MAX_LIST) {//au moins 6 : ajoute bouton au template ?>
                                        
                                        <a href="index.php?action=day&amp;date=<?= htmlspecialchars($page['dateMonth'].'-'.$weekDay) ?>" class="more">
                                            <button>Voir tout</button>
                                        </a>
                                    <?php }
                                } ?>
                            </div>
                        </aside>
                    </td>
                    <?php if ($monthDay % 7 == 0 && $weekDay < $page['nbDays']) {//si egal a nbDayMonth, est fermé par le dernier
                        echo '</tr><tr>';//nouvelle semaine
                    }
                }

                while ($page['dayName']['ang'][$page['endMonth'] - 1] != 'Sun') {//ne s est pas arreté sur dimanche ?>
                    <td class="otherMonth">
                        <a href="index.php?action=month&amp;date=<?= htmlspecialchars($page['nextPage']) ?>">
                            <aside>
                                <div class="date"></div>
                                <div class="vLine"></div>
                                <div class="allEvents"></div>
                            </aside>
                        </a>
                    </td>
                    <?php
                    $page['endMonth']++;
                }?>
            </tr>
        </tbody>
    </table>
<?php $template['article'] = ob_get_clean();


require('View/template.php');
