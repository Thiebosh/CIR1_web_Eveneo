<?php 
if ($_SESSION['rank'] = 'CUSTOMER') require('View/FrontEndSpecific.php');
else require('View/BackEndSpecific.php');


$pageName = 'Accueil';

$legendContent = 'Evènements du mois';

$menuContent = '';

ob_start(); ?>
    <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($lastMonth) ?>">
        <button><h3>Mois précédent</h3></button>
    </a>
    <h3><?= htmlspecialchars($showDate) ?></h3>
    <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($nextMonth) ?>">
        <button><h3>Mois suivant</h3></button>
    </a>
<?php $asideContent = ob_get_clean();

ob_start(); ?>
    <table>
        <thead>
            <tr>
                <?php for ($weekDay = 0; $weekDay < 7; $weekDay++) { ?>
                    <th>
                        <h4><?= htmlspecialchars($dayName['fr'][$weekDay]) ?></h4>
                    </th>
                <?php } ?>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <?php for ($weekDay = 0; $weekDay < 7; $weekDay++) { ?>
                    <th>
                        <h4><?= htmlspecialchars($dayName['fr'][$weekDay]) ?></h4>
                    </th>
                <?php } ?>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <?php
                $monthDay = $weekDay = 0;
                while ($dayName['ang'][$monthDay] != $startMonth) {
                    echo '<td class="otherMonth"></td>';
                    $monthDay++;
                }

                foreach($dataMonth as $dataDay) {
                    $weekDay++;
                    $monthDay++;
                    ?>
                    <td>
                        <?= displayMonth($weekDay, $dataDay) ?>
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

ob_start(); ?>
    <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($lastMonth) ?>">
        <button><h3>Mois précédent</h3></button>
    </a>
    <h3><?= htmlspecialchars($showDate) ?></h3>
    <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($nextMonth) ?>">
        <button><h3>Mois suivant</h3></button>
    </a>
<?php $asideBottomContent = ob_get_clean();


require('View/template.php');
