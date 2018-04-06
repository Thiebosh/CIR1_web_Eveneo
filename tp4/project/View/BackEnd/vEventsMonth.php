<?php 
$pageName = 'Accueil';

$legendContent = 'Evènements du mois';

$menuContent = '';


ob_start(); ?>
    <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($lastMonth) ?>">Mois précédent</a>
    <?= htmlspecialchars($showDate) ?>
    <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($nextMonth) ?>">Mois suivant</a>
<?php $asideContent = ob_get_clean();


ob_start(); ?>
    <table>
        <thead>
            <tr>
                <?php for ($dayInWeek = 0; $dayInWeek < 7; $dayInWeek++) { ?>
                    <th colspan="2"><?= htmlspecialchars($dayName['fr'][$dayInWeek]) ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="7">
                    Sélectionnez un jour pour y créer un événement!
                </td>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <?php
                $dayInMonth = $dayInWeek = 0;
                while ($dayName['ang'][$dayInMonth] != $dayStartMonth) {
                    echo '<td></td>';
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
                                    <td>
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

                                                    <form method="post" action="index.php?action=detail&amp;id=<?= htmlspecialchars($event['id']) ?>">
                                                        <input type="hidden" name="script_delete" value='true'>
                                                        <input type="submit" value="Supprimer">
                                                    </form>
                                                </div>
                                                <?php
                                                $nbEvent++;
                                                if ($nbEvent == MAX_LIST) break;
                                            }
                                            
                                            if (count($eventsDay) > MAX_LIST) {//au moins 6 : ajoute bouton au template ?>
                                                <a href="index.php?action=list&amp;date=<?= htmlspecialchars($date) ?>">Plus de conférences</a>
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
                        echo '<td></td>';
                        $dayEndMonth++;
                    }
                } ?>
            </tr>
        </tbody>
    </table>
<?php $articleContent = ob_get_clean();


require('View/template.php');
