<?php
if ($_SESSION['rank'] == 'CUSTOMER') require_once('View/vFrontEnd.php');
else require_once('View/vBackEnd.php');


$template['pageName'] = 'Accueil';

$template['titleContent'] = 'Évènements du mois';

ob_start();
    if ($page['dateMonth'] != date('Y-m')) { ?>
        <li>
            <a href='index.php?action=reception'>
                <button>Mois en cours</button>
            </a>
        </li>
    <?php }
$template['menuContent'] = ob_get_clean();


ob_start();
    for ($weekDay = 0; $weekDay < 7; $weekDay++) { ?>
        <th>
            <h4><?= htmlspecialchars($page['dayName']['fr'][$weekDay]) ?></h4>
        </th>
    <?php }
$template['displayWeekDay'] = ob_get_clean();

ob_start(); ?>
    <table id="month">
        <thead>
            <tr> <?= $template['displayWeekDay'] ?> </tr>
            <?php displayMonth(1, false, false) ?>
        </thead>
        <tfoot><tr> <?= $template['displayWeekDay'] ?> </tr></tfoot>
        <tbody>
            <tr>
                <?php
                $monthDay = $weekDay = 0;
                while ($page['dayName']['ang'][$monthDay] != $page['startMonth']) {//ne commence pas par lundi
                    echo '<td class="otherMonth"></td>';
                    $monthDay++;
                }

                foreach($dataMonth as $dataDay) {
                    $weekDay++;
                    $monthDay++;
                    ?>
                    <td>
                        <?php displayMonth(2, false, $dataDay) ?>
                            <aside>
                                <div class="date"><?= htmlspecialchars($weekDay) ?></div>
                                <div class="vLine"></div>
                                <div class="allEvents">
                                    <?php if ($dataDay) {
                                        $nbEvent = 0;
                                        foreach($dataDay as $dataEvent) {
                                            if (displayMonth(3, $dataEvent, false)) {?>
                                                <a href="index.php?action=detail&amp;id=<?= htmlspecialchars($dataEvent['id']) ?>" <?php displayMonth(4, $dataEvent, false) ?>>
                                                    <?= htmlspecialchars($dataEvent['name']) ?>
                                                </a>
                                                <?php
                                                $nbEvent++;
                                            }
                                            if ($nbEvent == MAX_LIST) break;
                                        }
                                        
                                        if (count($dataDay) > MAX_LIST) {//au moins 6 : ajoute bouton au template ?>
                                            
                                            <a href="index.php?action=list&amp;date=<?= htmlspecialchars($dataDay[0]['date']) ?>" class="more">
                                                <button>Voir tout</button>
                                            </a>
                                        <?php }
                                    } ?>
                                </div>
                            </aside>
                        <?php displayMonth(5, false, false) ?>
                    </td>
                    <?php if ($monthDay % 7 == 0 && $weekDay < $page['nbDays']) {//si egal a nbDayMonth, est fermé par le dernier
                        echo '</tr><tr>';//nouvelle semaine
                    }
                }

                while ($page['dayName']['ang'][$page['endMonth'] - 1] != 'Sun') {//ne s est pas arreté sur dimanche
                    echo '<td class="otherMonth"></td>';
                    $page['endMonth']++;
                }?>
            </tr>
        </tbody>
    </table>
<?php $template['articleContent'] = ob_get_clean();


require('View/template.php');
