<?php
if ($_SESSION['rank'] == 'CUSTOMER') require_once('View/vFrontEnd.php');
else require_once('View/vBackEnd.php');


$pageName = 'Accueil';

$legendContent = 'Evènements du mois';

ob_start(); ?>
    <li>
        <a href="index.php?action=reception"><button>Mois en cours</button></a>
    </li>
<?php $menuContent = ob_get_clean();

ob_start(); ?>
    <tr>
        <th class="borderless"></th>
        <th class="borderless">
            <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($lastMonth) ?>">
                <button><h3>Mois précédent</h3></button>
            </a>
        </th>
        <th colspan="3" class="borderless">
            <h3><?= htmlspecialchars($showDate) ?></h3>
        </th>
        <th class="borderless">
            <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($nextMonth) ?>">
            <button><h3>Mois suivant</h3></button>
            </a>
        </th>
        <th class="borderless"></th>
    </tr>
<?php $headTable = ob_get_clean();

ob_start(); ?>
    <tr>
    <?php for ($weekDay = 0; $weekDay < 7; $weekDay++) { ?>
        <th>
            <h4><?= htmlspecialchars($dayName['fr'][$weekDay]) ?></h4>
        </th>
    <?php } ?>
    </tr>
<?php $tailTable = ob_get_clean();

ob_start(); ?>
    <table id="mainGrid">
        <thead>
            <?= $headTable ?>
            <tr><th colspan="7" class="borderless"><br></th></tr>
            <tr></tr>
            <?= $tailTable ?>
            <?php displayMonth(1, false, false) ?>
        </thead>
        <tfoot>
            <?= $tailTable ?>
            <tr></tr>
            <tr><th colspan="7" class="borderless"><br></th></tr>
            <?= $headTable ?>
        </tfoot>
        <tbody id="month">
            <tr>
                <?php
                $monthDay = $weekDay = 0;
                while ($dayName['ang'][$monthDay] != $startMonth) {//ne commence pas par lundi
                    echo '<td class="otherMonth"></td>';
                    $monthDay++;
                }

                foreach($dataMonth as $dataDay) {
                    $weekDay++;
                    $monthDay++;
                    ?>
                    <td>
                        <?php displayMonth(2, false, $dataDay) ?>
                            <table>
                                <tr>
                                    <td class="date">
                                        <?= htmlspecialchars($weekDay) ?>
                                    </td>
                                    <td>
                                        <?php if ($dataDay) {
                                            $nbEvent = 0;
                                            foreach($dataDay as $dataEvent) {
                                                if (displayMonth(3, $dataEvent, false)) {?>
                                                    <div <?php displayMonth(4, $dataEvent, false) ?>>
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
                                                <a href="index.php?action=list&amp;date=<?= htmlspecialchars($dataDay[0]['date']) ?>">
                                                    <button>Voir plus</button>
                                                </a>
                                            <?php }
                                        } ?>
                                    </td>
                                </tr>
                            </table>
                        <?php displayMonth(5, false, false) ?>
                    </td>
                    <?php if ($monthDay % 7 == 0 && $weekDay < $dataDate['nbDays']) {//si egal a nbDayMonth, est fermé par le dernier
                        echo '</tr><tr>';//nouvelle semaine
                    }
                }

                while ($dayName['ang'][$endMonth - 1] != 'Sun') {//ne s est pas arreté sur dimanche
                    echo '<td class="otherMonth"></td>';
                    $endMonth++;
                }?>
            </tr>
        </tbody>
    </table>
<?php $articleContent = ob_get_clean();

$asideContent = '';


require('View/template.php');
