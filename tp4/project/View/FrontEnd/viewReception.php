<?php 
$pageName = 'Accueil';

$menuContent = '';

$legendContent = 'Evènements du mois';


ob_start(); ?>
    <form method="post" action="index.php?action=lastMonth">
        <input type="submit" value="Mois précédent">
    </form>

    <?= $infoPage['month'].' '.$infoPage['year'] ?>

    <form method="post" action="index.php?action=nextMonth">
        <input type="submit" value="Mois suivant">
    </form>
<?php $asideContent = ob_get_clean();


ob_start(); 
    $dayName[0] = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
    $dayName[1] = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    ?>
    <table>
        <thead>
            <tr>
                <?php
                for ($jour = 0; $jour < 7; $jour++) {
                    echo '<th colspan="2">'.$dayName[1][$i].'</th>';
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                $jour = 1;
                while ($dayName[0][$jour - 1] != date('D, gmmktime(0, 0, 0, $infoPage[\'month\'], 1, $infoPage[\'year\'])')) {
                    echo '<td colspan="2"></td>';
                    $jour++;
                }
                foreach($listEventsMonth as $listEventsDay) {
                ?>
                    <td>
                        <?= $jour ?>
                    </td>
                    <td>
                        <?php
                        if ($listEventsDay) {
                            $compteur = 0;
                            foreach($listEventsDay as $event) {
                                $compteur++;
                                ?>
                                <a href="index.php?action=detailEvent&amp;id=<?= $event['id'] ?>">
                                    <?= htmlspecialchars($event['name']) ?>
                                </a>
                                <?php
                                if (compteur == 5) {
                                    break;
                                }
                            }
                            
                            if (count($listEventsDay) > 5) {//au moins 6 : ajoute bouton au template
                                echo '<a href="index.php?action=allEvent">Voir plus de conférences</a>';
                            }
                        }
                        ?>
                    </td>
                    <?php
                    if ($jour % 7 == 0) {
                        echo '</tr><tr>';
                    }
                }

                if ($jour % 7 != 0) {//ne s est pas arreté sur dimanche  (necessaire?)
                    $jour = date('N, gmmktime(0, 0, 0, $infoPage[\'month\'], $jour, $infoPage[\'year\'])');
                    while ($dayName[0][$jour - 1] != 'Sun') {
                        echo '<td colspan="2"></td>';
                        $jour++;
                    }
                }
                ?>
            </tr>
        </tbody>
    </table>
<?php $articleContent = ob_get_clean();


require('View/template.php');
