<?php 
$pageName = 'Accueil';

$legendContent = 'Evènements du mois';

$menuContent = '';


ob_start(); ?>
    <form method="post" action="index.php?action=reception"><!--remplacer index.php par ./ ?-->
        <input type="hidden" name="date" value=<?= htmlspecialchars($lastMonth) ?>>
        <input type="submit" value="Mois précédent">
    </form>

    <?= htmlspecialchars($showDate) ?>

    <form method="post" action="index.php?action=reception">
        <input type="hidden" name="date" value=<?= htmlspecialchars($nextMonth) ?>>
        <input type="submit" value="Mois suivant">
    </form>
<?php $asideContent = ob_get_clean();


ob_start(); ?>
    <table>
        <thead>
            <tr>
                <?php
                for ($dayInWeek = 0; $dayInWeek < 7; $dayInWeek++) {
                    echo '<th colspan="2">' . $dayName['fr'][$dayInWeek] . '</th>';
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                $dayInMonth = $dayInWeek = 0;
                while ($dayName['ang'][$dayInMonth] != $dayStartMonth) {
                    echo '<td colspan="2"></td>';
                    $dayInMonth++;
                }
                foreach($eventsMonth as $eventsDay) {
                    $dayInWeek++;
                    $dayInMonth++;
                    ?>
                    <td>
                        <?= htmlspecialchars($dayInWeek) ?>
                    </td>
                    <td>
                        <?php
                        if ($eventsDay) {
                            $nbEvent = 0;
                            foreach($eventsDay as $event) {
                                ?>
                                <div>
                                    <a href="index.php?action=detail&amp;id=<?= htmlspecialchars($event['id']) ?>">
                                        <?= htmlspecialchars($event['name']) ?>
                                    </a>
                                </div>
                                <?php
                                $nbEvent++;
                                if ($nbEvent == MAX_LIST) break;
                            }
                            
                            if (count($eventsDay) > MAX_LIST) {//au moins 6 : ajoute bouton au template
                                echo '<a href="index.php?action=list">Plus de conférences</a>';
                            }
                        }
                        ?>
                    </td>
                    <?php
                    if ($dayInMonth % 7 == 0 && $dayInWeek < $nbDayMonth) {//si egal a nbDayMonth, est fermé par le dernier
                        echo '</tr><tr>';//nouvelle semaine
                    }
                }

                if ($dayInWeek % 7 != 0) {//ne s est pas arreté sur dimanche  (necessaire?)
                    while ($dayName['ang'][$dayEndMonth - 1] != 'Sun') {
                        echo '<td colspan="2"></td>';
                        $dayEndMonth++;
                    }
                }
                ?>
            </tr>
        </tbody>
    </table>
<?php $articleContent = ob_get_clean();


require('View/template.php');
