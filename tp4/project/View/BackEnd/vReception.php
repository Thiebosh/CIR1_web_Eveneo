<?php 
$pageName = 'Accueil';

$menuContent = '';

$legendContent = 'Evènements du mois';


ob_start(); ?>
    <form method="post" action="index.php?action=reception">
        <input type="hidden" name="date" value=<?= $lastMonth ?>>
        <input type="submit" value="Mois précédent">
    </form>

    <?= $showDate ?>

    <form method="post" action="index.php?action=reception">
        <input type="hidden" name="date" value=<?= $nextMonth ?>>
        <input type="submit" value="Mois suivant">
    </form>
<?php $asideContent = ob_get_clean();


ob_start(); ?>
    <table>
        <thead>
            <tr>
                <?php
                for ($weekDay = 0; $weekDay < 7; $weekDay++) {
                    echo '<th colspan="2">' . $dayName['fr'][$i] . '</th>';
                }
                ?>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="14"><!--7jours * 2-->
                    Sélectionnez un jour pour y créer un événement!
                </td>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <?php
                $weekDay = 1;
                while ($dayName['ang'][$weekDay - 1] != $dayStartMonth) {
                    echo '<td colspan="2"></td>';
                    $weekDay++;
                }
                foreach($eventsMonth as $eventsDay) {
                ?>
                    <td>
                        <form method="post" action="index.php?action=new">
                            <input type="hidden" name="date" value=<?= date('Y-m-d', gmmktime(0, 0, 0, $split[1], $weekDay, $split[0])) ?>>
                            <input type="submit" value="<?= $weekDay ?>">
                        </form>
                    </td>
                    <td>
                        <?php
                        if ($eventsDay) {
                            $nbEvent = 0;
                            foreach($eventsDay as $event) {
                                ?>
                                <div>
                                    <a href="index.php?action=detailEvent&amp;id=<?= $event['id'] ?>">
                                        <?= htmlspecialchars($event['name']) ?>
                                    </a>
                                    <form method="post" action="index.php?action=delete">
                                        <input type="hidden" name="id" value=<?= $event['id'] ?>>
                                        <input type="submit" value="Supprimer l'événement">
                                    </form>
                                </div>
                                <?php
                                $nbEvent++;
                                if ($nbEvent == MAX_LIST) {
                                    break;
                                }
                            }
                            
                            if (count($eventsDay) > MAX_LIST) {//au moins 6 : ajoute bouton au template
                                echo '<a href="index.php?action=list">Plus de conférences</a>';
                            }
                        }
                        ?>
                    </td>
                    <?php
                    if ($weekDay % 7 == 0 && $weekDay < $nbDayMonth) {//si egal a nbDayMonth, est fermé par le dernier
                        echo '</tr><tr>';//nouvelle semaine
                    }
                }

                if ($weekDay % 7 != 0) {//ne s est pas arreté sur dimanche  (necessaire?)
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
