<?php
if ($_SESSION['rank'] == 'CUSTOMER') require('View/vFrontEnd.php');
else require('View/vBackEnd.php');


$pageName = 'Liste';

$legendContent = 'Evènements du jour';

ob_start(); ?>
    <li>
        <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($date) ?>"><button>Accueil</button></a>
    </li>
<?php $menuContent = ob_get_clean();

ob_start(); ?>
    <tr>
        <th class="borderless">
            <a href="index.php?action=list&amp;date=<?= htmlspecialchars($lastDay) ?>">
                <button><h3>Jour précédent</h3></button>
            </a>
        </th>
        <th class="borderless">
            <h3><?= htmlspecialchars($showDate) ?></h3>
        </th>
        <th class="borderless">
            <a href="index.php?action=list&amp;date=<?= htmlspecialchars($nextDay) ?>">
                <button><h3>Jour suivant</h3></button>
            </a>
        </th>
    </tr>
<?php $headTable = ob_get_clean();

ob_start(); ?>
    <table id="mainGrid">
        <thead>
            <?= $headTable ?>
            <tr><th colspan="3" class="borderless"><br></th></tr>
            <tr><th colspan="3"></th></tr>
            <?php displayDay(3, false, $date); ?>
        </thead>
        <tfoot>
            <?php displayDay(3, false, $date); ?>
            <tr><th colspan="3"></th></tr>
            <tr><th colspan="3" class="borderless"><br></th></tr>
            <?= $headTable ?>
        </tfoot>
        <tbody id="day">
            <tr>
                <?php
                $nbEvents = 0;
                foreach($dataDay as $dataEvent) {
                    $nbEvents++
                    ?>
                    <td>
                        <fieldset>
                            <a href="index.php?action=detail&amp;id=<?= htmlspecialchars($dataEvent['id']) ?>">
                                <h3><?= htmlspecialchars($dataEvent['name']) ?></h3>
                            </a>
                            Début : <?= htmlspecialchars($dataEvent['startTime']) ?><br>
                            <?php displayDay(1, $dataEvent, false); ?>
                            Places restantes : <?= htmlspecialchars($dataEvent['place']) ?>
                            <?php displayDay(2, $dataEvent, false); ?>
                        </fieldset>
                    </td>
                    <?php
                    if ($nbEvents % 3 == 0) echo "</tr><tr>";
                }
                while ($nbEvents % 3 != 0) {
                    echo "<td></td>";
                    $nbEvents++;
                }
                ?>
            </tr>
        </tbody>
    </table>
<?php $articleContent = ob_get_clean();

$asideContent = '<a href="#"><button class="ancre"><h3>Haut de page</h3></button></a>';


require('View/template.php');
