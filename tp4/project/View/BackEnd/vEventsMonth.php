<?php 
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
                <?php for ($dayInWeek = 0; $dayInWeek < 7; $dayInWeek++) { ?>
                    <th>
                        <h4><?= htmlspecialchars($dayName['fr'][$dayInWeek]) ?></h4>
                    </th>
                <?php } ?>
            </tr>
            <tr>
                <th colspan="7">
                    Sélectionnez un jour pour y créer un événement!
                </th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <?php for ($dayInWeek = 0; $dayInWeek < 7; $dayInWeek++) { ?>
                    <th>
                        <h4><?= htmlspecialchars($dayName['fr'][$dayInWeek]) ?></h4>
                    </th>
                <?php } ?>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <?php
                $dayInMonth = $dayInWeek = 0;
                while ($dayName['ang'][$dayInMonth] != $dayStartMonth) {
                    echo '<td class="otherMonth"></td>';
                    $dayInMonth++;
                }
                
                foreach($eventsMonth as $eventsDay) {
                    $dayInWeek++;
                    $dayInMonth++;
                    $date = date('Y-m-d', gmmktime(0, 0, 0, $dateSplit[1], $dayInWeek, $dateSplit[0]));
                    ?>
                    <td>
                        <a href="index.php?action=new&amp;date=<?= htmlspecialchars($date) ?>">
                            <table>
                                <tr>
                                    <td class="date">
                                        <?= htmlspecialchars($dayInWeek) ?>
                                    </td>
                                    <td>
                                        <?php if ($eventsDay) {
                                            $nbEvent = 0;
                                            foreach($eventsDay as $event) { ?>
                                                <div>
                                                    <a href="index.php?action=detail&amp;id=<?= htmlspecialchars($event['id']) ?>">
                                                        <?= htmlspecialchars($event['name']) ?>
                                                    </a>
                                                </div>
                                                <?php
                                                $nbEvent++;
                                                if ($nbEvent == MAX_LIST) break;
                                            }
                                            
                                            if (count($eventsDay) > MAX_LIST) {//au moins 6 : ajoute bouton au template ?>
                                                <br>
                                                <a href="index.php?action=list&amp;date=<?= htmlspecialchars($date) ?>">
                                                    <button>Voir plus</button>
                                                </a>
                                            <?php }
                                        } ?>
                                    </td>
                                </tr>
                            </table>
                        </a>
                    </td>
                    <?php if ($dayInMonth % 7 == 0 && $dayInWeek < $nbDayMonth) {//si egal a nbDayMonth, est fermé par le dernier
                        echo '</tr><tr>';//nouvelle semaine
                    }
                }

                if ($dayInWeek % 7 != 0) {//ne s est pas arreté sur dimanche
                    while ($dayName['ang'][$dayEndMonth - 1] != 'Sun') {
                        echo '<td class="otherMonth"></td>';
                        $dayEndMonth++;
                    }
                } ?>
            </tr>
        </tbody>
    </table>
<?php $articleContent = ob_get_clean();


require('View/template.php');
